<?php

namespace App\Conversations;

use App\Department;
use App\Location;
use App\Status;
use App\User;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\DB;

class FirstUpdateConversation extends Conversation
{
  protected $data = [], $user, $botinfo;

  private static function keyboardFree()
  {
    return json_encode(['keyboard' => []]);
  }

  private static function keyboardDefault()
  {
    return json_encode([
      'keyboard' => [
        [
          ['text' => '/validasi'],
          ['text' => '/update'],
        ],
        [
          ['text' => '/infoloker'],
          ['text' => '/infoalumni'],
        ],
        [
          ['text' => '/tambahloker'],
          ['text' => '/bantuan'],
        ],
      ],
      'resize_keyboard' => true,
      'one_time_keyboard' => true
    ]);
  }

  public function askEmail()
  {
    if (empty($this->user->email)) {
      $this->ask("Silahkan masukkan alamat email kamu:", function (Answer $answer) {
        $email = trim($answer->getText());
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $this->user->email = $email;
          $this->askGender();
        } else {
          $this->say('Maaf, data yang kamu masukkan sepertinya bukan email yang valid. Silahkan coba lagi!');
          $this->askEmail();
        }
      });
    } else {
      $this->askGender();
    }
  }

  public function askGender()
  {
    if (empty($this->user->gender)) {
      $question = Question::create('Silahkan masukkan jenis kelamin anda:')
        ->callbackId('ask_gender')
        ->addButtons([
          Button::create('Laki-laki')->value('M'),
          Button::create('Perempuan')->value('F')
        ]);

      $this->ask($question, function (Answer $answer) {
        $this->user->gender = $answer->getValue();
        $this->say($answer->getText());
        $this->askPob();
      });
    } else {
      $this->askPob();
    }
  }

  public function askPob()
  {
    if (empty($this->user->pob)) {
      $this->ask("Silahkan masukan tempat lahir kamu:", function (Answer $answer) {
        $pob = trim($answer->getText());
        if (preg_match("/^[a-zA-Z\s]*$/", $pob)) {
          $this->user['pob'] = $pob;
          $this->askDepartment();
        } else {
          $this->say('Maaf, data yang kamu masukkan sepertinya bukan tempat lahir yang valid. Silahkan coba lagi!');
          $this->askPob();
        }
      });
    } else {
      $this->askDepartment();
    }
  }

  // 
  public function askAddress()
  {
    if (
      empty($this->user->street) ||
      empty($this->user->address_id) ||
      empty($this->user->sub_district_id) ||
      empty($this->user->district_id) ||
      empty($this->user->province_id)
    ) {
      $this->say("Silahkan masukkan alamat kamu!");
      $this->askProvince();
    } else {
      $this->askDepartment();
    }
  }

  public function askProvince()
  {
    $options = [];
    $locations = collect(Location::getProvinces());
    foreach ($locations as $l) {
      $options[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Provinsi:')
      ->callbackId('ask_province')
      ->addButtons($options);

    $this->ask($question, function (Answer $answer) use ($locations) {
      $this->user->province_id = $answer->getValue();
      $this->say($locations->firstWhere('id', $this->user->province_id)->nama);
      $this->askDistrict();
    });
  }

  public function askDistrict()
  {
    $options = [];
    $locations = collect(Location::getDistricts($this->user->province_id));
    foreach ($locations as $l) {
      $options[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Kabupaten/Kota:')
      ->callbackId('ask_district')
      ->addButtons($options);

    $this->ask($question, function (Answer $answer) use ($locations) {
      $this->user->district_id = $answer->getValue();
      $this->say($locations->firstWhere('id', $this->user->district_id)->nama);
      $this->askSubDistrict();
    });
  }

  public function askSubDistrict()
  {
    $options = [];
    $locations = collect(Location::getSubDistricts($this->user->district_id));
    foreach ($locations as $l) {
      $options[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Kecamatan:')
      ->callbackId('ask_sub_district')
      ->addButtons($options);

    return $this->ask($question, function (Answer $answer) use ($locations) {
      $this->user->sub_district_id = $answer->getValue();
      $this->say($locations->firstWhere('id', $this->user->sub_district_id)->nama);
      $this->askVillage();
    });
  }

  public function askVillage()
  {
    $options = [];
    $locations = collect(Location::getVillages($this->user->sub_district_id));
    foreach ($locations as $l) {
      $options[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Desa/Kelurahan:')
      ->callbackId('ask_village')
      ->addButtons($options);

    return $this->ask($question, function (Answer $answer) use ($locations) {
      $this->user->address_id = $answer->getValue();
      $this->say($locations->firstWhere('id', $this->user->address_id)->nama);
      $this->askStreet();
    });
  }

  public function askStreet()
  {
    $this->ask("Jalan/dusun/RT/RW:", function (Answer $answer) {
      $this->user->street = trim($answer->getText());
      $this->askDepartment();
    });
  }
  // 

  public function askDepartment()
  {
    if (empty($this->user->department_slug)) {
      $db = [];
      foreach (\App\Department::all() as $d) {
        if (empty($db) || count(last($db)) >= 3) {
          $db[] = [];
        }
        $db[count($db) - 1][] = $d->department;
      }

      $this->ask('Silahkam pilih jurusan kamu!', function (Answer $answer) {
        try {
          $department = Department::firstWhere('department', $answer->getText());
          $this->user->department_slug = $department->code;
          $this->say("Baik, jurusan yang kamu pilih adalah " . $department->department);
          $this->askGrad();
        } catch (\Throwable $th) {
          \Log::debug($th->getMessage());
          $this->say("Mohon maaf, silahkan ulangi lagi.");
          $this->askDepartment();
        }
      }, ['reply_markup' => json_encode([
        'keyboard' => $db,
        'one_time_keyboard' => true,
        'resize_keyboard' => true
      ])]);
    } else {
      $this->askGrad();
    }
  }

  public function askGrad()
  {
    if (empty($this->user->grad)) {
      # code...
      $this->ask("Kemudian, silahkan masukkan tahun lulus kamu!", function (Answer $answer) {
        $grad = trim($answer->getText());
        if (preg_match("/^[0-9\s]*$/", $grad)) {
          $this->user->grad = $grad;
          $this->askPhone();
        } else {
          $this->say('Maaf, data yang kamu masukkan sepertinya bukan tahun lulus yang valid. Silahkan coba lagi!');
          $this->askGrad();
        }
      });
    } else {
      $this->askPhone();
    }
  }

  public function askPhone()
  {
    if (empty($this->user->phone)) {
      $this->ask('Nomor telepon:', function (Answer $answer) {
        $payload = $answer->getMessage()->getPayload();
        $phone = null;
        try {
          $phone = $payload['contact']['phone_number'];
        } catch (\Throwable $th) {
          $phone = trim($answer->getText());
        }
        $this->user->phone = $phone;
        $this->askStatus();
      }, ['reply_markup' => json_encode([
        'keyboard' => [[[
          'text' => 'Kirim kontak', 'request_contact' => true,
        ]]],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
      ])]);
    } else {
      $this->askStatus();
    }
  }

  public function askStatus()
  {
    $db = [];
    foreach (\App\Status::all() as $d) {
      if (empty($db) || count(last($db)) >= 3) {
        $db[] = [];
      }
      $db[count($db) - 1][] = $d->status;
    }
    if (empty($db) || count(last($db)) >= 3) {
      $db[] = [];
    }
    $db[count($db) - 1][] = "Belum ada";

    return $this->ask('Silahkan pilih status pekerjaan/kegiatan kamu saat sekarang!', function (Answer $answer) {
      try {
        $status = Status::where('status', $answer->getText())->first();
        if (empty($status)) {
          $this->data['status'] =  [];
        } else {
          if (empty($this->data['status'])) {
            $this->data['status'] = [['status_id' => $status->id]];
          } else {
            \Log::debug('status' . json_encode($this->data['status']));
            $this->data['status'][0]['status_id'] = $status->id;
          }
        }

        $this->update();
      } catch (\Throwable $th) {
        \Log::debug($th->getMessage());
        $this->say("Mohon maaf, silahkan ulangi lagi.");
        $this->askStatus();
      }
    }, ['reply_markup' => json_encode([
      'keyboard' => $db,
      'one_time_keyboard' => true,
      'resize_keyboard' => true
    ])]);
  }

  public function update()
  {
    $this->user->save();

    try {
      $old_status_id = $this->user->statuses()->first()->pivot->id;
    } catch (\Throwable $th) {
      $old_status_id = '';
    }

    if (isset($this->data['status'])) {
      foreach ($this->data['status'] as $status) {
        if (empty($status['status_id'])) {
          continue;
        }
        if (!empty($old_status_id)) {
          DB::table('user_statuses')
            ->where('id', $old_status_id)
            ->update([
              'user_id' => $this->user->id,
              'status_id' => $status['status_id'],
            ]);
        } else {
          DB::table('user_statuses')->insert([
            'user_id' => $this->user->id,
            'status_id' => $status['status_id'],
          ]);
        }
      }
    }

    $message = "Selamat, data kamu sekarang sudah lengkap. Sekarang kamu bisa juga mengaksis website alumni SMK N Pringsurat dengan menggunakan:";
    $message .= "\nEmail: {$this->user->email} atau NISN: {$this->user->nisn}";
    $message .= "\nPassword: " . date('dmY', strtotime($this->user->dob));
    $this->say($message);
    $this->say('Terimakasih. ^_^', ['reply_markup' => self::keyboardDefault()]);
    return true;
  }

  public function run()
  {
    $this->botinfo = $this->bot->getUser()->getInfo();
    try {
      $this->user = User::where('telegram_id', $this->botinfo['user']['id'])->firstOrFail();
      $this->askEmail();
    } catch (\Throwable $th) {
      $message = 'Mohon maaf, sepertinya kamu belum terdaftar sebagai alumni SMK N Pringsurat. Silahkan tekan /validasi untuk mengecek apakah akun kamu terdaftar sebagai alumni SMK N Pringsurat';
      $this->say($message, ['reply_markup' => self::keyboardDefault()]);
      \Log::error($th);
    }
  }
}

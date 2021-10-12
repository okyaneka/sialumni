<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;
use App\Location;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\Facades\DB;

class UpdateConversation extends Conversation
{
  protected $data = [], $user, $botinfo;

  public function __construct($param = null)
  {
    $this->user = new User;
  }

  public function greetings()
  {
    if ($this->user->isDataComplete(true)) {
      $this->showMenu();
    } else {
      $message = "Sepertinya data kamu masih belum lengkap. Jangan khawatir, cukup ikuti instruksi saya ya.";
      $this->say($message);
      $this->bot->startConversation(new FirstUpdateConversation(), $this->botinfo['user']['id'], TelegramDriver::class);
    }
  }

  public function showMenu()
  {
    $button = [
      Button::create('Status')->value('status'),
      Button::create('Alamat')->value('address'),
      Button::create('Nomor telepon')->value('phone'),
      Button::create('batal')->value('cancel'),
    ];

    $question = Question::create("Silahkan pilih data apa yang ingin diperbarui!")
      ->callbackId('menu')
      ->addButtons($button);

    return $this->ask($question, function (Answer $answer) {
      switch ($answer->getValue()) {
        case 'status':
          $this->askStatus();
          break;

        case 'address':
          $this->askAddress();
          break;

        case 'phone':
          $this->askPhone();
          break;

        case 'cancel':
          $this->closing();
          break;
        default:
          // code...
          break;
      }
    });
  }

  public function closing()
  {
    $this->say('Terimakasih telah menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.');
  }

  // ########################################################################

  public function askStatus()
  {
    $status = [];

    foreach (\App\Status::all() as $s) {
      $status[] = Button::create($s->status)->value($s->id);
    }

    $question = Question::create('Silahkan masukkan status kegiatan kamu yang baru!')
      ->callbackId('ask_status')
      ->addButtons($status);

    return $this->ask($question, function (Answer $answer) {
      $this->data['status'][0]['status_id'] = $answer->getValue();
      $this->askConfirm();
    });
  }

  public function askAddress()
  {
    $this->say("Untuk mengubah data alamat, kamu akan diminta memasukkan data Provinsi, Kabupaten, Kecamatan, Desa, dan Dusun secara berturut-turut.");
    return $this->askProvince();
  }

  public function askProvince()
  {
    $location = [];

    foreach (Location::getProvinces() as $l) {
      $location[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Silahkan masukkan alamat (provinsi) kamu!')
      ->callbackId('ask_province')
      ->addButtons($location);

    return $this->ask($question, function (Answer $answer) {
      $this->data['province'] = $answer->getValue();
      $this->askDistrict();
    });
  }

  public function askDistrict()
  {
    $location = [];

    foreach (Location::getDistricts($this->data['province']) as $l) {
      $location[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Silahkan masukkan alamat (kabupaten) kamu!')
      ->callbackId('ask_district')
      ->addButtons($location);

    return $this->ask($question, function (Answer $answer) {
      $this->data['district'] = $answer->getValue();
      $this->askSubDistrict();
    });
  }

  public function askSubDistrict()
  {
    $location = [];

    foreach (Location::getSubDistricts($this->data['district']) as $l) {
      $location[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Silahkan masukkan alamat (kecamatan) kamu!')
      ->callbackId('ask_sub_district')
      ->addButtons($location);

    return $this->ask($question, function (Answer $answer) {
      $this->data['sub_district'] = $answer->getValue();
      $this->askVillage();
    });
  }

  public function askVillage()
  {
    $location = [];

    foreach (Location::getVillages($this->data['sub_district']) as $l) {
      $location[] = Button::create($l->nama)->value($l->id);
    }

    $question = Question::create('Silahkan masukkan alamat (desa / kelurahan) kamu!')
      ->callbackId('ask_address')
      ->addButtons($location);

    return $this->ask($question, function (Answer $answer) {
      $this->data['address'] = $answer->getValue();
      $this->askStreet();
    });
  }

  public function askStreet()
  {
    return $this->ask("Silahkan masukkan alamat (jalan / dusun / RT RW) kamu!", function (Answer $answer) {
      $this->data['street'] = trim($answer->getText());
      $this->askConfirm();
    });
  }

  public function askPhone()
  {
    return $this->ask("Silahkan kirimkan nomor telepon kamu!", function (Answer $answer) {
      $payload = $answer->getMessage()->getPayload();
      $phone = $payload['contact']['phone_number'];
      $this->data['phone'] = $phone;
      $this->askConfirm();
    }, [
      'reply_markup' => json_encode([
        'keyboard' => [
          [
            ['text' => 'Kirim kontak', 'request_contact' => true]
          ]
        ]
      ])
    ]);
  }

  // ########################################################################

  public function askConfirm()
  {
    $message = "Kamu akan mengubah data-data berikut:\n";
    $message .= !empty($this->data['status']) ? "Status : dari " . $this->user->statuses()->first()->status . " menjadi " . \App\Status::find($this->data['status'][0]['status_id'])->status . "\n" : '';
    $message .= !empty($this->data['province']) ?
      "Alamat :\ndari " . $this->user->full_address . "menjadi\n" .
      $this->data['street'] . ', ' .
      Location::getVillage($this->data['address'])->nama . ', ' .
      Location::getSubDistrict($this->data['sub_district'])->nama . ', ' .
      Location::getDistrict($this->data['district'])->nama . ', ' .
      Location::getProvince($this->data['province'])->nama . "\n" : '';
    $message .= !empty($this->data['phone']) ? "Nomor telepon : dari " . $this->user->phone . " menjadi " . $this->data['phone'] : '';
    $this->say($message);

    $question = Question::create("Apakah kamu akan mengubah data tersebut?")
      ->callbackId('confirm')
      ->addButtons([
        Button::create("Iya, perbarui sekarang")->value('yes'),
        Button::create("Tidak, ada lagi")->value('more'),
        Button::create("Batal")->value('cancel'),
      ]);

    return $this->ask($question, function (Answer $answer) {
      switch ($answer->getValue()) {
        case 'yes':
          $this->update();
          break;

        case 'more':
          $this->showMenu();
          break;

        case 'cancel':
          $this->closing();
          break;

        default:
          // code...
          break;
      }
    });
  }

  public function update()
  {
    $this->user->province_id = empty($this->data['province']) ? $this->user->province_id : $this->data['province'];
    $this->user->district_id = empty($this->data['district']) ? $this->user->district_id : $this->data['district'];
    $this->user->sub_district_id = empty($this->data['sub_district']) ? $this->user->sub_district_id : $this->data['sub_district'];
    $this->user->address_id = empty($this->data['address']) ? $this->user->address_id : $this->data['address'];
    $this->user->street = empty($this->data['street']) ? $this->user->street : $this->data['street'];
    $this->user->phone = empty($this->data['phone']) ? $this->user->phone : $this->data['phone'];
    
    if (isset($this->data['status'])) {
      $old_status_id = $this->user->statuses()->first();
      foreach ($this->data['status'] as $status) {
        if (!empty($old_status_id)) {
          DB::table('user_statuses')
            ->where('id', $old_status_id->pivot->id)
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

    $this->user->update();

    $this->say("Data kamu telah tersimpan");
    return $this->closing();
  }

  /**
   * Start the conversation
   */
  public function run()
  {
    $this->botinfo = $this->bot->getUser()->getInfo();
    try {
      $this->user = $this->user->where('telegram_id', $this->botinfo['user']['id'])->firstOrFail();
      $this->greetings();
    } catch (\Throwable $th) {
      $message = 'Mohon maaf, sepertinya kamu belum terdaftar sebagai alumni SMK N Pringsurat. Silahkan tekan /validasi untuk mengecek apakah akun kamu terdaftar sebagai alumni SMK N Pringsurat';
      $this->say($message);
      \Log::error($th);
    }
  }
}

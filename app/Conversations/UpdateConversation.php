<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;
use App\Location;
use App\Status;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Support\Facades\DB;

class UpdateConversation extends Conversation
{
  protected $data = [], $user, $botinfo;

  public function __construct($param = null)
  {
    $this->user = new User;
  }

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

  public function greetings()
  {
    if ($this->user->isDataComplete(true)) {
      $this->showMenu();
    } else {
      $message = "Silahkan ikuti instruksi saya ya.";
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
      ->callbackId('menu');

    return $this->ask('Silahkan pilih data apa yang ingin diperbarui!', function (Answer $answer) {
      switch ($answer->getText()) {
        case 'Status Pekerjaan':
          $this->askStatus();
          break;

        case 'Alamat':
          $this->askAddress();
          break;

        case 'Telepon':
          $this->askPhone();
          break;

        case 'Tidak Jadi':
          $this->closing();
          break;
        default:
          $this->say("Mohon maaf, silahkan ulangi lagi.");
          $this->showMenu();
          break;
      }
    }, ['reply_markup' => json_encode([
      'keyboard' => [
        [
          ['text' => 'Status Pekerjaan', 'callback_data' => 13],
          ['text' => 'Alamat'],
          ['text' => 'Telepon'],
        ], [
          ['text' => 'Tidak Jadi'],
        ]
      ],
      'one_time_keyboard' => true,
      'resize_keyboard' => true
    ])]);
  }

  public function closing()
  {
    $this->say('Terimakasih telah menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.', ['reply_markup' => json_encode([
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
      'resize_keyboard' => true
    ])]);
  }

  // ########################################################################

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


    return $this->ask('Silahkan masukkan status kegiatan kamu yang baru!', function (Answer $answer) {
      try {
        $status = Status::where('status', $answer->getText())->first();

        if (empty($status)) {
          $this->data['status'] =  [];
        } else {
          if (empty($this->data['status'])) {
            $this->data['status'] = [['status_id' => $status->id]];
          } else {
            $this->data['status'][0]['status_id'] = $status->id;
          }
        }
        return $this->askConfirm();
      } catch (\Throwable $th) {
        \Log::debug($th->getMessage());
        $this->say("Mohon maaf, silahkan ulangi lagi.");
        $this->askStatus();
      }
    }, [
      'reply_markup' => json_encode([
        'keyboard' => $db,
        'one_time_keyboard' => true,
        'resize_keyboard' => true
      ])
    ]);
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
      $phone = null;
      try {
        $phone = $payload['contact']['phone_number'];
      } catch (\Throwable $th) {
        $phone = trim($answer->getText());
      }
      $this->data['phone'] = $phone;
      $this->askConfirm();
    }, [
      'reply_markup' => json_encode([
        'keyboard' => [
          [['text' => 'Kirim kontak', 'request_contact' => true]]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
      ])
    ]);
  }

  // ########################################################################

  public function askConfirm()
  {
    $message = "Kamu akan mengubah data-data berikut:\n";
    if (!empty($this->data['status'])) {
      $old_status = empty($this->user->statuses()->first()) ? 'Belum ada' : $this->user->statuses()->first()->status;
      $new_status = empty(\App\Status::find($this->data['status'][0]['status_id'])) ? 'Belum ada' : \App\Status::find($this->data['status'][0]['status_id'])->status;
      $message .=  "- Status pekerjaan dari " . $old_status . " menjadi " . $new_status . "";
    } else {
      $old_status = empty($this->user->statuses()->first()) ? 'Belum ada' : $this->user->statuses()->first()->status;
      $new_status = 'Belum ada';
      $message .=  "- Status pekerjaan dari " . $old_status . " menjadi " . $new_status . "";
    }
    $message .= !empty($this->data['province']) ?
      "\n- Alamat dari " . $this->user->full_address . " menjadi " .
      $this->data['street'] . ', ' .
      Location::getVillage($this->data['address'])->nama . ', ' .
      Location::getSubDistrict($this->data['sub_district'])->nama . ', ' .
      Location::getDistrict($this->data['district'])->nama . ', ' .
      Location::getProvince($this->data['province'])->nama . "" : '';
    $message .= !empty($this->data['phone']) ? "\n- Nomor telepon dari " . $this->user->phone . " menjadi " . $this->data['phone'] : '';
    $this->say($message);

    return $this->ask('Apakah kamu akan mengubah data tersebut?', function (Answer $answer) {
      switch ($answer->getText()) {
        case 'Iya, perbarui sekarang':
          $this->update();
          break;

        case 'Belum, masih ada lagi':
          $this->showMenu();
          break;

        case 'Batal':
        default:
          $this->closing();
          break;
      }
    }, [
      'reply_markup' => json_encode([
        'keyboard' => [
          [
            ['text' => 'Iya, perbarui sekarang'],
            ['text' => 'Belum, masih ada lagi'],
            ['text' => 'Batal'],
          ]
        ],
        'resize_keyboard' => true,
        'one_time_keyboard' => true
      ])
    ]);
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
      $this->say($message, ['reply_markup' => self::keyboardDefault()]);
      \Log::error($th);
    }
  }
}

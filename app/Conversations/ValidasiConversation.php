<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;

class ValidasiConversation extends Conversation
{
  protected $data = [], $botinfo;

  public function __construct($param = null)
  {
    $this->user = new User;
  }

  private static function keyboardFree()
  {
    return json_encode(['remove_keyboard' => true]);
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

  public function askName()
  {
    return $this->ask("Silahkan masukkan nama lengkap kamu!", function (Answer $answer) {
      $this->data['name'] = trim($answer->getText());
      $this->askDoB();
    }, ['reply_markup' => self::keyboardFree()]);
  }

  public function askDoB()
  {
    return $this->ask("Silahkan masukkan tanggal lahir (format TANGGAL-BULAN-TAHUN) kamu!\nContoh: 17-08-1945", function (Answer $answer) {
      $this->data['dob'] = trim($answer->getText());
      $this->validate();
    });
  }

  public function validate()
  {
    $message = '';
    try {
      $user = User::where([
        ['name', '=', $this->data['name']],
        ['dob', '=', date('Y-m-d', strtotime($this->data['dob']))],
      ])->firstOrFail();
      $user->telegram_id = $this->botinfo['user']['id'];
      $user->save();
      $message = "Selamat, kamu sudah terdaftar sebagai alumni SMK N Pringsurat. ";
      $message .= "Untuk join group alumni SMK N Pringsurat bisa pakai link https://t.me/+Eq3_XJj-MqdlZGVl. ";

      if (!$user->isDataComplete(true)) {
        $message .= "\nTapi data diri kamu masih belum lengkap nih, boleh minta tolong untuk melengkapi data diri kamu dengan menggunakan perintah /update. Terimakasih 😄";
      }
      $this->say($message, ['reply_markup', self::keyboardDefault()]);
    } catch (\Throwable $th) {
      $message = 'Mohon maaf, sepertinya kamu belum/tidak terdaftar sebagai alumni SMK N Pringsurat.';
      $this->say($message);
    }
  }

  public function info(User $user)
  {
    $message = 'Akun kamu telah terdaftar sebagai:';
    $message .= "\nNama: $user->name";
    $message .= "\nJurusan: $user->department";
    $message .= "\nStatus alumni: $user->status";

    if (!$user->isDataComplete(true)) {
      $message .= "\n\nTapi data diri kamu masih belum lengkap nih, boleh minta tolong untuk melengkapi data diri kamu dengan menggunakan perintah /update. Terimakasih 😄";
    } else {
      $message .= "\n\nKamu masih bisa mencari informasi lainya dengan menekan perintah berikut.";
    }

    $this->say($message, ['reply_markup' => self::keyboardDefault()]);
  }

  public function run()
  {
    $this->botinfo = $this->bot->getUser()->getInfo();
    try {
      $user = User::where('telegram_id', $this->botinfo['user']['id'])->firstOrFail();
      $this->info($user);
    } catch (\Throwable $th) {
      $this->askName();
      \Log::error($th);
    }
  }
}

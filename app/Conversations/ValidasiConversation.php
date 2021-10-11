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

  public function askNisn()
  {
    return $this->ask("Silahkan masukkan nisn Kamu!", function (Answer $answer) {
      $this->data['nisn'] = trim($answer->getText());
      $this->askDoB();
    });
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
        ['nisn', '=', $this->data['name']],
        ['dob', '=', date('Y-m-d', strtotime($this->data['dob']))],
      ])->firstOrFail();
      $user->telegram_id = $this->botinfo['user']['id'];
      $user->save();
      $message = "Selamat, kamu sudah terdaftar sebagai alumni SMK N Pringsurat.";

      if (!$user->isDataComplete(true)) {
        $message .= "\nTetapi data diri kamu masih belum lengkap nih, boleh minta tolong untuk melengkapi data diri kamu dengan menggunakan perintah /update. Terimakasih 😄";
      }
    } catch (\Throwable $th) {
      $message = 'Mohon maaf, sepertinya kamu belum/tidak terdaftar sebagai alumni SMK N Pringsurat.';
    }

    $this->say($message);
  }

  public function info(User $user)
  {
    $message = 'Akun kamu telah terdaftar sebagai:';
    $message .= "\nNama: $user->name";
    $message .= "\nJurusan: $user->department";
    $message .= "\nStatus alumni: $user->status";
    $this->say($message);
  }

  public function run()
  {
    $this->botinfo = $this->bot->getUser()->getInfo();
    try {
      $user = User::where('telegram_id', $this->botinfo['user']['id'])->firstOrFail();
      $this->info($user);
    } catch (\Throwable $th) {
      $this->askNisn();
      \Log::error($th);
    }
  }
}

<?php

namespace App\Conversations;

use App\Job;
use App\User;
use BotMan\BotMan\Messages\Attachments\Contact;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;

class AlumniConversation extends Conversation
{
  const EXCEPTIONS_KEYWORDS = ['lulusan', 'angkatan', 'jurusan', 'nama'];

  protected $botinfo;

  protected $offset = 0;

  protected $user;

  protected $users;

  public function __construct()
  {
    $this->users = User::where('type', User::DEFAULT_TYPE)->whereNotNull('grad')->orderBy('name')->get();
  }

  public function askForSearch()
  {
    // $buttons = [
    //   Button::create('Ya, tolong!')->value('yes'),
    //   Button::create('Tidak, terimakasih.')->value('no'),
    // ];

    $question = Question::create("Kamu ingin mencoba mencarinya?")->callbackId('ask_for_search');

    $this->ask($question, function (Answer $answer) {
      switch ($answer->getText()) {
        case 'Ya':
          $this->doSearch();
          break;
        case 'Tidak':
        default:
          $this->closing();
          break;
      }
    }, [
      'reply_markup' => json_encode([
        'keyboard' => [
          [
            ['text' => 'Ya'],
            ['text' => 'Tidak']
          ]
        ]
      ])
    ]);
  }

  public function doSearch()
  {
    $this->ask("Kamu ingin mencari siapa?", function (Answer $answer) {
      $this->users = User::where('type', User::DEFAULT_TYPE)->whereNotNull('grad')->orderBy('name');
      $keywords = explode(' ', strtolower(trim($answer->getText())));
      foreach (self::EXCEPTIONS_KEYWORDS as $except) {
        if (($index = array_search($except, $keywords)) !== false) {
          array_splice($keywords, $index, 1);
        }
      }
      $this->users->where(function ($query) use ($keywords) {
        $query->where(function ($query) use ($keywords) {
          foreach ($keywords as $keyword) {
            $query->orWhere('name', 'LIKE', "%$keyword%");
          }
        });
        $query->orWhere(function ($query) use ($keywords) {
          foreach ($keywords as $keyword) {
            $query->orWhere('grad', 'LIKE', "%$keyword%");
          }
        });
        $query->orWhere(function ($query) use ($keywords) {
          foreach ($keywords as $keyword) {
            $query->orWhere('department_slug', 'LIKE', "%$keyword%");
          }
        });
      });
      $this->users = $this->users->get();
      if ($this->users->count() > 0) {
        $this->say("Aku menemukan ada {$this->users->count()} alumni yang mirip dengan \"{$answer->getText()}\", berikut di antaranya:");
        $this->showUser();
      } else {
        $this->askConfirm("Maaf, aku tidak bisa menemukan alumni yang mirip dengan \"{$answer->getText()}\"");
      }
    });
  }

  public function showUser()
  {
    $user = $this->users->skip($this->offset)->first();
    $this->askConfirm($this->userToText($user));
    // if (!empty($user->phone)) {
    //   $contact = new Contact($user->phone, $user->name, '', $user->telegram_id);
    //   $message = OutgoingMessage::create('')->withAttachment($contact);
    //   $this->say($message);
    // }


  }

  public function askConfirm($message)
  {
    $keyboard = [];
    if ($this->offset > 0) {
      $keyboard[] = ['text' => 'Sebelumnya'];
    }
    if (($this->offset + 1) < $this->users->count()) {
      $keyboard[] = ['text' => 'Berikutnya'];
    }

    $this->ask(Question::create($message)->callbackId('show_job'), function (Answer $answer) {
      switch ($answer->getText()) {
        case 'Sebelumnya':
          $this->offset -= 1;
          $this->showJob();
          break;
        case 'Berikutnya':
          $this->offset += 1;
          $this->showJob();
          break;
        case 'Ubah kata kunci':
          $this->offset = 0;
          $this->doSearch();
          break;
        case 'Cukup':
        default:
          $this->closing();
          break;
      }
    }, [
      'reply_markup' => json_encode([
        'keyboard' => [
          [
            $keyboard
          ],
          [
            ['text' => 'Ubah kata kunci'],
            ['text' => 'Cukup'],
          ]
        ]
      ])
    ]);
  }

  public function closing()
  {
    $this->say('Terimakasih telah menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.');
    return true;
  }

  private function userToText(User $user)
  {
    $text = '';
    $text .= ucwords($user->name) . "\n";
    $text .= "Jurusan $user->department\n";
    $text .= "Lulusan $user->grad\n";
    if (!empty($user->phone)) {
      $text .= "kontak $user->phone\n";
    }
    $text .= "Info: " . route('user.show', $user);

    return $text;
  }

  public function run()
  {
    try {
      $this->botinfo = $this->bot->getUser()->getInfo();
      $this->user = User::where('telegram_id', $this->botinfo['user']['id'])->firstOrFail();
      if ($this->users->count()) {
        $message = "Sampai saat ini, sudah ada {$this->users->count()} alumni yang terdaftar di sistem kami. Kamu dapat mencari salah satu dari mereka berdasarkan nama, jurusan, atau lulusan.";
        $this->say($message);
        $this->askForSearch();
      } else {
        return $this->say("Mohon maaf, untuk saat ini belum ada alumni yang terdaftar di sistem kami.");
      }
    } catch (\Throwable $th) {
      $message = 'Mohon maaf, sepertinya kamu belum terdaftar sebagai alumni SMK N Pringsurat. Silahkan tekan /validasi untuk mengecek apakah akun kamu terdaftar sebagai alumni SMK N Pringsurat';
      $this->say($message);
      \Log::error($th);
    }
  }
}

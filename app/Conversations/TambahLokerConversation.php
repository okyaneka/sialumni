<?php

namespace App\Conversations;

use App\Job;
use App\User;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Support\Facades\Storage;

class TambahLokerConversation extends Conversation
{
  protected $botinfo;
  protected $user;
  protected $poster;
  protected $raw_data;

  public function __construct()
  {
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

  public function askPoster()
  {
    return $this->askForImages(
      "Silahkan kirimkan gambar poster (bila ada)",
      function ($images) {
        try {
          $image = $images[0];
          $url = $image->getUrl(); // The direct url
          $contents = file_get_contents($url);
          $path = str_replace('/', DIRECTORY_SEPARATOR, '/posters/');
          $format = substr($url, strrpos($url, '.') + 1);
          $name = 'poster_' . time() . '.' . $format;
          Storage::put($path . $name, $contents, 'public');
          $this->poster = 'posters/' . $name;
          return $this->askInfo();
        } catch (\Throwable $th) {
          \Log::error($th->getMessage());
          $this->say('Mohon maaf bisa diulangi lagi!');
          return $this->askPoster();
        }
      },
      function (Answer $answer) {
        try {
          if ($answer->getText() == 'Tidak ada gambar') {
            return $this->say('Terimakasih');
            return $this->askInfo();
          } else {
            throw new \Error("Bukan gambar");
          }
        } catch (\Throwable $th) {
          \Log::error($th->getMessage());
          $this->say('Mohon maaf bisa diulangi lagi!');
          return $this->askPoster();
        }
      },
      [
        'reply_markup' => json_encode([
          'keyboard' => [['Tidak ada gambar']],
          'resize_keyboard' => true,
          'one_time_keyboard' => true
        ])
      ]
    );
  }

  public function askInfo()
  {
    return $this->ask('Silahkan masukan informasi loker!', function (Answer $answer) {
      $this->raw_data = $answer->getText();
      return $this->saving();
    }, ['reply_markup' => self::keyboardFree()]);
  }

  public function saving()
  {
    Job::create([
      'company' => 'null',
      'position' => 'null',
      'location' => 'null',
      'duedate' => date('Y-m-d', strtotime('+30 days')),
      'seen_until' => date('Y-m-d', strtotime('+30 days')),
      'raw_data' => $this->raw_data,
      'poster' => $this->poster
    ]);

    $message = 'Terimakasih. Info loker kamu akan segera kami proses.';
    $message .= "\n\nKamu masih bisa mencari informasi lainya dengan menekan perintah berikut.";
    return $this->say($message, ['reply_markup' => self::keyboardDefault()]);
  }

  public function run()
  {
    try {
      $this->botinfo = $this->bot->getUser()->getInfo();
      $this->user = User::where('telegram_id', $this->botinfo['user']['id'])->firstOrFail();
      $this->say(
        "Untuk menambahkan informasi lowongan pekerjaan, silahkan kirimkan gambar poster (bila ada) dan informasi lowongan pekerjaan.",
        ['reply_markup' => self::keyboardFree()]
      );
      return $this->askPoster();
    } catch (\Throwable $th) {
      \Log::error($th);
      $message = 'Mohon maaf, sepertinya kamu belum terdaftar sebagai alumni SMK N Pringsurat. Silahkan tekan /validasi untuk mengecek apakah akun kamu terdaftar sebagai alumni SMK N Pringsurat';
      $this->say($message, ['reply_markup' => self::keyboardDefault()]);
    }
  }
}

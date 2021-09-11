<?php

namespace App\Conversations;

use App\Job;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class LokerConversation extends Conversation
{
  protected $offset = 0;

  protected $jobs;

  public function showJob()
  {
    $buttons = [
      Button::create('Berikutnya')->value('next'),
      Button::create('Cukup')->value('enough'),
    ];

    $job = $this->jobs->skip($this->offset)->first();

    $this->ask(Question::create($this->jobToText($job))->callbackId('show_job')->addButtons($buttons), function (Answer $answer) {
      switch ($answer->getValue()) {
        case 'next':
          $this->offset += 1;
          $this->showJob();
          break;
        case 'enough':
          $this->say('Terimakasih telah menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.');
          return true;
        default:
          break;
      }
    });
  }

  private function jobToText(Job $job)
  {
    $text = '';
    $text .= "$job->company\n";
    $text .= "Posisi: $job->position\n";
    $text .= "Alamat: $job->full_address\n";
    $text .= "Dibuka sampai: " . date('m-d-Y', strtotime($job->duedate)) . "\n";
    if (!empty($requirements = unserialize($job->requirements))) {
      $text .= "\n";
      $text .= "Persyaratan:\n";
      foreach ($requirements as $req) {
        $text .= "- $req\n";
      }
    }
    if (!empty($job->email) || !empty($job->phone)) {
      $text .= "Kontak:\n";
      if (!empty($job->email)) {
        $text .= "- Email: $job->email\n";
      }
      if (!empty($job->phone)) {
        $text .= "- Telepon: $job->phone\n";
      }
    }
    $text .= "\n";
    $text .= "Info: " . route('job.show', $job);

    return $text;
  }

  public function run()
  {
    $this->jobs = Job::where('duedate', '<=', date('Y-m-d'))->get();
    $message = "Aku menemukan ada {$this->jobs->count()} lowongan pekerjaan yang masih dibuka, diantaranya:";
    $this->say($message);
    $this->showJob();
  }
}

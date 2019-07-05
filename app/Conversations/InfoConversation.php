<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;
use App\Job;
use DB;

class InfoConversation extends Conversation
{
    function greetings()
    {
        $question = Question::create('Silahkan pilih informasi apa yang ingin dicari!')
        ->callbackId('ask_info')
        ->addButtons([Button::create('Pengguna')->value('user'),
            Button::create('Loker')->value('job'),
            Button::create('Statistik')->value('statistic'),
        ]);

        return $this->ask($question, function(Answer $answer) {
            switch ($answer->getValue()) {
                case 'user':
                $this->userInfo();
                break;
                case 'job':
                $this->jobInfo();
                break;
                case 'statistic':
                $this->statInfo();
                break;
                default:
                    // code...
                break;
            }
        });
    }

    # /////////////////////////////////////////////////////////////////////////

    function userInfo()
    {
        $user = User::where('telegram_id', $this->bot->getUser()->getId())->get()->first();

        $message = "Berikut ini info tentang anda\n".
        "Nama : $user->name\n".
        "Email : $user->email\n".
        "TTL : $user->pob, ".date("d-M-Y", strtotime($user->dob))."\n".
        "Alamat : $user->street, ".$user->getAddress().", ".$user->getSubDistricts().", ".$user->getDistricts().", ".$user->getProvinces()."\n".
        "Lulusan : $user->grad\n".
        "Jurusan : $user->department\n".
        "Telepon : $user->phone\n".
        "Status : \n";
        $status = $user->statuses()->get();
        foreach ($status as $s) {
            $message .= "- ".$s->status;
            $message .= !empty($s->pivot->info) ? " di ".$s->pivot->info : "";
            $message .= !empty($s->pivot->year) ? " sampai ".$s->pivot->year : "";
            $message .= "\n";
        }

            // $status->status 
            // @if (!empty($status->pivot->info))
            // di <strong>{{ $status->pivot->info }}</strong>
            // @endif
            // @if (!empty($status->pivot->year))
            // sampai {{ $status->pivot->year }}
            // @endif


        return $this->say($message);
    }

    function jobInfo($offset = 0)
    {
        $jobs = Job::where('duedate','>',date('Y-m-d'))
        ->offset($offset)
        ->limit(5)
        ->get();

        $message = "Berikut ini beberapa informasi lowongan pekerjaan\n";
        foreach ($jobs as $j) {
            $location = unserialize($j->location);
            $message .= "- $j->company\n".
            "Posisi sebagai $j->position\n".
            $location['street'].",".
            \App\Location::getVillage($location['address'])->nama.",".
            \App\Location::getSubDistrict($location['sub_district'])->nama.",".
            \App\Location::getDistrict($location['district'])->nama.",".
            \App\Location::getProvince($location['province'])->nama."\n";
            $message .= route('job.show', $j);
            $message .= "\n\n";
        }

        $button = [];
        if ($jobs->count() == 5) {
            $button[] = Button::create('Lagi')->value($offset+5);
        }
        $button[] = Button::create('Cukup')->value('enough');

        $question = Question::create($message)
        ->callbackId('ask_info')
        ->addButtons($button);

        // return $this->reply($message);
        return $this->ask($question, function(Answer $answer) {
            switch ($answer->getValue()) {
                case 'enough':
                $this->closing();
                break;
                
                default:
                $this->jobInfo($answer->getValue());
                    // code...
                break;
            }
        });
    }

    function statInfo()
    {
        $total = User::where('type','=','default')->whereNotNull('grad')->count();
        $statuses = DB::table('statuses')
            ->join('user_statuses','statuses.id','=','user_statuses.status_id')
            ->select(DB::raw('statuses.id, statuses.status, count(*) as total'))
            ->groupBy('id')
            ->get();

        $message = "Statistik alumni hingga saat ini\nTotal alumni $total\n";
        foreach ($statuses as $s) {
            $message .= "Total alumni yang $s->status adalah $s->total\n";
        }
        $message .= "data ini di ambil sejak %y";

        return $this->say($message);
    }

    function closing()
    {
        return $this->say('Terimakasih menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.');
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->greetings();
    }
}

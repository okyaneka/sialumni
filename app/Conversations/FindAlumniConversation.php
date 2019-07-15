<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;

class FindAlumniConversation extends Conversation
{
    private $data = [];

    function askName()
    {
        return $this->ask("Tuliskan nama alumni yang ingin dicari!", function (Answer $answer) {
            $this->data['keyword'] = $answer->getText();
            $this->result();
        });
    }

    function result()
    {
        $users = User::where('name','like','%'.$this->data['keyword'].'%')
            ->whereNotNull('grad')
            ->get();

        $results = [];

        foreach ($users as $user) {
            $results[] = Button::create($user->name.' ('.$user->department.', '.$user->grad.')')->value($user->id);
        }

        if ($users->count() == 0) {
            return $this->say('Tidak ditemukan data alumni untuk pencarian "'.$this->data['keyword'].'"');
        }

        $question = Question::create('Ditemukan '.$users->count().' alumni')
        ->callbackId('results')
        ->addButtons($results);

        return $this->ask($question, function (Answer $answer) {
            $this->detail($answer->getValue());
        });
    }

    function detail($id)
    {
        $user = User::find($id);

        $message = "Nama : $user->name\n".
            "Jurusan : $user->department\n".
            "Lulusan : $user->grad\n".
            "Nomor Telepon : $user->phone\n";

        $this->say($message);
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        return $this->askName();
    }
}

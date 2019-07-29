<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;
use App\User;
use App\Location;
use DB;

class UpdateConversation extends Conversation
{
    protected $data = [], $user, $botinfo;

    public function __construct($param = null)
    {
        $this->user = new User;
    }

    function greetings()
    {
        $this->say('Dalam menu update, anda dapat memperbarui informasi anda seperti status, alamat, dan nomor telepon.');
        return $this->ask('Balas "Oke" untuk melanjutkan', function(Answer $answer) {
            $this->showMenu();
        });
    }

    function showMenu()
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

        return $this->ask($question, function(Answer $answer)
        {
           switch ($answer->getValue()) {
                case 'status' :
                    $this->askStatus();
                    break;

                case 'address' :
                    $this->askAddress();
                    break;

                case 'phone' :
                    $this->askPhone();
                    break;

                case 'cancel' :
                    $this->closing();
                    break;
                default:
                    // code...
                    break;
            } 
        });
    }

    function closing()
    {
        $this->say('Terimakasih menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.');
        return true;
    }

    // ########################################################################

    function askStatus()
    {
        $status = [];

        foreach (\App\Status::all() as $s) {
            $status[] = Button::create($s->status)->value($s->id);
        }

        $question = Question::create('Silahkan masukkan status kegiatan anda yang baru!')
        ->callbackId('ask_status')
        ->addButtons($status);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['status'][0]['status_id'] = $answer->getValue();
            $this->askConfirm();
        });
    }

    function askAddress()
    {
        $this->say("Untuk mengubah data alamat, kamu akan diminta memasukkan data Provinsi, Kabupaten, Kecamatan, Desa, dan Dusun secara berturut-turut.");
        return $this->askProvince();
    }

    function askProvince()  
    {
        $location = [];

        foreach (Location::getProvinces() as $l) {
            $location[] = Button::create($l->nama)->value($l->id);
        }

        $question = Question::create('Silahkan masukkan alamat (provinsi) anda!')
        ->callbackId('ask_province')
        ->addButtons($location);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['province'] = $answer->getValue();
            $this->askDistrict();
        });
    }

    function askDistrict()
    {
        $location = [];

        foreach (Location::getDistricts($this->data['province']) as $l) {
            $location[] = Button::create($l->nama)->value($l->id);
        }

        $question = Question::create('Silahkan masukkan alamat (kabupaten) anda!')
        ->callbackId('ask_district')
        ->addButtons($location);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['district'] = $answer->getValue();
            $this->askSubDistrict();
        });
    }

    function askSubDistrict()
    {
        $location = [];

        foreach (Location::getSubDistricts($this->data['district']) as $l) {
            $location[] = Button::create($l->nama)->value($l->id);
        }

        $question = Question::create('Silahkan masukkan alamat (kecamatan) anda!')
        ->callbackId('ask_sub_district')
        ->addButtons($location);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['sub_district'] = $answer->getValue();
            $this->askVillage();
        });
    }

    function askVillage()
    {
        $location = [];

        foreach (Location::getVillages($this->data['sub_district']) as $l) {
            $location[] = Button::create($l->nama)->value($l->id);
        }

        $question = Question::create('Silahkan masukkan alamat (desa / kelurahan) anda!')
        ->callbackId('ask_address')
        ->addButtons($location);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['address'] = $answer->getValue();
            $this->askStreet();
        });
    }

    function askStreet()
    {
        return $this->ask("Silahkan masukkan alamat (jalan / dusun / RT RW) anda!", function(Answer $answer)
        {
            $this->data['street'] = trim($answer->getText());
            $this->askConfirm();
        });
    }

    function askPhone()
    {
        return $this->ask("Silahkan masukkan nomor telepon anda!", function(Answer $answer)
        {
            $this->data['phone'] = trim($answer->getText());
            $this->askConfirm();
        });
    }

    // ########################################################################

    function askConfirm()
    {
        $message = "Anda akan mengubah data-data berikut:\n";
        $message .= !empty($this->data['status']) ? "Status : dari ".$this->user->statuses()->first()->status." menjadi ".\App\Status::find($this->data['status'][0]['status_id'])->status."\n" : '';
        $message .= !empty($this->data['province']) ? 
            "Alamat :\ndari ".
            $this->user->street.', '.
            Location::getVillage($this->user->address)->nama.', '.
            Location::getSubDistrict($this->user->sub_district)->nama.', '.
            Location::getDistrict($this->user->district)->nama.', '.
            Location::getProvince($this->user->province)->nama."\n"
            ."menjadi\n".
            $this->data['street'].', '.
            Location::getVillage($this->data['address'])->nama.', '.
            Location::getSubDistrict($this->data['sub_district'])->nama.', '.
            Location::getDistrict($this->data['district'])->nama.', '.
            Location::getProvince($this->data['province'])->nama."\n" : '';
        $message .= !empty($this->data['phone']) ? "Nomor telepon : dari ".$this->user->phone." menjadi ".$this->data['phone'] : '';
        $this->say($message);

        $question = Question::create("Apakah anda akan mengubah data tersebut?")
        ->callbackId('confirm')
        ->addButtons([
            Button::create("Iya, perbarui sekarang")->value('yes'),
            Button::create("Tidak, ada lagi")->value('more'),
            Button::create("Batal")->value('cancel'),
        ]);

        return $this->ask($question, function(Answer $answer)
        {
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

    function update()
    {
        $this->user->province = empty($this->data['province']) ? $this->user->province : $this->data['province'];
        $this->user->district = empty($this->data['district']) ? $this->user->district : $this->data['district'];
        $this->user->sub_district = empty($this->data['sub_district']) ? $this->user->sub_district : $this->data['sub_district'];
        $this->user->address = empty($this->data['address']) ? $this->user->address : $this->data['address'];
        $this->user->street = empty($this->data['street']) ? $this->user->street : $this->data['street'];
        $this->user->phone = empty($this->data['phone']) ? $this->user->phone : $this->data['phone'];

        $old_status_id = $this->user->statuses()->first()->pivot->id;

        // $this->data['status'][0]['status_id'] = '3';

        // $this->say(json_encode($old_status->pivot->id));
        // return;

        if (isset($this->data['status'])) {   
            foreach ($this->data['status'] as $status) {
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


        $this->user->update();

        $this->say("Data anda telah tersimpan");
        return $this->closing();

    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->botinfo = $this->bot->getUser()->getInfo();
        $this->user = $this->user->where('telegram_id', $this->bot->getUser()->getId())->get()->first();

        if (empty($this->user)) {
            return $this->say("Akun telegram anda belum terdaftar sebagai alumni kami. Silahkan tekan /daftar untuk mendaftarkan akun anda sebagai alumni kami");
        }

        if ($this->user->count() == 0) {
            $this->say("Mohon maaf, akun anda tidak terdaftar sebagai alumni SMK Negeri Pringsurat. Silahkan tekan /daftar untuk mendaftarkan akun anda");
            return TRUE;
        }

        $this->greetings();
    }
}

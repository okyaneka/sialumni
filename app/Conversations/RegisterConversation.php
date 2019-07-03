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

class RegisterConversation extends Conversation
{
    protected $data = [], $user, $botinfo;

    public function __construct($param = null)
    {
        $this->user = new User;
    }

    function greetings()
    {
        $this->say('Dalam menu pendaftaran ini, anda akan diminta memasukan beberapa data secara bertahap.');
        $this->say('Data-data tersebut antara lain');
        $this->say('nama lengkap, alamat email, tempat lahir, tanggal lahir, jurusan, tahun lulus, jenis kelamin, alamat (provinsi), alamat (kabupaten), alamat (kecamatan), alamat (desa), alamat (jalan / RT RW), nomor telepon, nomor telegram');
        return $this->ask('Baik kita mulai untuk yang pertama. (Balas "oke" untuk memulai)', function(Answer $answer) {
            if (strtolower($answer->getText()) == 'oke') {
                $this->askName();
            } else {
                $this->closing();
            }
        });
    }

    function askName($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        return $this->ask("Silahkan masukkan nama lengkap Anda!", function(Answer $answer)
        {
            $this->data['name'] = trim($answer->getText());
            if ($this->data['is_fix']) {
                $this->askConfirm(1);
            } else {
                $this->askPoB();
            }
        });
    }

    function askPoB($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        return $this->ask("Silahkan masukkan tempat lahir anda!", function(Answer $answer)
        {
            $this->data['pob'] = trim($answer->getText());
            if ($this->data['is_fix']) {
                $this->askConfirm(1);
            } else {
                $this->askDoB();
            }
        });
    }

    function askDoB($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        return $this->ask("Silahkan masukkan tanggal lahir (format TAHUN-BULAN-TANGGAL) anda!\nContoh : 1945-08-17", function(Answer $answer)
        {
            $this->data['dob'] = trim($answer->getText());
            if ($this->data['is_fix']) {
                $this->askConfirm(1);
            } else {
                $this->askDepartment();
            }
        });
    }

    function askDepartment($is_fix = FALSE)
    {
        $department_button = [];
        foreach (\App\Department::all() as $d) {
            $department_button[] = Button::create($d->department)->value($d->code);
        }
        $question = Question::create('Silahkam masukkan jurusan anda!')
        ->callbackId('ask_department')
        ->addButtons($department_button);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['department'] = $answer->getValue();
            $this->askConfirm(1);
            // $this->askGrad();
        });
    }

    // ########################################################################

    function banned()
    {
        $this->say("Kami mendeteksi bahwa anda bukan alumni dari SMK Negeri Pringsurat. Mohon maaf untuk sementara nomor anda tidak dapat digunakan untuk mendaftarkan diri.");
    }

    // ########################################################################

    function askGrad($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        return $this->ask("Silahkan masukkan tahun lulus anda!", function(Answer $answer)
        {
            $this->data['grad'] = trim($answer->getText());
            if ($this->data['is_fix']) {
                $this->askConfirm(2);
            } else {
                $this->askProvince();
            }
        });
    }

    function askGender($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        $question = Question::create('Silahkan masukkan jenis kelamin anda!')
        ->callbackId('ask_gender')
        ->addButtons([Button::create('Laki-laki')->value('M'),
            Button::create('Perempuan')->value('F')
        ]);

        return $this->ask($question, function(Answer $answer) {
            $this->data['gender'] = $answer->getValue();
            $this->askProvince();
        });
    }

    function askProvince($is_fix = FALSE)  
    {
        $this->data['is_fix'] = $is_fix;
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
            $this->askDistrict($this->data['is_fix']);
        });
    }

    function askDistrict($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
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
            $this->askSubDistrict($this->data['is_fix']);
        });
    }

    function askSubDistrict($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
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
            $this->askAddress($this->data['is_fix']);
        });
    }

    function askAddress($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
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
            $this->askStreet($this->data['is_fix']);
        });
    }

    function askStreet($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        return $this->ask("Silahkan masukkan alamat (jalan / dusun / RT RW) anda!", function(Answer $answer)
        {
            $this->data['street'] = trim($answer->getText());
            if ($this->data['is_fix']) {
                $this->askConfirm(2);
            } else {
                $this->askPhone();
            }
        });
    }

    function askPhone($is_fix = FALSE)
    {
        $this->data['is_fix'] = $is_fix;
        return $this->ask("Silahkan masukkan nomor telepon anda!", function(Answer $answer)
        {
            $this->data['phone'] = trim($answer->getText());
            if ($this->data['is_fix']) {
                $this->askConfirm(2);
            } else {
                $this->askStatus();
            }
        });
    }

    function askTelegram($is_fix = FALSE)
    {
        return $this->ask("Silahkan masukkan nomor telegram anda!", function(Answer $answer)
        {
            $this->data['telegram'] = trim($answer->getText());
            $this->askStatus();
        });
    }

    function askStatus($is_fix = FALSE)
    {
        $status = [];

        foreach (\App\Status::all() as $s) {
            $status[] = Button::create($s->status)->value($s->id);
        }

        $question = Question::create('Silahkan masukkan status kegiatan anda!')
        ->callbackId('ask_status')
        ->addButtons($status);

        return $this->ask($question, function(Answer $answer)
        {
            $this->data['status'][0]['status_id'] = $answer->getValue();
            $this->askConfirm(2);
        });
    }

    // ########################################################################

    function askConfirm($case)
    {
        $this->data['case'] = $case;
        switch ($this->data['case']) {
            case 1:
            $this->say("Anda memasukkan data berikut:\n".
                "Nama : ".$this->data['name']."\n".
                "Tempat Lahir : ".$this->data['pob']."\n".
                "Tanggal Lahir : ".$this->data['dob']."\n".
                "Jurusan : ".$this->data['department']."\n");
            break;
            case 2:
            $this->say("Anda memasukkan data berikut:\n".
                "Tahun lulus : ".$this->data['grad']."\n".
                "Alamat : ".
                    $this->data['street'].', '.
                    Location::getVillage($this->data['address'])->nama.', '.
                    Location::getSubDistrict($this->data['sub_district'])->nama.', '.
                    Location::getDistrict($this->data['district'])->nama.', '.
                    Location::getProvince($this->data['province'])->nama."\n".
                "Nomor Telepon : ".$this->data['phone']."\n".
                "Status : ".\App\Status::find($this->data['status'][0]['status_id'])->status);
            break;
            default:
            break;
        }

        $question = Question::create('Apakah data yang anda masukkan sudah benar?')
        ->callbackId('ask_confirmation')
        ->addButtons([
            Button::create('Ya, sudah benar')->value('TRUE'),
            Button::create('Ada yang salah')->value('FALSE')
        ]);

        return $this->ask($question, function(Answer $answer)
        {
            if ($answer->getValue() == 'TRUE') {
                if ($this->data['case'] == 1) {
                    $this->check();
                } else {                    
                    $this->sayThanks();
                }
            } else {
                $this->askFix($this->data['case']);
            }
        });
    }

    function askFix($case)  
    {
        $this->data['case'] = $case;
        $button = [];
        switch ($this->data['case']) {
            case 1:
            $button = [
                Button::create('Nama')->value('name'),
                Button::create('Tempat lahir')->value('pob'),
                Button::create('Tanggal lahir')->value('dob'),
                Button::create('Jurusan')->value('department'),
            ];
            break;

            case 2:
            $button = [
                Button::create('Tahun lulus')->value('grad'),
                Button::create('Alamat')->value('address'),
                Button::create('Nomor telepon')->value('phone'),
                Button::create('Status')->value('status'),
            ];
            break;
            
            default:
                // code...
            break;
        }

        $question = Question::create('Silahkan pilih data mana yang ingin diperbaiki?')
        ->callbackId('ask_fix')
        ->addButtons($button);

        return $this->ask($question, function(Answer $answer) {
            switch ($answer->getValue()) {
                case 'name':
                $this->askName(TRUE);
                break;

                case 'pob':
                $this->askPoB(TRUE);
                break;

                case 'dob':
                $this->askDoB(TRUE);
                break;

                case 'department':
                $this->askDepartment(TRUE);
                break;

                case 'grad':
                $this->askGrad(TRUE);
                break;

                case 'address':
                $this->askProvince(TRUE);
                break;

                case 'phone':
                $this->askPhone(TRUE);
                break;

                case 'status':
                $this->askStatus(TRUE);
                break;

                default:
                break;
            }
        });
    }

    function check()
    {
        $this->user = $this->user->where([
            [ 'name','=',$this->data['name'] ],
            [ 'dob','=',$this->data['dob'] ],
            [ 'pob','=',$this->data['pob'] ],
            [ 'department','=',$this->data['department'] ]
        ]);

        if ($this->user->get()->count() == 1) {
            $this->user = $this->user->get()->first();
            $data = "NIS : ".$this->user->nis."\n".
            "Nama : ".$this->user->name."\n".
            "Jenis Kelamin : ".($this->user->gender == 'M' ? 'Laki-laki' : 'Perempuan')."\n".
            "Email : ".$this->user->email."\n".
            "Tempat Lahir : ".$this->user->dob."\n".
            "Tanggal Lahir : ".$this->user->pob."\n".
            "Jurusan : ".$this->user->department;

            $this->say("Kami mendeteksi bahwa data anda telah terdaftar dalam sistem kami dengan rincian sebagai berikut:\n");
            $this->say($data);
            $this->say('Untuk selanjutnya, anda akan diminta untuk memasukan beberapa data seperti tahun lulus, alamat, status, nomor telepon');

            return $this->ask('Balas "Oke" untuk melanjutkan.', function(Answer $answer) {
                if (strtolower($answer->getText()) == 'oke') {
                    $this->askGrad();
                } else {
                    $this->closing();
                }
            });
        } else {
            $this->banned();
        }
    }

    // ########################################################################

    function askNis()
    {
        return $this->ask('Sebelumnya, Silahkan masukan nomor induk siswa anda!', function(Answer $answer)
        {
         $this->data['nis'] = $answer->getText();
         $this->sayThanks();
     });
    }

    // ########################################################################

    function sayThanks()
    {
        $this->say('Anda telah terdaftar dalam sistem kami. Silahkan klik link berikut dan login dengan nis dan password berikut');
        $this->say('nis : '.$this->user->nis."\n".'password : '.$this->user->temp_password);

        $this->user->province = $this->data['province'];
        $this->user->district = $this->data['district'];
        $this->user->sub_district = $this->data['sub_district'];
        $this->user->address = $this->data['address'];
        $this->user->street = $this->data['street'];
        $this->user->grad = $this->data['grad'];
        $this->user->phone = $this->data['phone'];
        $this->user->telegram_id = $this->botinfo['user']['id'];
        $this->user->temp_password = '';

        foreach ($this->data['status'] as $status) {
            DB::table('user_statuses')->insert([
                'user_id' => $this->user->id,
                'status_id' => $status['status_id'],
            ]);
        }

        $this->user->update();

        $this->closing();
    }

    function closing()
    {
        $this->say('Terimakasih menggunakan layanan dari Skanira Bot. Untuk informasi dan fitur-fitur yang lain, silahkan gunakan perintah "/" pada tombol dibawah.');
        return TRUE;
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->botinfo = $this->bot->getUser()->getInfo();
        $user = $this->user->where('telegram_id', $this->bot->getUser()->getId());
        // $this->bot->reply(json_encode($this->bot->getDriver()));
        if ($user->count() == 0) {
            $this->greetings();
        } else {
            $this->say('Akun anda telah terdaftar ke dalam sistem kami, anda dapat menggunakan fitur-fitur yang lain dengan menggunakan perintah "/" pada tombol dibawah.');
            return TRUE;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo();
            $db_status = true;
        } catch (\Throwable $th) {
            $db_status = false;
        }

        $status = [
            'php' => phpversion() >= '7.2.5',
            'db' => $db_status,
        ];

        return view('setup.index', compact('status'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'username' => ['required', 'string', 'min:4'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'file' => ['required', 'file', 'max:5MB']
        ]);

        Artisan::call('migrate:refresh');

        $url = str_replace('<token>', env('TELEGRAM_TOKEN'), 'https://api.telegram.org/bot<token>/setWebhook');
        $data = [
            'url' => url('/telegram'),
            'certificate' => $req->file('file')
        ];
        $headers = ["Content-Type:multipart/form-data"];
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => true
        ];
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        $res = curl_getinfo($ch);
        curl_close($ch);

        if ($res['http_code'] == 200) {
            $admin = new User();
            $admin->nis = $req->nis;
            $admin->name = $req->name;
            $admin->email = $req->email;
            $admin->password = $req->password;
            $admin->type = User::ADMIN_TYPE;
            $admin->save();
            return redirect('setup.status');
        }

        return back()->withErrors('Setup failed. Please try again');
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            // 'file' => ['required', 'file', 'max:5MB']
        ]);

        Artisan::call('migrate:refresh');

        $url = str_replace('<token>', env('TELEGRAM_TOKEN'), 'https://api.telegram.org/bot<token>/setWebhook');
        // $file = curl_file_create($req->file->path());
        $data = [
            'url' => url('/bot' . env('TELEGRAM_TOKEN'))
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
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $body = json_decode(substr($res, $info['header_size']));
        curl_close($ch);

        if ($info['http_code'] == 200) {
            try {
                $admin = new User();
                $admin->nis = $req->username;
                $admin->name = ucfirst($req->username);
                $admin->email = $req->email;
                $admin->password = Hash::make($req->password);
                $admin->type = User::ADMIN_TYPE;
                $admin->save();
                return redirect()->route('setup.status');
            } catch (\Throwable $th) {
                return back()->withInput()->withErrors($th->getMessage());
            }
        }

        return back()->withInput()->withErrors($body->description);
    }

    public function status()
    {
        return view('setup.status');
    }
}

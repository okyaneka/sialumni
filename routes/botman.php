<?php
use App\Http\Controllers\TelegramController;

$botman = resolve('botman');

$botman->fallback(function($bot) {
    $bot->reply('Maaf, ada yang bisa saya bantu?');
});

$botman->hears('getinfo', function ($bot) {
    $bot->reply(json_encode($bot->getUser()->getInfo()));
    // $bot->reply(json_encode($bot->getUser()->getInfo()));
});

$botman->hears('Hi', function ($bot) {
    $bot->reply("Hello!");
});

$botman->hears('/start', function ($bot) {
    $bot->reply('Halo. Selamat datang di SkaniraBot. Disini kamu akan dapat mengakses informasi tentang alumni. Selain itu, disini kamu juga bisa mendaftarkan diri kamu sebagai alumni SMK Negeri Pringsurat. Silahkan tekan tombol "/" di bagian bawah untuk memulai berinteraksi dengan SkaniraBot. Semoga harimu menyenangkan! ^_^.');
});

$botman->hears('/info', TelegramController::class.'@info');
$botman->hears('/daftar', TelegramController::class.'@daftar');
$botman->hears('/update', TelegramController::class.'@update');
$botman->hears('/carialumni', TelegramController::class.'@carialumni');

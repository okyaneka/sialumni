<?php
use App\Http\Controllers\TelegramController;

$botman = resolve('botman');

$botman->fallback(function($bot) {
    $bot->reply('Maaf, saya tidak mengerti apa yang kamu maksud. Silahkan pilih menu atau tekan tombol "/" di bagian bawah untuk memulai berinteraksi dengan SkaniraBot. Semoga harimu menyenangkan! ^_^.');
});

$botman->hears('/start', function ($bot) {
    $bot->reply('Halo. Selamat datang di SkaniraBot. Disini kamu akan dapat mengakses informasi tentang alumni. Selain itu, disini kamu juga bisa mendaftarkan diri kamu sebagai alumni SMK Negeri Pringsurat. Silahkan tekan tombol "/" di bagian bawah untuk memulai berinteraksi dengan SkaniraBot. Semoga harimu menyenangkan! ^_^.');
});

$botman->hears('/validasi', TelegramController::class.'@validasi'); // validasi
$botman->hears('/update', TelegramController::class.'@update'); // update
$botman->hears('/infoloker', TelegramController::class.'@infoloker'); // infoloker
$botman->hears('/tambahloker', function ($bot) {
    $bot->reply('Mohon maaf, untuk fitur ini masih dalam pengembangan. Terimakasih.');
}); // tambahloker
$botman->hears('/infoalumni', TelegramController::class.'@infoalumni'); // infoalumni
// /bantuan
$botman->hears('/info', TelegramController::class.'@info');
$botman->hears('/carialumni', TelegramController::class.'@carialumni');
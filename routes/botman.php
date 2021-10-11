<?php

use App\User;
use App\Http\Controllers\TelegramController;
use BotMan\Drivers\Telegram\TelegramDriver;

$botman = resolve('botman');

$botman->fallback(function ($bot) {
    $payload = $bot->getMessage()->getPayload();
    if ($payload['chat']['type'] != 'group') {
        $payload = $bot->getMessage()->getPayload();
        $bot->reply('Maaf, saya tidak mengerti apa yang kamu maksud. Coba pakai perintah ini!', ['reply_markup' => json_encode([
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
            ]
        ])]);
    }
});

$botman->hears('/start', function ($bot) {
    $payload = $bot->getMessage()->getPayload();
    $user = $payload['from'];
    if ($payload['chat']['type'] != 'group') {
        $bot->reply('Halo. Selamat datang di SkaniraBot. Disini kamu akan dapat mengakses informasi tentang alumni. Selain itu, disini kamu juga bisa mendaftarkan diri kamu sebagai alumni SMK Negeri Pringsurat. Silahkan tekan "/validasi", ikuti petunjuknya dan kemudian siap untuk dapat menikmati semua layanan dari SkaniraBot. Semoga harimu menyenangkan! ^_^.');
    }
    if ($payload['chat']['type'] == 'group') {
        $name = !empty($user['username']) ? '@' . $user['username'] : $user['first_name'];
        $bot->reply("$name, dibilangin jangan di group");
    }
});

// Personal
$botman->hears('/validasi', TelegramController::class . '@validasi'); // validasi
$botman->hears('/update', TelegramController::class . '@update'); // update
$botman->hears('/infoloker', TelegramController::class . '@infoloker'); // infoloker
$botman->hears('/infoalumni', TelegramController::class . '@infoalumni'); // infoalumni
$botman->hears('/tambahloker', function ($bot) {
    $bot->reply('Mohon maaf, untuk fitur ini masih dalam pengembangan. Terimakasih.');
}); // tambahloker
$botman->hears('/bantuan', function ($bot) {
    $bot->reply('Mohon maaf, untuk fitur ini masih dalam pengembangan. Terimakasih.');
}); // bantuan

// Group
$botman->hears('/validasi@' . env("TELEGRAM_BOT_ID"), TelegramController::class . '@validasi'); // validasi
$botman->hears('/update@' . env("TELEGRAM_BOT_ID"), TelegramController::class . '@update'); // update
$botman->hears('/infoloker@' . env("TELEGRAM_BOT_ID"), TelegramController::class . '@infoloker'); // infoloker
$botman->hears('/infoalumni@' . env("TELEGRAM_BOT_ID"), TelegramController::class . '@infoalumni'); // infoalumni
$botman->hears('/tambahloker@' . env("TELEGRAM_BOT_ID"), function ($bot) {
    $bot->reply('Mohon maaf, untuk fitur ini masih dalam pengembangan. Terimakasih.');
}); // tambahloker
$botman->hears('/bantuan@' . env("TELEGRAM_BOT_ID"), function ($bot) {
    $bot->reply('Mohon maaf, untuk fitur ini masih dalam pengembangan. Terimakasih.');
}); // bantuan

$botman->group(['driver' => [TelegramDriver::class]], function ($botman) {
    $botman->on('new_chat_members', function ($users) use ($botman) {
        foreach ($users as $user) {
            \Log::info("New member: " . json_encode($user));
            $name = !empty($user['username']) ? '@' . $user['username'] : $user['first_name'];
            if (User::where('telegram_id', $user['id'])->count()) {
                $message = "\nSebelumnya, cek pesan pribadiku dulu ya!";
                $botman->say("Halo $name, sebelum mulai lebih jauh, coba deh kamu tekan /validasi dulu.", $user['id'], TelegramDriver::class);
            } else {
                $message = "\nCoba /start Aku dulu ya... Eits, tapi jangan di group";
            }
            $botman->reply("Halo $name, selamat datang di grup Alumni SMK N Pringsurat. $message");
        }
    });

    $botman->on('left_chat_member', function ($user) use ($botman) {
        \Log::info("Leaved member: " . json_encode($user));
    });

    $botman->hears('/start@' . env("TELEGRAM_BOT_ID"), function ($bot) {
        $bot->reply('Halo. Selamat datang di Grup Alumni SkaniraBot. Disini kamu akan dapat mengakses informasi tentang alumni. Selain itu, disini kamu juga bisa mendaftarkan diri kamu sebagai alumni SMK Negeri Pringsurat. Silahkan tekan "/" dan pilih command yang tersedia untuk dapat menikmati semua layanan dari SkaniraBot. Semoga harimu menyenangkan! ^_^.');
    });
});

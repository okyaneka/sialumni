<?php
use App\Http\Controllers\TelegramController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
// $botman->hears('/infoloker', TelegramController::class.'@startConversation');

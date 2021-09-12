<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use App\User;

class TelegramController extends Controller
{
    private $config;
    private $botman;

    public function __construct()
    {
        $this->config = [
            // Your driver-specific configuration
            "telegram" => [
                "token" => env('TELEGRAM_TOKEN')
            ],
            'botman' => [
                'conversation_cache_time' => 180
            ],
        ];

        // Load the driver(s) you want to use
        DriverManager::loadDriver(TelegramDriver::class);

        // Create an instance
        $this->botman = BotManFactory::create($this->config);
    }

    //
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    function info(BotMan $bot)
    {
        $this->isGroup($bot);
        return $bot->startConversation(new \App\Conversations\InfoConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    public function validasi(BotMan $bot)
    {
        $this->isGroup($bot);
        return $bot->startConversation(new \App\Conversations\ValidasiConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    public function update(BotMan $bot)
    {
        $this->isGroup($bot);
        return $bot->startConversation(new \App\Conversations\UpdateConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    public function infoloker(BotMan $bot)
    {
        $this->isGroup($bot);
        return $bot->startConversation(new \App\Conversations\LokerConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    public function infoalumni(BotMan $bot)
    {
        $this->isGroup($bot);
        return $bot->startConversation(new \App\Conversations\AlumniConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    function carialumni(BotMan $bot)
    {
        $this->isGroup($bot);
        return $bot->startConversation(new \App\Conversations\FindAlumniConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    private function isGroup(BotMan $bot)
    {
        $payload = $bot->getMessage()->getPayload();
        if ($payload['chat']['type'] == 'group') {
            $name = !empty($payload['from']['username']) ? '@' . $payload['from']['username'] : $payload['from']['first_name'];
            if (User::where('telegram_id', $payload['from']['id'])->count()) {
                $bot->reply("Hai $name.\nSilahkan check pesan pribadi ya");
            } else {
                $bot->reply("Hai $name.\nCoba /start Aku dulu. Lewat japri ya...");
            } 
            return true;
        }
        return false;
    }
}

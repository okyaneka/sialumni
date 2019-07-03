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
                'conversation_cache_time' => 30
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
    	return $bot->startConversation(new \App\Conversations\InfoConversation());
    }

    function daftar(BotMan $bot)
    {
        if($bot->getMessage()->getPayload()['chat']['type'] == 'group') {
            $bot->reply("Hai : ".$bot->getUser()->getFirstname().".\nSilahkan check pesan pribadi ya");
        }
        return $bot->startConversation(new \App\Conversations\RegisterConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    function update(BotMan $bot)
    {
        if ($bot->getMessage()->getPayload()['chat']['type'] == 'group') {
            $bot->reply("Hai : ".$bot->getUser()->getFirstname().".\nSilahkan check pesan pribadi ya");
        }

    	return $bot->startConversation(new \App\Conversations\UpdateConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }

    function carialumni(BotMan $bot)
    {
        if ($bot->getMessage()->getPayload()['chat']['type'] == 'group') {
            $bot->reply("Hai : ".$bot->getUser()->getFirstname().".\nSilahkan check pesan pribadi ya");
        }
        
    	return $bot->startConversation(new \App\Conversations\FindAlumniConversation(), $bot->getUser()->getId(), TelegramDriver::class);
    }
}

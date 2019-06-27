<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

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
		DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);

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
    	return $bot->startConversation(new \App\Conversations\RegisterConversation());
    }

    function update(BotMan $bot)
    {
    	return $bot->startConversation(new \App\Conversations\UpdateConversation());
    }

    function carialumni(BotMan $bot)
    {
    	return $bot->startConversation(new \App\Conversations\FindAlumniConversation());
    }
}

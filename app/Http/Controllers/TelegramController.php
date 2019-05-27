<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use App\Conversations\ExampleConversation;

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
			]
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
}
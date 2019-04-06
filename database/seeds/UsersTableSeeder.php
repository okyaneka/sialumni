<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run()
	{
		DB::table('users')->insert([
			[
				'name' => 'Admin Admin',
				'email' => 'admin@argon.com',
				'email_verified_at' => now(),
				'password' => Hash::make('secret'),
				'type' => 'admin',
				'created_at' => now(),
				'updated_at' => now()
			],
			[
				'name' => 'User User',
				'email' => 'user@argon.com',
				'email_verified_at' => now(),
				'password' => Hash::make('secret'),
				'type' => 'default',
				'created_at' => now(),
				'updated_at' => now()
			]
		]);
	}
}
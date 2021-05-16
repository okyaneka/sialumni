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
		DB::table('users')->delete();

		DB::table('users')->insert([
			[
				'name' => 'Admin Admin',
				'email' => 'admin@argon.com',
				'nis' => 'admin',
				'email_verified_at' => now(),
				'password' => Hash::make('secret'),
				'type' => 'admin',
				'gender' => 'M',
				'created_at' => now(),
				'updated_at' => now()
			],
		]);

		DB::table('users')->insert([
			// [
			// 	'name' => 'User User',
			// 	'nis' => '0001',
			// 	'email' => 'user@argon.com',
			// 	'email_verified_at' => now(),
			// 	'password' => Hash::make('secret'),
			// 	'type' => 'default',
			// 	'province' => '33',
			// 	'district' => '3323',
			// 	'sub_district' => '3323060',
			// 	'address' => '3323060006',
			// 	'gender' => 'M',
			// 	'created_at' => now(),
			// 	'updated_at' => now()
			// ]
		]);

		// DB::table('user_statuses')->insert([
		// 	[
		// 		'user_id' => 2,
		// 		'status_code' => 'L',
		// 		'info' => 'Universitas Negeri Yogyakarta',
		// 		'year' => '2014',
		// 	]
		// ]);
	}
}

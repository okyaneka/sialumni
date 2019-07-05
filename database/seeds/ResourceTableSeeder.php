<?php

use Illuminate\Database\Seeder;

class ResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->delete();

        DB::table('departments')->insert([
            [
                'code' => 'TKJ',
                'department' => 'Teknik Komputer Jaringan',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('statuses')->delete();

        DB::table('statuses')->insert([
        	[
        		'status' => 'Melanjutkan Studi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'Bekerja',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'status' => 'Wiraswasta',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('settings')->delete();

        DB::table('settings')->insert([
            [
                'name' => 'defaultpassword',
                'config' => '123456'
            ]
        ]);
    }
}

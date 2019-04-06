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
        DB::table('departments')->insert([
        	[
        		'code' => 'TKJ',
        		'department' => 'Teknik Komputer Jaringan',
                'created_at' => now(),
                'updated_at' => now()
        	],
        ]);

        DB::table('statuses')->insert([
        	[
        		'code' => 'L',
        		'status' => 'Melanjutkan Studi',
                'created_at' => now(),
                'updated_at' => now()
        	],
        ]);
    }
}

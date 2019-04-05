<?php

use Illuminate\Database\Seeder;

class Resource extends Seeder
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
        	],
        ]);

        DB::table('statuses')->insert([
        	[
        		'code' => 'L',
        		'status' => 'Melanjutkan Studi',
        	],
        ]);
    }
}

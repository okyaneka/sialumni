<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->string('street')->nullable();
            $table->string('address')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('district')->nullable();
            $table->string('department', 5)->nullable();
            $table->string('status', 5)->nullable();
            $table->year('grad')->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('telegram', 14)->nullable();
            $table->string('group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'pob',
                'dob',
                'street',
                'address',
                'sub_district',
                'district',
                'department',
                'status',
                'grad',
                'phone',
                'telegram',
                'group',
            ]);
        });
    }
}

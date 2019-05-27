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
            $table->enum('gender', ['M', 'F']);
            $table->string('pob')->nullable();
            $table->date('dob')->nullable();
            $table->string('street')->nullable();
            $table->string('address')->nullable();
            $table->string('sub_district')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('department', 5)->nullable();
            $table->string('grad', 4)->nullable();
            $table->string('phone', 14)->nullable();
            $table->string('telegram', 14)->nullable();
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
                'gender',
                'dob',
                'street',
                'address',
                'sub_district',
                'district',
                'province',
                'department',
                'grad',
                'phone',
                'telegram',
            ]);
        });
    }
}

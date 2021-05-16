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
            $table->string('address_id')->nullable();
            $table->string('sub_district_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('province_id')->nullable();
            $table->string('department_slug', 5)->nullable();
            $table->string('grad', 4)->nullable();
            $table->string('phone', 14)->nullable()->unique();
            $table->string('telegram_id')->nullable()->unique();
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
                'gender',
                'pob',
                'dob',
                'street',
                'address_id',
                'sub_district_id',
                'district_id',
                'province_id',
                'department_slug',
                'grad',
                'phone',
                'telegram_id',
            ]);
        });
    }
}

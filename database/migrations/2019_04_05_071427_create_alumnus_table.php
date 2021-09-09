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
        $this->dropColumnIfExist('users', 'gender');
        $this->dropColumnIfExist('users', 'pob');
        $this->dropColumnIfExist('users', 'dob');
        $this->dropColumnIfExist('users', 'street');
        $this->dropColumnIfExist('users', 'address_id');
        $this->dropColumnIfExist('users', 'sub_district_id');
        $this->dropColumnIfExist('users', 'district_id');
        $this->dropColumnIfExist('users', 'province_id');
        $this->dropColumnIfExist('users', 'department_slug');
        $this->dropColumnIfExist('users', 'grad');
        $this->dropColumnIfExist('users', 'phone');
        $this->dropColumnIfExist('users', 'telegram_id');
    }

    private function dropColumnIfExist($table, $column)
    {
        if (Schema::hasColumn($table, $column)) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->dropColumn($column);
            });
        }
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company');
            $table->string('position');
            $table->string('salary')->nullable();
            $table->string('location');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('duedate');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('info')->nullable();
            $table->enum('published', [1,0])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}

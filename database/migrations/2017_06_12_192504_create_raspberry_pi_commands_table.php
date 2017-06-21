<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaspberryPiCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raspberry_pi_commands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raspberry_pi_id');
            $table->boolean('shutdown');
            $table->boolean('restart');
            $table->boolean('update');
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
        Schema::dropIfExists('raspberry_pi_commands');
    }
}

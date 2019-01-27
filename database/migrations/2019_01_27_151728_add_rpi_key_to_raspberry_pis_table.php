<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRpiKeyToRaspberryPisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raspberry_pis', function (Blueprint $table) {
            $table->string('rpi_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raspberry_pis', function (Blueprint $table) {
            $table->dropColumn('rpi_key');
        });
    }
}

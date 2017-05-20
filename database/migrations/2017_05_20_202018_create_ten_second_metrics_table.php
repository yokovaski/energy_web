<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenSecondMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ten_second_metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mode');
            $table->integer('usage_now');
            $table->integer('redelivery_now');
            $table->integer('solar_now');
            $table->integer('usage_total_high');
            $table->integer('redelivery_total_high');
            $table->integer('usage_total_low');
            $table->integer('redelivery_total_low');
            $table->integer('solar_total');
            $table->integer('usage_gas_now');
            $table->integer('usage_gas_total');
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
        Schema::dropIfExists('ten_second_metrics');
    }
}



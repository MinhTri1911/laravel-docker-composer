<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTShipSpotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_ship_spot', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('ship_id');
            $table->date('month_usage');
            $table->bigInteger('spot_id');
            $table->bigInteger('currency_id');
            $table->double('amount_charge', 20, 2)->nullable();
            $table->string('remark', 255)->nullable();
            $table->boolean('del_flag')->default(0);
            $table->string('created_by', 150)->nullable();
            $table->timestamps();
            $table->string('updated_by', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_ship_spot');
    }
}

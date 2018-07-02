<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTShipSpotTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_ship_spot', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->bigInteger('ship_id');
            $table->string('usage_month', 7);
            $table->string('type', 30);
            $table->string('currency', 10);
            $table->float('amount_charge', 20)->nullable();
            $table->string('notice')->nullable();
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
        Schema::drop('t_ship_spot');
    }

}

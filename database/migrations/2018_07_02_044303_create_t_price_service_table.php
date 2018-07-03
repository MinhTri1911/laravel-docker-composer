<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTPriceServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_price_service', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('service_id');
            $table->bigInteger('currency_id');
            $table->double('price', 20, 2);
            $table->double('charge_register', 20, 2)->default(0);
            $table->double('charge_create_data', 20, 2)->default(0);
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
        Schema::dropIfExists('t_price_service');
    }
}

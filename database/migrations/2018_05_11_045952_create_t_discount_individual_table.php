<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTDiscountIndividualTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_discount_individual', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->bigInteger('ship_id');
            $table->string('setting_month', 7);
            $table->string('type', 30);
            $table->string('currency', 10);
            $table->float('amount_discount', 20)->nullable();
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
        Schema::drop('t_discount_individual');
    }

}

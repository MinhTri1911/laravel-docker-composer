<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMShipTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_ship', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->string('name', 100);
            $table->bigInteger('company_id');
            $table->boolean('language')->default(0);
            $table->string('imo_number', 15);
            $table->string('mmsi_number', 20);
            $table->string('nationality', 30);
            $table->string('classification', 30);
            $table->string('classification_control_number', 20);
            $table->boolean('type');
            $table->string('specification', 30);
            $table->string('url_1', 150);
            $table->string('url_2', 150);
            $table->string('url_3', 150);
            $table->boolean('del_flag')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::drop('m_ship');
    }

}

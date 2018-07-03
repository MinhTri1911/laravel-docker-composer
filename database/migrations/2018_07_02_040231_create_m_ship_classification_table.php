<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMShipClassificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_ship_classification', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('code', 10);
            $table->string('name_jp', 50);
            $table->string('name_en', 50);
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
        Schema::dropIfExists('m_ship_classification');
    }
}

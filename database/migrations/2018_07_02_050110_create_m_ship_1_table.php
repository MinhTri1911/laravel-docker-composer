<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMShip1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_ship', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->bigInteger('company_id');
            $table->string('imo_number', 15);
            $table->string('mmsi_number', 20)->nullable();
            $table->bigInteger('nation_id');
            $table->bigInteger('classification_id');
            $table->string('register_number', 20)->nullable();
            $table->bigInteger('type_id');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('water_draft')->nullable();
            $table->integer('total_weight_ton')->nullable();
            $table->integer('total_ton')->nullable();
            $table->integer('member_number')->nullable();
            $table->string('url_1', 255)->nullable();
            $table->string('url_2', 255)->nullable();
            $table->string('url_3', 255)->nullable();
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
        Schema::dropIfExists('m_ship');
    }
}

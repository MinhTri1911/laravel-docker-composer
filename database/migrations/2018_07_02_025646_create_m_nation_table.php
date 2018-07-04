<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMNationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_nation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 10);
            $table->integer('iso_number')->unsigned();
            $table->string('iso_code', 20);
            $table->string('name_jp', 30);
            $table->string('name_en', 30);
            $table->string('currency_code', 5);
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
        Schema::dropIfExists('m_nation');
    }
}

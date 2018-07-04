<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_jp', 100);
            $table->string('name_en', 100);
            $table->string('name_short', 100);
            $table->double('version_max', 5, 2);
            $table->double('version_min', 5, 2);
            $table->double('version_rev', 5, 2);
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
        Schema::dropIfExists('m_service');
    }
}

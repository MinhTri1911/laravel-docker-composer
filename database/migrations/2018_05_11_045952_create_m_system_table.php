<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMSystemTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_system', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->string('name', 100);
            $table->string('version', 30);
            $table->boolean('language')->default(0);
            $table->string('currency', 10);
            $table->float('usage_monthly_fee', 20);
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
        Schema::drop('m_system');
    }

}

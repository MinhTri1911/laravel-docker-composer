<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMBillingMethod1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_billing_method', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_jp', 50);
            $table->string('name_en', 50);
            $table->string('month_billing', 30);
            $table->tinyInteger('month')->unsigned();
            $table->tinyInteger('unit')->unsigned();
            $table->tinyInteger('method')->unsigned();
            $table->bigInteger('currency_id');
            $table->double('charge', 20, 2);
            $table->string('link_template', 255)->nullable();
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
        Schema::dropIfExists('m_billing_method');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMBillingMethodTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_billing_method', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->string('name', 50);
            $table->string('month', 12);
            $table->string('total', 1)->default('T');
            $table->string('charge', 50);
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
        Schema::drop('m_billing_method');
    }

}

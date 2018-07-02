<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMContractTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_contract', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->string('revision_number', 25)->nullable();
            $table->bigInteger('company_id');
            $table->bigInteger('ship_id');
            $table->bigInteger('system_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
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
        Schema::drop('m_contract');
    }

}

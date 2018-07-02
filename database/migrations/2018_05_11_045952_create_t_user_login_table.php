<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTUserLoginTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_user_login', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->string('operation_person', 100);
            $table->bigInteger('ope_company_id');
            $table->string('department', 50);
            $table->string('position', 50);
            $table->string('job', 50);
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
        Schema::drop('t_user_login');
    }

}

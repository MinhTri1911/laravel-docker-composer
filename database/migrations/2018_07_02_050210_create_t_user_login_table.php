<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_user_login', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->bigInteger('ope_company_id');
            $table->string('department', 50);
            $table->string('position', 50);
            $table->boolean('auth_create')->default(0);
            $table->boolean('auth_approve')->default(0);
            $table->boolean('auth_reference')->default(0);
            $table->boolean('auth_operation')->default(0);
            $table->boolean('auth_admin')->default(0);
            $table->string('login_id', 150);
            $table->string('password', 256);
            $table->tinyInteger('type')->default(0);
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
        Schema::dropIfExists('t_user_login');
    }
}

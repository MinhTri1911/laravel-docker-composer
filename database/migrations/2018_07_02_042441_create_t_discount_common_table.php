<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDiscountCommonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_discount_common', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('company_id');
            $table->date('setting_month');
            $table->bigInteger('currency_id');
            $table->double('money_discount', 20, 2);
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
        Schema::dropIfExists('t_discount_common');
    }
}

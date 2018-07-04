<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDetailHistoryUsageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_detail_history_usage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('history_usage_id');
            $table->tinyInteger('charge_type_id');
            $table->tinyInteger('detail_charge_type_id');
            $table->date('month_usage');
            $table->string('description')->nullable();
            $table->bigInteger('currency_id');
            $table->double('money_billing', 20, 2)->nullable();
            $table->double('money', 20, 2)->nullable();
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
        Schema::dropIfExists('t_detail_history_usage');
    }
}

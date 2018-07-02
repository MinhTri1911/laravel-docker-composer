<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTHistoryBillingMonthlyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_history_billing_monthly', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->bigInteger('contract_id');
            $table->string('usage_month', 7);
            $table->bigInteger('history_billing_id')->nullable();
            $table->string('currency', 10);
            $table->float('total_month_billing', 20)->nullable();
            $table->float('month_usage_charge', 20)->nullable();
            $table->float('inital_charge', 20)->nullable();
            $table->float('create_data_cost', 20)->nullable();
            $table->float('spot_cost', 20)->nullable();
            $table->float('discount', 20)->nullable();
            $table->string('notice')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::drop('t_history_billing_monthly');
    }

}

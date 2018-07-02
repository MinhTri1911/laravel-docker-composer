<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTHistoryBillingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_history_billing', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->bigInteger('company_id');
            $table->date('claim_date');
            $table->bigInteger('billing_method_id');
            $table->date('payment_due_date');
            $table->integer('billing_day_no')->unsigned();
            $table->date('payment_actual_date')->nullable();
            $table->string('currency', 10);
            $table->float('total_amount_billing', 20)->nullable();
            $table->float('total_monthly_charge', 20)->nullable();
            $table->float('total_inital_charge', 20)->nullable();
            $table->float('total_create_data_cost', 20)->nullable();
            $table->float('total_spot_cost', 20)->nullable();
            $table->float('total_discount', 20)->nullable();
            $table->float('total_commission_other_charge', 20)->nullable();
            $table->float('total_consumption_tax', 20)->nullable();
            $table->string('notice')->nullable();
            $table->bigInteger('ope_company_id');
            $table->string('pdf_original_link', 200);
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
        Schema::drop('t_history_billing');
    }

}

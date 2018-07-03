<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTHistoryBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_history_billing', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('company_id');
            $table->date('claim_date');
            $table->bigInteger('billing_method_id');
            $table->date('payment_due_date');
            $table->integer('payment_deadline_no')->unsigned()->nullable();
            $table->integer('billing_day_no')->unsigned()->nullable();
            $table->date('payment_actual_date')->nullable();
            $table->bigInteger('currency_id');
            $table->double('total_amount_billing', 20, 2)->nullable();
            $table->double('total_money', 20, 2)->nullable();
            $table->bigInteger('ope_company_id');
            $table->string('remark', 255)->nullable();
            $table->string('pdf_original_link', 255);
            $table->tinyInteger('approved_flag')->default(2);
            $table->text('reason_reject')->nullable();
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
        Schema::dropIfExists('t_history_billing');
    }
}

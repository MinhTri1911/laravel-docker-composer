<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTHistoryContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_history_contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('contract_id');
            $table->double('revision_number', 3, 1);
            $table->bigInteger('ship_id');
            $table->bigInteger('service_id');
            $table->bigInteger('currency_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('approved_flag')->default(2);
            $table->dateTime('start_pending_date')->nullable();
            $table->dateTime('end_pending_date')->nullable();
            $table->text('reason_reject')->nullable();
            $table->boolean('del_flag')->default(0);
            $table->string('remark', 255)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('created_by', 150)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->string('updated_by', 150)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('create_data_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_history_contract');
    }
}

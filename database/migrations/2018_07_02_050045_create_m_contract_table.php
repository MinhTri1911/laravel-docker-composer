<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('revision_number', 3, 1);
            $table->bigInteger('ship_id');
            $table->bigInteger('service_id');
            $table->bigInteger('currency_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('approved_flag')->default(2);
            $table->text('reason_reject')->nullable();
            $table->dateTime('pending_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('m_contract');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCompanyOperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_company_operation', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name', 100);
            $table->string('short_name', 100);
            $table->bigInteger('nation_id');
            $table->string('address', 150);
            $table->boolean('language')->default(0);
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
        Schema::dropIfExists('m_company_operation');
    }
}

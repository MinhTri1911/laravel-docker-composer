<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_company', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name_jp', 100);
            $table->string('name_en', 100);
            $table->bigInteger('nation_id');
            $table->string('postal_code', 20)->nullable();
            $table->string('head_office_address', 150)->nullable();
            $table->string('represent_person', 100);
            $table->double('fund', 20, 2)->nullable();
            $table->integer('employees_number')->unsigned();
            $table->string('year_research', 4)->nullable();
            $table->bigInteger('billing_method_id');
            $table->string('month_billng', 30);
            $table->integer('payment_deadline_no')->unsigned()->nullable();
            $table->integer('billing_day_no')->unsigned()->nullable();
            $table->string('currency_code', 5);
            $table->bigInteger('currency_id');
            $table->string('ope_person_name_1', 100);
            $table->string('ope_position_1', 100)->nullable();
            $table->string('ope_department_1', 100)->nullable();
            $table->string('ope_postal_code_1', 20)->nullable();
            $table->string('ope_address_1', 150)->nullable();
            $table->string('ope_phone_1', 20)->nullable();
            $table->string('ope_fax_1', 20)->nullable();
            $table->string('ope_email_1', 150);
            $table->string('ope_person_name_2', 100)->nullable();
            $table->string('ope_position_2', 100)->nullable();
            $table->string('ope_department_2', 100)->nullable();
            $table->string('ope_postal_code_2', 20)->nullable();
            $table->string('ope_address_2', 150)->nullable();
            $table->string('ope_phone_2', 20)->nullable();
            $table->string('ope_fax_2', 20)->nullable();
            $table->string('ope_email_2', 150)->nullable();
            $table->bigInteger('ope_company_id');
            $table->string('url', 255)->nullable();
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
        Schema::dropIfExists('m_company');
    }
}

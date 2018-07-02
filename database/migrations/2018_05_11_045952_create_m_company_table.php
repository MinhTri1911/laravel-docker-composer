<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMCompanyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_company', function(Blueprint $table)
        {
            $table->bigInteger('id')->primary();
            $table->string('name', 100);
            $table->string('nationality', 30);
            $table->string('postal_code', 20);
            $table->string('head_office_address', 150);
            $table->string('represent_person', 100);
            $table->float('fund', 20)->nullable();
            $table->integer('employees_number')->unsigned();
            $table->bigInteger('billing_method_id');
            $table->integer('payment_deadline_no')->unsigned();
            $table->integer('billing_day_no')->unsigned();
            $table->string('currency', 10);
            $table->string('ope_person_name_1', 100);
            $table->string('ope_position_1', 100);
            $table->string('ope_department_1', 100);
            $table->string('ope_postal_code_1', 20);
            $table->string('ope_address_1', 150);
            $table->string('ope_phone_1', 20);
            $table->string('ope_fax_1', 20);
            $table->string('ope_email_1', 150);
            $table->bigInteger('ope_company_id');
            $table->string('url', 150);
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
        Schema::drop('m_company');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPendingDateFromMContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_contract', function (Blueprint $table) {
            $table->dateTime('start_pending_date')->after('approved_flag')->nullable();
            $table->dateTime('end_pending_date')->after('start_pending_date')->nullable();
            $table->dropColumn('pending_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_contract', function (Blueprint $table) {
            $table->dateTime('pending_at')->nullable();
            $table->dropColumn('start_pending_date');
            $table->dropColumn('end_pending_date');
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractIdToShipSpot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_ship_spot', function (Blueprint $table) {
            $table->bigInteger('contract_id')->after('ship_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_ship_spot', function (Blueprint $table) {
            $table->dropColumn('contract_id');
        });
    }
}

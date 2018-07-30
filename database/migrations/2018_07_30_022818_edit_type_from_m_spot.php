<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTypeFromMSpot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_spot', function (Blueprint $table) {
            DB::statement('ALTER TABLE m_spot MODIFY COLUMN type TINYINT(4)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_spot', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddDefaultValueToDateFinInDealHistorique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_historique', function (Blueprint $table) {
            // Modify 'date_fin' to have a default value of CURRENT_TIMESTAMP
            DB::statement('ALTER TABLE deal_historique CHANGE date_fin date_fin DATETIME DEFAULT CURRENT_TIMESTAMP');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deal_historique', function (Blueprint $table) {
            // Revert 'date_fin' to be nullable and remove default value
            DB::statement('ALTER TABLE deal_historique CHANGE date_fin date_fin DATETIME DEFAULT NULL');

        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateDateDebutDefaultValueInDealHistorique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_historique', function (Blueprint $table) {
            // Modify the 'date_debut' column to have CURRENT_TIMESTAMP as the default value
            DB::statement('ALTER TABLE deal_historique CHANGE date_debut date_debut DATETIME DEFAULT CURRENT_TIMESTAMP');
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
            // Revert to a column without a default value
            DB::statement('ALTER TABLE deal_historique CHANGE date_debut date_debut DATETIME DEFAULT NULL');
        });
    }
}

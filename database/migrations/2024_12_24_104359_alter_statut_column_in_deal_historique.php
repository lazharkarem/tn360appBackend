<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStatutColumnInDealHistorique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_historique', function (Blueprint $table) {
            // Change the 'statut' column from ENUM to VARCHAR(255)
            $table->string('statut', 255)->change();
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
            // Revert 'statut' column back to ENUM type
            $table->enum('statut', ['completed', 'en_cours', 'active'])->change();
        });
    }
}

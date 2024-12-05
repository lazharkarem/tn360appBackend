<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateDealDepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_depense', function (Blueprint $table) {
            // Check if the 'statut' column doesn't already exist
            if (!Schema::hasColumn('deal_depense', 'statut')) {
                // Add the 'statut' column
                $table->enum('statut', ['en_cours', 'cloturee'])->default('en_cours')->after('compteur_objectif');
            }

            // Check if the 'ID_deal_offre' column doesn't already exist
            if (!Schema::hasColumn('deal_depense', 'ID_deal_offre')) {
                // Add the 'ID_deal_offre' column and foreign key
                $table->unsignedBigInteger('ID_deal_offre')->nullable()->after('ID_client');
                $table->foreign('ID_deal_offre')->references('ID_deal_offre')->on('deal_offre')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deal_depense', function (Blueprint $table) {
            // Remove 'statut' column
            $table->dropColumn('statut');

            // Remove 'ID_deal_offre' column and foreign key
            $table->dropForeign(['ID_deal_offre']);
            $table->dropColumn('ID_deal_offre');
        });
    }
}

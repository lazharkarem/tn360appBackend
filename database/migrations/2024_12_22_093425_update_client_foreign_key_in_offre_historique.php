<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientForeignKeyInOffreHistorique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the existing foreign key constraint (if any)
        Schema::table('offre_historique', function (Blueprint $table) {
            // Check if the constraint exists and drop it
            $table->dropForeign(['ID_client']);
        });

        // Add the correct foreign key constraint
        Schema::table('offre_historique', function (Blueprint $table) {
            $table->foreign('ID_client')->references('ID_client')->on('client')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the foreign key constraint in case of rollback
        Schema::table('offre_historique', function (Blueprint $table) {
            $table->dropForeign(['ID_client']);
        });
    }
}

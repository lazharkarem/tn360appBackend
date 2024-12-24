<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffreHistoriqueTable extends Migration
{
    public function up()
    {
        Schema::create('offre_historique', function (Blueprint $table) {
            $table->id('ID_offre_historique'); // Primary key
            $table->unsignedBigInteger('ID_client'); // Foreign key to clients table
            $table->string('type_offre'); // Offer type (varchar)
            $table->decimal('amount_earned_total', 15, 2); // Earned amount (decimal)
            $table->string('statut'); // Status (varchar)
            $table->date('date_debut'); // Start date of offer
            $table->date('date_fin'); // End date of offer
            $table->timestamps(); // Laravel's automatic created_at and updated_at

            // Foreign key constraints (if any)
            $table->foreign('ID_client')->references('ID_client')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('offre_historique');
    }
}

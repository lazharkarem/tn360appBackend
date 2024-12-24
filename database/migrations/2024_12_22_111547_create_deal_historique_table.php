<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealHistoriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('deal_historique', function (Blueprint $table) {
        $table->id('ID_deal_historique');
        $table->unsignedBigInteger('ID_client');
        $table->string('type_offre');
        $table->decimal('amount_earned_total', 10, 2);
        $table->enum('statut', ['completed'])->default('completed');
        $table->date('date_debut');
        $table->date('date_fin');
        $table->timestamps();

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
        Schema::dropIfExists('deal_historique');
    }
}

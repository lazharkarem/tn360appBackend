<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeOffreFromDealHistorique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('deal_historique', function (Blueprint $table) {
        $table->dropColumn('type_offre');
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
        $table->string('type_offre');
    });
}
}

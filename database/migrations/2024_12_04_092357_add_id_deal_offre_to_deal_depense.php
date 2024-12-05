<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdDealOffreToDealDepense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('deal_depense', function (Blueprint $table) {
        $table->bigInteger('ID_deal_offre')->unsigned()->nullable();
        $table->foreign('ID_deal_offre')->references('ID_deal_offre')->on('deal_offre')->onDelete('cascade');
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
        $table->dropForeign(['ID_deal_offre']);
        $table->dropColumn('ID_deal_offre');
    });
}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountEarnedToDealDepense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('deal_depense', function (Blueprint $table) {
        $table->decimal('amount_earned', 10, 2)->default(0.00)->after('compteur_objectif');
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
        $table->dropColumn('amount_earned');
    });
}
}

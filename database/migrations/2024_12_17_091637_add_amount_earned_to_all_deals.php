<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountEarnedToAllDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    foreach (['deal_frequence', 'deal_marque', 'deal_anniversaire'] as $table) {
        Schema::table($table, function (Blueprint $table) {
            $table->decimal('amount_earned', 10, 2)->default(0.00)->after('segments');
        });
    }
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
{
    foreach (['deal_frequence', 'deal_marque', 'deal_anniversaire'] as $table) {
        Schema::table($table, function (Blueprint $table) {
            $table->dropColumn('amount_earned');
        });
    }
}
}

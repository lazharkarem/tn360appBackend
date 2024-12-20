<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountEarnedTotalToDealOffreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('deal_offre', function (Blueprint $table) {
        $table->decimal('amount_earned_total', 10, 2)->default(0.00)->after('type_offre');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
{
    Schema::table('deal_offre', function (Blueprint $table) {
        $table->dropColumn('amount_earned_total');
    });
}
}

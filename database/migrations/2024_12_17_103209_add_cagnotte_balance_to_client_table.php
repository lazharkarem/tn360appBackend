<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCagnotteBalanceToClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::table('client', function (Blueprint $table) {
        // Adding cagnotte_balance column
        $table->decimal('cagnotte_balance', 10, 2)->default(0.00)->after('order_count');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down()
{
    Schema::table('client', function (Blueprint $table) {
        // Dropping cagnotte_balance column if rollback is needed
        $table->dropColumn('cagnotte_balance');
    });
}
}

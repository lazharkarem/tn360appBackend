<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyOnDealDepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('deal_depense', function (Blueprint $table) {
        // Drop the existing foreign key constraint (if exists)
        $table->dropForeign(['ID_deal_offre']);

        // Add the new foreign key constraint with ON DELETE CASCADE
        $table->foreign('ID_deal_offre')
              ->references('ID_deal_offre')
              ->on('deal_offre')
              ->onDelete('cascade');
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
        // Drop the foreign key
        $table->dropForeign(['ID_deal_offre']);
    });
}
}

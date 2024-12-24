<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToDealDepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deal_depense', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            $table->dropForeign(['ID_deal_offre']);
            
            // Add the foreign key constraint with cascading delete
            $table->foreign('ID_deal_offre')
                  ->references('ID_deal_offre')
                  ->on('deal_offre')
                  ->onDelete('cascade'); // This ensures that when a DealOffre is deleted, all related DealDepenses are deleted
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
            // Drop the foreign key constraint
            $table->dropForeign(['ID_deal_offre']);
        });
    }
}

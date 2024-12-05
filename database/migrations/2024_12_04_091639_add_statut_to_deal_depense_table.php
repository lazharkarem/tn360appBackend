<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatutToDealDepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('deal_depense', function (Blueprint $table) {
        $table->enum('statut', ['en_cours', 'cloturee'])->default('en_cours');
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
        $table->dropColumn('statut');
    });
}
}

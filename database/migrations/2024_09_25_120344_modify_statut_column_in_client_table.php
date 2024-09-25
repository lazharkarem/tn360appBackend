<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyStatutColumnInClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::table('client', function (Blueprint $table) {
                 $table->integer('statut')->nullable()->change(); // Make 'statut' nullable
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
                $table->integer('statut')->nullable()->change(); // Optionally revert back if needed
            });
        }
}

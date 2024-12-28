<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_marque_id_to_marques_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarqueIdToMarquesTable extends Migration
{
    public function up()
    {
        // Ensure 'marque_id' is a BIGINT type in the 'articles' table
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'marque_id')) {
                // Add marque_id column as BIGINT UNSIGNED
                $table->unsignedBigInteger('marque_id')->nullable();

                // Add foreign key constraint
                $table->foreign('marque_id')->references('id_marque')->on('marques')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        // Rollback the changes if needed
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['marque_id']);
            $table->dropColumn('marque_id');
        });
    }
}

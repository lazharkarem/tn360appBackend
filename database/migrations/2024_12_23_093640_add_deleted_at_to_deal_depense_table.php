<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToDealDepenseTable extends Migration
{
    public function up()
    {
        Schema::table('deal_depense', function (Blueprint $table) {
            // Add deleted_at column for SoftDeletes
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('deal_depense', function (Blueprint $table) {
            // Drop deleted_at column if rolling back
            $table->dropSoftDeletes();
        });
    }
}

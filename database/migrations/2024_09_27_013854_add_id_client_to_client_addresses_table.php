<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdClientToClientAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::table('client_addresses', function (Blueprint $table) {
                $table->unsignedBigInteger('ID_client')->after('id'); // Adjust the position as needed
                // Optionally, add a foreign key constraint if needed
                // $table->foreign('ID_client')->references('id')->on('clients')->onDelete('cascade');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
        {
            Schema::table('client_addresses', function (Blueprint $table) {
                $table->dropColumn('ID_client');
            });
        }
}

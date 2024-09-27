<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing primary key
            $table->string('address_type', 100)->nullable(); // Address type
            $table->string('contact_person_number', 20); // Contact person number
            $table->text('address'); // Address
            $table->string('latitude', 200)->nullable(); // Latitude
            $table->string('longitude', 200)->nullable(); // Longitude
            $table->unsignedBigInteger('client_id'); // Add the client_id field
            $table->string('contact_person_name', 100); // Contact person name
            $table->timestamps(); // created_at and updated_at

            // Add a foreign key constraint for the client_id
            $table->foreign('client_id')->references('ID_client')->on('client')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_addresses');
    }
}

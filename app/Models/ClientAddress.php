<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    protected $table = 'client_addresses';

    protected $fillable = [
        'ID_client',
        'contact_person_name',
        'contact_person_number',
        'address',
        'longitude',
        'latitude',
    ];
}

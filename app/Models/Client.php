<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_client'; // Specify the custom primary key

    // Other properties
    protected $fillable = [
        'email',
        'civilite',
        'date_de_naissance1',
        'date_de_naissance2',
        'date_de_naissance3',
        'date_de_naissance4',
        'address',
        'date_de_naissance',
        'statut',
        'code_postal',
        'image',
        'nom_enfant_1',
        'nom_enfant_2',
        'nom_enfant_3',
        'nom_enfant_4',
        'nom_et_prenom',
        'password',
        'profession',
        'situation_familiale',
        'tel',
        'verification_code',
        'ville',
        'gouvernorat',
    ];
}

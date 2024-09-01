<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, DefaultDatetimeFormat;

    protected $primaryKey = 'ID_client';
    protected $table = 'client';

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


     protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

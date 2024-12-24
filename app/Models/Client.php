<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, DefaultDatetimeFormat;

    // Primary key
    protected $primaryKey = 'ID_client';

    // Table name
    protected $table = 'client';

    // Fillable attributes
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

    // Hidden attributes (won't be visible when serialized)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attribute casting
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

      public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->save();
    }


    public function deductFromCagnotte($amount)
{
    if ($this->cagnotte < $amount) {
        throw new \InvalidArgumentException('Insufficient funds in cagnotte.');
    }

    $this->cagnotte -= $amount;
    $this->save();
}


 // Relationships
    public function dealDepense()
    {
        return $this->hasMany(DealDepense::class, 'ID_client');
    }

    public function dealFrequences()
    {
        return $this->hasMany(DealFrequence::class, 'ID_client');
    }


public function offres()
{
    return $this->hasMany(DealOffre::class, 'ID_client');
}


}

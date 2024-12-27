<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Marque extends Model
{
    protected $primaryKey = 'id_marque'; // Primary key column
    protected $fillable = [
        'nom_marque',
        'statut',
        'image',
        'addresse_marque',
        'email_marque',
        'tel_marque',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'marque_id');
    }
}

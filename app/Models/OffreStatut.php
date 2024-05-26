<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreStatut extends Model
{
    protected $primaryKey = 'statut';

    public $incrementing = false;

    protected $fillable = ['statut'];

    public $timestamps = false;
}

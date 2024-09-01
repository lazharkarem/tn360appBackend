<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreStatut extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_statut';
    protected $table = 'offre_statut';
    public $incrementing = true;
    protected $fillable = ['statut'];

    public function dealOffres()
    {
        return $this->hasMany(DealOffre::class, 'statut', 'statut');
    }
}

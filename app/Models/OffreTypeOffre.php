<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreTypeOffre extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_type_offre';
    protected $table = 'offre_typeoffre';
    public $incrementing = true;
    protected $fillable = ['type_offre'];

    public function dealOffres()
    {
        
        return $this->hasMany(DealOffre::class, 'type_offre', 'type_offre');
    }
}

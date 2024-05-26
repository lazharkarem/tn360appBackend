<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $primaryKey = 'ID_offre';

    protected $table = 'offre';



    protected $fillable = ['ID_client', 'date_debut', 'date_fin', 'statut', 'canal', 'type_offre'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }

    public function statut()
    {
        return $this->belongsTo(OffreStatut::class, 'statut');
    }

    public function canal()
    {
        return $this->belongsTo(OffreCanal::class, 'canal');
    }

    public function typeoffre()
    {
        return $this->belongsTo(OffreTypeoffre::class, 'type_offre');
    }
}

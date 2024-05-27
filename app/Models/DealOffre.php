<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealOffre extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_deal_offre';
    protected $table = 'deal_offre';
    protected $fillable = ['ID_client', 'date_debut', 'date_fin', 'statut', 'canal', 'type_offre'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }

    public function offreStatut()
    {
        return $this->belongsTo(OffreStatut::class, 'statut', 'statut');
    }

     public function offreCanal()
    {
        return $this->belongsTo(OffreCanal::class, 'canal', 'canal');
    }

    public function typeOffre()
    {
        return $this->belongsTo(OffreTypeOffre::class, 'type_offre', 'type_offre');
    }
}

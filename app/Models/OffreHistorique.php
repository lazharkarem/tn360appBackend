<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreHistorique extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_offre_historique';
    protected $table = 'offre_historique';
    protected $fillable = [
        'ID_client',
        'type_offre',
        'amount_earned_total',
        'statut',
        'date_debut',
        'date_fin',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client', 'ID_client');
    }
}

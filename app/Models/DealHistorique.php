<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealHistorique extends Model
{
    use HasFactory;

    protected $table = 'deal_historique';
    
    protected $fillable = [
        'ID_client', // This should remain in the deal_historique table
        'amount_earned_total',
        'statut',
        'date_debut',
        'date_fin',
    ];

    // Define the relationship if needed, for example, to `Client`:
    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealFrequence extends Model
{
    protected $primaryKey = 'ID_deal_frequence';

    protected $table = 'deal_frequence';

    protected $fillable = [
        'ID_client', 'segments','panier_moyen','objectif_frequence','compteur_frequence','gain','commande_1','commande_2','commande_3','commande_4','commande_5'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }


}

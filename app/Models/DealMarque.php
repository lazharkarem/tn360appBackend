<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealMarque extends Model
{
    protected $primaryKey = 'ID_deal_marque';

    protected $table = 'deal_marque';


    protected $fillable = [
        'ID_client','segments', 'code_marque', 'objectif_1', 'objectif_2', 'objectif_3','objectif_4','objectif_5',
        'gain_objectif_1', 'gain_objectif_2', 'gain_objectif_3','gain_objectif_4','gain_objectif_5','compteur_objectif'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }
}

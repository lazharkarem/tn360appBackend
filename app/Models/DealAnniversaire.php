<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealAnniversaire extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_deal_anniversaire';

    protected $table = 'deal_anniversaire';

    protected $fillable = [
        'ID_client', 'segments', 'date_de_naissance', 'objectif_1', 'objectif_2',
        'objectif_3', 'objectif_4', 'objectif_5', 'gain_objectif_1',
        'gain_objectif_2', 'gain_objectif_3', 'gain_objectif_4',
        'gain_objectif_5', 'compteur_objectif', 'amount_earned',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }

    public function dealOffre()
    {
        return $this->belongsTo(DealOffre::class, 'ID_deal_offre', 'ID_deal_offre');
    }

    public static function booted()
    {
        static::saved(function ($dealAnniversaire) {
            $dealAnniversaire->updateDealOffreTotal();
        });

        static::deleted(function ($dealAnniversaire) {
            $dealAnniversaire->updateDealOffreTotal();
        });
    }

    public function calculateAmountEarned()
    {
        return $this->gain_objectif_1 +
               $this->gain_objectif_2 +
               $this->gain_objectif_3 +
               $this->gain_objectif_4 +
               $this->gain_objectif_5;
    }

    public function updateDealOffreTotal()
    {
        if ($this->dealOffre) {
            $this->dealOffre->updateTotalAmountEarned();
        }
    }

    public function save(array $options = [])
    {
        $this->amount_earned = $this->calculateAmountEarned();
        parent::save($options);
    }
}

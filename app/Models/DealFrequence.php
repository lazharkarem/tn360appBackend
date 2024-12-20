<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealFrequence extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_deal_frequence';

    protected $table = 'deal_frequence';

    protected $fillable = [
        'ID_client', 'segments', 'panier_moyen', 'objectif_frequence',
        'compteur_frequence', 'gain', 'commande_1', 'commande_2',
        'commande_3', 'commande_4', 'commande_5', 'amount_earned',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }

    public function dealOffre()
    {
        return $this->belongsTo(DealOffre::class, 'ID_deal_offre', 'ID_deal_offre');
    }

    /**
     * Booted method to update DealOffre's total when saved or deleted
     */
    public static function booted()
    {
        static::saved(function ($dealFrequence) {
            $dealFrequence->updateDealOffreTotal();
        });

        static::deleted(function ($dealFrequence) {
            $dealFrequence->updateDealOffreTotal();
        });
    }

    /**
     * Calculate total earned amount
     */
    public function calculateAmountEarned()
    {
        return $this->gain ?? 0;
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

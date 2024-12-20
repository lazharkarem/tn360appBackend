<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealDepense extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_deal_depense';

    protected $table = 'deal_depense';

    protected $fillable = [
        'ID_client',
        'ID_deal_offre', // Foreign key to DealOffre
        'segments',
        'objectif_1', 'objectif_2', 'objectif_3', 'objectif_4', 'objectif_5',
        'gain_objectif_1', 'gain_objectif_2', 'gain_objectif_3', 'gain_objectif_4', 'gain_objectif_5',
        'compteur_objectif',
        'amount_earned', // New column to store earned amount
    ];

    /**
     * Relationships
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client', 'ID_client');
    }

    public function dealOffre()
    {
        return $this->belongsTo(DealOffre::class, 'ID_deal_offre', 'ID_deal_offre');
    }

    /**
     * Booted - Automatically Update Parent Total
     */
    public static function booted()
    {
        // Trigger the update on save or delete
        static::saved(function ($dealDepense) {
            $dealDepense->updateDealOffreTotal();
        });

        static::deleted(function ($dealDepense) {
            $dealDepense->updateDealOffreTotal();
        });
    }

    /**
     * Update the related DealOffre's Total Earned Amount
     */
    public function updateDealOffreTotal()
    {
        if ($this->dealOffre) {
            $this->dealOffre->updateTotalAmountEarned();
        }
    }

    /**
     * Calculate Total Gain from Objectifs
     * Can be used to calculate `amount_earned` based on objectifs.
     */
    public function calculateAmountEarned()
    {
        return $this->gain_objectif_1 +
               $this->gain_objectif_2 +
               $this->gain_objectif_3 +
               $this->gain_objectif_4 +
               $this->gain_objectif_5;
    }

    /**
     * Override Save to Recalculate Amount Earned
     */
    public function save(array $options = [])
    {
        // Calculate amount_earned before saving
        $this->amount_earned = $this->calculateAmountEarned();
        parent::save($options);
    }
}

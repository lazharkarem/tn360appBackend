<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealDepense extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'ID_deal_depense';

    protected $table = 'deal_depense';

    // Define the fillable fields
    protected $fillable = [
        'ID_client',
        'ID_deal_offre', // Foreign key to DealOffre
        'segments',
        'objectif_1', 'objectif_2', 'objectif_3', 'objectif_4', 'objectif_5',
        'gain_objectif_1', 'gain_objectif_2', 'gain_objectif_3', 'gain_objectif_4', 'gain_objectif_5',
        'compteur_objectif',
        'amount_earned', // New column to store earned amount
    ];

    // Define the casts to enforce proper data types
    protected $casts = [
        'gain_objectif_1' => 'float',
        'gain_objectif_2' => 'float',
        'gain_objectif_3' => 'float',
        'gain_objectif_4' => 'float',
        'gain_objectif_5' => 'float',
        'amount_earned' => 'float',
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
    return $this->belongsTo(DealOffre::class, 'ID_deal_offre');
}


    /**
     * Booted - Automatically Update Parent Total
     */
    protected static function booted()
    {
        static::saved(function ($dealDepense) {
            $dealDepense->updateDealOffreTotal();
            $dealDepense->transferEarnedAmountToCagnotte();
            $dealDepense->transferToHistoriqueIfEligible();
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
        return array_sum([
            $this->gain_objectif_1,
            $this->gain_objectif_2,
            $this->gain_objectif_3,
            $this->gain_objectif_4,
            $this->gain_objectif_5,
        ]);
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

    /**
     * Transfer Earned Amount to Client's Cagnotte
     */
    public function transferEarnedAmountToCagnotte()
    {
        $client = $this->client;

        if ($client) {
            $client->cagnotte_balance += $this->amount_earned;
            $client->save();
        }
    }

    /**
     * Transfer Deal to Historique if Eligible
     */
    public function transferToHistoriqueIfEligible()
    {
        $dealOffre = $this->dealOffre;

        if ($this->statut === 'cloturee' || ($dealOffre && $dealOffre->date_fin <= now())) {
            \DB::transaction(function () use ($dealOffre) {
                // Insert into deal_historique
                \DB::table('deal_historique')->insert([
                    'ID_client' => $this->ID_client,
                    'type_offre' => $dealOffre->type_offre ?? null,
                    'amount_earned_total' => $this->amount_earned,
                    'statut' => 'completed',
                    'date_debut' => $dealOffre->date_debut ?? null,
                    'date_fin' => $dealOffre->date_fin ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Delete from deal_depense
                $this->delete();
            });
        }
    }

    /**
     * Scope to get deals by client ID
     */
    public function scopeByClient($query, $clientId)
    {
        return $query->where('ID_client', $clientId);
    }

    /**
     * Scope for active deals
     */
    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }
}

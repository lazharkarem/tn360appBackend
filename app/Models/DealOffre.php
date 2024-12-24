<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DealOffre extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_deal_offre';
    protected $table = 'deal_offre';

    protected $fillable = [
        'ID_client', 'date_debut', 'date_fin', 'statut', 'canal', 'type_offre', 'amount_earned_total'
    ];

    /**
     * Relationships
     */
   public function dealDepense()
    {
        return $this->hasOne(DealDepense::class, 'ID_deal_offre', 'ID_deal_offre');
    }

    /**
     * Booted Method - Automatically Update Total Amount
     */
public static function booted()
{
    static::updated(function ($dealOffre) {
        if ($dealOffre->statut === 'cloturee' || $dealOffre->date_fin <= now()) {
            $dealOffre->moveToHistorical();
        }
    });

    static::saving(function ($dealOffre) {
        $dealOffre->updateTotalAmountEarned();
    });
}


    /**
     * Update Total Amount Earned
     */
    public function updateTotalAmountEarned()
    {
        $this->amount_earned_total = $this->dealDepense()->sum('amount_earned');
        $this->saveQuietly();
    }

    /**
     * Move the DealOffre to historical
     */
// public function moveToHistorical()
// {
//     \DB::transaction(function () {
//         // Transfer DealOffre to offre_historique
//         $historicalOffre = \DB::table('offre_historique')->insert([
//             'ID_client' => $this->ID_client,
//             'type_offre' => $this->type_offre,
//             'amount_earned_total' => $this->amount_earned_total,
//             'statut' => $this->statut,
//             'date_debut' => $this->date_debut,
//             'date_fin' => $this->date_fin,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);

//         Log::info('Offre moved to historique', ['offre' => $this]);

//         // Check and transfer related DealDepense
//         $dealDepense = $this->dealDepense;

//         if ($dealDepense) {
//             // Transfer DealDepense to deal_historique
//             $historicalDepense = \DB::table('deal_historique')->insert([
//                 'ID_client' => $dealDepense->ID_client,
//                 'ID_deal_offre' => $dealDepense->ID_deal_offre,
//                 'segments' => $dealDepense->segments,
//                 'objectif_1' => $dealDepense->objectif_1,
//                 'objectif_2' => $dealDepense->objectif_2,
//                 'objectif_3' => $dealDepense->objectif_3,
//                 'objectif_4' => $dealDepense->objectif_4,
//                 'objectif_5' => $dealDepense->objectif_5,
//                 'gain_objectif_1' => $dealDepense->gain_objectif_1,
//                 'gain_objectif_2' => $dealDepense->gain_objectif_2,
//                 'gain_objectif_3' => $dealDepense->gain_objectif_3,
//                 'gain_objectif_4' => $dealDepense->gain_objectif_4,
//                 'gain_objectif_5' => $dealDepense->gain_objectif_5,
//                 'compteur_objectif' => $dealDepense->compteur_objectif,
//                 'amount_earned' => $dealDepense->amount_earned,
//                 'statut' => 'completed', // Mark as completed
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);

//             Log::info('Depense moved to historique', ['deal_depense' => $dealDepense]);

//             // Delete DealDepense
//             $dealDepense->delete();
//         } else {
//             Log::warning('No DealDepense found for DealOffre', ['offre_id' => $this->ID_deal_offre]);
//         }

//         // Delete the original DealOffre
//         $this->delete();
//         Log::info('Offre deleted after moving to historique', ['offre' => $this]);
//     });
// }

public function moveToHistorical()
{
    \DB::transaction(function () {
        Log::info('Starting move to historical', ['deal_offre_id' => $this->ID_deal_offre]);

        // Transfer DealOffre to offre_historique (include type_offre and other fields like date_debut, date_fin)
        $historicalOffre = \DB::table('offre_historique')->insert([
            'ID_client' => $this->ID_client,
            'amount_earned_total' => $this->amount_earned_total,  // Ensure amount_earned_total is passed
            'statut' => $this->statut,
            'date_debut' => $this->date_debut,  // Fetch date_debut from the current DealOffre
            'date_fin' => $this->date_fin,     // Fetch date_fin from the current DealOffre
            'type_offre' => $this->type_offre, // Include type_offre here
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Offre moved to historique', ['deal_offre_id' => $this->ID_deal_offre]);

        // Check and transfer related DealDepense
        $dealDepense = $this->dealDepense;

        if ($dealDepense) {
            Log::info('DealDepense found', ['deal_depense_id' => $dealDepense->ID_deal_offre]);

            // Transfer DealDepense to deal_historique using Eloquent
            $historicalDepense = DealHistorique::create([
                'ID_client' => $dealDepense->ID_client,
                'ID_deal_offre' => $dealDepense->ID_deal_offre,
                'segments' => $dealDepense->segments,
                'objectif_1' => $dealDepense->objectif_1,
                'objectif_2' => $dealDepense->objectif_2,
                'objectif_3' => $dealDepense->objectif_3,
                'objectif_4' => $dealDepense->objectif_4,
                'objectif_5' => $dealDepense->objectif_5,
                'gain_objectif_1' => $dealDepense->gain_objectif_1,
                'gain_objectif_2' => $dealDepense->gain_objectif_2,
                'gain_objectif_3' => $dealDepense->gain_objectif_3,
                'gain_objectif_4' => $dealDepense->gain_objectif_4,
                'gain_objectif_5' => $dealDepense->gain_objectif_5,
                'compteur_objectif' => $dealDepense->compteur_objectif,
                'amount_earned' => $dealDepense->amount_earned,
                'statut' => $dealDepense->statut,
                'date_debut' => $dealDepense->dealOffre->date_debut, // Add date_debut from DealOffre
                'date_fin' => $dealDepense->dealOffre->date_fin,     // Add date_fin from DealOffre
            ]);

            Log::info('Depense moved to historique', ['deal_depense_id' => $dealDepense->ID_deal_offre]);

            // Delete DealDepense after transferring
            $dealDepense->delete();
            Log::info('DealDepense deleted after transfer', ['deal_depense_id' => $dealDepense->ID_deal_offre]);
        } else {
            Log::warning('No DealDepense found for DealOffre', ['deal_offre_id' => $this->ID_deal_offre]);
        }

        // Delete the original DealOffre
        $this->delete();
        Log::info('Offre deleted after moving to historique', ['deal_offre_id' => $this->ID_deal_offre]);
    });
}







    /**
     * Check if all objectives are completed
     */
    public function isObjectiveCompleted()
    {
        return $this->dealDepense()->where('statut', '!=', 'achieved')->count() === 0;
    }

    /**
     * Relationship with Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }
}

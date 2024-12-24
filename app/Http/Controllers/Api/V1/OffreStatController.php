<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DealOffre;
use App\Models\DealDepense;
use App\Models\OffreHistorique;
use App\Models\DealHistorique;
use Illuminate\Support\Facades\DB; // For DB transaction
use Illuminate\Support\Facades\Log;
use App\Models\Client;

class OffreStatController extends Controller
{
public function transferOffre($id)
{
    DB::beginTransaction();

    try {
        // Retrieve the DealOffre (ensure it has one associated DealDepense)
        $offre = DealOffre::findOrFail($id);

        // Update the status to "cloturée" before transferring
        $offre->statut = 'cloturée';
        $offre->save();

        // Retrieve the single DealDepense related to this DealOffre
        $dealDepense = $offre->dealDepense;

        if (!$dealDepense) {
            return response()->json([
                'status' => 'error',
                'message' => 'No associated DealDepense found for this offer.',
            ], 404);
        }

        // Update the statut of the DealDepense before transferring
        $dealDepense->statut = 'cloturée';  // Set statut to "cloturée"
        $dealDepense->save();

        // Enhanced logging for DealDepense record
        Log::info('DealDepense Transfer Diagnostic', [
            'offre_id' => $id,
            'deal_depense_id' => $dealDepense->ID_deal_depense,
            'client_id' => $dealDepense->ID_client,
            'statut' => $dealDepense->statut,
            'amount_earned' => $dealDepense->amount_earned,
            'soft_deleted' => $dealDepense->trashed(),
        ]);

        // Transfer DealOffre to historique
        $historicalOffre = OffreHistorique::create([
            'ID_client' => $offre->ID_client,
            'type_offre' => $offre->type_offre,
            'amount_earned_total' => $offre->amount_earned_total,
            'statut' => $offre->statut, // The updated status 'cloturée' will be transferred
            'date_debut' => $offre->date_debut,
            'date_fin' => $offre->date_fin,
        ]);

        // Transfer the single DealDepense to DealHistorique
        try {
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
                'statut' => $dealDepense->statut, // The updated status 'cloturée' will be transferred
            ]);
        } catch (\Exception $transferException) {
            Log::error('Individual Depense Transfer Failed', [
                'depense_id' => $dealDepense->ID_deal_depense,
                'error_message' => $transferException->getMessage(),
            ]);
        }

        // Commit transaction before deletion to ensure rollback works if something fails
        DB::commit();

        // Force delete the related DealDepense after commit
        $dealDepense->forceDelete();

        // Delete the original DealOffre after transaction commit
        $offre->forceDelete();

        Log::info('Transfer Completion Diagnostic', [
            'offre_id' => $id,
            'historical_offre_id' => $historicalOffre->id,
            'transferred_depense_id' => $dealDepense->ID_deal_depense,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Offer and associated expense transferred successfully.',
            'transferred_depense' => $dealDepense->ID_deal_depense,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Transfer Offre Complete Failure', [
            'offre_id' => $id,
            'error_message' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Transfer failed: ' . $e->getMessage(),
        ], 500);
    }
}




    public function getOffreHistorique()
    {
        $historique = OffreHistorique::all();
        return response()->json($historique, 200);
    }


    public function getActiveOffres()
    {
        // Retrieve active deal offers
        $dealOffres = DealOffre::all();
        return response()->json($dealOffres, 200);
    }
}
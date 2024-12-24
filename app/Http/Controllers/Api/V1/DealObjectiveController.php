<?php

namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DealDepense;

class DealObjectiveController extends Controller
{
    public function handleObjectiveAchievement($dealDepenseId)
    {
        $dealDepense = DealDepense::find($dealDepenseId);

        if ($dealDepense) {
            // Transfer earned amount to client cagnotte
            $dealDepense->transferEarnedAmountToCagnotte();

            // Check if all objectives are achieved for the deal_offre
            $dealOffre = $dealDepense->dealOffre;
            $remainingObjectives = $dealOffre->dealDepense()->where('statut', '!=', 'achieved')->count();

            if ($remainingObjectives === 0) {
                // Move to historique if all objectives are achieved
                $dealOffre->moveToHistorical();
            }
        }

        return response()->json(['message' => 'Objective handled successfully']);
    }
}

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
    public function dealDepenses()
    {
        return $this->hasMany(DealDepense::class, 'ID_deal_offre', 'ID_deal_offre');
    }

    /**
     * Booted Method - Automatically Update Total Amount
     */
    public static function booted()
    {
        // Listen to deal_depense changes
        static::updated(function ($dealOffre) {
            if (!empty($dealOffre->date_fin) && Carbon::parse($dealOffre->date_fin)->isPast()) {
                $dealOffre->dealDepenses()->update(['statut' => 'cloturee']);
            }
        });

        // Listen for dealOffre deletion
        static::deleted(function ($dealOffre) {
            $dealOffre->dealDepenses()->delete();
        });

        // Update total amount when DealDepense is changed
        static::saving(function ($dealOffre) {
            $dealOffre->updateTotalAmountEarned();
        });
    }

    /**
     * Update Total Amount Earned
     */
    public function updateTotalAmountEarned()
    {
        $this->amount_earned_total = $this->dealDepenses()->sum('amount_earned');
        $this->saveQuietly();
    }
}

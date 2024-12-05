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
    protected $fillable = ['ID_client', 'date_debut', 'date_fin', 'statut', 'canal', 'type_offre'];

    public function client()
    {
        // return $this->belongsTo(Client::class, 'ID_client');
        return $this->belongsTo(Client::class, 'ID_client', 'ID_client');
    }

    public function offreStatut()
    {
        // return $this->belongsTo(OffreStatut::class, 'statut', 'statut');
        return $this->belongsTo(OffreStatut::class, 'statut', 'statut');
    }

     public function offreCanal()
    {
        // return $this->belongsTo(OffreCanal::class, 'canal', 'canal');
        return $this->belongsTo(OffreCanal::class, 'canal', 'canal');
    }

    public function typeOffre()
    {
        // return $this->belongsTo(OffreTypeOffre::class, 'type_offre', 'type_offre');
        return $this->belongsTo(OffreTypeOffre::class, 'type_offre', 'type_offre');
    }

   public function dealDepenses()
{
    return $this->hasMany(DealDepense::class, 'ID_deal_offre', 'ID_deal_offre');
}



    /**
     * Listen for updates and check if the date_fin has passed.
     * Automatically update related DealDepense if necessary.
     */
    public static function booted()
    {
        static::updated(function ($dealOffre) {
            // Check if the deal has expired and the 'date_fin' has passed
            if (Carbon::parse($dealOffre->date_fin)->isPast()) {
                // Close all related deal_depenses
                $dealOffre->dealDepenses()->update(['statut' => 'cloturee']);
            }
        });

        // Listen for the 'deleted' event to cascade delete related DealDepense
        static::deleted(function ($dealOffre) {
            // Delete all related DealDepense records when the DealOffre is deleted
            $dealOffre->dealDepenses()->delete();
        });
    }
}
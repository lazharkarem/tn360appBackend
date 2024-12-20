<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CagnotteRetrait extends Model
{
    protected static function boot()
    {
        parent::boot();

        // Update cagnotte balance on withdrawal
        static::created(function ($cagnotteRetrait) {
            $cagnotteRetrait->client->decrement('cagnotte_balance', $cagnotteRetrait->amount_retrait);
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CagnotteDepot extends Model
{
    protected static function boot()
    {
        parent::boot();

        // Update cagnotte balance on deposit creation
        static::created(function ($cagnotteDepot) {
            $cagnotteDepot->client->increment('cagnotte_balance', $cagnotteDepot->amount_depot);
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }
}

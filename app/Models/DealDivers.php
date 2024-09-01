<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealDivers extends Model
{
    protected $primaryKey = 'ID_deal_divers';

    protected $fillable = ['ID_client', 'objectif'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }
}

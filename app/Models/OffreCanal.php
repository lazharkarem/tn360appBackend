<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreCanal extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID_canal';

    protected $table = 'offre_canal';
    public $incrementing = true;
    protected $fillable = ['canal'];

    public function dealOffres()
    {
        return $this->hasMany(DealOffre::class, 'canal', 'canal');
    }
}

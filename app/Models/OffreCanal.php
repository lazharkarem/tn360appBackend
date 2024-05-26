<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreCanal extends Model
{
    protected $primaryKey = 'canal';

    public $incrementing = false;

    protected $fillable = ['canal'];

    public $timestamps = false;
}

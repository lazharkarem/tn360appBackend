<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreTypeoffre extends Model
{
    protected $primaryKey = 'type_offre';

    public $incrementing = false;

    protected $fillable = ['type_offre'];

    public $timestamps = false;
}

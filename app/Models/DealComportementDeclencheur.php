<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealComportementDeclencheur extends Model
{
    protected $primaryKey = 'declencheur';

    public $incrementing = false;

    protected $fillable = ['declencheur'];

    public $timestamps = false;
}

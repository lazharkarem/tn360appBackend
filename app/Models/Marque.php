<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}

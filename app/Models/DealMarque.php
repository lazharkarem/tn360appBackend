<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealMarque extends Model
{
    use HasFactory; // Ensure you are using this trait

    protected $primaryKey = 'ID_deal_marque';

    protected $table = 'deal_marque';

    protected $fillable = [
        'ID_client', 'segments', 'code_marque', 'objectif_1', 'objectif_2', 'objectif_3',
        'objectif_4', 'objectif_5', 'gain_objectif_1', 'gain_objectif_2', 'gain_objectif_3',
        'gain_objectif_4', 'gain_objectif_5', 'compteur_objectif', 'upload_marque_picture' // Ensure this field is fillable
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'ID_client');
    }

    // Add validation rules if needed
    public static function rules()
    {
        return [
            'ID_client' => 'required',
            'segments' => 'nullable|string',
            'code_marque' => 'nullable|string',
            'upload_marque_picture' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Optional file validation
            // Add validation rules for other fields as necessary
        ];
    }
}

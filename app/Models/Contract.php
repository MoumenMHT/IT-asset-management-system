<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_contract';

    protected $fillable = [
        'ref',        
        'date_acquisition',    
        'garantie',
        'Type_contract',
        'id_structure',
        'id_fournisseur'
    ];

    // Define the relationship
    public function structure()
    {
        return $this->belongsTo(Structure::class, 'id_structure', 'id_structure');
    }
    public function fournisseur()
    {
        return $this->belongsTo(Provider::class, 'id_fournisseur', 'id_fournisseur');
    }
}

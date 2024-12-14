<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_equipement';

    protected $fillable = [
        'id_contract',        
        'Type',    
        'num_serie',
        'marque',
        'etat',
        'status',
        'date_amortissement',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'id_contract', 'id_contract');
    }

}

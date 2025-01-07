<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostory extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_history';


    protected $fillable = [
        'type',        
        'date',    
        'id_employer',
        'id_equipement',
        'status',
    ];


    public function employer()
    {
        return $this->belongsTo(Employer::class, 'id_employer', 'id_employer');
    }

    public function equipement()
    {
        return $this->belongsTo(Equipment::class, 'id_equipement', 'id_equipement');
    }
}

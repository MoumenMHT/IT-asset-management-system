<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_employer';

    protected $fillable = [
        'nom',        
        'prenom',    
        'fonc',
        'code',
        'id_structure',
        'id_user'
    ];

    // Define the relationship
    public function structure()
    {
        return $this->belongsTo(Structure::class, 'id_structure', 'id_structure');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

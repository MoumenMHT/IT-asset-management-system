<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class structure extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_structure';

    protected $fillable = ['nom']; // Ensure 'nom' is in the fillable array if you're using mass assignment

}

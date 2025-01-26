<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Provider extends Model
{
    use HasFactory, LogsActivity;


    protected $primaryKey = 'id_fournisseur';

    protected $fillable = [
        'nom',        
    ];
}

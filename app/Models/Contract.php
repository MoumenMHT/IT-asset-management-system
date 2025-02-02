<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;



class Contract extends Model
{
    use HasFactory, LogsActivity;
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

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = class_basename($activity->subject_type); // Store only "User" instead of "App\Models\User"
    }

}

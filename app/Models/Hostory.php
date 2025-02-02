<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;



class Hostory extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'id_history';


    protected $fillable = [
        'type',        
        'date',    
        'id_employer',
        'id_equipement',
        'status',
        'path',
    ];


    public function employer()
    {
        return $this->belongsTo(Employer::class, 'id_employer', 'id_employer');
    }

    public function equipement()
    {
        return $this->belongsTo(Equipment::class, 'id_equipement', 'id_equipement');
    }

    
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = class_basename($activity->subject_type); // Store only "User" instead of "App\Models\User"
    }
}

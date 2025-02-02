<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;



class Equipment extends Model
{
    use HasFactory, LogsActivity;
    protected $primaryKey = 'id_equipement';

    protected $fillable = [
        'id_contract',        
        'Type',    
        'num_serie',
        'marque',
        'etat',
        'status',
        'date_amortissement',
        'id_employer',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'id_contract', 'id_contract');
    }
    public function employer()
    {
        return $this->belongsTo(Employer::class, 'id_employer', 'id_employer');
    }



    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = class_basename($activity->subject_type); // Store only "User" instead of "App\Models\User"
    }

}

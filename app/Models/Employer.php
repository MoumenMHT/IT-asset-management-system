<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;



class Employer extends Model
{
    use HasFactory, LogsActivity;

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


    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = class_basename($activity->subject_type); // Store only "User" instead of "App\Models\User"
    }
}

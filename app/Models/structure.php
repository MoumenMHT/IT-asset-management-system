<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;


class structure extends Model
{
    use HasFactory, LogsActivity;
    protected $primaryKey = 'id_structure';

    protected $fillable = ['nom']; // Ensure 'nom' is in the fillable array if you're using mass assignment


    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->subject_type = class_basename($activity->subject_type); // Store only "User" instead of "App\Models\User"
    }

}

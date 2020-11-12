<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'appointment_date', 'appointment_start_hour', 'status', 'observations', 'emergency', 'state', 'type_id', 'pet_id', "doctor_id"
    ];

    public function type(){
        return $this->belongsTo('App\Models\AppointmentType');
    }

    public function pet(){
        return $this->belongsTo('App\Models\Pet');
    }

    public function doctor(){
        return $this->belongsTo('App\Models\User', 'doctor_id');
    }
}
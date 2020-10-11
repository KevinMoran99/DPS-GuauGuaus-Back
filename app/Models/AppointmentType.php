<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentType extends Model
{
    protected $table = 'appointment_types';

    protected $fillable = [
        'name', 'duration' ,'state'
    ];

    /*Relation between medical_condition and pet_details (one to many)*/
    public function appointment(){
        return $this->belongsTo('App\Models\Appointment');
    }
}

?>
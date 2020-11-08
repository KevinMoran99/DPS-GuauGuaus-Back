<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Appointment;
use App\Models\AppointmentType;

class inAppointment implements Rule
{
    private $id;
    private $doctor_id;
    private $type_id;
    private $appointment_date;
    private $error_message = "";

    public function __construct($doctor_id,$type_id,$appointment_date,$id=0)
    {
        $this->id = $id;
        $this->doctor_id = $doctor_id;
        $this->type_id = $type_id;
        $this->appointment_date = $appointment_date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {   
        //Check if another appointment on this time exists already
        $appointment = Appointment::where("appointment_date", $this->appointment_date)
                                    ->where("appointment_start_hour", $value)
                                    ->where("state",1)
                                    ->where("id","!=", $this->id)->get();


        //Check for query results
        if(count($appointment) != 0) {
            //changes error message variable
            $this->error_message = "Una cita a esta hora ya existe.";
            return false;
        }

        //Find appointment type
        $appointmentType = AppointmentType::find($this->type_id);

        //check if appointment type is an emergency
        if($appointmentType->name == "Emergencia"){
            $duration = 0;
        }
        else{
            //get duration in minutes and transform into seconds
            $duration = $appointmentType->duration * 60;
        }

        //The time the appoint is being set plus the duration
        $finish_time = strtotime($value) + $duration;
        //Transform variable from quantity of seconds to time format
        $finish_time = date('H:i:s', $finish_time);


        //Check if there is another appointment within the duration of the appointment
        $appointment = Appointment::where("appointment_date", $this->appointment_date)
                                    ->where("appointment_start_hour",">", $value)
                                    ->where("appointment_start_hour","<", $finish_time)
                                    ->where("state",1)
                                    ->where("id","!=", $this->id)->get();

        //Check for query results
        if(count($appointment) != 0) {
            //changes error message variable
            $this->error_message = "Una cita ya existe dentro de la duracion de la cita que se esta tratando de crear.";
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error_message;
    }
}
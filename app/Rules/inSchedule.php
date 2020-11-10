<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Schedule;
use App\Models\Special;

class inSchedule implements Rule
{
    private $id;
    private $doctor_id;
    private $appointment_date;
    private $error_message = "";

    public function __construct($doctor_id,$appointment_date,$id=0)
    {
        $this->id = $id;
        $this->doctor_id = $doctor_id;
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
        //Get the day of the week using PHP's date function.
        $day = date("l", strtotime($this->appointment_date));
        
        //Translate day name to spanish
        $day = $this->translateDay($day);

        //Check if appointment is in between the doctor's schedule
        $schedule = Schedule::where("doctor_id", $this->doctor_id)
                            ->where("start_hour","<=", $value)
                            ->where("finish_hour",">=", $value)
                            ->where("day",$day)
                            ->where("state",1)
                            ->where("id","!=", $this->id)->get();


        //Check for query results
        if(count($schedule) == 0) {
            //changes error message variable
            $this->error_message = "La cita tiene que estar dentro del horario del doctor.";
            return false;
        }

        //Check if appoint is NOT in any of the doctor's special schedules
        $special = Special::where("doctor_id", $this->doctor_id)
                            ->where("start_hour","<=", $value)
                            ->where("finish_hour",">=", $value)
                            ->where("day",$this->appointment_date)
                            ->where("state",1)
                            ->where("id","!=", $this->id)->get();


        //Check for query results
        if(count($special) != 0) {
            //changes error message variable
            $this->error_message = "La cita esta dentro de un horario especial del doctor.";
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

    //This functions translates the day given in english to spanish
    private function translateDay($day){
        if($day == "Monday"){
            $day = "Lunes";
        }
        if($day == "Tuesday"){
            $day = "Martes";
        }   
        if($day == "Wednesday"){
            $day = "Miercoles";
        }
        if($day == "Thursday"){
            $day = "Jueves";
        }
        if($day == "Friday"){
            $day = "Viernes";
        }
        if($day == "Saturday"){
            $day = "Sabado";
        }
        if($day == "Sunday"){
            $day = "Domingo";
        }

        return $day;
    }
}
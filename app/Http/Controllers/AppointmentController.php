<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Rules\inSchedule;
use App\Rules\inAppointment;
use App\Rules\isDoctor;

class AppointmentController extends Controller
{
    //CRUD

    //Show list of Appointments
    public function index()
    {
        //Requests list of data from data base
        $appointment = Appointment::with('type','pet','doctor', 'pet.owner')->orderBy('appointment_date','desc')->get();
        //$appointment  = Appointment::all();

        //Encodes in json format all the data found
        $json = json_decode($appointment, true);

        //Returns json 
        return $json;
    }
    
    //Show list of active Appointments
    public function getActiveAppointments()
    {
        //Requests list of data from data base
        $appointment = Appointment::with('type','pet','doctor', 'pet.owner')->where('state',1)->orderBy('appointment_date','desc')->get();
        //$appointment  = Appointment::all();

        //Encodes in json format all the data found
        $json = json_decode($appointment, true);

        //Returns json 
        return $json;
    }

    //Search for AppointmentType
    public function show($id)
    {
        //Searches for data using an id
        $appointment = Appointment::find($id)->get();

        //Check if data was found
        if(!$appointment) {
            //Return no data found message
            return response()->json(['No se encontró la cita.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($appointment, true);

        //Return json 
        return $json;
    }

    public function getAppointmentbyPet($pet_id)
    {
        $appointment = Appointment::with('type','pet','doctor', 'pet.owner')->where("pet_id", $pet_id)->where('state',1)->orderBy('appointment_date','desc')->get();
        if(count($appointment) ==0) {
            return response()->json(['La mascota no tiene citas.'], 404);
        }

        $json = json_decode($appointment, true);

        return $json;
    }

    
    public function getAppointmentbyDoctor($doctor_id)
    {
        $appointment = Appointment::with('type','pet','doctor', 'pet.owner')->where("doctor_id", $doctor_id)->where('state',1)->orderBy('appointment_date','desc')->get();
        if(count($appointment) ==0) {
            return response()->json(['La mascota no tiene citas.'], 404);
        }

        $json = json_decode($appointment, true);

        return $json;
    }

    //Create data
    public function store(Request $request)
    {
        /*Validate get/post from form

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'appointment_date' => array('required'),
                'appointment_start_hour' => array('required',
                                                    new inSchedule($request->doctor_id, $request->appointment_date),
                                                    new inAppointment($request->doctor_id, $request->type_id ,$request->appointment_date)),
                'status' => array('required'),
                'observations' => array('required'),
                'emergency' => array('required'),
                'type_id' => array('required'),
                'pet_id' => array('required'),
                'doctor_id' => array('required', new isDoctor()),
                'state'=>array('required', 'boolean'),
            )
        );
        

        //Check if validation fails
        if ($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors'=>$validator->errors()], 422);
        }


        try {
            //Starts UserType variable
            $appointment = new Appointment;

            //Inserts data recieved from form into variable
            $appointment->fill($request->all());

            //Adds new data into database
            $appointment->save();

            //Return list of data from data base in json format
            return response()->json($appointment);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $appointment = Appointment::find($request['id']);

        //Checks if data was found
        if(!$appointment) {

            //Returns message of no data found
            return response()->json(['No se encontró la cita.'], 404);
        }

        /*Validate get/post from form

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'appointment_date' => array('required'),
                'appointment_start_hour' => array('required',
                                                    new inSchedule($request->doctor_id, $request->appointment_date,$request->id),
                                                    new inAppointment($request->doctor_id, $request->type_id ,$request->appointment_date,$request->id)),
                'status' => array('required'),
                'observations' => array('required'),
                'emergency' => array('required'),
                'type_id' => array('required'),
                'pet_id' => array('required'),
                'doctor_id' => array('required', new isDoctor()),
                'state'=>array('required', 'boolean'),
            )
        );
        

        //Check if validation fails
        if ($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors'=>$validator->errors()], 422);
        }


        try {
            //Inserts data recieved from form into variable
            $appointment->fill($request->all());
            
            //Adds new data into database
            $appointment->save();

            //Return list of data from data base in json format
            return response()->json($appointment);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
}
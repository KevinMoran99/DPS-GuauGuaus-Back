<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\AppointmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppointmentTypeController extends Controller
{
    //CRUD

    //Show list of AppointmentTypes
    public function index()
    {
        //Requests list of data from data base
        $appointmentType = AppointmentType::all();

        //Encodes in json format all the data found
        $json = json_decode($appointmentType, true);

        //Returns json 
        return $json;
    }

    //Search for AppointmentType
    public function show($id)
    {
        //Searches for data using an id
        $appointmentType = AppointmentType::find($id)->where('state',1);

        //Check if data was found
        if(!$appointmentType) {
            //Return no data found message
            return response()->json(['No se encontró el tipo de cita.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($appointmentType, true);

        //Return json 
        return $json;
    }

    //Create data
    public function store(Request $request)
    {
        /*Validate get/post from form

        Variables:
            name -> this is the name of the type of user
            duration -> this is the duration of the appointment
            state -> this is the state of the type of user, active or in-active.

        Rules: 
            name -> has to be required, unique value inside table, minimum of 1 characters, maximun of 50 characters
            duration -> has to be required, has to be a numberic value
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:1', 'max:50'),
                'duration' => array('required','numeric'),
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
            $appointmentType = new AppointmentType;

            //Inserts data recieved from form into variable
            $appointmentType->fill($request->all());

            //Adds new data into database
            $appointmentType->save();

            //Return list of data from data base in json format
            return response()->json($appointmentType);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }


        
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $appointmentType = AppointmentType::find($request['id']);

        //Checks if data was found
        if(!$appointmentType) {

            //Returns message of no data found
            return response()->json(['No se encontró el tipo de cita.'], 404);
        }

        /*Validate get/post from form

        Variables:
            name -> this is the name of the type of user
            duration -> this is the duration of the appointment
            state -> this is the state of the type of user, active or in-active.

        Rules: 
            name -> has to be required, unique value inside table, minimum of 1 characters, maximun of 50 characters
            duration -> has to be required, has to be a numberic value
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:1', 'max:50'),
                'duration' => array('required','numeric'),
                'state'=>array('required', 'boolean'),
            )
        );
        
        //Checks if validation fails
        if($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {

            //Inserts data recieved from form into variable
            $appointmentType->fill($request->all());
            
            //Adds new data into database
            $appointmentType->save();

            //Return list of data from data base in json format
            return response()->json($appointmentType);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
}
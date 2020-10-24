<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Special;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SpecialController extends Controller
{
    //CRUD

    //Show list of UserTypes
    public function index()
    {
        //Requests list of data from data base
        $schedule = Special::with('doctor')->get();

        //Encodes in json format all the data found
        $json = json_decode($schedule, true);

        //Returns json 
        return $json;
    }

    //Search for UserTypes
    public function show($id)
    {
        //Searches for data using an id
        $schedule = Special::with('doctor')->find($id);

        //Check if data was found
        if(!$schedule) {
            //Return no data found message
            return response()->json(['No se encontró el horario.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($schedule, true);

        //Return json 
        return $json;
    }

    //Create data
    public function store(Request $request)
    {
        $yearEnd = date('Y-m-d', strtotime('12/31'));
        $validator = Validator::make($request->all(),
            $rules = array(
                'doctor_id' => array('required','exists:users,id', 'numeric'),
                'day'=>array('required', 'before_or_equal:'.$yearEnd, 'date_format:Y-m-d', 'after:today'),
                'start_hour'=>array('required', 'date_format:H:i'),
                'finish_hour'=>array('required', 'after:start_hour', 'date_format:H:i'),
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
            $special = new Special;

            //Inserts data recieved from form into variable
            $special->fill($request->all());

            //Adds new data into database
            $special->save();

            //Return list of data from data base in json format
            return response()->json($special);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }


        
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $special = Special::find($request['id']);

        //Checks if data was found
        if(!$special) {

            //Returns message of no data found
            return response()->json(['No se encontró el horario especial del medico.'], 404);
        }

        /*Validate get/post from form

        Variables:
            name -> this is the name of the type of user
            state -> this is the state of the type of user, active or in-active.

        Rules: 
            name -> has to be required, unique value inside table, minimum of 3 characters, maximun of 100 characters
            state -> has to be required, has to be a boolean character

        */
        $yearEnd = date('Y-m-d', strtotime('12/31'));
        $validator = Validator::make($request->all(),
            $rules = array(
                'doctor_id' => array('required','exists:users,id', 'numeric'),
                'day'=>array('required', 'before_or_equal:'.$yearEnd, 'date_format:Y-m-d', 'after:today'),
                'start_hour'=>array('required', 'date_format:H:i'),
                'finish_hour'=>array('required', 'after:start_hour', 'date_format:H:i'),
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
            $special->fill($request->all());
            
            //Adds new data into database
            $special->save();

            //Return list of data from data base in json format
            return response()->json($special);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
    public function getActiveSpecial()
    {
        $details = Special::with('doctor')->where("state", 1)->get();

        if(count($details)==0) {
            return response()->json(['No se encontró horarios activos'], 404);
        }

        $json = json_decode($details, true);

        return $json;
    }

    public function getDoctorSpecials($doctor_id)
    {
        $details = Special::with('doctor')->where("doctor_id",$doctor_id)->get();

        if(count($details)==0) {
            return response()->json(['No se encontró horarios especiales para este doctor'], 404);
        }

        $json = json_decode($details, true);

        return $json;
    }
    public function getDoctorActiveSpecials($doctor_id)
    {
        $details = Special::with('doctor')->where("doctor_id",$doctor_id)->where("state",1)->get();

        if(count($details)==0) {
            return response()->json(['No se encontró horarios especiales para este doctor'], 404);
        }

        $json = json_decode($details, true);

        return $json;
    }
}
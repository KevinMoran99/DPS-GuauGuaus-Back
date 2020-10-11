<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\MedicalCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MedicalConditionController extends Controller
{
    //CRUD

    //Show list of MedicalConditions
    public function index()
    {
        //Requests list of data from data base
        $medicalCondition = MedicalCondition::all();

        //Encodes in json format all the data found
        $json = json_decode($medicalCondition, true);

        //Returns json 
        return $json;
    }

    //Search for medicalCondition
    public function show($id)
    {
        //Searches for data using an id
        $medicalCondition = MedicalCondition::find($id);

        //Check if data was found
        if(!$medicalCondition) {
            //Return no data found message
            return response()->json(['No se encontró la condicion medica.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($medicalCondition, true);

        //Return json 
        return $json;
    }

    //Create data
    public function store(Request $request)
    {
        /*Validate get/post from form

        Variables:
            name -> this is the name of the type of user
            state -> this is the state of the type of user, active or in-active.

        Rules: 
            name -> has to be required, unique value inside table, minimum of 1 characters, maximun of 50 characters
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:1', 'max:50'),
                'state'=>array('required', 'boolean'),
            )
        );
        

        //Check if validation fails
        if ($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors'=>$validator->errors()], 422);
        }


        try {
            //Starts MedicalCondition variable
            $medicalCondition = new MedicalCondition;

            //Inserts data recieved from form into variable
            $medicalCondition->fill($request->all());

            //Adds new data into database
            $medicalCondition->save();

            //Return list of data from data base in json format
            return response()->json($medicalCondition);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }


        
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $medicalCondition = MedicalCondition::find($request['id']);

        //Checks if data was found
        if(!$medicalCondition) {

            //Returns message of no data found
            return response()->json(['No se encontró la condicion medica.'], 404);
        }

        /*Variables:
            name -> this is the name of the type of user
            state -> this is the state of the type of user, active or in-active.

        Rules: 
            name -> has to be required, unique value inside table, minimum of 1 characters, maximun of 50 characters
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:1', 'max:50'),
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
            $medicalCondition->fill($request->all());
            
            //Adds new data into database
            $medicalCondition->save();

            //Return list of data from data base in json format
            return response()->json($medicalCondition);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
}
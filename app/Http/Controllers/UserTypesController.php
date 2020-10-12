<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserTypesController extends Controller
{
    //CRUD

    //Show list of UserTypes
    public function index()
    {
        //Requests list of data from data base
        $userType = UserType::all();

        //Encodes in json format all the data found
        $json = json_decode($userType, true);

        //Returns json 
        return $json;
    }

    //Search for UserTypes
    public function show($id)
    {
        //Searches for data using an id
        $userType = UserType::find($id);

        //Check if data was found
        if(!$userType) {
            //Return no data found message
            return response()->json(['No se encontró el tipo de usuario.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($userType, true);

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
            name -> has to be required, unique value inside table, minimum of 3 characters, maximun of 100 characters
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required','unique:users_types','min:3', 'max:100'),
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
            $userType = new UserType;

            //Inserts data recieved from form into variable
            $userType->fill($request->all());

            //Adds new data into database
            $userType->save();

            //Return list of data from data base in json format
            return response()->json($userType);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }


        
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $userType = UserType::find($request['id']);

        //Checks if data was found
        if(!$userType) {

            //Returns message of no data found
            return response()->json(['No se encontró el tipo de usuario.'], 404);
        }

        /*Validate get/post from form

        Variables:
            name -> this is the name of the type of user
            state -> this is the state of the type of user, active or in-active.

        Rules: 
            name -> has to be required, unique value inside table, minimum of 3 characters, maximun of 100 characters
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required','min:3', 'max:100'),
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
            $userType->fill($request->all());
            
            //Adds new data into database
            $userType->save();

            //Return list of data from data base in json format
            return response()->json($userType);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
    public function getActiveUserTypes()
    {
        $types = UserType::where("state", 1)->get();

        if(count($types) ==0) {
            return response()->json(['No se encontró tipos de usuario activos'], 404);
        }

        $json = json_decode($types, true);

        return $json;
    }
}
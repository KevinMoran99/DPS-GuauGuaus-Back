<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store(){
        
    }
    public function index()
    {
        $users = User::all();
        $json = json_decode($users, true);

        return $json;
    }

    //Search for UserTypes
    public function show($id)
    {
        //Searches for data using an id
        $user = User::find($id);

        //Check if data was found
        if(!$user) {
            //Return no data found message
            return response()->json(['No se encontró el  usuario.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($user, true);

        //Return json 
        return $json;
    }


    //Create data
    public function store(Request $request)
    {
        /*Validate get/post from form

        Rules: 
            name -> has to be required,  minimum of 3 characters, maximun of 50 characters
            last name -> has to be required, minimum of 3 characters, maximun of 50 characters
            email -> has to be required, has to have email format, maximum of 50 characters
            password -> has to be required
            dui -> has to be required, minimum of 10 characters, maximum of 10 characters, has to be numeric, has to be an integer
            address -> has to be required, minimum of 5 characters ,maximum of 500 characters
            phone -> has to be required, minimum of 8 characters, maximum of 8 characters, has to be numeric, has to be an integer
            state -> has to be required, has to be a boolean character
            type_user_id -> has to be required, has to be numeric, has to be an integer

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                //'name', 'lastname', 'email', 'password', 'dui', 'address', 'phone', 'state', 'type_user_id'
                'name' => array('required','min:3', 'max:50'),
                'lastname' => array('required','min:3', 'max:50'),
                'email' => array('required','email','max:50'),
                'password' => array('required'),
                'dui' => array('required','min:10','max:10','numeric','integer'),
                'address' => array('required','min:5','max:500'),
                'phone' => array('required','min:8','max:8','numeric','integer'),
                'state'=>array('required', 'boolean'),
                'type_user_id' => array('required','numeric','integer'),
            )
        );
        

        //Check if validation fails
        if ($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors'=>$validator->errors()], 422);
        }


        try {
            //Starts UserType variable
            $user = new User;

            //Inserts data recieved from form into variable
            $user->fill($request->all());

            //Adds new data into database
            $user->save();

            //Return list of data from data base in json format
            return response()->json($user);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }


    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $user = User::find($request['id']);

        //Checks if data was found
        if(!$user) {

            //Returns message of no data found
            return response()->json(['No se encontró el usuario.'], 404);
        }

        /*Validate get/post from form

        Rules: 
            name -> has to be required,  minimum of 3 characters, maximun of 50 characters
            last name -> has to be required, minimum of 3 characters, maximun of 50 characters
            email -> has to be required, has to have email format, maximum of 50 characters
            password -> has to be required
            dui -> has to be required, minimum of 10 characters, maximum of 10 characters, has to be numeric, has to be an integer
            address -> has to be required, minimum of 5 characters ,maximum of 500 characters
            phone -> has to be required, minimum of 8 characters, maximum of 8 characters, has to be numeric, has to be an integer
            state -> has to be required, has to be a boolean character
            type_user_id -> has to be required, has to be numeric, has to be an integer

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                //'name', 'lastname', 'email', 'password', 'dui', 'address', 'phone', 'state', 'type_user_id'
                'name' => array('required','min:3', 'max:50'),
                'lastname' => array('required','min:3', 'max:50'),
                'email' => array('required','email','max:50'),
                'password' => array('required'),
                'dui' => array('required','min:10','max:10','numeric','integer'),
                'address' => array('required','min:5','max:500'),
                'phone' => array('required','min:8','max:8','numeric','integer'),
                'state'=>array('required', 'boolean'),
                'type_user_id' => array('required','numeric','integer'),
            )
        );
        
        //Checks if validation fails
        if($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {

            //Inserts data recieved from form into variable
            $user->fill($request->all());
            
            //Adds new data into database
            $user->save();

            //Return list of data from data base in json format
            return response()->json($user);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
}
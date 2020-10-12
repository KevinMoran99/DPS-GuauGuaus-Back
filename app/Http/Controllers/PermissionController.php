<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    //CRUD

    //Show list of Permissions
    public function index()
    {
        //Requests list of data from data base
        $permission = Permission::all();

        //Encodes in json format all the data found
        $json = json_decode($permission, true);

        //Returns json 
        return $json;
    }

    //Search for Permissions
    public function show($id)
    {
        //Searches for data using an id
        $permission = Permission::find($id)->where('state',1);

        //Check if data was found
        if(!$permission) {
            //Return no data found message
            return response()->json(['No se encontró el permiso.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($permission, true);

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
            create,read,update,delete -> this are the options in which we determine if the permission allows to create,read,update and/or delete the data

        Rules: 
            name -> has to be required, unique value inside table
            registro -> has to be required
            create,read,update, delete -> has to be required, has to be a number, has to be an integer
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required','unique:permissions'),
                'registro'=>array('required',),
                'create' => array('reguired', 'numeric', 'integer'),
                'read' => array('reguired', 'numeric', 'integer'),
                'update' => array('reguired', 'numeric', 'integer'),
                'delete' => array('reguired', 'numeric', 'integer'),
                'state'=>array('required', 'boolean')
            )
        );
        

        //Check if validation fails
        if ($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors'=>$validator->errors()], 422);
        }


        try {
            //Starts permission variable
            $permission = new Permission;

            //Inserts data recieved from form into variable
            $permission->fill($request->all());

            //Adds new data into database
            $permission->save();

            //Return list of data from data base in json format
            return response()->json($permission);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }


        
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $permission = Permission::find($permission['id']);

        //Checks if data was found
        if(!$permission) {

            //Returns message of no data found
            return response()->json(['No se encontró el permiso.'], 404);
        }

        /*Validate get/post from form

        Variables:
            name -> this is the name of the type of user
            state -> this is the state of the type of user, active or in-active.
            create,read,update,delete -> this are the options in which we determine if the permission allows to create,read,update and/or delete the data

        Rules: 
            name -> has to be required, unique value inside table
            registro -> has to be required
            create,read,update, delete -> has to be required, has to be a number, has to be an integer
            state -> has to be required, has to be a boolean character

        */
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required','unique:permissions'),
                'registro'=>array('required',),
                'create' => array('reguired', 'numeric', 'integer'),
                'read' => array('reguired', 'numeric', 'integer'),
                'update' => array('reguired', 'numeric', 'integer'),
                'delete' => array('reguired', 'numeric', 'integer'),
                'state'=>array('required', 'boolean')
            )
        );
        
        //Checks if validation fails
        if($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {

            //Inserts data recieved from form into variable
            $permission->fill($request->all());
            
            //Adds new data into database
            $permission->save();

            //Return list of data from data base in json format
            return response()->json($permission);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
}
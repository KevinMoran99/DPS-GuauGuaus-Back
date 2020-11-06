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
        $permission = Permission::with("users_types")->get();

        //Encodes in json format all the data found
        $json = json_decode($permission, true);

        //Returns json 
        return $json;
    }

    //Search for Permissions
    public function show($id)
    {
        //Searches for data using an id
        $permission = Permission::find($id);

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
                'registro'=>array('required','in:users,users_types,special,schedules,species,special,pets,pet_details,permissions,medical_condition,appointment_types,appointment'),
                'create' => array('required', 'boolean'),
                'read' => array('required', 'boolean'),
                'update' => array('required', 'boolean'),
                'delete' => array('required', 'boolean'),
                'users_types_id' => array('required', 'exists:users_types,id'),
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
        $permission = Permission::find($request['id']);

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
                'registro'=>array('required','in:users,users_types,special,schedules,species,special,pets,pet_details,permissions,medical_condition,appointment_types,appointment'),
                'create' => array('required', 'boolean'),
                'read' => array('required', 'boolean'),
                'update' => array('required', 'boolean'),
                'delete' => array('required', 'boolean'),
                'users_types_id' => array('required', 'exists:users_types,id'),
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
    public function getActivePermission()
    {
        //Searches for data using an id
        $permission = Permission::with("users_types")->where("state", 1)->get();

        //Check if data was found
        if(count($permission) ==0) {
            //Return no data found message
            return response()->json(['No se encontraron permisos activos.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($permission, true);

        //Return json 
        return $json;
    }

    public function getTypeUsersPermissions($type_users_id)
    {
        //Searches for data using an id
        $permission = Permission::with("users_types")->where("users_types_id", $type_users_id)->get();

        //Check if data was found
        if(count($permission) ==0) {
            //Return no data found message
            return response()->json(['No se encontraron permisos activos.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($permission, true);

        //Return json 
        return $json;
    }

    public function getActiveTypeUsersPermissions($type_users_id)
    {
        //Searches for data using an id
        $permission = Permission::with("users_types")->where("users_types_id", $type_users_id)->where("state", 1)->get();

        //Check if data was found
        if(count($permission) ==0) {
            //Return no data found message
            return response()->json(['No se encontraron permisos activos.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($permission, true);

        //Return json 
        return $json;
    }
}
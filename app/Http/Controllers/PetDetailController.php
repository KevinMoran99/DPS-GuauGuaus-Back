<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\PetDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PetDetailController extends Controller
{
    //CRUD

    //Show list of UserTypes
    public function index()
    {
        //Requests list of data from data base
        $petdetail = PetDetail::with('codition', 'pet')->get();

        //Encodes in json format all the data found
        $json = json_decode($petdetail, true);

        //Returns json 
        return $json;
    }

    //Search for UserTypes
    public function show($id)
    {
        //Searches for data using an id
        $petdetail = PetDetail::with('codition', 'pet')->find($id);

        //Check if data was found
        if(!$petdetail) {
            //Return no data found message
            return response()->json(['No se encontró la condicion medica.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($petdetail, true);

        //Return json 
        return $json;
    }

    //Create data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            $rules = array(
                'pet_id' => array('required','exists:pets,id', 'numeric'),
                'codition_id'=>array('required', 'exists:medical_condition,id', 'numeric'),
                'observations'=>array('required','min:10', 'max: 1000' ),
                'state'=>array('required', 'boolean')
            )
        );
        

        //Check if validation fails
        if ($validator->fails()) {

            //Return response of errors in json format
            return response()->json(['errors'=>$validator->errors()], 422);
        }


        try {
            //Starts UserType variable
            $petdetail = new PetDetail;

            //Inserts data recieved from form into variable
            $petdetail->fill($request->all());

            //Adds new data into database
            $petdetail->save();

            //Return list of data from data base in json format
            return response()->json($petdetail);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }


        
    }

    //Update and delete data 
    /*In this case the update function with allow us to 'delete' data, setting the data 'state' to false, making it invisible for the client*/
    public function update(Request $request){

        //Searches for data using id
        $petdetail = PetDetail::find($request['id']);

        //Checks if data was found
        if(!$petdetail) {

            //Returns message of no data found
            return response()->json(['No se encontró la condicion medica.'], 404);
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
                'pet_id' => array('required','exists:pets,id', 'numeric'),
                'codition_id'=>array('required', 'exists:medical_condition,id', 'numeric'),
                'observations'=>array('required','min:10', 'max: 1000' ),
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
            $petdetail->fill($request->all());
            
            //Adds new data into database
            $petdetail->save();

            //Return list of data from data base in json format
            return response()->json($petdetail);

        } catch (\Throwable $th) {

            //Return throw error in json format
            return response()->json($th->getMessage(), 423);
        }
    }
    public function getActivePetDetails()
    {
        $details = PetDetail::where("state", 1)->get();

        if(count($details)==0) {
            return response()->json(['No se encontró condiciones medicas activas'], 404);
        }

        $json = json_decode($details, true);

        return $json;
    }
    public function showMediConditionsForPets($pet_id)
    {
        //Searches for data using an id
        $petdetail = PetDetail::with('codition', 'pet')->where("pet_id", $pet_id)->get();

        //Check if data was found
        if(count($petdetail)==0) {
            //Return no data found message
            return response()->json(['No se encontró condiciones medicas para esa mascota.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($petdetail, true);

        //Return json 
        return $json;
    }
    public function showActiveMediConditionsForPets($pet_id)
    {
        //Searches for data using an id
        $petdetail = PetDetail::with('codition', 'pet')->where("pet_id", $pet_id)->where("state", 1)->get();

        //Check if data was found
        if(count($petdetail)==0) {
            //Return no data found message
            return response()->json(['No se encontró la condicion medica.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($petdetail, true);

        //Return json 
        return $json;
    }
    public function showMediConditionsForConditions($condition_id)
    {
        //Searches for data using an id
        $petdetail = PetDetail::with('codition', 'pet')->where("codition_id", $condition_id)->get();

        //Check if data was found
        if(count($petdetail)==0) {
            //Return no data found message
            return response()->json(['No se encontró condiciones medicas para ese tipo de condicion.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($petdetail, true);

        //Return json 
        return $json;
    }
    public function showMediConditionsForConditionsactive($condition_id)
    {
        //Searches for data using an id
        $petdetail = PetDetail::with('codition', 'pet')->where("codition_id", $condition_id)->where("state", 1)->get();

        //Check if data was found
        if(count($petdetail)==0) {
            //Return no data found message
            return response()->json(['No se encontró condiciones medicas para ese tipo de condicion.'], 404);
        }

        //Encodes in json format all the data found
        $json = json_decode($petdetail, true);

        //Return json 
        return $json;
    }
}
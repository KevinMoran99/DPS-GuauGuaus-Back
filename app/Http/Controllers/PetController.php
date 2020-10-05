<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:3', 'max:25'),
                'birthday' => array('required', 'before:tomorrow', 'date_format:Y-m-d'),
                'photo' => array('required', 'min:3', 'max:500'),
                'weight' => array('required','regex:/^\d+(\.\d{1,2})?$/','min:0'),
                'height'=> array('required','regex:/^\d+(\.\d{1,2})?$/','min:0'),
                'state'=>array('required', 'boolean'),
                'species_id'=>array('required', 'exists:species,id', 'numeric'),
                'owner_id'=>array('required', 'exists:users,id', 'numeric' )
            )
        );
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $pet = new Pet;

        $pet->fill($request->all());

        $pet->save();

        return response()->json($pet);
    }
    public function update(Request $request)
    {
        $pet = Pet::find($request['id']);

        if(!$pet) {
            return response()->json(['No se encontró la mascota.'], 404);
        }
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:3', 'max:25'),
                'birthday' => array('required', 'before:tomorrow', 'date_format:Y-m-d'),
                'photo' => array('required', 'min:3', 'max:500'),
                'weight' => array('required','regex:/^\d+(\.\d{1,2})?$/','min:0'),
                'height'=> array('required','regex:/^\d+(\.\d{1,2})?$/','min:0'),
                'state'=>array('required', 'boolean'),
                'species_id'=>array('required', 'exists:species,id', 'numeric'),
                'owner_id'=>array('required', 'exists:users,id', 'numeric' )
            )
        );
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $pet->fill($request->all());

        try {

            $pet->save();
            return response()->json($pet);

        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 423);
        }
    }
    public function index()
    {
        $pets = Pet::with('owner', 'species')->get();
        $json = json_decode($pets, true);

        return $json;
    }
    public function show($id)
    {
        $pet = Pet::with('owner', 'species')->find($id);

        if(!$pet) {
            return response()->json(['No se encontró la mascota.'], 404);
        }

        $json = json_decode($pet, true);

        return $json;
    }
}
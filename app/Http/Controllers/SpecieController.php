<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Specie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SpecieController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required','unique:species', 'min:3', 'max:100'),
                'state'=>array('required', 'boolean'),
            )
        );
        
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $specie = new Specie;

        $specie->fill($request->all());

        $specie->save();

        return response()->json($specie);
    }

    public function update(Request $request)
    {
        $specie = Specie::find($request['id']);

        if(!$specie) {
            return response()->json(['No se encontró la especie.'], 404);
        }

        //Validations
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:3', 'max:100'),
                'state'=>array('required', 'boolean'),
            )
        );
        
        //If a validation fails, it returns a json containing the error list with a 422 status code
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $specie->fill($request->all());

        try {

            $specie->save();
            return response()->json($specie);

        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 423);
        }



    }


    public function show($id)
    {
        $specie = Specie::find($id)->where('state',1);

        if(!$specie) {
            return response()->json(['No se encontró la especie.'], 404);
        }

        $json = json_decode($specie, true);

        return $json;
    }


    public function index()
    {
        $species = Specie::all();
        $json = json_decode($species, true);

        return $json;
    }
}
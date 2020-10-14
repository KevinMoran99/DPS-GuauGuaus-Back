<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Pet;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SpecieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    protected $UserController, $SpecieController;
    public function __construct(UserController $UserController, SpecieController $SpecieController)
    {
        $this->UserController = $UserController;
        $this->SpecieController=$SpecieController;
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:3', 'max:25'),
                'birthday' => array('required', 'before:tomorrow', 'date_format:Y-m-d'),
                'photo' => array('required', 'min:3'),
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
        try
        {
            $sava = $this->UserController->show($request->owner_id);
            $sava2 = $this->SpecieController->show($request->species_id);
            $nuevo = explode("@", $sava['email'] );
            $nombrearchivo=$request->name.'_'.$sava2['name'].'_'.$nuevo[0];
            $imagensalida="img/".str_replace(" ", "_",$nombrearchivo).".jpg";
            $imagen = base64_decode($request->photo);
            $botes = file_put_contents($imagensalida, $imagen);
            $request->merge([
                'photo'=>'/'.$imagensalida
            ]);
        }
        catch (\Throwable $th) {
            return response()->json($th->getMessage(), 424);
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
        $imagenante = $pet['photo'];
        $validator = Validator::make($request->all(),
            $rules = array(
                'name' => array('required', 'min:3', 'max:25'),
                'birthday' => array('required', 'before:tomorrow', 'date_format:Y-m-d'),
                'photo' => array('required', 'min:3'),
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
        try
        {
            $sava = $this->UserController->show($request->owner_id);
            $sava2 = $this->SpecieController->show($request->species_id);
            $nombrearchivo=$request->name.'_'.$sava2['name'].'_'.$sava['dui'];
            $imagensalida="img/".str_replace(" ", "_",$nombrearchivo).".jpg";
            $imagen = base64_decode($request->photo);
            $botes = file_put_contents($imagensalida, $imagen);
            $request->merge([
                'photo'=>'/'.$imagensalida
            ]);
        }
        catch (\Throwable $th) {
            return response()->json($th->getMessage(), 424);
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
    public function getPetbySpecie($specie_id)
    {
        $pet = Pet::with('owner', 'species')->where("species_id", $specie_id)->get();

        if(count($pet) ==0) {
            return response()->json(['No se encontró la mascota esa especie.'], 404);
        }

        $json = json_decode($pet, true);

        return $json;
    }

    public function getPetbyOwner($owner_id)
    {
        $pet = Pet::with('owner', 'species')->where("owner_id", $owner_id)->get();

        if(count($pet) ==0) {
            return response()->json(['No se encontró la mascota con ese dueño'], 404);
        }

        $json = json_decode($pet, true);

        return $json;
    }

    public function getActivePets()
    {
        $pet = Pet::with('owner', 'species')->where("state", 1)->get();

        if(count($pet) ==0) {
            return response()->json(['No se encontró mascotas activas'], 404);
        }

        $json = json_decode($pet, true);

        return $json;
    }
}
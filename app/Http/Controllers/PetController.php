<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function store(){
        
    }
    public function index()
    {
        $pets = Pet::all();
        $json = json_decode($pets, true);

        return $json;
    }
}
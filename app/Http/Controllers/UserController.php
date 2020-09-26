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
}
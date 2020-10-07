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

    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
        ]);

        if (! $token = Auth::attempt(['email' => $request->email, 'password' => $request->password, 'state' => 1])) {
            return response()->json(['Credenciales incorrectas.'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $user = Auth::user();

        $user->token = $token;
        $user->token_type = 'bearer';
        $user->expires_in = Auth::factory()->getTTL() * 60;

        return response()->json($user, 200);
    }
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }
    public function logout() {
        try{


            Auth::guard()->logout();
            return response()->json('Sesión finalizada. El token ha sido invalidado.');
        } catch (TokenExpiredException $e) {
            return response()->json(['Token expirado'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['Token invalido'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['Token ausente'], $e->getStatusCode());
        }
    }
}
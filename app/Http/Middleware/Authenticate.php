<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Models\User;
use App\Models\Permission;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null)
    {
        //Check if user is authenticated and logged in using token
        if ($this->auth->guard($guard)->guest()) {
            //Returns no logged in message
            return response(['No está autenticado.'], 401);
        }

        //Get user data from Auth library
        $user = AuthFacade::user();

        //Get route path from request
        $path = $request->getPathInfo();
        //Get method from request (GET, POST, PUT)
        $method = $request->getMethod();
        //Empty variable for permission to be checked
        $permission = "";

        //Extract main name from complete path using function
        $path = $this->filterPath($this->extractPathName($path));

        //Check what permission is required based on the method from the request
        if($method == "PUT"){
            //Set permission parameter
            $permission = "update";
        }

        if($method == "GET"){
            //Set permission parameter
            $permission = "read";
        }

        if($method == "POST"){
            //Set permission parameter
            $permission = "create";
        }
        if ($path=="logout" || $path=="profile" || $path=="updateProfile") {
            return $next($request);
        }
        //Searches if the user_type of the user has the permission based on the table name (pets, users, etc...) and permission name (read, update, delete, create)
        $permission = Permission::with("users_types")->where("users_types_id", $user->type_user_id)
                                                     ->where("state", 1)
                                                     ->where("registro",$path)
                                                     ->where("".$permission,1)->get();

        //Check if data was found
        if(count($permission) ==0) {
            //Return false if no data was found, this means the user HAS NO permission
            return response()->json(['El usuario '.$user->name.' NO tiene permiso de realizar esta operacion.'], 403);
        }

        return $next($request);
    }

    private function extractPathName($path){
        //Remove the first character from string
        $path = substr($path, 1); 
        //Get the string until it reaches the first '/' character
        $explode_path = explode("/", $path, 2);
        //Get the first string from array returned from explode function
        $path = $explode_path[0];

        return $path;
    }

    private function filterPath($path){

        //Check for specific paths and change them to the database's table name
        if($path == "usertypes"){
            $path = "users_types";
        }

        if($path == "medicalconditions"){
            $path = "medical_condition";
        }

        if($path == "appointmenttypes"){
            $path = "appointment_types";
        }

        if($path == "petdetails"){
            $path = "pet_details";
        }

        if($path == "specials"){
            $path = "special";
        }
        
        if($path == "appointments"){
            $path = "appointment";
        }

        return $path;
    }
}


<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'dui', 'address', 'phone', 'state', 'socials', 'type_user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
    public function type_user(){
        return $this->belongsTo('App\Models\UserType');
    }
    public function pet(){
        return $this->hasMany('App\Models\Pet');
    }
    public function schedule(){
        return $this->hasMany('App\Models\Schedule');
    }
    public function special(){
        return $this->hasMany('App\Models\Schedule');
    }
    public function permission(){
        return $this->hasMany('App\Models\Permission', 'users_types_id', 'type_user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}

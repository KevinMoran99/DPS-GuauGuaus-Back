<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'users_types';

    protected $fillable = [
        'name', 'state'
    ];

    /*Relation between user_types and user (one to many)*/
    public function user(){
        return $this->hasMany('App\Models\User');
    }

    /*Relation between user_types and permission (one to many)*/
    public function permission(){
        return $this->hasMany('App\Models\Permission');
    }
}

?>
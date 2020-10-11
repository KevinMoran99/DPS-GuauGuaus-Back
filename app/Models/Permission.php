<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'registro', 'create', 'read', 'update', 'delete', 'users_types_id'
    ];

    /*Relation between permission and users_type*/
    public function user_type(){
        return $this->belongsTo('App\Models\UserType');    
    }

}

?>
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $table = 'special';

    protected $fillable = [
        'doctor_id', 'day', 'start_hour', 'finish_hour', 'state'
    ];

    /*Relation between permission and users_type*/
    public function doctor(){
        return $this->belongsTo('App\Models\User');    
    }

}

?>
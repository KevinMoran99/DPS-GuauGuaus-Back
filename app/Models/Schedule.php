<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
        'doctor_id', 'day', 'start_hour', 'finish_hour', 'state'
    ];

    /*Relation between permission and users_type*/
    public function doctor(){
        return $this->belongsTo('App\Models\User');    
    }

}

?>
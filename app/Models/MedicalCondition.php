<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalCondition extends Model
{
    protected $table = 'medical_condition';

    protected $fillable = [
        'name', 'state'
    ];


    /*Relation between medical_condition and pet_details (one to many)*/
    public function pet_detail(){
        return $this->belongsTo('App\Models\PetDetail');
    }
}

?>
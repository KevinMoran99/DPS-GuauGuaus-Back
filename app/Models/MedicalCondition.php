<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalCondition extends Model
{
    protected $table = 'medical_condition';

    protected $fillable = [
        'name', 'state'
    ];

    public function petdetail(){
        return $this->hasMany('App\Models\PetDetail');
    }
}

?>
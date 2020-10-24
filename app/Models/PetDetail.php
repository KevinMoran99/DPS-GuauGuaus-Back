<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetDetail extends Model
{
    protected $table = 'pet_details';

    protected $fillable = [
        'pet_id', 'codition_id', 'observations', 'state'
    ];

    public function pet(){
        return $this->belongsTo('App\Models\Pet');
    }

    public function codition(){
        return $this->belongsTo('App\Models\MedicalCondition');
    }
}

?>
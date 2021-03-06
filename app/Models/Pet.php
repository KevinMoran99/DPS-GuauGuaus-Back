<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pets';

    protected $fillable = [
        'name', 'birthday', 'photo', 'weight', 'height', 'state', 'species_id', 'owner_id'
    ];
    public function species(){
        return $this->belongsTo('App\Models\Specie');
    }
    public function owner(){
        return $this->belongsTo('App\Models\User');
    }
    public function petdetails(){
        return $this->hasMany('App\Models\PetDetail');
    }
}
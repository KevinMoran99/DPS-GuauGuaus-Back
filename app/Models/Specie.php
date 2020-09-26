<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specie extends Model
{
    protected $table = 'species';

    protected $fillable = [
        'name', 'state'
    ];

    public function pet(){
        return $this->hasOne('App\Models\Pet');
    }
}
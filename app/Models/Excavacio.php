<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Excavacio extends Model {

    //use SoftDeletes;

    protected $table = 'excavacions';
    protected $fillable = ['codi', 'nom', 'poblacio'];

    public function ues() {
        return $this->hasMany('App\Models\UE');
    }

    public function numberOfUes() {
        return $this->ues()->count();
    }

}

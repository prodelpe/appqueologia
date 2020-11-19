<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relacio extends Model {

    protected $table = 'relacions';
    protected $fillable = [
        'excavacio_id',
        'ue_origen_id',
        'tipus_relacio_id',
        'ue_desti_id',
        'inversa'
    ];
    protected $casts = [
        'excavacio_id' => 'array',
        'ue_origen_id' => 'array',
        'tipus_relacio_id' => 'array',
        'ue_desti_id' => 'array'
    ];

    public function ue_origen() {
        return $this->belongsTo('App\Models\UE', 'ue_origen_id');
    }

    public function ue_desti() {
        return $this->belongsTo('App\Models\UE', 'ue_desti_id');
    }

    /*
     * Troba totes les UEs relacionades que te una relació d'una UE
     */

    public function getUesByRelacio($excavacio_id, $tipus_relacio_id, $ue_origen_id) {
        return Relacio::all()
                        ->where('excavacio_id', $excavacio_id)
                        ->where('tipus_relacio_id', $tipus_relacio_id)
                        ->where('ue_origen_id', $ue_origen_id);
    }

}

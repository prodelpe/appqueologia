<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UE extends Model {

    //use SoftDeletes;
    
    protected $fillable = [
        'codi', 
        'excavacio_id', 
        'sector',
        'definicio', 
        'descripcio', 
        'interpretacio', 
        'cronologia', 
        'criteris_datacio', 
        'observacions'
        ];
    
    protected $casts = [
        'tipus_relacio_id' => 'array',
        'ue_id' => 'array'
    ];
    
    protected $table = 'ues';

    public function sector() {
        return $this->belongsTo('App\Models\Sector');
    }
    
    public function relacions(){
        return $this->hasMany('App\Models\Relacio');
    }

}

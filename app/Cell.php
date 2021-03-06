<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cell extends Model
{
    //
    protected $fillable = [
        'name',
        'sector_id'
    ];
    public function sector(){
        return $this->belongsTo('App\Sector');
    }
    public function house()
    {
        return $this->belongsTo('App\House');
    }
}

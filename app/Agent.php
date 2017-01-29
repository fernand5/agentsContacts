<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idAgent';
    protected $table= 'agents';
    protected $fillable = [
        'idAgent'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Contact','idContact');
    }
}

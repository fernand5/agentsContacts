<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    public $timestamps = false;
    protected $table= 'zipcodes';
    protected $fillable = [
        'idContact', 'name', 'code','agentId'
    ];

}

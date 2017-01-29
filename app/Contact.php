<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'idContacts';
    protected $table= 'contacts';
    protected $fillable = [
        'idContacts', 'name', 'code', 'lat', 'lng'
    ];

    public function agent()
    {
        return $this->belongsTo('App\Agent','idAgent');
    }
}

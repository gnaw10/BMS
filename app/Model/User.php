<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    public $timestamps = false;
    protected $hidden = array ('password','apikey');
    
    public function books()
    {
        return $this->hasMany('App\Model\Book');
    }
     public function logs()
    {
        return $this->hasMany('App\Model\Log');
    }
}
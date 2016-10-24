<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
    public function logs()
    {
        return $this->hasMany('App\Model\Log');
    }
}
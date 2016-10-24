<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
    public function book()
    {
        return $this->belongsTo('App\Model\Book');
    }
}
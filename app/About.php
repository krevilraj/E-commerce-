<?php

namespace App;

use App\Concern\Mediable;
use Illuminate\Database\Eloquent\Model;

class About extends Model{
 use  Mediable;

    protected $fillable = [
        'title',
        'content',
        'author'
    ];  //
}

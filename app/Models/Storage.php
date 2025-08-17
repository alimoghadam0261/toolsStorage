<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'name', 'location', 'manager', 'content'
    ];


}

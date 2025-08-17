<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ToolsInformation extends Model
{
    use SoftDeletes;
    protected $table = 'toolsinformations';

    protected $fillable = [
        'name', 'serialNumber'
    ];

    public function details()
    {
        return $this->hasOne(ToolsDetail::class, 'tools_information_id');
    }


    public function locations()
    {
        return $this->hasMany(ToolsLocation::class);
    }

}

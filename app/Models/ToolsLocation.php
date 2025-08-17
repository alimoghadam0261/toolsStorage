<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolsLocation extends Model
{
    protected $fillable = [
        'tools_information_id',
        'location',
        'moved_at',
        'moved_at',
        'Receiver'
    ];

    public function tool()
    {
        return $this->belongsTo(ToolsInformation::class, 'tools_information_id');
    }
}

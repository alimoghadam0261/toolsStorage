<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id',
        'description', 'ip_address', 'user_agent'
    ];

    /**
     * رابطه با کاربر
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function toolsInformation()
    {
        return $this->belongsTo(\App\Models\ToolsInformation::class, 'model_id');
    }


    public function storage()
    {
        return $this->belongsTo(\App\Models\Storage::class, 'model_id');
    }
}

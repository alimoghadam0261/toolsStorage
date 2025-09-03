<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer_items extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'transfer_id',
        'toolsinformation_id',
        'toolsdetailes_id',
        'qty',
        'damaged_qty',
        'lost_qty',
        'note',
        'image', // اضافه شد
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function toolInformation()
    {
        return $this->belongsTo(ToolsInformation::class, 'toolsinformation_id');
    }

    public function toolDetail()
    {
        return $this->belongsTo(ToolsDetail::class, 'toolsdetailes_id');
    }
}

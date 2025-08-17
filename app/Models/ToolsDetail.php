<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ToolsDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tools_information_id','category','brand','model','Weight','TypeOfConsumption',
        'size','price','StorageLocation','color','dateOfSale','dateOfexp','content','Receiver'
    ];
    protected $table = 'toolsdetailes';
    public function information()
    {
        return $this->belongsTo(ToolsInformation::class, 'tools_information_id');
    }
}

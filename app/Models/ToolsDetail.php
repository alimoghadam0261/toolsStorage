<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ToolsDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tools_information_id','category','count','model','Weight','TypeOfConsumption','attach','status',
        'size','price','StorageLocation','color','dateOfSale','dateOfexp','content','Receiver',  'storage_id',
    ];
    protected $table = 'toolsdetailes';
    public function information()
    {
        return $this->belongsTo(ToolsInformation::class, 'tools_information_id');
    }
    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }
}

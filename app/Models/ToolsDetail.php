<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsDetail extends Model
{
    use SoftDeletes;

    protected $table = 'toolsdetailes';

    protected $casts = [
        'dateOfSale' => 'date',
        'dateOfexp'  => 'date',
    ];

    protected $fillable = [
        // فیلدهای قدیمی
        'tools_information_id','category','count','model','Weight','TypeOfConsumption',
        'attach','status','size','price','StorageLocation','color','dateOfSale',
        'dateOfexp','content','Receiver','storage_id','companynumber',

        // فیلدهای جدید مدیریت موجودی
        'qty_total','qty_in_use','qty_damaged','qty_lost',
    ];

    // ارتباط با جدول اطلاعات کلی ابزار
    public function information()
    {
        return $this->belongsTo(ToolsInformation::class, 'tools_information_id');
    }

    // ارتباط با جدول انبار
    public function storage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }

    // 👉 متد کمکی برای گرفتن موجودی قابل استفاده
    public function getAvailableAttribute()
    {
        return $this->qty_total - ($this->qty_in_use + $this->qty_damaged + $this->qty_lost);
    }



    public function getPriceAttribute($value)
    {
        return (int) $value; // یا number_format($value, 0)
    }

}

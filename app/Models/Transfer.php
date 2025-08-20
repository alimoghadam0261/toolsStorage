<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{

//    protected $table = 'Transfers';

    use SoftDeletes;

    protected $fillable = [
        'user_id', 'from_storage_id', 'to_storage_id',
        'status', 'number', 'reason', 'sent_at', 'received_at', 'note'
    ];

    // کاربر ایجادکننده
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // انبار مبدا
    public function fromStorage()
    {
        return $this->belongsTo(Storage::class, 'from_storage_id');
    }

    // انبار مقصد
    public function toStorage()
    {
        return $this->belongsTo(Storage::class, 'to_storage_id');
    }

    // آیتم‌های انتقال
    public function items()
    {
        return $this->hasMany(Transfer_items::class);
    }
}

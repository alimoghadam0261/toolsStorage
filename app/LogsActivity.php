<?php

namespace App;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * ثبت فعالیت کاربر در جدول user_activities
     *
     * @param string $action
     * @param mixed|null $model
     * @param string|null $description
     */
    public function logActivity(string $action, $model = null, string $description = null)
    {
        $modelId = null;

        if ($model) {
            if ($model instanceof \App\Models\User) {
                $modelId = $model->cardNumber; // استفاده از شماره پرسنلی
            } else {
                $modelId = $model->id ?? null; // سایر مدل‌ها
            }
        }

        UserActivity::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'model_type' => $model
                ? ($model instanceof \App\Models\User ? $model->role : class_basename($model))
                : null,
            'model_id'   => $modelId,
            'description'=> $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

<?php

namespace App\Observers;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    public function created(Model $model)
    {
        $this->logActivity('create', $model);
    }

    public function updated(Model $model)
    {
        $this->logActivity('update', $model);
    }

    public function deleted(Model $model)
    {
        $this->logActivity('delete', $model);
    }

    public function restored(Model $model)
    {
        $this->logActivity('restore', $model);
    }

    private function logActivity($action, Model $model)
    {
        // جلوگیری از لاگ خود جدول لاگ
        if ($model instanceof UserActivity) {
            return;
        }

        UserActivity::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'description'=> class_basename($model) . " ID {$model->id} {$action}d",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

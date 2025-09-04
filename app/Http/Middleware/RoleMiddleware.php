<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'شما به این بخش دسترسی ندارید ❌');
        }

        // اگر نقش author بود و وارد مسیرهای ممنوعه شد
        if ($user->role === 'author') {
            $blockedRoutes = [
                'admin.result-info',
                'admin.result.tools',
                'admin.personal',
                'admin.users.destroy',
                'admin.users.restore',
                'admin.users.forceDelete',
                'admin.info.UserActivityDashboard',
                'admin.info.Toolscharts',
            ];

            if (in_array($request->route()->getName(), $blockedRoutes)) {
                abort(403, 'شما به این بخش دسترسی ندارید ❌');
            }
        }

        return $next($request);
    }
}

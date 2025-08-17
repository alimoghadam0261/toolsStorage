<div>
    <div>
        <h4>گزارش فعالیت‌های کاربر: {{ $user->name }}</h4>

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>تاریخ</th>
                <th>عملیات</th>
                <th>توضیحات</th>
                <th>IP</th>
                <th>User Agent</th>
            </tr>
            </thead>
            <tbody>
            @forelse($activities as $activity)
                <tr>
                    <td>{{ jdate($activity->created_at)->format('Y/m/d H:i') }}</td>
                    <td>{{ $activity->action }}</td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->ip_address }}</td>
                    <td>{{ $activity->user_agent }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">هیچ فعالیتی ثبت نشده است</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $activities->links() }}
    </div>

</div>




<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div class="mb-4">
                    <input type="text"
                           wire:model.live.500ms="search"
                           class="form-control"
                           placeholder="🔍 جستجو بر اساس نام یا شماره پرسنلی ...">
                </div>

                <br>

                <div class="container py-3">
                    {{-- لاگ کاربران --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="mb-0">📌 لاگ فعالیت کاربران</h4>
                        <span class="text-muted small">آخرین رویدادها کاربران</span>
                    </div>

                    <div class="table-responsive border rounded mb-5">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>کاربر</th>
                                <th>عملیات</th>
                                <th>مدل</th>
                                <th>شماره پرسنلی</th>
                                <th style="min-width:220px;">توضیحات</th>
                                <th>IP</th>
                                <th>تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($activities as $a)
                                <tr>
                                    <td>{{ $a->user->name ?? 'سیستم' }}</td>
                                    <td>{{ $a->action }}</td>
                                    <td>{{ $a->model_type ?? '-' }}</td>
                                    <td class="text-muted">{{ $a->user->cardNumber ?? '-' }}</td>
                                    <td>{{ $a->description ?? '-' }}</td>
                                    <td class="text-muted">{{ $a->ip_address ?? '-' }}</td>
                                    <td>{{ $a->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">هنوز لاگی ثبت نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- لاگ ابزارها --}}
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="mb-0">🛠️ لاگ فعالیت ابزارها</h4>
                        <span class="text-muted small">ایجاد، ویرایش و حذف ابزارها</span>
                    </div>

                    <div class="table-responsive border rounded">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>کاربر</th>
                                <th>عملیات</th>
                                <th>شماره پرسنلی</th>
                                <th style="min-width:220px;">توضیحات</th>
                                <th>تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($toolActivities as $t)
                                <tr>
                                    <td>{{ $t->user->name ?? 'سیستم' }}</td>
                                    <td>{{ $t->action }}</td>
                                    <td class="text-muted">{{ $t->user->cardNumber ?? '-' }}</td>
                                    <td>{{ $t->description ?? '-' }}</td>
                                    <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">هنوز لاگی ثبت نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- لاگ انبارها --}}
                    <div class="d-flex align-items-center justify-content-between mb-3 mt-5">
                        <h4 class="mb-0">🏢 لاگ فعالیت انبارها</h4>
                        <span class="text-muted small">ایجاد و ویرایش انبارها</span>
                    </div>

                    <div class="table-responsive border rounded">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>کاربر</th>
                                <th>عملیات</th>
                                <th>نام انبار</th>
                                <th>شماره پرسنلی</th>
                                <th style="min-width:220px;">توضیحات</th>
                                <th>تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($storageActivities as $s)
                                <tr @if($s->action === 'create') style="background-color: rgba(0, 255, 0, 0.2);"
                                    @elseif($s->action === 'edit') style="background-color: rgba(255,255,0,0.2);" @endif>
                                    <td>{{ $s->user->name ?? 'سیستم' }}</td>
                                    <td>{{ $s->action }}</td>
                                    <td>{{ $s->storage->name ?? '-' }}</td>
                                    <td class="text-muted">{{ $s->user->cardNumber ?? '-' }}</td>
                                    <td>{{ $s->description ?? '-' }}</td>
                                    <td>{{ $s->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">هنوز لاگی ثبت نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>


                    <div class="mt-3">
                        {{-- صفحه بندی کاربران --}}
                        {{ $activities->links() }}
                        {{-- صفحه بندی ابزارها --}}
                        {{ $toolActivities->links() }}
                    </div>
                </div>



            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

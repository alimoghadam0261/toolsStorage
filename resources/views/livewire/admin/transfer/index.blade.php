<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div class="widgets-admin">
                    <div class="box-widget-admin" style="background: #ddf0f8">
                        <a href="{{route('admin.transfer.form')}}">
                            <br>

                            <h5 style="transform: translateY(-.5em)">
                                ارسال ابزار جدید
                            </h5>

                        </a></div>

                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" dir="rtl">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                    </div>
                @endif
                <br>
                <div class="table-transfer-page">
                    <table class="table table-bordered table-hover text-center" dir="rtl">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>شماره ثبت</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>نام مسئول</th>
                            <th>وضعیت</th>
                            <th>توضیحات</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($transfers as $index=>$transfer)
                            <tr class="border-b">
                                <td class="px-2 py-1">{{ $index+1 }}</td>
                                <td class="px-2 py-1">{{ $transfer->number }}</td>
                                <td class="px-2 py-1">{{ $transfer->fromStorage->name ?? '-' }}</td>
                                <td class="px-2 py-1">{{ $transfer->toStorage->name ?? '-' }}</td>
                                <td class="px-2 py-1">{{ $transfer->user->name ?? '-' }}</td>
                                <td class="px-2 py-1">{{ $transfer->status }}</td>
                                <td class="px-2 py-1">
                                    <ul class="list-disc ml-4">
                                        @foreach($transfer->items as $item)
                                            <li>
                                                {{ $item->toolDetail->information->name ?? '---' }}
                                                ({{ $item->qty }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-2 py-1">{{ $transfer->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">هیچ انتقالی ثبت نشده است.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

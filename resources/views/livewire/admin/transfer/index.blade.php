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
                    <table class="table table-bordered table-hover text-center table-striped" dir="rtl">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>شماره ثبت</th>
                            <th>مبدا</th>
                            <th>مقصد</th>
                            <th>نام مسئول</th>
                            <th>وضعیت</th>
{{--                            <th>توضیحات</th>--}}
                            <th>تاریخ</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transfers as $index=>$transfer)

                            <tr class="border-b" style="cursor:pointer;" wire:click="test({{$transfer->id}})">

                                <td class="px-2 py-1">{{ $index+1 }}</td>
                                <td class="px-2 py-1">{{ $transfer->number }}</td>
                                <td class="px-2 py-1">{{ $transfer->fromStorage->name ?? '-' }}</td>
                                <td class="px-2 py-1">{{ $transfer->toStorage->name ?? '-' }}</td>
                                <td class="px-2 py-1">{{ $transfer->user->name ?? '-' }}</td>
                                <td class="px-2 py-1"
                                    style="{{$transfer->status == "sent" ? 'background:#f4f474;':'background: #5ac85a'}}">
                                    {{ $transfer->status == "sent" ? "ارسال" : "برگشت" }}
                                </td>
                                <td class="px-2 py-1">{{ jDate($transfer->created_at)->format('Y/m/d')}}</td>
                                <td class="px-2 py-1">

                                    @if($transfer->status == 'returned')
                                        <a href="{{ route('transfer.return', $transfer->id) }}" wire:click.stop
                                           onclick="return confirm('⚠️ این انتقال قبلاً ویرایش شده است. آیا مطمئن هستید می‌خواهید دوباره ویرایش کنید؟')">
                                            <button class="btn btn-sm btn-outline-secondary">ویرایش مجدد</button>
                                        </a>
                                    @else
                                        <a href="{{ route('transfer.return', $transfer->id) }}" wire:click.stop>
                                            <button class="btn btn-sm btn-outline-warning">ویرایش</button>
                                        </a>
                                    @endif

                                    <button wire:click.stop="delete({{ $transfer->id }})"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('آیا مطمئن هستید می‌خواهید این انتقال را حذف کنید؟')">
                                        حذف
                                    </button>
                                </td>
                            </tr>


                        @endforeach
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

<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <!-- بخش اصلی محتوا -->
            <div class="col-lg-10 col-md-12" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>

                <!-- کارت جزئیات انتقال -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        جزئیات انتقال #{{ $transfer->number }}
                    </div>
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-md-6 mb-2">
                                <strong>مبدا:</strong> {{ $transfer->fromStorage->name ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>مقصد:</strong> {{ $transfer->toStorage->name ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>مسئول:</strong> {{ $transfer->user->name ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>وضعیت:</strong> {{ $transfer->status == "sent" ? "ارسال" : "برگشت" }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>توضیحات:</strong> {{ $transfer->note ?? '-' }}
                            </div>
                            <div class="col-md-12 mb-2">
                                <strong>تاریخ:</strong> {{ jDate($transfer->created_at)->format('Y/m/d') }}
                            </div>
                        </div>

                        <hr>

                        <!-- جدول اقلام انتقال -->
                        <h5 class="mb-3">اقلام انتقال</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>نام ابزار</th>
                                    <th>تعداد</th>
                                    <th>توضیحات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transfer->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->toolDetail->information->name ?? '---' }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->note ?? '-' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- دکمه بازگشت -->
                        <a href="{{ route('admin.transfer.index') }}" class="btn btn-secondary mt-3">
                            بازگشت
                        </a>

                    </div>
                </div>
            </div>

            <!-- سایدبار -->
            <div class="col-lg-2 col-md-12">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

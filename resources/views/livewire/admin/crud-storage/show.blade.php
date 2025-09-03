<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>


                <div>
                    <div class="row">
                        <div class="box-show-detail" style="width: auto !important;">
                            <h4>نام سایت</h4>
                            <p>
                                {{$storages->name}}
                            </p>
                        </div>

                        <div class="box-show-detail" style="width: auto !important;">
                            <h4>مدیر پروژه:</h4>
                            <p>
                                {{$storages->manager}}
                            </p>
                        </div>

                        <div class="box-show-detail" style="width: auto !important;">
                            <h4>آدرس</h4>
                            <p>
                                {{$storages->location}}
                            </p>
                        </div>

                        <div class="box-show-detail" style="width: auto !important;">
                            <h4>توضیحات</h4>
                            <p>
                                {{$storages->content}}
                            </p>
                        </div>

                    </div>
                    <hr>
                    <h4>لیست ابزارهای این انبار</h4>
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>نام ابزار</th>
                            <th>تعداد</th>
                            <th>مدل</th>
                            <th>وضعیت موجودی</th>
                            <th>تاریخ ورود</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($locations as $index => $location)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- بررسی وجود ابزار --}}
                                <td>{{ $location->tool->name ?? '-' }}</td>

                                {{-- تعداد جزئیات ابزار --}}
                                <td>{{ $location->tool->details->count() ?? 0 }}</td>

                                {{-- مدل ابزار (اولین مدل از details اگر وجود داشته باشد) --}}
                                <td>
                                    {{ optional(optional($location->tool->details)->first())->model ?? '-' }}
                                </td>

                                {{-- وضعیت موجودی --}}
                                <td>{{ $location->status ?? '-' }}</td>

                                {{-- تاریخ ورود --}}
                                <td>
                                    {{ $location->moved_at ? jdate($location->moved_at)->format('Y-m-d H:i') : '-' }}
                                </td>

                                {{-- عملیات نمایش --}}
                                <td>
                                    @if($location->tools_information_id)
                                        <a href="{{ route('admin.tools.show', $location->tools_information_id) }}" class="btn btn-sm btn-primary">نمایش</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">ابزاری برای این انبار ثبت نشده</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                    <div class="d-flex justify-content-center mt-4 pagination pagination-sm">
                        {{ $locations->links() }}
                    </div>
                </div>



            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>






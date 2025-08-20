<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <div class="widgets-admin">
                    <div class="box-widget-admin" style="background: #ddf0f8">
                        <a href="{{route('admin.tools.create')}}">
                        <br>

                            <h5 style="transform: translateY(-.5em)">
                                ثبت ابزار جدید
                            </h5>

                    </a></div>

                </div>




                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                    </div>
                @endif
                <br>
                <div class="search-storage-admin" dir="rtl">
                    <input
                        type="text"
                        placeholder="جستجو : نام ابزار یا شماره ابزار را وارد نمایید"
                        class="form-control"
                        wire:model.live="searchTerm"
                    >
                </div>
                <br>
                <div class="show-storage-admin">

                    <div class="col-md-12">
                        <div class="box-storage-admin">
                            <div class="row test-storage-info">
                                <div class="col-md-6"><span>محموع ابزار آلات در انبار:{{$count}}  </span><span
                                        class="badge badge-info">
                                       <button class="btn btn-outline-info"> <a
                                               href="">    مشاهده همه</a></button></span></div>

                                <div class="col-md-6">


                                            <label for="">فیلتر بر اساس</label>

                                            <select wire:model.live="sortBy" class="form-select-sm" name="" id="">
                                                <option value="date">تاریخ</option>
                                                <option value="count">تعداد</option>
                                                <option value="price">قیمت</option>
                                            </select>


                                </div>


                            </div>
                            <br>
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th>سریال</th>
                                    <th>تعداد</th>
                                    <th>مدل</th>
                                    <th>تحویل گیرنده</th>
                                    <th>قیمت</th>
                                    <th>تاریخ</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tools as $index => $tool)

                                    <tr style="cursor:pointer;" wire:click="goToShow({{ $tool->id }})">
                                        <td>{{ $index+1 }}</td>
                                        <td>
                                            @if($tool->details && $tool->details->attach)
                                                <img src="{{ asset('storage/tools/' . $tool->details->attach) }}" width="50" alt="{{ $tool->name }}" />
                                            @else
                                                <img src="{{ asset('img/default.png') }}" width="50" alt="{{ $tool->name }}" />
                                            @endif
                                        </td>


                                        <td {{ trim($tool->name) == "انبار مرکزی" ? 'style="background:green"' : 'style="background:none"' }}>
                                            {{ $tool->name }}
                                        </td>

                                        <td>{{ $tool->serialNumber }}</td>
                                        <td>{{ $tool->details->count ?? '-' }}</td>
                                        <td>{{ $tool->details->model ?? '-' }}</td>
                                        <td>{{ $tool->details->	Receiver ?? '-' }}</td>
                                        <td>{{ $tool->details->price ?? '-' }}</td>
                                        <td>
                                            @if($tool->details && $tool->details->created_at)
                                                {{ jDate($tool->details->created_at)->format('Y/m/d') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{route('admin.tools.edit',$tool->id)}}">
                                                <button class="btn btn-sm btn-outline-warning">ویرایش</button>
                                            </a>

                                            <a href="{{ route('admin.result.tools', $tool->id) }}">
                                                <button class="btn btn-sm btn-info">گزارش</button>
                                            </a>

                                            <button wire:click="delete({{ $tool->id }})"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('آیا مطمئن هستید؟')">حذف
                                            </button>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

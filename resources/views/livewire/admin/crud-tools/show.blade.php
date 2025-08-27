<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <div class="container">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="img-single-tools">



                                @if($tool->details && $tool->details->attach)
                                    <img src="{{ asset('storage/tools/' . $tool->details->attach) }}" width="200" alt="{{ $tool->name }}" />
                                @else
                                    <img src="{{ asset('img/default.png') }}" width="200" alt="{{ $tool->name }}" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9 row">
                            <div class="box-show-detail">
                                <span><strong>نام:</strong></span><br><span>{{$tool->name}}</span>
                            </div>
                            <div class="box-show-detail">
                                <span><strong>دسته بندی:</strong></span><br><span>{{$tool->details->category=='IPR-' ? 'سرمایه ای':'مصرفی'}}</span>
                            </div>
                            <div class="box-show-detail">
                                <span><strong> شماره سریال:</strong></span><br><span
                                    dir="ltr">{{$tool->serialNumber}}</span>
                            </div >
                            <div class="box-show-detail">
                                <span><strong> شماره سریال شرکتی:</strong></span><br><span
                                    dir="ltr">{{$tool->companynumber != null ? $tool->companynumber : "ندارد"}}</span>
                            </div >
                            <div class="box-show-detail" style = "{{$tool->details->count < 10 ? 'animation:2s alarm linear infinite' : ''}}">
                                <span><strong>تعداد:</strong></span><br><span>{{$tool->details->count}}</span>
                            </div>
                            <div class="box-show-detail">
                                <span><strong>قیمت:</strong></span><br><span>{{($tool->details->price)}}</span>
                            </div>
                            <div class="box-show-detail">
                                <span><strong>رنگ:</strong></span><br><span>{{$tool->details->color}}</span>
                        </div>
                            <div class="box-show-detail">
                                <span><strong>تحویل گیرنده:</strong></span><br><span>{{$tool->details->Receiver}}</span>
                            </div>
                            <div class="box-show-detail">
                                <span><strong>اندازه:</strong></span><br><span>{{$tool->details->size}}</span>
                        </div>
                            <div class="box-show-detail">
                                <span><strong>وزن:</strong></span><br><span>{{$tool->details->Weight}}</span>
                            </div>
                            <div class="box-show-detail">
                                <span><strong>موارد مصزفی:</strong></span><br><span>{{$tool->details->TypeOfConsumption}}</span>
                        </div>
                            <div class="box-show-detail">
                                <span><strong>لوکیشن:</strong></span><br><span>{{$tool->details->StorageLocation}}</span>
                            </div>
                                <div class="box-show-detail">
                                <span><strong>وضعیت:</strong></span><br><span>{{$tool->details->status}}</span>
                                </div>
                            <div class="box-show-detail">
                                <span><strong>تاریخ تولید:</strong></span><br><span>{{ jDate($tool->details->dateOfSale)->format('Y/m/d') }}</span>
                        </div>
                            <div class="box-show-detail">
                                <span><strong>تاریخ انقضا :</strong></span><br><span>{{ jDate($tool->details->dateOfexp)->format('Y/m/d') }}</span>
                            </div>
                                <div class="box-show-detail">
                                <span><strong>تاریخ ثبت سیستم:</strong></span><br><span>{{ jDate($tool->details->created_at)->format('Y/m/d') }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                <hr>
                <h1>گزارشات</h1>
                <br>
                <table class="table table-striped    text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">محل </th>
                        <th scope="col">تحویل گیرنده</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col">تاریخ</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($locations as $index =>$item)
                        <tr>
                            <th scope="row">{{$index+1}}</th>
                            <td {{ $item->location == 'انبار مرکزی' ? 'style=background:#A6D6BCFF;' : 'style=background:none' }}>{{ $item->location }}</td>
                            <td>{{$item->Receiver}}</td>
                            <td>{{$item->status}}</td>
                            <td>{{jdate($item->moved_at)->format('y/m/d')}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>

                <div class="col-md-2">
                    @livewire('component.admin.sidebar')
                </div>
            </div>
        </div>
    </div>

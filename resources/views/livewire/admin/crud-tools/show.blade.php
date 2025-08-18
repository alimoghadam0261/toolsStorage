<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <div class="img-single-tools">
                                <img src="{{ asset('storage/tools/' . $tool->attach) }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span><strong>نام:</strong></span><span>{{$tool->name}}</span><br>
                            <span><strong>دسته بندی:</strong></span><span>{{$tool->details->category}}</span><br>
                            <span><strong> شماره سریال:</strong></span><span dir="ltr">{{$tool->serialNumber}}</span><br>
                            <span><strong>تعداد:</strong></span><span>{{$tool->details->count}}</span><br>
                            <span><strong>قیمت:</strong></span><span>{{$tool->details->price}}</span><br>
                            <span><strong>رنگ:</strong></span><span>{{$tool->details->color}}</span><br>
                            <span><strong>تحویل گیرنده:</strong></span><span>{{$tool->details->Receiver}}</span><br>
                            <span><strong>اندازه:</strong></span><span>{{$tool->details->size}}</span><br>
                            <span><strong>وزن:</strong></span><span>{{$tool->details->Weight}}</span><br>
                            <span><strong>موارد مصزفی:</strong></span><span>{{$tool->details->TypeOfConsumption}}</span><br>
                            <span><strong>لوکیشن:</strong></span><span>{{$tool->details->StorageLocation}}</span><br>
                            <span><strong>وضعیت:</strong></span><span>{{$tool->details->status}}</span><br>
                            <span><strong>تاریخ تولید:</strong></span><span>{{ jDate($tool->details->dateOfSale)->format('Y/m/d') }}</span><br>
                            <span><strong>تاریخ انقضا :</strong></span><span>{{ jDate($tool->details->dateOfexp)->format('Y/m/d') }}</span><br>
                            <span><strong>تاریخ ثبت سیستم:</strong></span><span>{{ jDate($tool->details->created_at)->format('Y/m/d') }}</span><br>

                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

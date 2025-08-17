<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>

                <div class="container py-4">

                    <form wire:submit.prevent="save" class="mb-4 border p-3 rounded">
                        <h5>{{ $isEdit ? 'ویرایش ابزار' : 'افزودن ابزار جدید' }}</h5>

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label>نام</label>
                                <input required type="text" class="form-control" wire:model="name">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>دسته بندی:</label>
                                <select required class="form-select" name="category" wire:model.live="category" id="">
                                    <option value="" selected>انتخاب کنید</option>
                                    <option value="tools" >مصرفی</option>
                                    <option value="jam" >سرمایه ای</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>شماره سریال</label>
                                <input readonly type="text" class="form-control" wire:model="serialNumber">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>تحویل گیرنده</label>
                                <input required type="text" class="form-control" wire:model="Receiver">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>برند</label>
                                <input required type="text" class="form-control" wire:model="brand">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>مدل</label>
                                <input required type="text" class="form-control" wire:model="model">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>وزن</label>
                                <input required type="number" class="form-control" wire:model="Weight">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>نوع مصرف</label>
                                <input required type="text" class="form-control" wire:model="TypeOfConsumption">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>اندازه</label>
                                <input required type="text" class="form-control" wire:model="size">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>قیمت</label>
                                <input required type="number" class="form-control" wire:model="price">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>محل نگهداری</label>
                                <select required class="form-select" wire:model="StorageLocation">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->name }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>رنگ</label>
                                <input required type="text" class="form-control" wire:model="color">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>تاریخ تولید</label>
                                <input required type="date" class="form-control" wire:model="dateOfSale">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>تاریخ انقضا</label>
                                <input required type="date" class="form-control" wire:model="dateOfexp">
                            </div>


                            <div class="col-6 mb-2">
                                <label>توضیحات</label>
                                <textarea required class="form-control" wire:model="content"></textarea>
                            </div>
                        </div>

                        <button class="btn btn-primary">{{ $isEdit ? 'بروزرسانی' : 'ثبت' }}</button>
                        <button type="button" class="btn btn-secondary" wire:click="resetForm">انصراف</button>
                    </form>

                    {{--                    <table class="table table-bordered table-hover">--}}
                    {{--                        <thead class="table-light">--}}
                    {{--                        <tr>--}}
                    {{--                            <th>#</th>--}}
                    {{--                            <th>نام</th>--}}
                    {{--                            <th>سریال</th>--}}
                    {{--                            <th>برند</th>--}}
                    {{--                            <th>مدل</th>--}}
                    {{--                            <th>قیمت</th>--}}
                    {{--                            <th class="text-center">عملیات</th>--}}
                    {{--                        </tr>--}}
                    {{--                        </thead>--}}
                    {{--                        <tbody>--}}
                    {{--                        @foreach($tools as $index => $tool)--}}
                    {{--                            <tr>--}}
                    {{--                                <td>{{ $index+1 }}</td>--}}
                    {{--                                <td>{{ $tool->name }}</td>--}}
                    {{--                                <td>{{ $tool->serialNumber }}</td>--}}
                    {{--                                <td>{{ $tool->details->brand ?? '-' }}</td>--}}
                    {{--                                <td>{{ $tool->details->model ?? '-' }}</td>--}}
                    {{--                                <td>{{ $tool->details->price ?? '-' }}</td>--}}
                    {{--                                <td class="text-center">--}}
                    {{--                                    <button wire:click="edit({{ $tool->id }})" class="btn btn-sm btn-warning">ویرایش</button>--}}
                    {{--                                    <button wire:click="delete({{ $tool->id }})" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>--}}
                    {{--                                </td>--}}
                    {{--                            </tr>--}}
                    {{--                        @endforeach--}}
                    {{--                        </tbody>--}}
                    {{--                    </table>--}}

                </div>




                {{--                <div class="widgets-admin">--}}
                {{--                    <div class="box-widget-admin" style="background: #ddf0f8">--}}
                {{--                        <br>--}}

                {{--                        <h6>ثبت انبار و سایت جدید</h6>--}}

                {{--                    </div>--}}

                {{--                </div>--}}
                {{--                <br>--}}
                {{--                <div class="search-storage-admin" dir="rtl">--}}
                {{--                    <input type="text" placeholder="جستجو : نام ابزار یا شماره ابزار را وارد نمایید "--}}
                {{--                           class="form-control">--}}
                {{--                </div>--}}
                {{--                <br>--}}
                {{--                <div class="show-storage-admin">--}}

                {{--                    <div class="col-md-12">--}}
                {{--                        <div class="box-storage-admin">--}}
                {{--                            <div class="row test-storage-info">--}}
                {{--                                <div class="col-md-6"><span>تعداد انبار و سایت</span><span class="badge badge-info"><a--}}
                {{--                                            href="">مشاهده همه</a></span></div>--}}
                {{--                                <div class="col-md-6">--}}
                {{--                                    <div class="row">--}}
                {{--                                        <div class="col-md-4" dir="ltr">--}}
                {{--                                            <label for="">فیلتر بر اساس </label>--}}
                {{--                                        </div>--}}
                {{--                                        <div class="col-md-8">--}}
                {{--                                            <select  class=" form-select-sm" name="" id="">--}}
                {{--                                                <option>تاریخ</option>--}}
                {{--                                                <option>تعداد</option>--}}
                {{--                                                <option>قیمت</option>--}}
                {{--                                            </select>--}}

                {{--                                        </div>--}}

                {{--                                    </div>--}}

                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <br>--}}
                {{--                            <table class="table table-striped " >--}}
                {{--                                <thead>--}}
                {{--                                <tr class="table-dark">--}}
                {{--                                    <th scope="col">#</th>--}}
                {{--                                    <th scope="col">نام</th>--}}
                {{--                                    <th scope="col">شماره</th>--}}
                {{--                                    <th scope="col">تاریخ خروج</th>--}}
                {{--                                    <th scope="col">محل خروج</th>--}}
                {{--                                    <th scope="col">تغییرات</th>--}}

                {{--                                </tr>--}}
                {{--                                </thead>--}}
                {{--                                <tbody>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">1</th>--}}
                {{--                                    <td>Mark</td>--}}
                {{--                                    <td>Otto</td>--}}
                {{--                                    <td>@mdo</td>--}}
                {{--                                    <td>@mdo</td>--}}
                {{--                                    <td>@mdo</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">2</th>--}}
                {{--                                    <td>Jacob</td>--}}
                {{--                                    <td>Thornton</td>--}}
                {{--                                    <td>@fat</td>--}}
                {{--                                    <td>@fat</td>--}}
                {{--                                    <td>@fat</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">3</th>--}}
                {{--                                    <td colspan="2">Larry the Bird</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">3</th>--}}
                {{--                                    <td colspan="2">Larry the Bird</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">3</th>--}}
                {{--                                    <td colspan="2">Larry the Bird</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">3</th>--}}
                {{--                                    <td colspan="2">Larry the Bird</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">3</th>--}}
                {{--                                    <td colspan="2">Larry the Bird</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                </tr>--}}
                {{--                                <tr>--}}
                {{--                                    <th scope="row">3</th>--}}
                {{--                                    <td colspan="2">Larry the Bird</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                    <td>@twitter</td>--}}
                {{--                                </tr>--}}

                {{--                                </tbody>--}}
                {{--                            </table>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                </div>--}}

            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div class="widgets-admin">
                    <div class="box-widget-admin" style="background: #ddf0f8">
                        <a href="{{route('admin.storages.create')}}">
                            <br>

                            <h5 style="transform: translateY(-.5em)">
                                ثبت انبار و سایت جدید
                            </h5>
                        </a>
                    </div>

                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" dir="rtl">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                    </div>
                @endif
                <br>
                <div class="search-storage-admin" dir="rtl">
                    <input type="text" placeholder="جستجو : نام ابزار یا شماره ابزار را وارد نمایید "
                           class="form-control">
                </div>
                <br>


                <div class="show-storage-admin">

                    <div class="col-md-12" dir="rtl">
                        <div class="box-storage-admin">
                            <div class="row test-storage-info">
                                <div class="col-md-6"><span>محموع تعداد انبار و سایت: {{$count}} </span><span
                                        class="badge badge-info"> </span>

                                </div>
                                <br>
                                <table class="table table-bordered table-hover text-center">
                                    <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>نام</th>
                                        <th>لوکیشن</th>
                                        <th>مدیر پروژه</th>
                                        <th>توضیحات</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($storages as $index =>$item)
                                        <tr>
                                            <td>{{$index +1}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->location}}</td>
                                            <td>{{$item->manager}}</td>
                                            <td>{{$item->content}}</td>
                                            <td>
                                                <i
                                                    wire:click="delete({{ $item->id }})"
                                                    onclick="return confirm('آیا از حذف این سایت مطمئن هستید؟')"
                                                    class="fa fa-trash"
                                                    style="cursor:pointer"
                                                ></i>
                                                <i class="fa fa-edit"></i>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

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


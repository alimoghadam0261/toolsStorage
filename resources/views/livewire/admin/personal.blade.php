<div>
    <div class="dashboard-admin">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    @livewire('component.admin.topmenu')
                    <hr>
                    <br>
                    <div class="row">

                        <div class="col-md-7" dir="rtl">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="بستن"></button>
                                </div>
                            @endif
                            <div class="personal-list">
                                <table class="table table-striped ">
                                    <thead>
                                    <tr class="table-light">
                                        <th scope="col">#</th>
                                        <th scope="col">نام</th>
                                        <th scope="col">شماره پرسنلی</th>
                                        <th scope="col">سطح دسترسی</th>
                                        <th scope="col">محل خدمت</th>
                                        <th scope="col">دسترسی انبار</th>
{{--                                        <th scope="col">تغییرات</th>--}}
                                        <th scope="col">حدف</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($personal as $index => $item)
                                        <tr>
                                            <th scope="row">{{$index+1}}</th>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->cardNumber}}</td>
                                            <td>{{$item->role}}</td>
                                            <td>{{$item->department}}</td>
                                            <td>{{$item->storage}}</td>

{{--                                            <td><a href=""><i class="fa fa-edit"></i></a></td>--}}
                                            <td>
                                                <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST"
                                                      style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            style="border:none; background:none; cursor:pointer;">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-4 personal-register" dir="rtl">

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-4">
                                    <label class="block mb-6">نام و نام خانوادگی</label><br>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           class="form-control" required placeholder="مثال: علی مقدم">
                                    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-1">شماره موبایل</label><br>
                                    <input type="text" name="mobile" value="{{ old('mobile') }}"
                                           class="form-control" required placeholder="مثال:09124568734 ">
                                    @error('mobile') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-1">شماره پرسنلی</label><br>
                                    <input type="text" name="cardNumber" value="{{ old('cardNumber') }}"
                                           class="form-control" required placeholder="مثال:3497">
                                    @error('cardNumber') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-1">بخش (محل کار)</label><br>
                                    <input type="text" name="department" value="{{ old('department') }}"
                                           class="form-control" required placeholder="مثال:صنایع">
                                    @error('department') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block mb-1">انبار یا سایت</label><br>
                                    <select required class="form-select" name="storage" id="storage">
                                        <option value="">انتخاب کنید</option>
                                        <option value="انبار ذخیره">انبار ذخیره</option>
                                        @foreach($storages as $storage)
                                            <option value="{{ $storage->name }}">{{ $storage->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block mb-1">سطح دسترسی</label><br>
                                    <select class="form-select" name="role" id="role">
                                        <option value="">انتخاب کنید</option>
                                        <option value="admin">مدیر</option>
                                        <option value="author">انباردار</option>
                                        <option value="user">کاربر</option>
                                    </select>
                                    @error('role')
                                    <p class="text-red-600 text-sm">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-outline-success">
                                    ثبت‌ نام
                                </button>
                            </form>

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
</div>




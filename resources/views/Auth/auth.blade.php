<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود به انبار ابزارآلات</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    <style>
        .pagehomeLogin{
            width: 100%;
            height: 100vh;
            background-image: url("{{ asset('img/111.png') }}");
            background-position: center;
            background-size: cover;
        }
    </style>

</head>
<body dir="rtl" class="pagehomeLogin">


    <div class="topcontent">
        <div class="row">
            <div class="col-md-6 logo-home-page">  <div ><img src="./img/1.png" alt="logo" width="50" class="mt-2 spin-x"></div><div class="mt-3 mx-3" >شرکت تعمیرات نیروگاهی ایران</div></div>
            <div class="col-md-6"><h2 class=" mt-2" style="transform: translateX(25%)"> Iran Power Plant Repairs</h2></div>




        </div>
    </div>
    <br>
    <div class="content-home-page">
        <div class="row">
            <div class="col-md-4 img-login-form">
{{--                <img src="./img/3.png" alt="leader" width="600">--}}
            </div>

            <div class="col-md-6">
                <div class="col-md-6">


                        <br><br>
                        <br><br>
                    <div class="form-login">
                        <h1 class="btn btn-success text-center ">فرم ورود</h1>

                        <br>

                        @if($errors->has('credentials'))
                            <p class="text-red-600 mb-4">{{ $errors->first('credentials') }}</p>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="block mb-1">نام کاربری :</label>
                                <input type="number" name="cardNumber" value="{{ old('cardNumber') }}"
                                       class="form-control" required placeholder="شماره پرسنلی">
                                @error('cardNumber') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block mb-1">رمز عبور:</label>
                                <input type="number" name="mobile"
                                       class="form-control" required placeholder="شماره موبایل">
                                @error('mobile') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <div class="container">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="login">ورود</button>

                                    </div>
                                </div>

                            </div>






                        </form>
                    </div>
                </div>
                <br>
                <p class="info-login-page">
                   برای دریافت  نام کاربری و رمز عبور به مدیریت بخش صنایع مراجعه فرمایید.
                </p>
            </div>
            <div class="col-md-4"></div>

        </div>


                <div style="display: none" class="max-w-md mx-auto mt-10 p-6 bg-white shadow-md rounded">
                    <h2 class="text-2xl mb-4">ثبت‌نام</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block mb-1">نام و نام خانوادگی</label><br>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full border px-3 py-2 rounded" required placeholder="مثال: علی مقدم">
                            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">شماره موبایل</label><br>
                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                   class="w-full border px-3 py-2 rounded" required placeholder="09124568734">
                            @error('mobile') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">شماره پرسنلی</label><br>
                            <input type="text" name="cardNumber" value="{{ old('cardNumber') }}"
                                   class="w-full border px-3 py-2 rounded" required placeholder="3497">
                            @error('cardNumber') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">بخش (محل کار)</label><br>
                            <input type="text" name="department" value="{{ old('department') }}"
                                   class="w-full border px-3 py-2 rounded" required placeholder="صنایع">
                            @error('department') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block mb-1">سطح دسترسی</label><br>
                            <select class="form-select-sm" name="role" id="role">
                                <option value="">انتخاب کنید</option>
                                <option value="admin">مدیر</option>
                                <option value="author">انباردار</option>
                                <option value="user">کاربر</option>
                            </select>
                            @error('role')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
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
                        <button type="submit" class="btn btn-outline-success">
                            ثبت‌ نام
                        </button>
                    </form>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>



    </div>














</body>
</html>












<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body dir="rtl">
<div class="container mt-4">
    <div class="row align-items-center">
        <div class="col-auto">
            <a href="{{route('register.form')}}"><button >auth</button></a>
        </div>
        <div class="col-auto">
            <p class="mb-0">علی مقدم</p>
        </div>
    </div>
</div>
</body>

</html>

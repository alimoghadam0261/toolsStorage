<div>
    <div class="sidebar-component">


        <br>
        <div class="info-user1"><p><strong>آقای
                    {{\Illuminate\Support\Facades\Auth::user()->name}}
                    خوش آمدید</strong></p></div>
        <div class="info-user2">
            <p>شماره پرسنلی :
                {{\Illuminate\Support\Facades\Auth::user()->cardNumber}}
            </p>
        </div>


        <br>
        <ul>
            <li><i class="fa fa-gauge fa-sm"></i><a href="{{route('admin.dashboard')}}"> داشبورد</a></li>
            <li><i class="fa fa-tools fa-sm"></i><a href="{{route('admin.tools')}}"> موجودی ابزار </a></li>
            <li><i class="fa fa-database fa-sm"></i><a href="{{route('admin.storages')}}"> انبار و سایت</a></li>



            @if(auth()->user()->role == 'admin')
                <li><i class="fa fa-comments fa-sm"></i><a href="{{route('admin.result-info')}}"> گزارشات</a></li>
                <li><i class="fa fa-users fa-sm"></i> <a href="{{route('admin.personal')}}"> پرسنل</a></li>
            @else
                <li><i class="fa fa-comments fa-sm"></i><a href="" disabled style=" pointer-events: none; color: gray;  text-decoration: none;"> گزارشات</a></li>
                <li><i class="fa fa-users fa-sm"></i><a href="" disabled style=" pointer-events: none; color: gray;  text-decoration: none;"> پرسنل</a></li>
            @endif
            <li><i class="fa fa-comments fa-sm"></i><a href=""> پشتیبانی</a></li>

        </ul>
        <br><br><br><br>
        <div class="col-md-12"><a href="{{route('logout')}}"><button class="btn btn-danger ">خروج</button></a></div>
    </div>
</div>

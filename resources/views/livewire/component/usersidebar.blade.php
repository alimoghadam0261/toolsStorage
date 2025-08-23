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
            <li><i class="fa fa-gauge fa-sm"></i>
                <a style="{{request()->routeIs('admin.dashboard') ?
 'background:#0AC7FD33; padding:.5em; border-radius:5px;' : 'background:none;'  }}"
                   href="{{route('home')}}"> داشبورد</a></li>

            <li><i class="fa fa-tools fa-sm"></i>
                <a style="{{request()->routeIs('admin.tools') ?  'background:#0AC7FD33; padding:.5em; border-radius:5px;' : 'background:none;'  }}"
                   href="{{route('admin.tools')}}"> موجودی ابزار </a></li>

            <li><i class="fa fa-comments fa-sm"></i>
                <a href=""> پشتیبانی</a></li>




        </ul>

        <div class="col-md-12"><a href="{{route('logout')}}"><button class="btn btn-danger " style="width:200px;">خروج</button></a></div>
    </div>
</div>


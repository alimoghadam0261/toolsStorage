<div dir="rtl"class="bottomMenuMobile">
   <div class="container">
       <div class="bottom-menu-mobile-container">

           <a href="{{route('admin.dashboard')}}"><i class="fa fa-gauge"></i><p class="p-bottom-menu">داشبورد</p></a>


               <a href="{{route('admin.tools')}}"><i class="fa fa-tools"></i><p class="p-bottom-menu">موجودی ایزار</p></a>


               <a href="{{route('admin.storages')}}"><i class="fa fa-database"></i><p class="p-bottom-menu">انبار و سایت</p></a>

           @if(auth()->user()->role == 'admin')

               <a href="{{route('admin.result-info')}}"><i class="fa fa-comments"></i><p class="p-bottom-menu">گزارشات</p></a>

               <a class="personal-bottom-menu" href="{{route('admin.personal')}}"><i class="fa fa-users"></i><p class="p-bottom-menu">پرسنل</p></a>
           @else

               <a href=""><i class="fa fa-comments" disabled style=" pointer-events: none; color: gray;  text-decoration: none;"></i><p class="p-bottom-menu">گزارشات</p></a>

               <a class="personal-bottom-menu"  href=""><i class="fa fa-users" disabled style=" pointer-events: none; color: gray;  text-decoration: none;"></i><p class="p-bottom-menu">پرسنل</p></a>

           @endif

       </div>
   </div>
</div>

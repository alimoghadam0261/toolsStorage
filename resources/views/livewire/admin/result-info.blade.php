<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <br>

                  <div class="widgets-admin">

                    <div class="box-widget-admin">
                        <a href="{{route('admin.info.UserActivityDashboard')}}">
                        <h6>گزارشات پرسنل </h6>
                        </a>
                    </div>
                    <div class="box-widget-admin">
                        <a href="{{route('admin.info.Toolscharts')}}">
                        <h6>گزارشات ابزار ها </h6>
                        </a>
                    </div>
                    <div class="box-widget-admin">
                        <h6>مجموع جم خارج از انبار</h6>
                        <p>1234</p>
                    </div>
                </div>






            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

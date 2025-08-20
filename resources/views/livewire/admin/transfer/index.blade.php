<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div class="widgets-admin">
                    <div class="box-widget-admin" style="background: #ddf0f8">
                        <a href="{{route('admin.transfer.form')}}">
                            <br>

                            <h5 style="transform: translateY(-.5em)">
                                ارسال ابزار جدید
                            </h5>

                        </a></div>

                </div>


            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

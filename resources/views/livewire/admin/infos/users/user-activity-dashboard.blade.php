



<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>

                <div class="container-fluid py-4">
                 <div class="row">
                     <div class="col-md-6"><h2 class="mb-4">📊 داشبورد تحلیلی فعالیت کاربران</h2></div>
                     <div class="col-md-6">
                         <div class="widgets-admin">
                             <a  class="box-widget-admin p-3" href="{{route('admin.activities')}}">
                                 <h6> جزئیات عملکرد پرسنل</h6>
                             </a>
                         </div>
                     </div>


                 </div>
                    {{-- فیلترها --}}
{{--                    <div class="card shadow-sm mb-4">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row g-3">--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <label class="form-label">از تاریخ</label>--}}
{{--                                    <input type="date" class="form-control" wire:model.live="fromDate">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <label class="form-label">تا تاریخ</label>--}}
{{--                                    <input type="date" class="form-control" wire:model.live="toDate">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <label class="form-label">بازه</label>--}}
{{--                                    <select class="form-select" wire:model.live="range">--}}
{{--                                        <option value="day">روزانه</option>--}}
{{--                                        <option value="week">هفتگی</option>--}}
{{--                                        <option value="month">ماهانه</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <label class="form-label">نقش</label>--}}
{{--                                    <select class="form-select" wire:model.live="selectedRole">--}}
{{--                                        <option value="">همه</option>--}}
{{--                                        @foreach($roles as $role)--}}
{{--                                            <option value="{{ $role }}">{{ $role }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <label class="form-label">کاربر</label>--}}
{{--                                    <select class="form-select" wire:model.live="selectedUser">--}}
{{--                                        <option value="">همه</option>--}}
{{--                                        @foreach($users as $user)--}}
{{--                                            <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    {{-- نمودارها --}}
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header">فعالیت‌ها بر اساس تاریخ</div>
                                <div class="card-body">
                                    <canvas  style="width: 300px;height:150px;" id="chartByDate"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm" >
                                <div class="card-header">فعالیت‌ها بر اساس عملیات</div>
                                <div class="card-body"
                                     style="width: 300px;height:300px;"
                                >
                                    <canvas id="chartByAction"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header">فعالیت‌ها بر اساس نقش</div>
                                <div class="card-body">
                                    <canvas  id="chartByRole"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header">کاربران فعال (Top 10)</div>
                                <div class="card-body">
                                    <canvas id="chartByUser"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header">فعالیت‌ها بر اساس مدل</div>
                                <div class="card-body" style="width: 300px;height:450px;">
                                    <canvas  id="chartByModel"></canvas>
                                </div>
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
{{--<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
<script src="{{ asset('./js/chart.js') }}"></script>
<script>
    const chartByDate = new Chart(document.getElementById('chartByDate'), {
        type: 'line',
        data: {
            labels: @json(array_column($activitiesByDate, 'label')),
            datasets: [{
                label: 'تعداد فعالیت‌ها',
                data: @json(array_column($activitiesByDate, 'total')),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.3)',
                fill: true
            }]
        }
    });

    const chartByAction = new Chart(document.getElementById('chartByAction'), {
        type: 'pie',
        data: {
            labels: @json(array_column($activitiesByAction, 'action')),
            datasets: [{
                data: @json(array_column($activitiesByAction, 'total')),
                backgroundColor: ['#0d6efd','#198754','#dc3545','#ffc107','#6f42c1']
            }]
        }
    });

    const chartByRole = new Chart(document.getElementById('chartByRole'), {
        type: 'bar',
        data: {
            labels: @json(array_column($activitiesByRole, 'role')),
            datasets: [{
                label: 'تعداد',
                data: @json(array_column($activitiesByRole, 'total')),
                backgroundColor: '#20c997'
            }]
        }
    });

    const chartByUser = new Chart(document.getElementById('chartByUser'), {
        type: 'bar',
        data: {
            labels: @json(array_column($activitiesByUser, 'name')),
            datasets: [{
                label: 'تعداد',
                data: @json(array_column($activitiesByUser, 'total')),
                backgroundColor: '#6610f2'
            }]
        }
    });

    const chartByModel = new Chart(document.getElementById('chartByModel'), {
        type: 'doughnut',
        data: {
            labels: @json(array_column($activitiesByModel, 'model_type')),
            datasets: [{
                data: @json(array_column($activitiesByModel, 'total')),
                backgroundColor: ['#0dcaf0','#6f42c1','#fd7e14','#198754','#dc3545']
            }]
        }
    });
</script>

<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <h4>کمترین تعداد ابزار</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام</th>
                                <th scope="col">شماره</th>
                                <th scope="col">تعداد</th>
                            </tr>

                            <tbody>
                            @foreach($lowTools as $index => $item)
                            <tr>
                                <td>{{$index +1}}</td>
                                <td>{{$item->information->name}}</td>
                                <td>{{$item->information->serialNumber}}</td>
                                <td>{{$item->count}}</td>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h4>بیشترین تعداد ابزار</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام</th>
                                <th scope="col">شماره</th>
                                <th scope="col">تعداد</th>
                            </tr>

                            <tbody>
                            @foreach($maxTools as $index => $item)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$item->information->name}}</td>
                                    <td>{{$item->information->serialNumber}}</td>
                                    <td>{{$item->count}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>

                <br>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <h6>نمودار گراف تعداد ابزار ها </h6>
                        <div style="height:400px; width:90%; margin:0 auto;">
                            <canvas id="toolsChart"></canvas>
                        </div>

                    </div>
                    <div class="col-md-1"></div>
                </div>



            </div>
            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>

</div>

<script src={{asset('./js/chart.js')}}></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('toolsChart').getContext('2d');

        const chartLabels = @json($chartLabels);      // مثلا تاریخ یا زمان
        const lowCounts   = @json($lowCounts);        // مقادیر تعداد کمترین ابزار
        const maxCounts   = @json($maxCounts);        // مقادیر تعداد بیشترین ابزار
        const lowNames    = @json($lowNames);         // نام ابزارهای کمترین
        const maxNames    = @json($maxNames);         // نام ابزارهای بیشترین

        new Chart(ctx, {
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        type: 'line',
                        label: 'کمترین ابزارها',
                        data: lowCounts,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.3)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.3,
                        tooltipsData: lowNames   // اینو اضافه کردیم
                    },
                    {
                        type: 'line',
                        label: 'بیشترین ابزارها',
                        data: maxCounts,
                        backgroundColor: 'rgba(75, 192, 75, 0.7)',
                        borderColor: 'rgba(75, 192, 75, 1)',
                        borderWidth: 1,
                        tooltipsData: maxNames   // اینو اضافه کردیم
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let dataset = context.dataset;
                                let index   = context.dataIndex;
                                let value   = dataset.data[index];
                                let toolName = dataset.tooltipsData ? dataset.tooltipsData[index] : '';
                                return toolName + ' - ' + value + ' عدد';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxTicksLimit: 10
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>













<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div class="widgets-admin">
                    <div class="box-widget-admin">
                        <h6>مجموع ابزارآلات ثبت شده</h6>
                        <p>{{$countabzar}}</p>
                    </div>
                    <div class="box-widget-admin">
                        <h6>مجموع سرمایه ای ثبت شده </h6>
                        <p>{{$countJam}}</p>
                    </div>
                    <div class="box-widget-admin">
                        <h6>مجموع مصرفی ثبت شده </h6>
                        <p>{{$countmasraf}}</p>
                    </div>
                    <div class="box-widget-admin">
                        <h6>مجموع تعداد کل</h6>
                        <p>{{$countTotal}}</p>
                    </div>
                </div>
                <br>
                <div class="info-admin">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-dashboard-admin">
                                <!-- نمودار میله‌ای -->
                                <canvas id="inventoryChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-dashboard-admin">
                                <!-- نمودار خطی -->
                                <canvas id="inventoryLineChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="ticker-wrap-dashboard">
                <span class="text-right" dir="rtl">ابزار های در حال کاهش :</span>
                <div class="ticker-dashboard">
                    @foreach($lowTools as $item)
                        <div class="ticker-item-dashboard">
                            {{ $item->information->name }} (تعداد: {{ $item->count }})
                        </div>
                    @endforeach

                    {{-- 👇 تکرار مجدد برای ایجاد لوپ نرم --}}
                    @foreach($lowTools as $item)
                        <div class="ticker-item-dashboard">
                            {{ $item->information->name }} (تعداد: {{ $item->count }})
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

<script src="{{asset('./js/chart.js')}}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // داده‌ها از Blade به جاوا اسکریپت
        const chartData = @json($chartData); // داده‌های نمودار میله‌ای
        const lineChartData = @json($lineChartData); // داده‌های نمودار خطی

        // تنظیمات برای دسته‌بندی محصولات
        const categories = ['سرمایه ای', 'ابزار', 'مصرفی']; // دسته‌بندی‌ها
        const months = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند']; // ماه‌های شمسی

        // ایجاد داده‌ها برای هر ماه و هر دسته
        const dataForChart = categories.map(category => {
            return months.map(month => {
                return chartData.filter(item => item.category === category && item.month === months.indexOf(month) + 1)
                    .reduce((total, item) => total + item.count, 0);
            });
        });

        // نمودار میله‌ای
        const ctx1 = document.getElementById('inventoryChart').getContext('2d');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: months, // ماه‌ها برای محور X
                datasets: categories.map((category, index) => {
                    return {
                        label: category,
                        data: dataForChart[index], // داده‌ها برای هر دسته‌بندی
                        backgroundColor: `rgba(${(index + 1) * 50}, ${(index + 2) * 60}, ${(index + 3) * 70}, 0.5)`, // رنگ‌های مختلف برای هر دسته
                        borderColor: `rgba(${(index + 1) * 50}, ${(index + 2) * 60}, ${(index + 3) * 70}, 1)`,
                        borderWidth: 1
                    };
                })
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // نمودار خطی
        const ctx2 = document.getElementById('inventoryLineChart').getContext('2d');

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: lineChartData.map(item => months[item.month - 1]), // ماه‌ها برای محور X (شمسی)
                datasets: [{
                    label: 'تعداد کالا در انبار',
                    data: lineChartData.map(item => item.total), // تعداد کالاها
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'نمودار خطی ورود کالا به انبار'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

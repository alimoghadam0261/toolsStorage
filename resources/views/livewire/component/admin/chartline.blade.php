<div>
    <div>
        <canvas id="inventoryLineChart" width="400" height="200"></canvas>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('inventoryLineChart').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد'],
                        datasets: [{
                            label: 'تعداد کالا در انبار',
                            data: [20, 35, 30, 50, 40],
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
    </div>

</div>

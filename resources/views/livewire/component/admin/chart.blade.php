<div>
    <div>
        <canvas id="inventoryChart" width="400" height="200"></canvas>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const ctx = document.getElementById('inventoryChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar', // یا 'line'
                    data: {
                        labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'],
                        datasets: [{
                            label: 'تعداد ورود کالا به انبار',
                            data: [12, 19, 3, 5,3,14,6,15,20,2,11,4],
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
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
            });
        </script>
    </div>

</div>

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
                            label: 'تعداد  کالای جدید به انبار',
                            data: [5,150],
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                            {
                                label: 'تعداد  کالای قدیم به انبار',
                                data: [15,100],
                                backgroundColor: 'rgba(235,184,54,0.5)',
                                borderColor: 'rgb(229,235,54)',
                                borderWidth: 1
                            }

                        ]
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

<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-10">
               @livewire('component.admin.topmenu')
               <hr>
               <br>



{{--@foreach($test as $tes)   <p>{{ $tes->information->name ?? 'بدون نام' }} - قیمت: {{ $tes->price }}</p> @endforeach--}}
               <div id="mygraph" style="width: 100%; height: 600px;"></div>






           </div>
           <div class="col-md-2">
               @livewire('component.admin.sidebar')
           </div>
        </div>
    </div>

</div>
    <script src="{{ asset('./js/vis-network.js') }}"></script>
    <script src="{{ asset('./js/graph.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // گرفتن داده‌ها از PHP
        let testData = @json($test);

        // آماده‌سازی داده
        let items = testData.map((item, index) => {
            return {
                x: index, // شماره ابزار
                y: item.price ?? 0, // یا item.count
                label: item.information?.name ?? "بدون نام"
            };
        });

        let dataset = new vis.DataSet(items);

        let options = {
            style: 'bar', // خطی یا bar
            barChart: { width: 50, align: 'center' }, // برای حالت میله‌ای
            drawPoints: false,
            dataAxis: {
                left: {
                    title: { text: 'قیمت ابزارها' }
                }
            },
            orientation: 'top',
            showMajorLabels: true,
            showMinorLabels: true,
            // نمایش اسم ابزارها زیر محور X
            format: {
                x: function (val) {
                    return items[val]?.label ?? val;
                }
            }
        };

        let container = document.getElementById("mygraph");
        let graph2d = new vis.Graph2d(container, dataset, options);
    });
</script>











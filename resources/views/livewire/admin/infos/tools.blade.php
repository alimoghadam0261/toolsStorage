<div dir="rtl" class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <h1>گزارشات</h1>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped    text-center">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">محل </th>
                                    <th scope="col">تحویل گیرنده</th>
                                    <th scope="col">تاریخ</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($locations as $index =>$item)
                                    <tr>
                                        <th scope="row">{{$index+1}}</th>
                                        <td {{ $item->location == 'انبار مرکزی' ? 'style=background:#A6D6BCFF;' : 'style=background:none' }}>{{ $item->location }}</td>
                                        <td>{{$item->Receiver}}</td>
                                        <td>{{jdate($item->moved_at)->format('y/m/d')}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div wire:ignore>
                                <div id="mynetwork" style="width: 100%; height: 600px; border: 1px solid lightgray;"></div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</div>
<script
    type="text/javascript"
    src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>

<script>
    document.addEventListener('livewire:initialized', () => {
        const nodes = new vis.DataSet(@json($nodes));
        const edges = new vis.DataSet(@json($edges));

        const container = document.getElementById('mynetwork');
        const data = { nodes, edges };
        const options = {
            edges: {
                color: 'gray',
                length: 100,
                font: {
                    align: 'middle', // متن وسط خط
                    size: 14,
                    face: 'arial',
                    color: 'black'
                }
            },
            physics: { stabilization: true },
            nodes: {
                shape: 'circle',
                size: 16,
                color: 'skyblue'
            }
        };

        new vis.Network(container, data, options);
    });

</script>




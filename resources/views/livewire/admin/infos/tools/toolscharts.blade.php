<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>

                <!-- جدول کمترین تعداد ابزار -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>کمترین تعداد ابزار</h4>
                        <div class="table-container" style="height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class=" table table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام</th>
                                <th scope="col">شماره سریال</th>
                                <th scope="col">تعداد</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lowTools as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->information->name ?? '---' }}</td>
                                    <td>{{ $item->information->serialNumber ?? '---' }}</td>
                                    <td>{{ $item->count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- جدول بیشترین تعداد ابزار -->
                    <div class="col-md-6">
                        <h4>بیشترین تعداد ابزار</h4>
                        <div class="table-container" style="height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class=" table table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام</th>
                                <th scope="col">شماره سریال</th>
                                <th scope="col">تعداد</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($maxTools as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->information->name }}</td>
                                    <td>{{ $item->information->serialNumber }}</td>
                                    <td>{{ $item->count }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>

                <br>

                <!-- جدول خرابی‌ها -->
                <div class="row">
                    <div class="col-md-6">
                        <h4>تعداد خرابی‌های سایت ها</h4>
                        <div class="table-container" style="height: 400px; overflow-y: auto; ">
                        <table class="table table-striped">
                            <thead class=" table table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام ابزار</th>
                                <th scope="col">شماره سریال</th>
                                <th scope="col">تعداد خرابی</th>
                                <th scope="col">نام سایت</th>
                                <th scope="col">تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($damagedItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['serial'] }}</td>
                                    <td>{{ $item['damaged_qty'] }}</td>
                                    <td>{{ $item['site_name'] }}</td>
                                    <td>{{ $item['date'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    </div>

                    <!-- جدول گمشده‌ها -->
                    <div class="col-md-6">
                        <h4>تعداد گمشده‌های سایت ها</h4>
                        <div class="table-container" style="height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead class=" table table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">نام ابزار</th>
                                <th scope="col">شماره سریال</th>
                                <th scope="col">تعداد گمشده</th>
                                <th scope="col">نام سایت</th>
                                <th scope="col">تاریخ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lostItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['serial'] }}</td>
                                    <td>{{ $item['lost_qty'] }}</td>
                                    <td>{{ $item['site_name'] }}</td>
                                    <td>{{ $item['date'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    </div>
                </div>


                <br>
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <h4>تعداد گمشده های انبار مرکزی</h4>
                        <div class="table-container" style="height: 400px; overflow-y: auto; ">
                            <table class="table table-striped">
                                <thead class=" table table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نام ابزار</th>
                                    <th scope="col">شماره سریال</th>
                                    <th scope="col">تعداد گمشده</th>
                                    <th scope="col">تاریخ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($qtytoolslost as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->information->name ?? '-' }}</td>
                                        <td>{{ $item->information->serialNumber ?? '-' }}</td>
                                        <td>{{ $item['qtyLost'] }}</td>
                                        <td>{{ jdate($item->updated_at) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <!-- جدول گمشده‌ها -->
                    <div class="col-md-6">
                        <h4>تعداد خرابی های انبار مرکزی</h4>
                        <div class="table-container" style="height: 400px; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead class=" table table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">نام ابزار</th>
                                    <th scope="col">شماره سریال</th>
                                    <th scope="col">تعداد خرابی</th>
                                    <th scope="col">تاریخ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($qtytoolsdamage as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->information->name ?? '-' }}</td>
                                        <td>{{ $item->information->serialNumber ?? '-' }}</td>
                                        <td>{{ $item['qtyDamaged'] }}</td>
                                        <td>{{ jdate($item->updated_at) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

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

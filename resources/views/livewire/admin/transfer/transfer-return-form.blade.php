



<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>

                <div>
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            ثبت برگشت ابزار
                        </div>
                        <div class="card-body">
                            @if(session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form wire:submit.prevent="save">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>نام ابزار</th>
                                        <th>تعداد ارسال‌شده</th>
                                        <th>تعداد برگشتی (سالم)</th>
                                        <th>خراب</th>
                                        <th>گمشده</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $index => $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ $item['qty_sent'] }}</td>
                                            <td><input type="number" wire:model="items.{{ $index }}.qty_return" class="form-control" min="0" max="{{ $item['qty_sent'] }}"></td>
                                            <td><input type="number" wire:model="items.{{ $index }}.damaged_qty" class="form-control" min="0" max="{{ $item['qty_sent'] }}"></td>
                                            <td><input type="number" wire:model="items.{{ $index }}.lost_qty" class="form-control" min="0" max="{{ $item['qty_sent'] }}"></td>
                                        </tr>
                                        @error("items.$index.qty_return") <span class="text-danger">{{ $message }}</span> @enderror
                                        @error("items.$index.damaged_qty") <span class="text-danger">{{ $message }}</span> @enderror
                                        @error("items.$index.lost_qty") <span class="text-danger">{{ $message }}</span> @enderror
                                    @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-success mt-3">ثبت برگشت</button>
                            </form>
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

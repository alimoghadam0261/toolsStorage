<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <h5>پذیرش انبار و سایت جدید</h5>

                <br>

                <form action="" wire:submit.prevent="save" class="form-control">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-tools-create">
                            <label for="">نام سایت</label>
                            <input wire:model="name" class="form-control col-md-1" type="text" placeholder="نام سایت را بنویسید" required>
                            <br>
                            <label for="">آدرس سایت</label>
                            <input wire:model="location" class="form-control col-md-1" type="text" required placeholder="لوکیشن و آدرس سایت">
                            <br>

                            <br>

                        </div>
                        <div class="col-md-6 form-tools-create" >

                            <label for="">مدیر پروژه</label>
                            <input wire:model="manager" class="form-control col-md-1" type="text" placeholder="مثال :آقای کریمایی" required>
                            <br>
                            <label for="">توضیحات</label>
                            <textarea name="" id="" cols="20" rows="5" class="form-control" wire:model="content"></textarea>

                        </div>
                    </div>
                    <br>
                    <button class="btn btn-success">ثبت سایت جدید</button>
                </form>


            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>







<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>

                <div class="container py-4" >
                    <form wire:submit.prevent="save"
                          style="background: rgba(234,229,229,0.4);"
                          class="mb-4 border p-3 rounded" enctype="multipart/form-data" novalidate>
                        <h5>{{ $isEdit ? 'ویرایش ابزار' : 'افزودن ابزار جدید' }}</h5>

                        {{-- خلاصه خطاها --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>خطا در ورود اطلاعات:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="form-label">نام</label>
                                <input required type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       wire:model="name">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">دسته بندی:</label>
                                <select required class="form-select @error('category') is-invalid @enderror"
                                        wire:model.live="category">
                                    <option value="">انتخاب کنید</option>
                                    <option value="tools">مصرفی</option>
                                    <option value="abzar-">ابزار</option>
                                    <option value="IPR-">سرمایه ای</option>
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- فقط وقتی دسته‌بندی IPR- نیست، این سلکت نمایش داده بشه --}}
                            @if($category && $category !== 'IPR-'&& $category !==  'abzar-')
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">پیشوند اختصاصی</label>
                                    <select class="form-select @error('customPrefix') is-invalid @enderror"
                                            wire:model.live="customPrefix">
                                        <option value="">انتخاب کنید</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                    </select>
                                    @error('customPrefix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif

                            <div class="col-md-3 mb-2">
                                <label class="form-label">شماره سریال</label>
                                <input readonly type="text"
                                       class="form-control @error('serialNumber') is-invalid @enderror"
                                       wire:model="serialNumber">
                                @error('serialNumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">شماره سریال شرکتی:</label>
                                <input type="number"
                                       class="form-control @error('companynumber') is-invalid @enderror"
                                       wire:model="companynumber">
                                @error('companynumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">تحویل گیرنده</label>
                                <input required type="text"
                                       class="form-control @error('Receiver') is-invalid @enderror"
                                       wire:model="Receiver">
                                @error('Receiver') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">تعداد</label>
                                <input required type="number"
                                       class="form-control @error('count') is-invalid @enderror"
                                       wire:model="count">
                                @error('count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">وضعیت</label>
                                <select required class="form-select @error('status') is-invalid @enderror"
                                        wire:model="status">
                                    <option value="">انتخاب کنید</option>
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیرفعال</option>
                                    <option value="broken">خراب</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">فایل پیوست (حداکثر 2MB)</label>
                                <input type="file"
                                       class="form-control @error('attach') is-invalid @enderror"
                                       wire:model="attach" accept="image/*,.pdf,.doc,.docx">
                                @error('attach') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div wire:loading wire:target="attach" class="text-info small mt-1">در حال آپلود...</div>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">مدل</label>
                                <input required type="text"
                                       class="form-control @error('model') is-invalid @enderror"
                                       wire:model="model">
                                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">وزن</label>
                                <input required type="number"
                                       class="form-control @error('Weight') is-invalid @enderror"
                                       wire:model="Weight">
                                @error('Weight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">نوع مصرف</label>
                                <input required type="text"
                                       class="form-control @error('TypeOfConsumption') is-invalid @enderror"
                                       wire:model="TypeOfConsumption">
                                @error('TypeOfConsumption') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">اندازه</label>
                                <input required type="text"
                                       class="form-control @error('size') is-invalid @enderror"
                                       wire:model="size">
                                @error('size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">قیمت</label>
                                <input required type="number"
                                       class="form-control @error('price') is-invalid @enderror"
                                       wire:model="price" step="0.01">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">محل نگهداری (انبار)</label>
                                <select required class="form-select @error('storage_id') is-invalid @enderror"
                                        wire:model="storage_id">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                                @error('storage_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">رنگ</label>
                                <input required type="text"
                                       class="form-control @error('color') is-invalid @enderror"
                                       wire:model="color">
                                @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="form-label">تاریخ تولید</label>
                                <input  data-jdp
                                        data-jdp-only-date="true"
                                       class="form-control @error('dateOfSale') is-invalid @enderror"
                                        wire:model.defer="dateOfSale"

                                @error('dateOfSale') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-2">

                                <label class="form-label">تاریخ انقضا</label>
                                <input
                                    data-jdp
                                    data-jdp-only-date="true"
                                    class="form-control @error('dateOfSale') is-invalid @enderror"
                                    wire:model.defer="dateOfexp">

                                @error('dateOfexp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-6 mb-2">
                                <label class="form-label">توضیحات</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          wire:model="content"></textarea>
                                @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-primary">{{ $isEdit ? 'بروزرسانی' : 'ثبت' }}</button>
                            <button type="button" class="btn btn-secondary" wire:click="resetForm">انصراف</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

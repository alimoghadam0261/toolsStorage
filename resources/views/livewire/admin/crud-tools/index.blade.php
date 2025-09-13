<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>

                <div class="container py-4">

                    <form wire:submit.prevent="updateTool" class="mb-4 border p-3 rounded">
                        <h5></h5>

                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label>نام</label>
                                <input required type="text"  class="form-control" wire:model="name">
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
                                <label>شماره سریال</label>
                                <input readonly type="text" class="form-control" wire:model="serialNumber">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>شماره سریال شرکتی</label>
                                <input  type="number" class="form-control" wire:model="companynumber">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>تحویل گیرنده</label>
                                <input required type="text"  class="form-control" wire:model="Receiver">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>تعداد</label>
                                <input required type="number" class="form-control" wire:model="count">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>مدل</label>
                                <input  type="text" class="form-control" wire:model="model">
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
                                <label>وزن</label>
                                <input required type="number" class="form-control" wire:model="Weight">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>نوع مصرف</label>
                                <input required type="text" class="form-control" wire:model="TypeOfConsumption">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>اندازه</label>
                                <input required type="text" class="form-control" wire:model="size">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>قیمت</label>
                                <input required type="number" class="form-control" wire:model="price">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>محل نگهداری</label>
                                <select required class="form-select" wire:model="StorageLocation">
                                    <option value="">انتخاب کنید</option>
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage->name }}">{{ $storage->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>رنگ</label>
                                <input required type="text" class="form-control" wire:model="color">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>تاریخ فروش</label>
                                <input  type="date" class="form-control" wire:model="dateOfSale">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>تاریخ انقضا</label>
                                <input  type="date" class="form-control" wire:model="dateOfexp">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>تعداد خرابی</label>
                                <input required type="number" class="form-control" wire:model="qtyDamaged">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>تعداد گمشده</label>
                                <input required type="number" class="form-control" wire:model="qtyLost">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>تعداد اسقاطی</label>
                                <input required type="number" class="form-control" wire:model="qtyWritOff">
                            </div>


                            <div class="col-6 mb-2">
                                <label>توضیحات</label>
                                <textarea required class="form-control" wire:model="content"></textarea>
                            </div>
                        </div>
                        <form wire:submit.prevent="updateTool">
                            <button type="submit" class="btn btn-primary">به روز رسانی</button>
{{--                            <button type="button" class="btn btn-secondary" wire:click="resetForm">انصراف</button>--}}
                        </form>
                    </form>












                </div>


            </div>
            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>

<div class="container-fluid" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-md-10" dir="rtl">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    ایجاد انتقال ابزار
                </div>
                <div class="card-body">

                    {{-- پیام‌ها --}}
                    @if(session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- انتخاب انبار --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>انبار مبدا:</label>
                            <select wire:model.live="fromStorage" class="form-select">
                                <option value="">-- انتخاب کنید --</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>انبار مقصد:</label>
                            <select wire:model.live="toStorage" class="form-select">
                                <option value="">-- انتخاب کنید --</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- انتخاب ابزار --}}
                    @if($fromStorage)
                        <div class="mb-3">
                            <label>وضعبت:</label>
                            <select wire:model.live="status" class="form-select">
                                <option value="">-- انتخاب کنید --</option>
                                <option value="sent">ارسال</option>
                                <option value="returned">بازگشت</option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>تصویر:</label>
                            <input type="file" wire:model.live="image" class="form-control">
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror

                            @if ($image)
                                <div class="mt-2">
                                    پیش‌نمایش:
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" width="200">
                                </div>
                            @endif
                        </div>


                        <div class="mb-3">
                            <label>توضیحات:</label>
                            <textarea wire:model.live="note" class="form-select"></textarea>
                        </div>


                        <div class="mb-3">
                            <label>ابزار:</label>
                            <select wire:model.live="selectedTool" class="form-select">
                                <option value="">-- انتخاب کنید --</option>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}">
                                        {{ $tool->information->name ?? '' }} (موجودی: {{ $tool->count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if($selectedTool)
                            <div class="mb-3">
                                <label>تعداد:</label>
                                <input type="number" wire:model.live="qty" class="form-control"
                                       min="1" max="{{ $tools->find($selectedTool)->count }}">
                            </div>
                            <button wire:click="addItem" class="btn btn-primary">
                                افزودن به لیست
                            </button>
                        @endif
                    @endif

                    {{-- جدول اقلام --}}
                    @if(count($transferItems) > 0)
                        <hr>
                        <h5>لیست اقلام انتقال</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>نام ابزار</th>
                                    <th>تعداد</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transferItems as $index => $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['qty'] }}</td>
                                        <td>
                                            <button wire:click="removeItem({{ $index }})" class="btn btn-sm btn-danger">
                                                حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button wire:click="save" class="btn btn-success">ثبت انتقال</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-2">
            @livewire('component.admin.sidebar')
        </div>
    </div>
</div>

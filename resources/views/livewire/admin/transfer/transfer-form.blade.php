<div class="dashboard-admin">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                @livewire('component.admin.topmenu')
                <hr>
                <br>
                <div>
                    <div class="p-4 bg-white rounded shadow" dir="rtl">
                        <h2 class="text-lg font-bold mb-4">ایجاد انتقال ابزار</h2>

                        {{-- پیام موفقیت --}}
                        @if (session()->has('success'))
                            <div class="p-2 mb-3 bg-green-100 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- پیام خطا --}}
                        @if (session()->has('error'))
                            <div class="p-2 mb-3 bg-red-100 text-red-700 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- نمایش خطاهای کلی --}}
                        @if ($errors->any())
                            <div class="p-2 mb-3 bg-red-100 text-red-700 rounded">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- انتخاب انبار مبدا --}}
                        <div class="mb-3">
                            <label class="block mb-1">انبار مبدا:</label>
                            <select wire:model.live.live="fromStorage" class="form-select w-full">
                                <option value="">-- انتخاب کنید --</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                            @error('fromStorage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- انتخاب انبار مقصد --}}
                        <div class="mb-3">
                            <label class="block mb-1">انبار مقصد:</label>
                            <select wire:model.live="toStorage" class="form-select w-full">
                                <option value="">-- انتخاب کنید --</option>
                                @foreach($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                            @error('toStorage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- ابزارهای انبار مبدا --}}
                        @if($fromStorage)
                            <div class="mb-3">
                                <label class="block mb-1">ابزار:</label>
                                <select wire:model.live="selectedTool" class="form-select w-full">
                                    <option value="">-- انتخاب کنید --</option>
                                    @foreach($tools as $tool)
                                        <option value="{{ $tool->id }}">
                                            {{ $tool->information->name }}
                                            (موجودی: {{ $tool->count }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedTool') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            @if($selectedTool)
                                <div class="mb-3">
                                    <label class="block mb-1">تعداد (حداکثر: {{ $tools->find($selectedTool)->count }}):</label>
                                    <input type="number" wire:model.live="qty" class="form-control w-full" min="1"
                                           max="{{ $tools->find($selectedTool)->count }}">
                                    @error('qty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <button wire:click="addItem" type="button" class="btn btn-primary">
                                    افزودن به لیست
                                </button>
                            @endif
                        @endif

                        {{-- لیست اقلام انتقال --}}
                        @if(count($transferItems) > 0)
                            <hr class="my-4">
                            <h3 class="font-bold mb-2">لیست اقلام انتقال:</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">نام
                                            ابزار
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            تعداد
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            عملیات
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($transferItems as $index => $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $item['qty'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button wire:click="removeItem({{ $index }})" type="button"
                                                        class="text-red-600 hover:text-red-900">
                                                    حذف
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button wire:click="save" type="button" class="btn btn-success mt-3">
                                ثبت انتقال
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
</div>




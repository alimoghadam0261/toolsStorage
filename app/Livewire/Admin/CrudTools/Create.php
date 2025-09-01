<?php

namespace App\Livewire\Admin\CrudTools;

use App\Models\ToolsInformation;
use App\Models\UserActivity;
use App\Models\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\LogsActivity;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;
use Morilog\Jalali\CalendarUtils;
use Carbon\Carbon;

class Create extends Component
{
    use WithFileUploads, LogsActivity;

    // properties
    public $storages = [];
    public $tools;
    public $toolId;
    public $customPrefix;
    public $toolActivities;

    public $name, $serialNumber, $companynumber;
    public $category, $count, $model, $Weight, $TypeOfConsumption,
        $size, $price, $color, $dateOfSale, $dateOfexp, $Receiver,
        $content, $attach, $status;

    public $storage_id;
    public $StorageLocation;
    public $isEdit = false;

    public function mount()
    {
        $this->loadTools();

        $this->storages = Storage::select('id', 'name')->get();
        if ($this->storages->isNotEmpty() && empty($this->storage_id)) {
            $this->storage_id = $this->storages->first()->id;
            $this->StorageLocation = $this->storages->first()->name;
        }

        // بارگذاری لاگ ابزارها
        $this->toolActivities = UserActivity::with('user')
            ->whereIn('model_type', ['ToolsDetail', 'ToolsInformation'])
            ->latest()
            ->get();
    }

    public function loadTools()
    {
        $this->tools = ToolsInformation::with('details')->get();
    }

    // وقتی category تغییر کنه سریال جدید تولید می‌کنیم
    public function updatedCategory($value)
    {
        if (!empty($value)) {
            $this->serialNumber = $this->generateUniqueSerial($value);
        }
    }

    public function updatedCustomPrefix($value)
    {
        if (!empty($this->category)) {
            $this->serialNumber = $this->generateUniqueSerial($this->category);
        }
    }

    public function updatedStorageId($value)
    {
        $storage = $this->storages->firstWhere('id', (int)$value);
        $this->StorageLocation = $storage?->name;
    }

    private function generateUniqueSerial($category)
    {
        if (strtolower($category) === 'abzar-') {
            $prefix = 'abzar-';
        } elseif (strtoupper($category) === 'IPR' || $category === 'IPR-') {
            $prefix = 'IPR-';
        } else {
            $prefix = $this->customPrefix ? $this->customPrefix . '-' : '200-';
        }

        $lastNumber = ToolsInformation::withTrashed()
            ->where('serialNumber', 'like', $prefix . '%')
            ->select(DB::raw("MAX(CAST(SUBSTRING(serialNumber, ".(strlen($prefix)+1).") AS UNSIGNED)) as max_number"))
            ->value('max_number');

        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;
        $serial = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        while (ToolsInformation::withTrashed()->where('serialNumber', $serial)->exists()) {
            $nextNumber++;
            $serial = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        return $serial;
    }

    /**
     * تبدیل ارقام فارسی/عربی به انگلیسی
     */
    private function faDigitsToEn(string $value): string
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
        return str_replace($persian, $english, $value);
    }

    /**
     * پارس امن تاریخ جلالی -> Carbon
     * فرمت ورودی مورد انتظار: Y/m/d یا Y-m-d یا Y.m.d و می‌تواند ارقام فارسی داشته باشد.
     * برمی‌گرداند: Carbon object یا پرتاب Exception اگر نامعتبر باشد.
     */
    private function parseJalaliToCarbon(?string $jalali): ?Carbon
    {
        if (empty($jalali)) return null;

        $raw = trim($jalali);
        // تبدیل ارقام فارسی به لاتین
        $raw = $this->faDigitsToEn($raw);
        // یکسان‌سازی جداکننده‌ها
        $raw = str_replace(['.', '-',' '], '/', $raw);

        // اگر فرمت yyyy/m/d است، از Jalalian::fromFormat استفاده کن
        // برخی ورودی‌ها ممکن است روز/ماه تک رقمی باشند که ازFormat پشتیبانی می‌کند
        try {
            // اگر ورودی دقیقا 10 کاراکتر مثل 1402/05/10 یا 2023/.. باشد
            // سعی می‌کنیم با Y/m/d پارس کنیم
            $carbon = Jalalian::fromFormat('Y/m/d', $raw)->toCarbon();
            return $carbon;
        } catch (\Throwable $e) {
            // ممکن است کاربر فرمت متفاوتی داده باشد، تلاش برای parse با Carbon به‌عنوان fallback
            try {
                return Carbon::parse($raw);
            } catch (\Throwable $ex) {
                // ناتوان از پارس کردن
                throw new \InvalidArgumentException('Invalid jalali date: ' . $raw);
            }
        }
    }

    public function save()
    {
        // اعتبارسنجی اولیه: تاریخ‌ها به صورت رشته‌های جلالی قابل قبول (با ارقام فارسی یا لاتین)
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
            'serialNumber' => 'required|string|max:255|unique:toolsinformations,serialNumber,' . $this->toolId,
            'count' => 'required|integer|min:1',
            'model' => 'required|string|max:255',
            'Receiver' => 'required|string|max:25',
            'content' => 'nullable|string',
            'category' => 'required',
            'TypeOfConsumption' => 'required|string',
            'Weight' => 'required|string',
            'size' => 'required|string|max:255',
            'price' => 'required|numeric',
            'color' => 'required|string|max:255',
            'dateOfSale' => ['required', 'regex:/^[0-9۰-۹]{4}[\/\-\.\s][0-9۰-۹]{1,2}[\/\-\.\s][0-9۰-۹]{1,2}$/u'],
            'dateOfexp' => ['required', 'regex:/^[0-9۰-۹]{4}[\/\-\.\s][0-9۰-۹]{1,2}[\/\-\.\s][0-9۰-۹]{1,2}$/u'],
            'storage_id' => 'required|exists:storages,id',
            'attach' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'dateOfSale.regex' => 'فرمت تاریخ تولید معتبر نیست (مثال: 1402/05/10).',
            'dateOfexp.regex' => 'فرمت تاریخ انقضا معتبر نیست (مثال: 1402/12/01).',
        ]);

        // تبدیل جلالی -> Carbon (میلادی)
        try {
            $saleCarbon = $this->parseJalaliToCarbon($this->dateOfSale);
        } catch (\Throwable $e) {
            $this->addError('dateOfSale', 'تاریخ تولید نامعتبر است.');
            return;
        }

        try {
            $expCarbon = $this->parseJalaliToCarbon($this->dateOfexp);
        } catch (\Throwable $e) {
            $this->addError('dateOfexp', 'تاریخ انقضا نامعتبر است.');
            return;
        }

        // ایجاد ToolsInformation
        $info = ToolsInformation::create([
            'name' => $this->name,
            'serialNumber' => $this->serialNumber
        ]);

        // ذخیره فایل اگر آپلود شده
        $fileName = null;
        if ($this->attach) {
            $randomNumber = rand(1000, 9999);
            $currentTime = now()->format('YmdHis');
            $fileName = $randomNumber . '_' . $currentTime . '.' . $this->attach->getClientOriginalExtension();
            $this->attach->storeAs('tools', $fileName, 'public');
        }

        if (empty($this->StorageLocation)) {
            $this->StorageLocation = optional(Storage::find($this->storage_id))->name;
        }

        // ذخیره جزئیات؛ تاریخ‌ها را به فرمت ISO میلادی ذخیره می‌کنیم
        $details = $info->details()->create([
            'storage_id'       => $this->storage_id,
            'category'         => $this->category,
            'companynumber'    => $this->companynumber,
            'count'            => $this->count,
            'status'           => $this->status,
            'model'            => $this->model,
            'Weight'           => $this->Weight,
            'Receiver'         => $this->Receiver,
            'TypeOfConsumption'=> $this->TypeOfConsumption,
            'size'             => $this->size,
            'price'            => $this->price,
            'StorageLocation'  => $this->StorageLocation,
            'color'            => $this->color,
            'dateOfSale'       => $saleCarbon->format('Y-m-d'),
            'dateOfexp'        => $expCarbon->format('Y-m-d'),
            'content'          => $this->content,
            'attach'           => $fileName,
        ]);

        // ایجاد اولین لوکیشن
        $info->locations()->create([
            'location' => $this->StorageLocation,
            'Receiver' => $this->Receiver,
            'moved_at' => now(),
            'status' =>  $this->status,
        ]);

        // لاگ اکتیویتی
        $this->logActivity('create', $details, "ابزار جدید ایجاد شد: {$details->model}");

        // ریست فرم و بارگذاری مجدد
        $this->resetForm();
        $this->loadTools();

        return redirect()->route('admin.tools')->with('success', 'ابزار جدید با موفقیت ثبت شد ✅');
    }

    public function resetForm()
    {
        $this->reset([
            'toolId', 'name', 'serialNumber', 'category', 'count', 'model',
            'Weight', 'TypeOfConsumption', 'size', 'price',
            'color', 'dateOfSale', 'dateOfexp', 'content', 'isEdit', 'Receiver',
            'status', 'attach', 'storage_id', 'StorageLocation', 'companynumber'
        ]);
    }

    /**
     * نمونه متد برای بارگذاری اطلاعات جهت ویرایش (اختیاری)
     */
    public function edit($detailId)
    {
        $detail = \App\Models\ToolsDetail::findOrFail($detailId);

        $this->isEdit = true;
        $this->toolId = $detail->tools_information_id;
        $this->name = optional($detail->tool)->name ?? null;
        $this->serialNumber = optional($detail->tool)->serialNumber ?? null;
        $this->category = $detail->category;
        $this->companynumber = $detail->companynumber;
        $this->count = $detail->count;
        $this->model = $detail->model;
        $this->Weight = $detail->Weight;
        $this->TypeOfConsumption = $detail->TypeOfConsumption;
        $this->size = $detail->size;
        $this->price = $detail->price;
        $this->color = $detail->color;
        $this->Receiver = $detail->Receiver;
        $this->status = $detail->status;
        $this->storage_id = $detail->storage_id;
        $this->StorageLocation = $detail->StorageLocation;

        // تبدیل میلادی -> جلالی برای نمایش در input
        $this->dateOfSale = $detail->dateOfSale
            ? Jalalian::fromDateTime($detail->dateOfSale)->format('Y/m/d')
            : null;

        $this->dateOfexp = $detail->dateOfexp
            ? Jalalian::fromDateTime($detail->dateOfexp)->format('Y/m/d')
            : null;
    }

    public function render()
    {
        return view('livewire.admin.crud-tools.create', [
            'storages' => $this->storages,
            'toolActivities' => $this->toolActivities,
        ]);
    }
}

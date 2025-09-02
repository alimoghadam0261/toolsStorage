<div class="dashboard-admin" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10" dir="rtl">
                @livewire('component.admin.topmenu')
                <hr>
                <div class="widgets-admin">
                    <div class="box-widget-admin" style="background: #ddf0f8; transform: translateY(1em)">
                        <a href="{{route('admin.tools.create')}}">
                            <br>

                            <h5 style="transform: translateY(-.5em)">
                                ثبت ابزار جدید
                            </h5>

                        </a></div>

                </div>


                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                    </div>
                @endif
                <br>
                <div class="search-storage-admin" dir="rtl">
                    <input
                        type="text"
                        placeholder="جستجو : نام ابزار یا شماره ابزار را وارد نمایید"
                        class="form-control"
                        wire:model.live="searchTerm"
                    >
                </div>
                <br>
                <div class="show-storage-admin">

                    <div class="col-md-12">
                        <div class="box-storage-admin">
                            <div class="row test-storage-info">
                                <div class="col-md-2" style="margin-top:1.5em;">

                                    <span
                                        style="font-weight: bold"
                                    >مجموع ابزار آلات : {{ $count }}</span>

                                </div>

                                <div class="col-md-8 export-tools-page text-center">

                                    <div class="row mb-3" dir="rtl">
                                        <div class="col-md-3">
                                            <label>از تاریخ</label>
                                            <input data-jdp
                                                   data-jdp-only-date="true" class="form-control-sm"
                                                   wire:model.defer="date_from">
                                        </div>
                                        <div class="col-md-3">
                                            <label>تا تاریخ</label>
                                            <input data-jdp
                                                   data-jdp-only-date="true"

                                                   class="form-control-sm" wire:model.defer="date_to">
                                        </div>
                                        <div class="col-md-3" style="transform: translate(3em ,.2em)">
                                            <label>نوع خروجی</label><br>
                                            <select class="form-select-sm" wire:model="exportFormat">
                                                <option value="pdf">PDF</option>
                                                <option value="excel">Excel</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-start  ">
                                            <button
                                                style="transform: translate(4em ,1.7em)"
                                                wire:click="export" class="btn btn-info btn-sm">دانلود
                                            </button>
                                        </div>
                                    </div>

                                    <script>
                                        window.addEventListener('open-export-url', function (e) {
                                            const url = e.detail.url;
                                            // باز کردن در تب جدید
                                            window.open(url, '_blank');
                                        });
                                    </script>


                                </div>

                                <div class="col-md-2 sort-tools-page">


                                    <label for="">فیلتر بر اساس</label><br>

                                    <select wire:model.live="sortBy" class="form-select-sm" name="" id="">
                                        <option value="date">تاریخ</option>
                                        <option value="count">تعداد</option>
                                        <option value="price">قیمت</option>
                                    </select>


                                </div>


                            </div>
                            <br>
                            <table class="table table-bordered table-hover text-center" style="justify-content: center">
                                <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>نام</th>
                                    <th>سریال</th>
                                    <th>سریال1</th>
                                    <th>تعداد</th>
                                    <th>تحویل گیرنده</th>
                                    <th>قیمت</th>
                                    <th>QR</th>
                                    <th>تاریخ</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tools as $index => $tool)

                                    @php
                                        $toolCount = $tool->details->count ?? 0; // اگر details تهی بود میشه 0
                                        $bgColor = '';
                                        if($toolCount < 10) {
                                            $bgColor = 'background:red;
                                              animation: 2s alarm linear infinite;';
                                        } elseif($toolCount < 20) {
                                            $bgColor = 'background:#f4f474;';
                                        }
                                    @endphp


                                    <tr style="cursor:pointer;" wire:click="goToShow({{ $tool->id }})">
                                        <td>{{ $index+1 }}</td>
                                        <td>
                                            @if($tool->details && $tool->details->attach)
                                                <img loading="lazy" src="{{ asset('storage/tools/' . $tool->details->attach) }}"
                                                     width="50" alt="{{ $tool->name }}"/>
                                            @else
                                                <img src="{{ asset('img/default.png') }}" width="50"
                                                     alt="{{ $tool->name }}"/>
                                            @endif
                                        </td>


                                        <td {{ trim($tool->name) == "انبار مرکزی" ? 'style="background:green"' : 'style="background:none"' }}>
                                            {{ $tool->name }}
                                        </td>

                                        <td>{{ $tool->serialNumber }}</td>
                                        <td>{{ $tool->details->companynumber?? 'ثبت نشده'}}</td>
                                        <td style="{{ $bgColor }}">{{ $tool->details->count ?? '-' }}</td>

                                        <td>{{ $tool->details->	Receiver ?? '-' }}</td>
                                        <td>{{ $tool->details->price ?? '-' }}</td>
                                        <td>
                                            <div wire:ignore class="qrcode-holder" id="qrcode-{{ $tool->id }}"
                                                 data-qrcode-url="{{ route('admin.tools.show', $tool->id) }}"
                                                 style="width:90px; height:90px; display:flex; align-items:center; justify-content:center;">
                                                <!-- QR اینجا توسط JS ساخته می‌شود -->
                                            </div>

                                            <!-- دکمه دانلود (اختیاری) -->
                                            <div style="margin-top:5px; text-align:center;">
                                                <a href="#" class="btn btn-sm btn-outline-secondary download-qr"
                                                   data-target="#qrcode-{{ $tool->id }}"
                                                   onclick="event.stopPropagation(); return false;">
                                                    دانلود
                                                </a>
                                            </div>
                                        </td>


                                        <td>
                                            @if($tool->details && $tool->details->created_at)
                                                {{ jDate($tool->details->created_at)->format('Y/m/d') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="text-center">

                                            <a href="{{ route('admin.result.tools', $tool->id) }}"
                                               onclick="event.stopPropagation()">
                                                <button class="btn btn-sm btn-info">گزارش</button>
                                            </a>

                                            <a href="{{route('admin.tools.edit',$tool->id)}}"
                                               onclick="event.stopPropagation()">
                                                <button class="btn btn-sm btn-warning">ویرایش</button>
                                            </a>


                                            <button wire:click.stop="delete({{ $tool->id }})"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="event.stopPropagation(); return confirm('آیا مطمئن هستید؟')">
                                                حذف
                                            </button>
                                        </td>

                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-4 pagination pagination-sm">
                                {{ $tools->links() }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-2">
                @livewire('component.admin.sidebar')
            </div>
        </div>
    </div>
    <!-- qrious: کتابخانه سبک که canvas تولید می‌کند -->
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>--}}
    <script src="{{asset('./js/qrcode.js')}}"></script>

    <!-- robust QR script: load qrious if needed, build QR after DOM/livewire/mutations -->
    <!-- qrious: کتابخانه سبک که canvas تولید می‌کند -->
    <script>
        (function () {
            // مسیر درست فایل JS با استفاده از لاراول
            const QRIousCDN = "{{ asset('js/qrcode.js') }}";

            let qriousLoading = false;
            let qriousLoaded = !!window.QRious;

            // تابع لود QRious در صورت نیاز
            function loadQriousIfNeeded(callback) {
                if (window.QRious) {
                    qriousLoaded = true;
                    return callback && callback();
                }
                if (qriousLoading) {
                    const i = setInterval(() => {
                        if (window.QRious) {
                            clearInterval(i);
                            qriousLoaded = true;
                            callback && callback();
                        }
                    }, 150);
                    return;
                }
                qriousLoading = true;
                const s = document.createElement('script');
                s.src = QRIousCDN;
                s.async = true;
                s.onload = function () {
                    qriousLoaded = true;
                    qriousLoading = false;
                    console.log('[QR] qrious loaded.');
                    callback && callback();
                };
                s.onerror = function (e) {
                    qriousLoading = false;
                    console.error('[QR] failed to load qrious from', QRIousCDN, e);
                };
                document.head.appendChild(s);
            }

            // ایجاد QR برای یک المان
            function generateSingle(holder) {
                if (!holder) return;
                if (holder.dataset.qrGenerated === "1") return;

                holder.innerHTML = '';
                const url = holder.getAttribute('data-qrcode-url') || window.location.href;
                const size = parseInt(holder.getAttribute('data-qrcode-size') || '90', 10);
                const canvas = document.createElement('canvas');
                canvas.width = size;
                canvas.height = size;
                holder.appendChild(canvas);

                if (!window.QRious) {
                    loadQriousIfNeeded(() => {
                        generateSingle(holder);
                    });
                    return;
                }

                new QRious({
                    element: canvas,
                    value: url,
                    size: size,
                    level: 'H'
                });

                holder.dataset.qrGenerated = "1";
            }

            // ایجاد QR برای همه المان‌ها
            function generateAll() {
                const holders = Array.from(document.querySelectorAll('.qrcode-holder'));
                if (!holders.length) return;

                if (!window.QRious) {
                    loadQriousIfNeeded(() => {
                        holders.forEach(generateSingle);
                    });
                    return;
                }

                holders.forEach(generateSingle);
            }

            // فعال کردن دکمه‌های دانلود QR
            function initQRDownloadButtons() {
                document.querySelectorAll('.download-qr').forEach(btn => {
                    if (btn.dataset.bound === "1") return;
                    btn.dataset.bound = "1";

                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();

                        const target = btn.getAttribute('data-target');
                        if (!target) return;

                        const holder = document.querySelector(target);
                        if (!holder) {
                            alert('کانتینر QR پیدا نشد.');
                            return;
                        }

                        const canvas = holder.querySelector('canvas');
                        if (!canvas) {
                            alert('QR هنوز ساخته نشده است. لطفاً چند لحظه صبر کنید یا صفحه را رفرش کنید.');
                            return;
                        }

                        try {
                            const dataUrl = canvas.toDataURL('image/png');
                            const link = document.createElement('a');
                            const id = (holder.id || '').replace('qrcode-', '') || Date.now();
                            link.href = dataUrl;
                            link.download = 'qr-' + id + '-' + Date.now() + '.png';
                            document.body.appendChild(link);
                            link.click();
                            link.remove();
                        } catch (err) {
                            console.error('[QR] download error', err);
                            alert('خطا در دانلود QR — کنسول را بررسی کنید.');
                        }
                    });
                });
            }

            // ناظر DOM برای Livewire یا المان‌های جدید
            const observer = new MutationObserver(() => {
                document.querySelectorAll('.qrcode-holder').forEach(h => {
                    if (!h.dataset.qrGenerated) h.dataset.qrGenerated = "0";
                });
                setTimeout(() => {
                    generateAll();
                    initQRDownloadButtons();
                }, 120);
            });

            // شروع‌کننده
            function boot() {
                loadQriousIfNeeded(() => {
                    generateAll();
                    initQRDownloadButtons();
                });

                // هماهنگ با Livewire
                if (window.Livewire && typeof Livewire.hook === 'function') {
                    Livewire.hook('message.processed', () => {
                        document.querySelectorAll('.qrcode-holder').forEach(h => h.dataset.qrGenerated = "0");
                        setTimeout(() => {
                            generateAll();
                            initQRDownloadButtons();
                        }, 80);
                    });

                    document.addEventListener('livewire:load', () => {
                        setTimeout(() => {
                            generateAll();
                            initQRDownloadButtons();
                        }, 60);
                    });
                } else {
                    document.addEventListener('DOMContentLoaded', () => {
                        setTimeout(() => {
                            generateAll();
                            initQRDownloadButtons();
                        }, 60);
                    });
                    window.addEventListener('load', () => {
                        setTimeout(() => {
                            generateAll();
                            initQRDownloadButtons();
                        }, 60);
                    });
                }

                try {
                    observer.observe(document.body, {childList: true, subtree: true});
                } catch (e) {
                    console.warn('[QR] MutationObserver not supported', e);
                }
            }

            boot();

            // دسترسی دستی برای debug
            window._qr_generateAll = generateAll;
            window._qr_initDownloads = initQRDownloadButtons;

        })();
    </script>


</div>

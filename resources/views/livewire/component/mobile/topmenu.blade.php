<div dir="rtl">
    <div class="container-fluid topMenuMobile">
        <div class="row">

            <div class="col-6 " style="text-align: right;font-size:.7em;transform: translateY(.5em)" id="datetime" ></div>

            <div class="col-6" dir="ltr">
                <a href="{{route('logout')}}"><button class="btn btn-danger btn-sm exit-sidebar-component">خروج</button></a>
                <i class="fa fa-envelope"></i>

            </div>
        </div>
    </div>
</div>
<script>

        function updateDateTime() {
        const now = new Date();

        // گرفتن ساعت و دقیقه و ثانیه
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        // seconds = seconds < 10 ? "0" + seconds : seconds;

        // گرفتن تاریخ شمسی با Intl
        const options = { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' };
        const persianDate = new Intl.DateTimeFormat('fa-IR', options).format(now);

        // نمایش
        document.getElementById("datetime").innerHTML = `${persianDate} - ${hours}:${minutes}`;
    }

        // اجرای اولیه
        updateDateTime();

        // بروزرسانی هر 1 ثانیه
        setInterval(updateDateTime, 10000);



</script>

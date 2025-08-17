<div class="topmenu-component p-1">
  <div class="container ">
      <div class="row">
          <div class="col-md-4" style="text-align: right" id="datetime1" ></div>

          <div class="col-md-4"><p>شعار سال : سرمایه‌گذاری برای تولید</p></div>
          <div class="col-md-4">
              <div class="row ">

                  <div class="col-md-12" style="text-align: left"><i id="darkModeToggle" class="fa fa-moon"></i><a href="{{route('logout')}}"><button class="btn btn-danger btn-sm exit-sidebar-component">خروج</button></a></div>

              </div>
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
        document.getElementById("datetime1").innerHTML = `${persianDate} - ${hours}:${minutes}`;
    }

    // اجرای اولیه
    updateDateTime();

    // بروزرسانی هر 1 ثانیه
    setInterval(updateDateTime, 10000);





    document.getElementById('darkModeToggle').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');

        // ذخیره وضعیت در localStorage برای حفظ حالت بعد از رفرش
        if(document.body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.removeItem('darkMode');
        }
    });

    // بارگذاری حالت ذخیره شده
    if(localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
    }



</script>



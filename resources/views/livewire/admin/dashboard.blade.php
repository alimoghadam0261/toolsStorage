<div class="dashboard-admin">
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-10">
              @livewire('component.admin.topmenu')
              <hr>
              <br>
              <div class="widgets-admin">
                  <div class="box-widget-admin">
                      <h6>مجموع ابزارآلات ثبت شده</h6>
                      <p>{{$countTools}}</p>
                  </div>
                  <div class="box-widget-admin">
                      <h6>مجموع جم ثبت شده </h6>
                      <p>{{$countJam}}</p>
                  </div>
                  <div class="box-widget-admin">
                      <h6>مجموع تعداد ابزار خارج از انبار</h6>
                      <p>1234</p>
                  </div>
                  <div class="box-widget-admin">
                      <h6>مجموع جم خارج از انبار</h6>
                      <p>1234</p>
                  </div>
              </div>
              <br>
              <div class="info-admin">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="table-dashboard-admin">
                              @livewire('component.admin.chart')
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="table-dashboard-admin">
                              @livewire('component.admin.chartline')
                          </div>
                      </div>
                  </div>
              </div>


              <br>

          </div>
          <div class="ticker-wrap-dashboard">
              <span class="text-right" dir="rtl">ابزار های در حال کاهش :</span>
              <div class="ticker-dashboard">
                  @foreach($lowTools as $item)
                      <div class="ticker-item-dashboard">
                          {{ $item->information->name }} (تعداد: {{ $item->count }})
                      </div>
                  @endforeach

                  {{-- 👇 تکرار مجدد برای ایجاد لوپ نرم --}}
                  @foreach($lowTools as $item)
                      <div class="ticker-item-dashboard">
                          {{ $item->information->name }} (تعداد: {{ $item->count }})
                      </div>
                  @endforeach
              </div>
          </div>

          <div class="col-md-2">
              @livewire('component.admin.sidebar')
          </div>
      </div>
  </div>
</div>

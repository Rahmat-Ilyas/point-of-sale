<div class="row">
  <div class="col-sm-12">
    <h4 class="page-title">Point of Sale</h4>
    <p class="text-muted page-title-alt">Selamat datag di Aplikasi Point of Sale</p>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card-box">
      <h4 class="text-dark header-title m-t-0">Sales Analytics</h4>
      <div class="text-center">
        <ul class="list-inline chart-detail-list">
          <li>
            <h5><i class="fa fa-circle m-r-5" style="color: #5fbeaa;"></i>Desktops</h5>
          </li>
          <li>
            <h5><i class="fa fa-circle m-r-5" style="color: #5d9cec;"></i>Tablets</h5>
          </li>
          <li>
            <h5><i class="fa fa-circle m-r-5" style="color: #dcdcdc;"></i>Mobiles</h5>
          </li>
        </ul>
      </div>
      <div id="morris-bar-stacked" style="height: 310px;"></div>
    </div>
  </div>
</div>

<script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
<script src="assets/plugins/counterup/jquery.counterup.min.js"></script>

<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>

<script src="assets/plugins/jquery-knob/jquery.knob.js"></script>

<script src="assets/pages/jquery.dashboard.js"></script>

<script>
  $(document).ready(function() {
   $('.counter').counterUp({
     delay: 100,
     time: 1200
   });

   $(".knob").knob();
 });
</script>
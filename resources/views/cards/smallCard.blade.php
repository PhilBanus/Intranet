<?php
use Carbon\Carbon;
$Query = DB::table($Table)->distinct($Distinct)->whereDate($Where, '=', Carbon::$Date()->toDateString())->count();


	?>
<!-- Card -->
<div class="card card-cascade wider">

  <!-- Card image -->
  <div class="view view-cascade gradient-card-header {{$Css ?? ''}}">

    <!-- Title -->
    <h2 class="card-header-title mb-3">{{$Title}}</h2>
    <!-- Text -->
    <p class="mb-0"><i class="fas fa-calendar mr-2"></i><?php echo $Query ?></p>

  </div>

  <!-- Card content -->
  
  <!-- Card content -->

</div>
<!-- Card -->
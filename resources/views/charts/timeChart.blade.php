
          



<div class="card">
		  <div class="card-header">
			  {{ $title }}
			  			  </div>
		  <div class="card-body">
			  
			<canvas id="{{$ID}}"></canvas>
			  </div>
		  </div>


<?php
$Label = '';


$Query = DB::table($Table)
	->select(DB::raw('CAST('.$Column.' as DATE) as Time'), DB::raw("(COUNT(*)) as count"))
                     
                     ->groupBy(DB::raw('CAST('.$Column.' as DATE)'))
	
	->get();
                   
	
foreach ($Query as $Result) {
	$Label .= '{x: moment("'.$Result->Time.'"), y:'.floatval($Result->count).'},';

  
}



?>
<script>
$(document).ready(function(){
	console.log(<?php echo "[$Label]" ?>)
	var ctxSc = document.getElementById("{{$ID}}").getContext('2d');
var scatterData = {
datasets: [{
borderColor: 'rgba(99,0,125, .2)',
backgroundColor: 'rgba(99,0,125, .5)',
label: 'Login Count',
data: <?php echo "[$Label]" ?>
}]
}

var config1 = new Chart.Scatter(ctxSc, {
		       type: 'bar',
data: scatterData,
		
options: {
         scales: {
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'month'
                }
            }]
        }
    }
});
	
	
});
	
</script>
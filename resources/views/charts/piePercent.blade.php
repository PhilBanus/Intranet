
          



<div class="card">
		  <div class="card-header">
			  {{ $title }}
			  			  </div>
		  <div class="card-body">
			  
			<canvas id="{{$ID}}"></canvas>
			  </div>
		  </div>


<?php
$Label = [];
$Count = [];

$Query = DB::table($Table)
	->select(DB::raw('count(*) as count, '.$Column ))
	->groupBy($Column)
    ->get();;
	
foreach ($Query as $Result) {
	array_push($Label, $Result->$Column);
	array_push($Count, floatval($Result->count));
  
}


	$Label = json_encode($Label);
	$Count = json_encode($Count);

?>
<script>
$(document).ready(function(){
	
	var ctxP = document.getElementById("{{$ID}}").getContext('2d');
var myPieChart = new Chart(ctxP, {
  plugins: [ChartDataLabels],
  type: 'pie',
  padding: 10,
  data: {
    labels: <?php echo $Label; ?>,
    datasets: [{
      data: {{$Count}},
      backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#FF7D40","#A2C93A","#FFCC11","#8282ff","#a64dff"],
      hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
    }]
  },
  options: {
    responsive: true,
						   layout: { padding: 20 },
						    maintainAspectRatio: true,	 aspectRatio: 1,			 
    legend: {
      position: 'bottom',
      labels: {
        padding: 20,
        boxWidth: 10
      }
    },
    plugins: {
      datalabels: {
        formatter: function(value, ctx) {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map( function(data) {
            sum += data;
          });
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#024a94',
		anchor: 'end',
			align: 'end',
			offset: 4,
        labels: {
          title: {
            font: {
              size: '12'
            }
          }
        }
      }
    }
  }
});
});
	
</script>
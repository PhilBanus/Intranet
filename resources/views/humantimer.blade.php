<?php 

function humanTiming($start, $end)
{
$elapsed = "-";
	$enddate = !$end ? new DateTime($end) : new DateTime();
$startdate = new DateTime($start);
$interval = $startdate->diff($enddate);
	
	 if($interval->format('%s') != 0){ if($interval->format('%s') > 1){ $elapsed = $interval->format('%s seconds'); } else {$elapsed = $interval->format('%s second'); }};
	 if($interval->format('%i') != 0){ if($interval->format('%i') > 1){ $elapsed = $interval->format('%i minutes'); } else {$elapsed = $interval->format('%i minute'); }};
	 if($interval->format('%h') != 0){ if($interval->format('%h') > 1){ $elapsed = $interval->format('%h hours'); } else {$elapsed = $interval->format('%h hour'); }};
	 if($interval->format('%a') != 0){ if($interval->format('%a') > 1){ $elapsed = $interval->format('%a days'); } else {$elapsed = $interval->format('%a day'); }};
	 if($interval->format('%m') != 0){ if($interval->format('%m') > 1){ $elapsed = $interval->format('%m months'); } else {$elapsed = $interval->format('%m month'); }};
	 if($interval->format('%y') != 0){ if($interval->format('%y') > 1){ $elapsed = $interval->format('%y years'); } else {$elapsed = $interval->format('%y year'); }};
	



return $elapsed;
	


	
}

?>
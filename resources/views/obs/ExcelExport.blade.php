<?php


use Carbon\Carbon; 
 use Carbon\CarbonInterface; 
$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$OccurancesFilt = [];
array_push($OccurancesFilt,array('Site','=',$_GET['code']));

if($_GET['CloseCalls'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',1));
}
if($_GET['GoodPractice'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',2));
}
if($_GET['Incidents'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',3));
}
if($_GET['Accident'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',4));
}
if($_GET['Innovation'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',5));
}
if($_GET['Open'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',1));
}
if($_GET['Closed'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',0));
}
if($_GET['Time'] === 'Week'){
	array_push($OccurancesFilt,array('Reported_Date','>',$now->subWeek()));
}
if($_GET['Time'] === 'Month'){
	array_push($OccurancesFilt,array('Reported_Date','>',$now->subMonth()));
}
if($_GET['Time'] === 'Year'){
	array_push($OccurancesFilt,array('Reported_Date','>',$now->subYear()));
}
$DateDiff = 32;
if($_GET['Time'] === 'Range'){
		if(isset($_GET['fromRange'])) {
  array_push($OccurancesFilt,array('Reported_Date','>',Carbon::create(urldecode($_GET['fromRange']))));
		$DateDiff = Carbon::create($_GET['fromRange'])->diffInDays($now);
}
	
	if(isset($_GET['toRange'])) {
  array_push($OccurancesFilt,array('Reported_Date','<',Carbon::create(urldecode($_GET['toRange']))));
		$DateDiff = Carbon::create($_GET['toRange'])->diffInDays($now);
}
	
	if( isset($_GET['fromRange']) && isset($_GET['toRange']) ){
		$DateDiff = Carbon::create($_GET['fromRange'])->diffInDays($_GET['toRange']);
	}
	
}

if($_GET['code'] == 0){
	$data = DB::table('UKHT_Occurance_Close_Call as OC')->where($OccurancesFilt)->orderby('Reported_Date','desc')
	->join('UKHT_Occurance as O','Occurance','O.ID')
	
	->select(
	'O.Name as "Occurance Type"',
	DB::raw("'HUKOCC'+cast(OC.ID as varchar(50)) as 'Unique ID'"),
	DB::raw('CAST(OC.Date as Date) as "Event Date"'),
	DB::raw('CAST(OC.Date as Time) as "Event Time"'),
	DB::raw("UPPER('Head Office') as 'Involved Location'"),
	'Details as "Describe the Event and What Could have Happened"',
	'Actions_Taken_Site as "What ere you able to do about it"',
	'Actions_Taken_HSQE as "HSQE Actions"',
	'Risk_Prevented as "Risk Ranking"',
	DB::raw("UPPER(Category + '/' + Sub) as Category")

)
	->get();
}else{
	$data = DB::table('UKHT_Occurance_Close_Call as OC')->where($OccurancesFilt)->orderby('Reported_Date','desc')
	->join('Project as P','Site','Project_ID')
	->join('UKHT_Occurance as O','Occurance','O.ID')
	->select(
	'O.Name as "Occurance Type"',
	DB::raw("'HUKOCC'+cast(OC.ID as varchar(50)) as 'Unique ID'"),
	DB::raw('CAST(OC.Date as Date) as "Event Date"'),
	DB::raw('CAST(OC.Date as Time) as "Event Time"'),
	DB::raw('UPPER(P.Name) as "Involved Project"'),
	'Details as "Describe the Event and What Could have Happened"',
	'Actions_Taken_Site as "What ere you able to do about it"',
	'Actions_Taken_HSQE as "HSQE Actions"',
	'Risk_Prevented as "Risk Ranking"',
	DB::raw("UPPER(Category + '/' + Sub) as Category")

)
	->get();
}



$data = json_decode(json_encode($data), true);

 
  function cleanData(&$str)
  {
	  $str = urldecode($str);
	 
    // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';

    // force certain number/date formats to be imported as strings
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "$str";
    }

    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	  
	    $str = mb_convert_encoding($str, 'UTF-16LE', 'UTF-8');
	  
  }

  // file name for download
  $filename = "Occurance_Export" . date('dMYhms') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel; charset=UTF-16LE");

  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }






?>




<?php
header ('Content-Type: application/json');
use Carbon\Carbon;
	ob_end_clean(); // this
		 ob_start(); 
if($_POST['Type'] === "GETID"){
	$arr =  DB::select('select newid()', [1]);
	

		foreach($arr as $val){
		foreach($val as $al){
		 ob_end_clean(); // this
		 ob_start(); 
		echo $al;
		ob_end_flush();
		} }
	;
} 


if($_POST['Type'] === "AutoSave"){
	
	if(!$_POST['Date']){
		DB::table('UKHT_Overtime_Items')->updateOrInsert(
		['Global_ID' => $_POST['globalid']],	
		['Global_ID' => $_POST['globalid'], 'Project' => $_POST['Project'], 'Contact' => $_POST['Contact'], 'Start_Time' => $_POST['STime'], 'End_Time' => $_POST['ETime'], 'Hours' => $_POST['Hours'], 'Time_Of_Day' =>$_POST['TimeOFDay'], 'Description' => $_POST['Description'] ]
	);
	}else{
		$Date = carbon::create($_POST['Date']);
		DB::table('UKHT_Overtime_Items')->updateOrInsert(
		['Global_ID' => $_POST['globalid']],	
		['Global_ID' => $_POST['globalid'], 'Project' => $_POST['Project'], 'Contact' => $_POST['Contact'], 'Date' => $Date, 'Start_Time' => $_POST['STime'], 'End_Time' => $_POST['ETime'], 'Hours' => $_POST['Hours'], 'Time_Of_Day' =>$_POST['TimeOFDay'], 'Description' => $_POST['Description'] ]
	);
	};
	
	
	
	ob_end_clean(); // this
		 ob_start(); 
		echo $_POST['globalid']." - Updated";
		ob_end_flush();
	
}

if($_POST['Type'] === "GetDisabled" ){
	
	$Dates = DB::table('UKHT_Overtime_Items')->where('Contact', $_POST['Contact'])->where('Removed', 0)->whereNotNull('Date')->get();
	$array = array();
	foreach($Dates as $Date){
	 	array_push($array,array("".intval(carbon::create($Date->Date)->format('Y')).",".(intval(carbon::create($Date->Date)->format('n'))-1).",".intval(carbon::create($Date->Date)->format('d')).""));
	}
	
	
	ob_end_clean(); // this
	ob_start(); 
	echo json_encode($array);
	ob_end_flush();
}

if($_POST['Type'] === "DELETE"){
	
	DB::table('UKHT_Overtime_Items')->where('Global_ID', $_POST['globalid'])->delete();
	
}
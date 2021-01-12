<?php

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
		['Global_ID' => $_POST['globalid'], 'Project' => $_POST['Project'], 'Contact' => $_POST['Contact'], 'Start_Time' => $_POST['STime'], 'End_Time' => $_POST['ETime'], 'Hours' => $_POST['Hours'], 'Time_Of_Day' =>$_POST['TimeOFDay'], 'Description' => base64_encode($_POST['Description']) ]
	);
	}else{
		$Date = carbon::create($_POST['Date']);
		DB::table('UKHT_Overtime_Items')->updateOrInsert(
		['Global_ID' => $_POST['globalid']],	
		['Global_ID' => $_POST['globalid'], 'Project' => $_POST['Project'], 'Contact' => $_POST['Contact'], 'Date' => $Date, 'Start_Time' => $_POST['STime'], 'End_Time' => $_POST['ETime'], 'Hours' => $_POST['Hours'], 'Time_Of_Day' =>$_POST['TimeOFDay'], 'Description' =>base64_encode($_POST['Description']) ]
	);
	};
	
	
	
	ob_end_clean(); // this
		 ob_start(); 
		echo $_POST['globalid']." - Updated";
		ob_end_flush();
	
}

if($_POST['Type'] === "GetDisabled" ){
	
	$Dates = DB::table('UKHT_Overtime_Items')->where('Contact', $_POST['Contact'])->where('Removed', 0)->whereNotNull('Date')->where('Global_ID','!=',$_POST['GlobalID'])->get();
	$array = array();
	foreach($Dates as $Date){
		$year = (intval(carbon::create($Date->Date)->format('Y')));
		$month = ((intval(carbon::create($Date->Date)->format('n'))-1));
		$day = (intval(carbon::create($Date->Date)->format('d')));
		
		$arr = array($year, $month, $day);
	 	array_push($array, $arr);
	}
	
	
	
	header ('Content-Type: application/json');
	echo json_encode($array);
 exit();
}

if($_POST['Type'] === "DELETE"){
	
	DB::table('UKHT_Overtime_Items')->where('Global_ID', $_POST['globalid'])->delete();
	
}

if($_POST['Type'] === 'SUBMIT'){
	
    $Items = DB::table('UKHT_Overtime_Items')->where(['Contact' => $_POST['Contact'], 'Submitted' => 0])->get(); 
    
    
    foreach($Items as $Item){
        
        $PM = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
        
        DB::table('UKHT_Overtime_Items')->where(['Global_ID' => $Item->Global_ID, 'Submitted' => 0])->update(
	[ 'PM' => $PM->Contact_ID ]);
    };
    
    $Line = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $_POST['Contact'], 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
    
	DB::table('UKHT_Overtime_Items')->where(['Contact' => $_POST['Contact'], 'Submitted' => 0])->update(
	[ 'Submitted' => 1, 'Submitted_Date' => carbon::now(), 'Submitted_Month' => $_POST['SubmitMonth'], 'LineManager' => $Line->Contact_ID ]);
	
}
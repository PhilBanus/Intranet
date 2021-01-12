<?php 

if($_POST['mode'] == 1){
	
	
	$DATE = $_POST['Date'];
	$WHERE = $_POST['Where'];
	$DETAILS = urldecode($_POST['Details']);
	$ACTIONS = urldecode($_POST['Actions']);
	$PREVENTED = $_POST['Prevented'];
	$NAME = $_POST['Name'];
	$EMPLOYER = $_POST['Employer'];
	$EMAIL = $_POST['Email'];
	$OCCURANCE = $_POST['Occurance'];
	$SITE = $_POST['Site'];
	
	
	$id = DB::table('UKHT_Occurance_Close_Call')->insertGetId(
	['Site' => $SITE, 'Date' => $DATE, 'Location' => $WHERE, 'Email' => $EMAIL, 'Employer' => $EMPLOYER, 'Name' => $NAME, 'Details' => $DETAILS, 'Risk_Prevented' => $PREVENTED, 'Actions_Taken_Site' => $ACTIONS, 'Occurance' => $OCCURANCE]
	);
	
	echo $id;
	
}



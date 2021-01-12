<?php

use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Carbon\Carbon;

if($_POST['Type'] === "Member"){

	
}

if($_POST['Type'] === "Location"){
$ID = $_POST['id']; 
$LOCATION = $_POST['Location'];
$REMOVED = $_POST['Removed'];
	
	DB::table('UKHT_Occurance_Location')->updateOrInsert([
		'Name' => $LOCATION, 'Site' => $ID],['Removed' => $REMOVED]);
	
	
}








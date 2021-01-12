	<?php		
$Project_Name = $_POST["projectname"];
$Project_ID = $_POST["projectID"];
$Project_Owner = $_POST["projectowner"];
$Project_StartDate = $_POST["projectstartdate"];
$Project_EndDate = $_POST["projectenddate"];
$Project_StatusDescription = $_POST["projectstatusdescription"];
$Project_StatusID = $_POST["projectstatusid"];
$Project_Description = $_POST["projectDescription"];
$User = $_POST["User"];


$OldData = 
DB::table('UKHT_ICT_Projects')
	->where('ID', $Project_ID)
	->first();



DB::table('UKHT_ICT_Projects_Historic')
				->insert(['Project_ID' => $OldData->ID, 'Name' => $OldData->Name, 'Start_Date' => $OldData->Start_Date, 'End_Date' => $OldData->End_Date, 'Description' => $OldData->Description, 'Status_ID' => $OldData->Status_ID, 'Status_Description' => $OldData->Status_Description, 'Last_Update' => $OldData->Last_Update, 'Update_Contact' => $OldData->Last_Update_Contact]);
			
		



DB::table('UKHT_ICT_Projects')
		->where('ID', $Project_ID)
		->update(['Name' => $Project_Name, 'Start_Date' => $Project_StartDate, 'End_Date' => $Project_EndDate, 'Description' => $Project_Description, 'Status_ID' => $Project_StatusID, 'Status_Description' => $Project_StatusDescription, 'Last_Update_Contact' => $User]);


?>
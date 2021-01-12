	<?php		
	$project_name = $_POST['Project_name'];
	$project_owner = $_POST['Project_Creator'];
	$project_Startdate = $_POST['Project_StartDate'];
	$project_status = $_POST['Project_Status'];
	$project_Description = $_POST['$Project_Description'];


	$projectid = DB::Table('UKHT_ICT_Projects')
			->insertGetId(['Name' => $project_name, "End_Date" => $project_Startdate, 'Last_Update_Contact' => $project_owner, "Start_Date" => $project_Startdate, "Description" => $project_Description, 'Status_Description' => $project_status, 'Status_ID' => 1, 'Owner_ID' => $project_owner ]);
	
	DB::Table('UKHT_ICT_Projects_Contacts')
		->insert(['Contact_ID' => $project_owner, 'Project_ID' => $projectid,'Role_ID' => 3]);

?>
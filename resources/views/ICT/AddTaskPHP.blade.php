	<?php		
	$project_name = $_POST['project_id'];
	$contact_id = $_POST['contact_id'];
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$description = $_POST['description'];
	$type = $_POST['type'];

	
	if ($contact_id == 0) {
		$contact_id = null;
	} 

	if ($type == "checked"){
		DB::table('UKHT_ICT_Projects_Tasks')
			->where("ID","=",$project_name)
			->update(["isCompleted" => true]);
	} else if ($type == "unchecked") {
		DB::table('UKHT_ICT_Projects_Tasks')
			->where("ID","=",$project_name)
			->update(["isCompleted" => false]);
	} else if ($type == "Remove") {
		DB::table('UKHT_ICT_Projects_Tasks')
			->where("ID","=",$project_name)
			->update(["isRemoved" => true]);
	} else if ($type == "edit") {
		DB::table('UKHT_ICT_Projects_Tasks')
			->where("ID","=",$project_name)
			->update(["Description" => $description, "Contact" => $contact_id]);
	} else {
		DB::table('UKHT_ICT_Projects_Tasks')
		->insert(['Project_ID' => $project_name, "Description" => $description, "Start_Date" => $start_date, "End_Date" => $end_date, "Contact" => $contact_id ]);
	}



	

?>
	<?php		
	$project_id = $_POST['project_id'];
	$location_id = $_POST['location_id'];
	$description = $_POST['task_Description'];
	$type = $_POST['type'];
	$order = $_POST['order'];

	if ($type === "create"){
		db::table('UKHT_ICT_Projects_Tasks_New')
			->insert(['Project_ID' => $project_id, 'Location' => $location_id, 'Description' => $description, 'Task_Order' => $order, 'Start_Date' => date('Y-m-d H:i:s')]);
	} 
	if($type === "update_location") {
		db::table('UKHT_ICT_Projects_Tasks_New')
		->where('ID','=' ,$project_id)
		->update(['Location' => $location_id]); 
	}
	if($type === "update_order") {
		db::table('UKHT_ICT_Projects_Tasks_New')
		->where('ID','=' ,$project_id)
		->update(['Task_Order' => $order]); 
	}



?>
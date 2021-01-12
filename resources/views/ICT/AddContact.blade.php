	<?php		

$contact_id = $_POST['contact_id'];
$project_id = $_POST['project_id'];
$Role_ID = $_POST['Role_ID'];
$Type = $_POST['Type']	;

?>
<script>
	console.log({{$Type}});
</script>

<?php

if($Type === "Add"){
	DB::table('UKHT_ICT_Projects_Contacts')
	-> updateOrInsert(['Contact_ID' => $contact_id, 'Project_ID' => $project_id], ['Contact_ID' => $contact_id, 'Project_ID' => $project_id, 'Role_ID' => $Role_ID, 'Disabled' => false ]);
	email();
	
}

if($Type === "Delete"){
	
	DB::table('UKHT_ICT_Projects_Contacts')
		->where('Contact_ID', $contact_id)
		->where('Project_ID', $project_id)
		->update(['Disabled' => 1]);
	echo $contact_id;
	echo "Done";
}






function email(){
	$link = url('/')."/projectExtendedView?id=".$_POST['project_id'];
	$Type = $_POST['Type']	;
	$user = DB::table('user') 
	->select('Identity_Email')
	-> where('Contact_ID','=', $_POST['contact_id'])
	-> first();
	$project_name = DB::table('UKHT_ICT_Projects') 
	-> select('Name')
	-> where('ID', '=' , $_POST['project_id'])
	-> first();
	
	$messages = "";
	$title = "";
	if($Type == "Add"){
	$messages = "You have been added to project: ".$project_name->Name;
	$title = "project: $project_name->Name Added";
}

if($Type == "Delete"){
	$message = "You have been removed from project: ".$project_name->Name;
	$title = "project: $project_name->Name Removed";
}
	
	
	$to = $user->Identity_Email;
$subject = "Project ".$project_name->Name;

$message = "
<html>
<head>
<title>$title</title>
</head>
<body>
<p>$messages</p>
<p>$link</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <themis@hochtief.co.uk>' . "\r\n";


mail($to,$subject,$message,$headers);
}

?>
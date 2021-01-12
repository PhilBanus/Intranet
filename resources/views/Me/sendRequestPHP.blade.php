	<?php		
		$ID = $_POST['encrypted_ID'];
	if($_POST['mode'] == 'one'){
		$outcome = $_POST['approve'];
		DB::table('UKHT_HR_PD_Stage')->Update(['Approved' => $outcome])
			->where('ID' , $ID);
	} else {
		
	


	if(isset($_POST['Title'])){ $Title = $_POST['Title']; }else{ $Title = NULL;};
	if(isset($_POST['Forename'])){ $Forename = $_POST['Forename']; }else{ $Forename = NULL;};
	if(isset($_POST['Forename'])){ $Surname = $_POST['Surname']; }else{ $Surname = NULL;};
	if(isset($_POST['Telephone'])){ $Telephone = $_POST['Telephone']; }else{ $Telephone = NULL;};
	if(isset($_POST['Mobile'])){ $Mobile = $_POST['Mobile']; }else{ $Mobile = NULL;};
	if(isset($_POST['Email'])){ $Email = $_POST['Email']; }else{ $Email = NULL;};
	if(isset($_POST['Firstline'])){ $Firstline = $_POST['Firstline']; }else{ $Firstline = NULL;};
	if(isset($_POST['secondline'])){ $secondline = $_POST['secondline']; }else{ $secondline = NULL;};
	if(isset($_POST['Town'])){ $Town = $_POST['Town']; }else{ $Town = NULL;};
	if(isset($_POST['Postcode'])){ $Postcode = $_POST['Postcode']; }else{ $Postcode = NULL;};
	if(isset($_POST['Emergency_Title'])){ $Emergency_Title = $_POST['Emergency_Title']; }else{ $Emergency_Title = NULL;};
	if(isset($_POST['Emergency_Forename'])){ $Emergency_Forename = $_POST['Emergency_Forename']; }else{ $Emergency_Forename = NULL;};
	if(isset($_POST['Emergency_Surname'])){ $Emergency_Surname = $_POST['Emergency_Surname']; }else{ $Emergency_Surname = NULL;};
	if(isset($_POST['Emergency_Telephone'])){ $Emergency_Telephone = $_POST['Emergency_Telephone']; }else{ $Emergency_Telephone = NULL;};
	if(isset($_POST['Emergency_Mobile'])){ $Emergency_Mobile = $_POST['Emergency_Mobile']; }else{ $Emergency_Mobile = NULL;};
	

	
	
	$email_ID = DB::table('UKHT_HR_PD_Stage')
		->insertGetId(
		['Title' => $Title, 'Forename' => $Forename, 'Surname' => $Surname, 'Home_Telephone' => $Telephone, 'Mobile' => $Mobile, 'Email' => $Email, 'Address_Firstline' => $Firstline, 'Address_Secondline' => $secondline, 'Address_Town' => $Town, 'Address_Postcode' => $Postcode, 'Emergency_Title' => $Emergency_Title, 'Emergency_Forename' => $Emergency_Forename, 'Emergency_Surname' => $Emergency_Surname, 'Emergency_Telephone' => $Emergency_Telephone, 'Emergency_Mobile' => $Emergency_Mobile, 'User_ID' => $ID]
	);

echo $email_ID; 
	}
?>
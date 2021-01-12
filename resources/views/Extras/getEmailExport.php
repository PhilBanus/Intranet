<?php

ini_set('max_execution_time', 21600);

$count = 0;

$USERID = $_POST['ID'];

$Location = $_POST['LOCATION'];

$From_Date = $_POST['FROM'];
$To_Date = $_POST['TO'];



$Emails = DB::table('workspaceMailVaultv1.dbo.Mail_Vault as a')
	
	->select('a.Mail_Vault_ID', 'a.File_Location', 'a.Subject', 'a.Date', 'a.Body', 'a.File_Size')
	->join('workspaceMailVaultv1.dbo.Mail_Vault_Addresses as b', function($join)
        {
            $join->on('b.Mail_Vault_ID', '=', 'a.Mail_Vault_ID')
                 ->where('b.Email_Addressee_Type_ID', 1);
        })
	->join('workspaceMailVaultv1.dbo.Mail_Vault_Addresses as c', function($join)
        {
            $join->on('c.Mail_Vault_ID', '=', 'a.Mail_Vault_ID')
                 ->where('c.Email_Addressee_Type_ID', 2);
        })
	->whereIn('a.Mail_Vault_ID', function($query)
    {
		$USERID = $_POST['ID'];
        $query->select(DB::raw("Mail_Vault_ID"))
              ->from('workspaceMailVaultv1.dbo.Mail_Vault_Addresses')
              ->whereRaw("Email_Address_ID in (Select [email_address_id] from workspaceMailVaultv1.dbo.email_address 

where email_address.address in (Select Address_or_Number from workspaceMailVaultv1.dbo.U2ContactResolution where Contact_ID = ".$USERID.")  )");
    })
	->whereIn('b.Email_Address_ID', function($query)
    {
		$USERID = $_POST['ID'];
        $query->select(DB::raw("email_address_id"))
              ->from('workspaceMailVaultv1.dbo.Mail_Vault_Addresses')
              ->whereRaw("( b.Email_Address_ID in (Select [email_address_id] from workspaceMailVaultv1.dbo.email_address 

where email_address.address in (Select Address_or_Number from workspaceMailVaultv1.dbo.U2ContactResolution where Contact_ID = ".$USERID.")) or c.Email_Address_ID in (Select [email_address_id] from workspaceMailVaultv1.dbo.email_address 

where email_address.address in (Select Address_or_Number from workspaceMailVaultv1.dbo.U2ContactResolution where Contact_ID = ".$USERID.") ) )");
    })
	->whereBetween(DB::raw('Date'), array($From_Date, $To_Date))
	
	->orderby('Date','desc')
	
	
	->chunk(100, function($Emails)
{
	
	$count = 0;
	
	foreach($Emails as $Email){
		
	
		 
		  $zip = new ZipArchive;
		  if ($zip->open( $Email->File_Location) === TRUE) {
			
			  $Location = $_POST['LOCATION'];
	
    		if($zip->extractTo($Location)){ $count = $count +1; } ;
    		$zip->close();
   	

	
} else {
   
}

		

	}
	
echo "<div class='counter_id'>$count</div>"; 
		
	
	});

	
?>


	
	
	
	
	
	
	
	
	
	
	
	
	










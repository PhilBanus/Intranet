<?php 

$ID = $_POST['ID'];
$USER = $_POST['USER'];
$TYPE = $_POST['TYPE'];

if($TYPE === "REMOVE"){
$Delete = DB::table('UKHT_Alert_Group_Contacts')
	->where('Group_ID',$ID)
	->where('Contact_ID',$USER)
	->delete();


}

if($TYPE === "ADD"){
	DB::table('UKHT_Alert_Group_Contacts')
    ->updateOrInsert(
        ['Group_ID' => $ID, 'Contact_ID' => $USER],
        ['Group_ID' => $ID, 'Contact_ID' => $USER]
    );
}

if($TYPE === "CREATE"){
	DB::table('UKHT_Alert_Groups')
    ->insert(['Name' => $USER]);
}


?>
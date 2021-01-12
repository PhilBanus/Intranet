<?php 

$ID = $_POST['ID'];
$USER = $_POST['USER'];


$Update = DB::table('UKHT_Alert_Recipients')
	->where('Alert_ID',$ID)
	->where('Contact_ID',$USER)
	->update(['Read' => true]);



if($Update){

echo $ID;
echo $USER;
    
}
?>
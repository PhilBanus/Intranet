<?php 


$ID = $_POST['ID'];
$Nav = $_POST['Nav'];
$Type = $_POST['Type'];


if($Type === "false"){
	
	DB::table('UKHT_Nav_Access')->where('Role_ID', $ID)->where('Nav_ID',$Nav)->delete();
	
}else{
	
	
	DB::table('UKHT_Nav_Access')
    ->updateOrInsert(
        ['Role_ID' => $ID, 'Nav_ID' => $Nav],
        ['Role_ID' => $ID, 'Nav_ID' => $Nav]
    );
	
	
}

?>
<?php 


$ID = $_POST['ID'];
$Nav = $_POST['Nav'];
$Type = $_POST['Type'];


if($Type === "false"){
	
	DB::table('UKHT_User_Role')->where('User_ID', $ID)->where('Role_ID',$Nav)->delete();
	
}else{
	
	
	DB::table('UKHT_User_Role')
    ->updateOrInsert(
        ['User_ID' => $ID, 'Role_ID' => $Nav],
        ['User_ID' => $ID, 'Role_ID' => $Nav]
    );
	
	
}

?>
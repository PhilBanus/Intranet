<?php 


if($_POST['Type'] === "add"){ 
$id = DB::table('UKHT_Monitors')->insertGetId(
    ['Serial_Number' => $_POST['SN'], 'Make' => $_POST['MAKE'], 'Model' => $_POST['MODEL'], 'Location' => $_POST['L']]
);
}
	
if($_POST['Type'] === "edit"){ 
$id = DB::table('UKHT_Monitors')->where('Serial_Number','=', $_POST['olSerial'])->update(
    ['Serial_Number' => $_POST['SN'], 'Make' => $_POST['MAKE'], 'Model' => $_POST['MODEL']]
);
	
	
}


if($_POST['Type'] === "del"){
	
	$id = DB::table('UKHT_Monitors')->where('Serial_Number','=',$_POST["SN"])->delete();

}







?>
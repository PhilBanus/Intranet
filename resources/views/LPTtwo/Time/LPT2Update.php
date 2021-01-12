<?php 

$ID = $_POST['ID'];
$ROLE = $_POST['Role'];

if($_POST['Type'] === 'ROLE'){
	DB::table('LPT2_Links')->updateOrInsert(
['Contact' => $ID],
['Contact' => $ID, 'LPT2_Group' => $ROLE]
);
}


if($_POST['Type'] === 'RATE'){
	DB::table('LPT2_Rate')->updateOrInsert(
['Contact' => $ID],
['Contact' => $ID, 'Rate' => $ROLE]
);
}




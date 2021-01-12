	<?php		

$ID = $_POST['id'];
$USERID = $_POST['user'];
$Comment = urlencode($_POST['comment']);




				DB::table('UKHT_ICT_Projects_CommentsNotes')
				->insertGetId(['Project_ID' => $ID, 'contact_ID' => $USERID,'Description' => $Comment ]);

			
	?>
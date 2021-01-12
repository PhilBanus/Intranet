<?php

	header('Content-Type: application/json');
use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Carbon\Carbon;
if($_POST['type'] === "Comment"){
	
	$validAttachments = array();
	
	$count = count($_FILES['file']['name']);
for ($i = 0; $i < $count; $i++) {
    
	$filePath = $_FILES['file']['tmp_name'][$i];
	$fileName = $_FILES['file']['name'][$i];
    if(is_uploaded_file($filePath))
    {
        $attachment = new stdClass;
        $attachment->fileName = $fileName;
        $attachment->filePath = $filePath;
        $validAttachments[] = $attachment;
    }        
}
	
	

	
	$comment = base64_encode($_POST['comment']);
	$user = $_POST['user'];
	$ticket = $_POST['id'];
	
	$tech = DB::table('HELPDESK_TechnicianImage')->where('Technician',$user)->exists();
	$count = DB::table('HELPDESK_Comments')->where('Ticket',$ticket)->count()+1;
	
	DB::table('HELPDESK_Comments')->insert(
	[
		'Message' => $comment,
		'Contact' => $user,
		'Ticket'  => $ticket,
		'Technician' => $tech,
		'Count' => $count
	]);
	
	if($tech){
		$border = 'border-right border-danger';
	}else{
		$border = 'border-left border-success';
	}
	
		$arr = '<div class="result">
<div class="white p-2 mb-2 {{$border}} ">
	<div class="card-title small text-muted">'.DB::table('Contact')->where('Contact_ID',$user)->first()->Forename.' '.DB::table('Contact')->where('Contact_ID',$user)->first()->Surname.' - '.new Carbon().' </div>
	<div class="card-text">'.base64_decode($comment).'</div>
</div>
	</div>';



	
	
	
	$mail = new PHPMailer(true);
		
	try {
    //Server settings
 $mail->isSMTP();
//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host = '10.4.252.97';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;

//Whether to use SMTP authentication
$mail->SMTPAuth = false;
$mail->Username = 'admin@ukht.org';
$mail->Password = 'Pan2er622';   
		$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
		
		// TCP port to connect to

    //Recipients
    $mail->setFrom('philip.banus@hochtief.co.uk');
       // Add a recipient
    
		
		 $mail->addAddress( 
	DB::table('HELPDESK_Calls')->where('ID',$ticket)->first()->Email );
				
	
foreach($validAttachments as $attachment)
{
    $mail->AddAttachment($attachment->filePath, $attachment->fileName);
}
	
    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "[Ticket#$ticket] - ".base64_decode(DB::table('HELPDESK_Calls')->where('ID',$ticket)->first()->Subject);
    $mail->Body    = $_POST['comment'];
   
    $mail->send();
		
   	echo $arr;
} catch (Exception $e) {
    echo "{$mail->ErrorInfo}";
}	


	
}


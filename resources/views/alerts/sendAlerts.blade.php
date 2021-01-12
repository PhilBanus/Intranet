<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
date_default_timezone_set('Etc/UTC');

$Subject = urldecode($_POST['Subject']);
$Body =  urldecode($_POST['Body']);
$Color =  urldecode($_POST['Color']);
$Type =  urldecode($_POST['Type']);
$From =  urldecode($_POST['From']);
$NotificationGroup =  explode(",",urldecode($_POST['NotificationGroup']));
$Email =  urldecode($_POST['Email']);

echo $Email; 

$AlertID = DB::table('UKHT_Alerts')
	->insertGetId(
[
	'Subject' => $_POST['Subject'],
	'Body' => $_POST['Body'],
	'Active' => 1,
	'Color' => $Color,
	'Type' => $Type
	
]);



$Contact_IDS = DB::table('UKHT_Alert_Group_Contacts')
	->select('Contact_ID')
	->whereIn('Group_ID', $NotificationGroup)
	->distinct('Contact_ID')
	->pluck('Contact_ID');

$Contacts = DB::table('Contact')
	->join('User','User.Contact_ID','Contact.Contact_ID')
	->whereIn('Contact.Contact_ID',$Contact_IDS)
	->get();

foreach($Contacts as $Contact ){
	
	DB::table('UKHT_Alert_Recipients')
		->insert([
			'Alert_ID' => $AlertID,
			'Contact_ID' => $Contact->Contact_ID
		]);
	
	
	if($Email === "true"){
     
        $data = array('body'=>base64_encode($Body), "to"=>$Contact->Identity_Email);
      Mail::send('alerts.send', $data, function ($message)  use ($data) {        
          
$Subject = urldecode($_POST['Subject']);
$Body =  urldecode($_POST['Body']);
$Color =  urldecode($_POST['Color']);
$Type =  urldecode($_POST['Type']);
$From =  urldecode($_POST['From']);
   
    $message->from($From);
    $message->to($data['to'])->subject($Subject); 
   

});
	/*	$mail = new PHPMailer(true);
		
	try {
    //Server settings
 $mail->isSMTP();
//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->SMTPDebug = 4;
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
    $mail->setFrom($From);
    $mail->addAddress($Contact->Identity_Email);     // Add a recipient
    

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $Subject;
    $mail->Body    = $Body;
   
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

*/
		
		
	
	}
	 
	
}
	


?>



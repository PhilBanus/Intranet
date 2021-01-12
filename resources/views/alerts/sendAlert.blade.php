<?php 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



$Subject = urldecode($_POST['Subject']);
$Body =  urldecode($_POST['Body']);
$Color =  urldecode($_POST['Color']);
$Type =  urldecode($_POST['Type']);
$From =  urldecode($_POST['From']);
$NotificationGroup =  explode(",",urldecode($_POST['NotificationGroup']));
$Email =  urldecode($_POST['Email']);


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
        
        
		
		$mail = new PHPMailer(true);
		
	try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = '10.4.252.97';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'admin';                     // SMTP username
    $mail->Password   = 'Pan2er622';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 25;                                    // TCP port to connect to

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
		
		
	
	}
	 
	
}
	
echo "hi";


?>



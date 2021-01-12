<?php
$id = $_GET['content'];
$App = $_GET['App'];


$MyCompleted = DB::table('UKHT_Appraisal_Complete')
			->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Complete.Contact_ID')
			->where('UKHT_Appraisal_Complete.ID',$id)
		    ->first();
$Tab = $MyCompleted->Summary;

$date = $_GET['date'];
$html = urldecode($Tab);


$html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
$html = utf8_decode($html);
$html = str_replace(" cellspacing='10' cellpadding='10'"," style='font-family:Helvetica;'",$html);


$content = str_replace("<thead>","",$html);
$content = str_replace("</thead>","",$content);



header("Content-type: application/vnd.ms-word; charset=UTF-8; application/x-font-opentype");  
           header("Content-Disposition: attachment;Filename=".$MyCompleted->Forename."-".$MyCompleted->Surname."-".$date.".doc");  
           header("Pragma: no-cache");  
           header("Expires: 0");  
echo "<font face='helvetica'><h1>Appraisal $date </h1>";
echo "<h3>$MyCompleted->Forename $MyCompleted->Surname</h3>";
echo "<h5>$MyCompleted->Job_Title</h5>";
echo "<h6>Appraised by: $App</h6>";
echo $content;
echo "</font>"



?>
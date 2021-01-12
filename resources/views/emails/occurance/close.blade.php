
<?php
use Carbon\Carbon;
	$ID = $request->ID;
	$ROOT = $request->ROOT;
	$SUBROOT = $request->SUBROOT;

	$Occurance = DB::table('UKHT_Occurance_Close_Call')->where('ID', $ID)->first(); 
	
    $OccuranceName = DB::table('UKHT_Occurance')->where('ID',$Occurance->Occurance)->first();
			
	if($Occurance->Site == 0){
		$SiteName = "Head Office";
	}else{
		$site = DB::table('Project')->where('Project_ID',$Occurance->Site)->first();
		$SiteName = $site->Name;
	}
			
			if($Occurance->Risk_Prevented == 1){
				$atRisk = "Risk Prevented";
			}else{
				$atRisk = "At Risk";
			}
	
			if(is_numeric($Occurance->Location)){
	$loc = DB::table('UKHT_Occurance_Location')->where('ID',$Occurance->Location)->first();
	$locName =$loc->Name; 
			}else{
				$locName = $Occurance->Location; 
			}
	
$Photos = DB::table('UKHT_Occurance_Photos')->where('Occurance_ID','=',$Occurance->ID)->where('Post','!=',1);
$PostPhotos = DB::table('UKHT_Occurance_Photos')->where('Occurance_ID',$Occurance->ID)->where('Post','=',1);
$HistPhotos = DB::table('UKHT_Occurance_Historic_Photo')->where('Occurance_ID',$Occurance->Global_ID);


?>

@component('mail::message',['header' => 'HOCHTIEF Active Reporting Tool', 'headerURL' => 'https://themis.ukht.org/intranet/OccuranceView?id='.$ID ])




# CLOSED


This is to inform you that the {{$OccuranceName->Name}} at {{$SiteName}} - {{$locName}} has been closed.<br><br>

Root Cause: {{$Occurance->Root_Cause}} / {{$Occurance->Sub_Root}}
<br>
# {{$OccuranceName->Name}} Details
Reported: {{Carbon::createFromFormat('Y-m-d H:i:s.u',$Occurance->Reported_Date)->toRfc7231String()}}
<br>
Occurred: {{Carbon::createFromFormat('Y-m-d H:i:s.u',$Occurance->Date)->toRfc7231String()}}
<br>
Site: {{$SiteName}}
<br>
Location: {{$locName}}
<br>
Weather:  {{$Occurance->Weather}}
<br>
Lighting Conditions: {{$Occurance->Lighting_Conditions}}
# Describe the Event and What Could have happened:
{{urldecode($Occurance->Details)}}
# What were you able to do about it? 
{{urldecode($Occurance->Actions_Taken_Site)}}
# HSQE Information
Category:  {{$Occurance->Category}} \ {{$Occurance->Sub}}
# Actions taken
<strong>{{$Occurance->Last_Updated}}</strong>
<br>
HSQE Instruction: {{urldecode($Occurance->HSQE_Instruction)}}
<br>
Deadline:  {{$Occurance->DeadLine}}
<br>
Actions Taken:  {{base64_decode($Occurance->Actions_Taken_HSQE)}}
<br>
<?php 
if($Occurance->Contractor_Involved){
?>
Subcontractor was Involved 
<br>
<?php
}else{
?>
No Subcontractor involved
<br>
<br>
<?php
}
$History = DB::table('UKHT_Occurance_History')
		->where([['HSQE_Instruction','!=',$Occurance->HSQE_Instruction],['Occurance_ID',$Occurance->ID],['ReAllocated',0]])
		->orWhere([['Actions_Taken_HSQE','!=',$Occurance->Actions_Taken_HSQE],['Occurance_ID',$Occurance->ID],['ReAllocated',0]])
		->orderby("Last_Updated","desc")
				 ->get(); 
		
foreach($History as $item){
?>
<strong>{{$item->Last_Updated}}</strong>		
<br>
HSQE Instruction: {{urldecode($item->HSQE_Instruction)}}
<br>
Deadline: {{$item->DeadLine}}
<br>
Actions Taken: {{base64_decode($item->Actions_Taken_HSQE)}}
<br>
<?php 
if($Occurance->Contractor_Involved){
?>
Subcontractor was Involved
<br>
<?php
}else{
?>
No Subcontractor involved
<br>
<br>
<?php
}
}
?>
@endcomponent

	
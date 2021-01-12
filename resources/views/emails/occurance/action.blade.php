
<?php
use Carbon\Carbon;
	$ID = $request->ID;
	$INS = $request->INS;
	$ALL = $request->ALL;
	$REM = $request->REM;
	$DEAD = $request->DEAD;

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
	

?>

@component('mail::message',['header' => 'HOCHTIEF Active Reporting Tool', 'headerURL' => 'https://themis.ukht.org/intranet/OccuranceView?id='.$ID ])




# Dear {{DB::table('Contact')->where('Contact_ID', $id)->first()->Forename}}


This is to inform you that {{$OccuranceName->Name}} action has been completed at: <br> {{$SiteName}} - {{$locName}}.<br><br>
	Date and Time of observation - <strong>{{carbon::create($Occurance->Date)->toDayDateTimeString()}}</strong> <br><br>
	Action taken:<br> {{base64_decode($Occurance->Actions_Taken_HSQE)}} <br><br>


@component('mail::button', ['url' => 'https://themis.ukht.org/intranet/OccuranceView?id='.$ID])
Click view the {{$OccuranceName->Name}}
@endcomponent


@endcomponent

	
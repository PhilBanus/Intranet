
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
	
	
			$Contact = DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first();
	
			if(isset($Contact->User_Password)){
				$Link = "https://themis.ukht.org/intranet/OccuranceView?id=$Occurance->ID&action=true";
			}else{
				$Link = "https://themis.ukht.org/XWeb/PublicAssets/external/public/OccuranceView?id=$Occurance->ID&action=true";
			}
			

?>

@component('mail::message',['header' => 'HOCHTIEF Active Reporting Tool', 'headerURL' => $Link ])




# Dear {{DB::table('Contact')->where('Contact_ID', $request->ALL)->first()->Forename}}


This is to inform you that a {{$OccuranceName->Name}} has been reported at: <br> {{$SiteName}} - {{$locName}} and has been allocated to you.<br><br>
	Date to be completed by <strong>{{carbon::create($Occurance->DeadLine)->toFormattedDateString()}}</strong> <br><br>
	Instructions from HSQE:<br> {{$Occurance->HSQE_Instruction}} <br><br>


@component('mail::button', ['url' => $Link])
Click view and action the {{$OccuranceName->Name}}
@endcomponent

<br>

Thanks,<br>

HSQE
@endcomponent


	
	
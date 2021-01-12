<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php 
use Carbon\Carbon;
$ProjectID = request('ID') ? request('ID') : 91;
$FirstWeek = Carbon::create('12/15/2019');
$HTUKFullWeek = 45;
$HQFullWeek = 37.5;
$OtherFullWeek = 40;
$Timesheets = db::table('Timesheet_Item')->select('Period_Ending_Date')->join('Timesheet','Timesheet.Timesheet_ID','Timesheet_Item.Timesheet_ID')
	->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID','Timesheet.Timesheet_Period_ID')
	->where(['Entity_Identifier' => $ProjectID, 'Entity_Class_ID' => 3])->distinct('Period_Ending_Date')->get();

$Users = DB::table('Timesheet_Item')->select('Timesheet.Contact_ID','Forename','Surname')->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3])->join("Timesheet","Timesheet.Timesheet_ID","Timesheet_Item.Timesheet_ID")->join('Contact','Contact.Contact_ID','Timesheet.Contact_ID')->distinct('Timesheet.Contact_ID')->orderby('Forename', 'asc')->orderby('Surname','asc')->get()



?>
<table style="font-family: Calibri">
	<tr>
	<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">Name</th>
	<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">Role</th>
	<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">WBS</th>
	<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">Weekly Rate</th>
	@foreach($Timesheets as $Timesheet)
		<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">W.e. {{carbon::create($Timesheet->Period_Ending_Date)->format('d/m/y')}}</th>
	@endforeach
		<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">TOTAL</th>
		<th style="text-align: center; background-color: #44546A; color: white; white-space:nowrap;">SUB-TOTAL</th>
	</tr>
	<tbody>
		<?php 
	$GrandTotal = 0;
?>
	@foreach($Users as $User)
	<?php 
		
		$Internal = DB::table('Role_Membership')->where(['Contact_ID' => $User->Contact_ID, 'User_Role_ID' => 199])->exists(); 
		if($Internal){
            if(DB::table('Contact')->where('Contact_ID', $User->Contact_ID)->first()->Organisation_ID == -1){
                $FullWeek = $HQFullWeek;
            }else{
                $FullWeek = $HTUKFullWeek;
            }
			
		}else{
			$FullWeek = $OtherFullWeek;
		}
		$YearTotal = 0;
		$SubTotal = 0;
		$Rate = DB::table('LPT2_Rate')->where('Contact',$User->Contact_ID)->exists() ? DB::table('LPT2_Rate')->where('Contact',$User->Contact_ID)->first()->Rate : 0;
        $WeekTotal = 0;
		$disabled = DB::table('Entity_Contacts')->where([
				'Entity_Class_ID' => 3,
				'Contact_ID' => $User->Contact_ID,
				'Entity_Identifier' => $ProjectID])->first()->Active;
		?>
		<tr>
			@if($disabled)
			<td>
			@else
				<td style="background-color: #D04649"> InActive - 
			@endif
				{{$User->Forename}} {{$User->Surname}}</td>
			<td>{{DB::table('LPT2_Links')->where('Contact',$User->Contact_ID)->join('LPT2_WBS','LPT2_Group','ID')->first()->Role ?? ''}}</td>
			<td>{{DB::table('LPT2_Links')->where('Contact',$User->Contact_ID)->join('LPT2_WBS','LPT2_Group','ID')->first()->WBS ?? ''}}</td>
			<td class="rate">£{{number_format(intval($Rate))}}</td>
			@foreach($Timesheets as $Timesheet)
				<?php 
	$WeekTotal = db::table('Timesheet_Item_Time')->join('Timesheet_Item','Timesheet_Item.Timesheet_Item_ID','Timesheet_Item_Time.Timesheet_Item_ID')->join('Timesheet','Timesheet.Timesheet_ID','Timesheet_Item.Timesheet_ID')
	->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID','Timesheet.Timesheet_Period_ID')->where(['Period_Ending_Date' => $Timesheet->Period_Ending_Date, 'Contact_ID' => $User->Contact_ID, 'Entity_Class_ID' => 3, 'Entity_Identifier' => $ProjectID])->select(DB::raw('SUM(Time_Basic) as Total'))->first()->Total;
			if($WeekTotal >= $FullWeek){
				$WeekTotal = 1;
			}else{
				$WeekTotal = round(($WeekTotal/$FullWeek)*100)/100;
			}
			$YearTotal = $WeekTotal + $YearTotal;
?>
			<td class="week" style="text-align: center;">{{$WeekTotal}}</td>
			@endforeach
			<td class="" style="text-align: center;">{{$YearTotal}}</td>
			<?php $SubTotal = $YearTotal * intval($Rate);
			$GrandTotal = $GrandTotal + $SubTotal; ?>
			<td class="SubTotal" style="text-align: right; background-color: #ACB9CA">£{{number_format($SubTotal)}}</td>
		</tr>	
	@endforeach
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			@foreach($Timesheets as $Timesheet)
		<td></td>
	@endforeach
			<th>TOTAL</th>
			<th class="GTOTAL">£{{number_format($GrandTotal)}}</th>
		</tr>
	</tbody>
</table>


<script>


  


</script>

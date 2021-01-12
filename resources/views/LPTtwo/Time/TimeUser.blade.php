<?php 
use Carbon\Carbon;
	
$ProjectID = request('ID') ? request('ID') : 91;
	
$FirstWeek = Carbon::create('12/15/2019');
$TimeItems = db::table('Timesheet_Item')->where('Timesheet_ID',$_GET['time'])->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3])->get();
$AbsenceItems = db::table('Timesheet_Item')->where('Timesheet_ID',$_GET['time'])->WhereIn('Timesheet_Item_Category_ID',[10,2,1,8,41,37,36,96,19,3,4,5,7,8,9,10,11,14,36,33,37,40,41,130])->get();
$Timesheet = db::table('Timesheet')->where('Timesheet_ID',$_GET['time'])->first();
$TimesheetPeriod = db::table('Timesheet_Period')->where('Timesheet_Period_ID',$Timesheet->Timesheet_Period_ID)->first();
$Role = DB::table('LPT2_Links')->where('Contact',$_GET['C_ID'])->join('LPT2_WBS','LPT2_Group','ID')->first();
$arrMon = [0];
$arrTue = [0];
$arrWed = [0];
$arrThu = [0];
$arrFri = [0];
$arrSat = [0];
$arrSun = [0];
$arrALL = [0];
?>
<table>
	<tr><td colspan="5"><img src="{{public_path('/images/HMJV_logo.jpg')}}" alt="" height="50"> </td><td colspan="10">TIMESHEET</td></tr>
	<tr>
		<td colspan="1" width="10">Contract:</td>
		<td colspan="6" width="60">National Grid - {{DB::table('Project')->where('Project_ID',$ProjectID)->first()->Name}}</td>
		<td colspan="3" width="30">Week Ending Date:</td>
		<td colspan="2" width="20">{{Carbon::create($TimesheetPeriod->Date_To)->toDateString()}}</td>
		<td colspan="2" width="20">Project Week</td>
		<td colspan="1" width="10">{{$FirstWeek->diffInWeeks(Carbon::create($TimesheetPeriod->Date_To))+1}}</td>
	</tr>
	<tr>
		<td colspan="1" width="10">Name:</td>
		<td colspan="5" width="45">{{$_GET['Name']}}</td>
		<td colspan="1" width="15">Company:</td>
		<td colspan="3" width="30">{{base64_decode($_GET['Company'])}}</td>
		<td colspan="1" width="10">Role:</td>
		<td colspan="4" width="40">{{base64_decode($_GET['Role'])}}</td>
	</tr>
	<thead>
	<tr>
		<th rowspan="2" colspan="3" width="25">Task Description</th>
		<th rowspan="2" colspan="2" width="15">Location</th>
		<th rowspan="2" colspan="1" width="15">Activity</th>
		<th rowspan="2" colspan="1" width="15">WBS</th>
		<th colspan="8" width="80">Days Worked Per Task</th>
	</tr>
	<tr>
	<th width="10">Mo</th>
	<th width="10">Tu</th>
	<th width="10">We</th>
	<th width="10">Th</th>
	<th width="10">Fr</th>
	<th width="10">Sa</th>
	<th width="10">Su</th>
	<th width="10">Total</th>
	</tr>
	</thead>
	@foreach($TimeItems as $Item)
	<tr>
		<td rowspan="2" colspan="3">{{$Item->notes ?? "No Notes Provided"}}</td>
		<td rowspan="2" colspan="2" style="background-color: #C6E0B4; text-align: center">{{DB::table('Timesheet_Item_Category')->where('Timesheet_Item_Category_ID',$Item->Timesheet_Item_Category_ID)->first()->Name}}</td>
		<td rowspan="1" colspan="1" style="background-color: #C6E0B4; text-align: center">{{$Role->Core_Group ?? ''}}</td>
		<td rowspan="1" colspan="1" style="background-color: #cecece; text-align: center">{{$Role->WBS ?? ''}}</td>
		<?php 
		$Times = DB::table('Timesheet_Item_Time')->where('Timesheet_Item_ID',$Item->Timesheet_Item_ID)->get();
		$TotalTime = db::table('Timesheet_Item_Time')->where('Timesheet_Item_ID',$Item->Timesheet_Item_ID)->select(DB::raw('SUM(Time_Basic) as Total'))->first();
		foreach($Times as $Time){
				if(Carbon::create($Time->Date)->dayOfWeekIso == 1){ $Mon = $Time->Time_Basic; array_push($arrMon, $Mon); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 2){ $Tue = $Time->Time_Basic; array_push($arrTue, $Tue); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 3){ $Wed = $Time->Time_Basic; array_push($arrWed, $Wed); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 4){ $Thu = $Time->Time_Basic; array_push($arrThu, $Thu); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 5){ $Fri = $Time->Time_Basic; array_push($arrFri, $Fri); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 6){ $Sat = $Time->Time_Basic; array_push($arrSat, $Sat); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 7){ $Sun = $Time->Time_Basic; array_push($arrSun, $Sun); }

		}
		?>
		<td rowspan="2" colspan="1">{{$Mon ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Tue ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Wed ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Thu ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Fri ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Sat ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Sun ?? 0}}</td>
		<td rowspan="2" colspan="1" style=";  background-color: #cecece; text-align: center; font-weight: bold">{{ number_format((float)$TotalTime->Total, 2, '.', '')}}</td>
	</tr>
	<tr>
		<td rowspan="1" colspan="1" style="background-color: #C6E0B4; text-align: center">{{$Role->Group_Name ?? ''}}</td>
		<td rowspan="1" colspan="1" style="background-color: #C6E0B4; text-align: center"></td>
	</tr>
	<?php 
	$Mon = 0;
	$Tue = 0;
	$Wed = 0;
	$Thu = 0;
	$Fri = 0;
	$Sat = 0;
	$Sun = 0;
	
	
	
	?>
	@endforeach
	@foreach($AbsenceItems as $Item)
	<tr>
		<td rowspan="2" colspan="3">{{$Item->notes ?? "No Notes Provided"}}</td>
		<td rowspan="2" colspan="2" style="background-color: #C6E0B4; text-align: center">{{DB::table('Timesheet_Item_Category')->where('Timesheet_Item_Category_ID',$Item->Timesheet_Item_Category_ID)->first()->Name}}</td>
		<td rowspan="1" colspan="1" style="background-color: #C6E0B4; text-align: center"></td>
		<td rowspan="1" colspan="1" style="background-color: #Cecece; text-align: center"></td>
		<?php 
		$Times = DB::table('Timesheet_Item_Time')->where('Timesheet_Item_ID',$Item->Timesheet_Item_ID)->get();
		$TotalTime = db::table('Timesheet_Item_Time')->where('Timesheet_Item_ID',$Item->Timesheet_Item_ID)->select(DB::raw('SUM(Time_Basic) as Total'))->first();
		foreach($Times as $Time){
				if(Carbon::create($Time->Date)->dayOfWeekIso == 1){ $Mon = $Time->Time_Basic; array_push($arrMon, $Mon); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 2){ $Tue = $Time->Time_Basic; array_push($arrTue, $Tue); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 3){ $Wed = $Time->Time_Basic; array_push($arrWed, $Wed); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 4){ $Thu = $Time->Time_Basic; array_push($arrThu, $Thu); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 5){ $Fri = $Time->Time_Basic; array_push($arrFri, $Fri); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 6){ $Sat = $Time->Time_Basic; array_push($arrSat, $Sat); }
				if(Carbon::create($Time->Date)->dayOfWeekIso == 7){ $Sun = $Time->Time_Basic; array_push($arrSun, $Sun); }

		}
		?>
		<td rowspan="2" colspan="1">{{$Mon ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Tue ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Wed ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Thu ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Fri ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Sat ?? 0}}</td>
		<td rowspan="2" colspan="1">{{$Sun ?? 0}}</td>
		<td rowspan="2" colspan="1" style=";  background-color: #cecece; text-align: center; font-weight: bold">{{ number_format((float)$TotalTime->Total, 2, '.', '')}}</td>
	</tr>
	<tr>
		<td rowspan="1" colspan="1" style="background-color: #C6E0B4; text-align: center"></td>
		<td rowspan="1" colspan="1" style="background-color: #C6E0B4; text-align: center">{{DB::table('Timesheet_Item_Category')->where('Timesheet_Item_Category_ID',$Item->Timesheet_Item_Category_ID)->first()->Name}}</td>
	</tr>
	<?php 
	$Mon = 0;
	$Tue = 0;
	$Wed = 0;
	$Thu = 0;
	$Fri = 0;
	$Sat = 0;
	$Sun = 0;
	
	
	
	?>
	@endforeach
	<?php
	array_push($arrALL, array_sum($arrMon)); 
	array_push($arrALL, array_sum($arrTue)); 
	array_push($arrALL, array_sum($arrWed)); 
	array_push($arrALL, array_sum($arrThu));
	array_push($arrALL, array_sum($arrFri));
	array_push($arrALL, array_sum($arrSat)) ;
	array_push($arrALL, array_sum($arrSun)); 
	?>
	<tr style=";  background-color: #cecece">
		<td colspan="7" class="text-right" style="text-align: right; background-color: #cecece; font-weight: bold; border-top: solid thin #000000">Total:</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrMon)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrTue)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrWed)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrThu)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrFri)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrSat)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrSun)}}</td>
		<td  style=";  background-color: #cecece; font-weight: bold; text-align: center; border-top: solid thin #000000">{{array_sum($arrALL)}}</td>
	</tr>
	<tr></tr>
	<tr>
		<td colspan="6" class="text-center bg-grey" style="text-align: center;  background-color: #cecece; font-weight: bold; border: solid thin #000000">Individual</td>
		<td colspan="9" class="text-center bg-grey" style="text-align: center; background-color: #cecece; font-weight: bold; border: solid thin #000000">HMJV Project Management</td>
	</tr>
	<tr>
		<td>Signed:</td>
		<td colspan="5">
			@if($Timesheet->Date_Committed)
			Digitaly submitted
			@else
			NOT YET SUBMITTED
			@endif
		</td>
		<td>Signed:</td>
		<td colspan="9">
			@if($Timesheet->Approved == 1)
			Digitaly Approved
			@else
			NOT YET APPROVED
			@endif
		</td>
	</tr>
	<tr>
		<td>Date:</td>
		<td colspan="5">
			@if($Timesheet->Date_Committed)
			{{$Timesheet->Date_Committed}}
			@endif
		</td>
		<td>Date:</td>
		<td colspan="9">
			@if($Timesheet->Approved == 1)
			{{DB::table('Approval_Ticket')->where(['Approval_Ticket_ID' => $Timesheet->Approval_Ticket_ID, 'Approved' => 1 ])->first()->Created_Date}}
			@endif
		</td>
	</tr>
</table>

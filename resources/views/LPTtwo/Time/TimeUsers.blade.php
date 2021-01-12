<?php 
use Carbon\Carbon;
$ProjectID = request('ID') ? request('ID') : 91;
$FirstWeek = Carbon::create('12/15/2019');
$TimeItems = db::table('Timesheet_Item')->where('Timesheet_ID',$_GET['time'])->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3])->get();
$AbsenceItems = db::table('Timesheet_Item')->where('Timesheet_ID',$_GET['time'])->WhereIn('Timesheet_Item_Category_ID',[3,4,5,7,8,9,10,11,14,36,33,37,40,41,130])->get();
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
		<td colspan="6" width="60">National Grid - London Power Tunnels 2 (P2 - Tunnels Shafts)</td>
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
		<td rowspan="2" colspan="2">{{DB::table('Timesheet_Item_Category')->where('Timesheet_Item_Category_ID',$Item->Timesheet_Item_Category_ID)->first()->Name}}</td>
		<td rowspan="1" colspan="1"></td>
		<td rowspan="1" colspan="1"></td>
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
		<td rowspan="2" colspan="1">{{ number_format((float)$TotalTime->Total, 2, '.', '')}}</td>
	</tr>
	<tr>
		<td rowspan="1" colspan="1"></td>
		<td rowspan="1" colspan="1">{{DB::table('Timesheet_Item_Category')->where('Timesheet_Item_Category_ID',$Item->Timesheet_Item_Category_ID)->first()->Name}}</td>
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
		<td rowspan="2" colspan="2">{{DB::table('Timesheet_Item_Category')->where('Timesheet_Item_Category_ID',$Item->Timesheet_Item_Category_ID)->first()->Name}}</td>
		<td rowspan="1" colspan="1">{{$Role->Core_Group ?? ''}}</td>
		<td rowspan="1" colspan="1">{{$Role->WBS ?? ''}}</td>
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
		<td rowspan="2" colspan="1">{{ number_format((float)$TotalTime->Total, 2, '.', '')}}</td>
	</tr>
	<tr>
		<td rowspan="1" colspan="1">{{$Role->Group_Name ?? ''}}</td>
		<td rowspan="1" colspan="1">WBS</td>
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
	<tr>
		<td colspan="7" class="text-right" style="text-align: right">Total:</td>
		<td>{{array_sum($arrMon)}}</td>
		<td>{{array_sum($arrTue)}}</td>
		<td>{{array_sum($arrWed)}}</td>
		<td>{{array_sum($arrThu)}}</td>
		<td>{{array_sum($arrFri)}}</td>
		<td>{{array_sum($arrSat)}}</td>
		<td>{{array_sum($arrSun)}}</td>
		<td>{{array_sum($arrALL)}}</td>
	</tr>
</table>

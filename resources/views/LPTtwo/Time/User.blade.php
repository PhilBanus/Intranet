<?php 
use Carbon\Carbon;
$ProjectID = request('ID') ? request('ID') : 91;
$Contact = db::table('Contact')->where('Contact_ID',$_GET['id'])->first();
$Name = $Contact->Forename." ".$Contact->Surname;
$Org = DB::table('Organisation')->where('Organisation_ID',$Contact->Organisation_ID)->first();

$TimeSheets = DB::table('Timesheet_Item')->where(function($query) use ($ProjectID){
	$query->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3]);
	$query->orWhere(['Timesheet_Item_Category_ID' => 3, ['Timesheet.Timesheet_Period_ID' ,'>', 580]]);

})->where('Contact_ID',$Contact->Contact_ID)->join("Timesheet","Timesheet.Timesheet_ID","Timesheet_Item.Timesheet_ID")->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID','Timesheet.Timesheet_Period_ID')->orderby('Timesheet.Timesheet_Period_ID','desc')->toSql();

dd($TimeSheets);


$LastTimesheet = DB::table('Timesheet_Item')->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3])->where('Contact_ID',$Contact->Contact_ID)->join("Timesheet","Timesheet.Timesheet_ID","Timesheet_Item.Timesheet_ID")->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID','Timesheet.Timesheet_Period_ID')->orderby('Timesheet_Period_ID','desc')->select('Timesheet_Period.Timesheet_Period_ID','Date_To')->first();


			?>

<div class="card bg-light text-dark">

	<div class="card-body d-flex justify-content-between">
	
		<div class="col-md-4 justify-content-between">
			<span class="col-md-3">Job Title:</span> <span><strong>{{$Contact->Job_Title}}</strong></span>
		
		</div>
		
		<div class="col-md-4 justify-content-between">
			<span class="col-md-3">Job Role:</span> <strong>{{$Contact->Job_Title}}</strong>
		
		</div>
		
		<div class="col-md-4 justify-content-between">
			<span class="col-md-3">Organisation:</span> <strong>{{$Org->Name}}</strong>
		
		</div>
		
		
			
			
	
	</div>
	
	

</div>

			<table id="dtBasicExample" class="table table-striped table-bordered mt-2" cellspacing="0" width="100%">
  <thead class="black white-text">
    <tr>
      <th class="th-sm">Timesheet W/E
      </th>
      <th class="th-sm">Role
      </th>
      <th class="th-sm">Organisation
      </th>
      <th class="th-sm">Total Hours
      </th>
      <th class="th-sm">Cost?
      </th>
      <th class="th-sm">Last Timesheet ( w/e )
      </th>
    </tr>
  </thead>
  <tbody>
	  
<?php 
	
	foreach($TimeSheets as $TimeSheet){
	$Time = db::table('Timesheet_Item')->where('Timesheet_ID',$TimeSheet->Timesheet_ID)->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3])->pluck('Timesheet_Item_ID');
	$TotalTime = db::table('Timesheet_Item_Time')->whereIn('Timesheet_Item_ID',$Time)->select(DB::raw('SUM(Time_Basic) as Total'))->first();

		?>
	    <tr>
      <td>{{Carbon::create($TimeSheet->Period_Ending_Date)}}</td>
      <td>{{$Contact->Job_Title}}</td>
      <td>{{$Org->Name}}</td>
      <td>{{ number_format((float)$TotalTime->Total, 2, '.', '')}}</td>
      <td>£{{ number_format((float)$TotalTime->Total, 2, '.', '')}}</td>
      <td><a href="LPT2/User/export?time=97340" class="green-text" data-id="{{$TimeSheet-TimeSheet_ID}}"><i class="fas fa-file-excel"></i> View </a></td>
    </tr>
	  
	  
	  <?php
	}
  
    ?>
  </tbody>

</table>



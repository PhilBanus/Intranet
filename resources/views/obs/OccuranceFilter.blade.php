<?php use Carbon\Carbon; 
 use Carbon\CarbonInterface; 
$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$OccurancesFilt = [];

if($_GET['CloseCalls'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',1));
}
if($_GET['GoodPractice'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',2));
}
if($_GET['Incidents'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',3));
}
if($_GET['Accident'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',4));
}
if($_GET['Innovation'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',5));
}
if($_GET['Open'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',1));
}
if($_GET['Closed'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',0));
}
if($_GET['Time'] === 'Week'){
	array_push($OccurancesFilt,array('Date','>=',$now->startOfWeek(Carbon::SUNDAY)->subWeeks(2)));
	array_push($OccurancesFilt,array('Date','<',Carbon::now()->endOfWeek(Carbon::SUNDAY)->subWeek()));
		//array_push($OccurancesFilt,array('Date','<',Carbon::now()->subWeek()->endOfWeek(Carbon::SUNDAY)));

}
if($_GET['Time'] === 'Month'){
	array_push($OccurancesFilt,array('Date','>=',$now->subMonth()->startOfMonth()));
		array_push($OccurancesFilt,array('Date','<',Carbon::now()->subMonth()->endOfMonth()));

}
if($_GET['Time'] === 'Year'){
	array_push($OccurancesFilt,array('Date','>=',$now->subYear()->startOfYear()));
	array_push($OccurancesFilt,array('Date','<',Carbon::now()->startOfYear()));
}
if($_GET['Time'] === 'ThisYear'){
	array_push($OccurancesFilt,array('Date','>=',$now->startOfYear()));
}
$DateDiff = 32;
if($_GET['Time'] === 'Range'){
		if(isset($_GET['fromRange'])) {
  array_push($OccurancesFilt,array('Date','>',Carbon::createFromFormat('d-m-Y',$_GET['fromRange'])));
		$DateDiff = Carbon::createFromFormat('d-m-Y',$_GET['fromRange'])->diffInDays($now);
}
	
	if(isset($_GET['toRange'])) {
  array_push($OccurancesFilt,array('Date','<',Carbon::createFromFormat('d-m-Y',$_GET['toRange'])));
		$DateDiff = Carbon::createFromFormat('d-m-Y',$_GET['toRange'])->diffInDays($now);
}
	
	if( isset($_GET['fromRange']) && isset($_GET['toRange']) ){
		$DateDiff = Carbon::create($_GET['fromRange'])->diffInDays($_GET['toRange']);
	}
	
}

if($_GET['Project_0'] === 'false'){
	array_push($OccurancesFilt,array('Site','!=',0));
}


if($_GET['Quality'] === 'false'){
	array_push($OccurancesFilt,array('Q','!=',1));
}


if($_GET['HealthAndSafety'] === 'false'){
	array_push($OccurancesFilt,array('HS','!=',1));
}

if($_GET['Environment'] === 'false'){
	array_push($OccurancesFilt,array('ENV','!=',1));
}



if($_GET['Project_History'] === 'false'){
	foreach(DB::table('Project')->whereNotIn('Project_ID',DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->pluck('Linked_entity'))->pluck('Project_ID') as $hisory){
		array_push($OccurancesFilt,array('Site','!=',$hisory));
	}
	
	
}


foreach(DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->get() as $Project){
	
	if($_GET['Project_'.$Project->Linked_Entity] === 'false'){
	array_push($OccurancesFilt,array('Site','!=',$Project->Linked_Entity));
}
	
}


?>



<style>
.heading {
  font-weight: 700;
  color: #5d4267;
}
.card.colorful-card .testimonial-card .card-up {
  height: 95px;
}
.card.colorful-card .testimonial-card .avatar {
  border: 3px solid #fff !important;
}
.card.booking-card {
  background-color: #c7f2e3;
}
.card.booking-card .fa {
  color: #f7aa00;
}
.card.booking-card .card-body .card-text {
  color: #db2d43;
}
.card.card.booking-card .chip {
  background-color: #87e5da;
}
.card.booking-card .card-body hr {
  border-top: 1px solid #f7aa00;
}
.closecall-color {
  background-color: #024a94;
}
.goodpractice-color {
  background-color: green;
}
.fuchsia-rose-text {
  color: #db0075;
}
.aqua-sky-text {
  color: #5cc6c3;
}
.closecall-color-text {
  color: #F0C05A;
}
.list-inline-item .fas, .list-inline-item .far {
  font-size: .8rem;
}
.chili-pepper-text {
  color: #9B1B30;
}
.collapse-content .fa.fa-heart:hover {
  color: #f44336 !important;
}
.collapse-content .fa.fa-share-alt:hover {
  color: #0d47a1 !important;
}
	
	    canvas{
        width: 100% !important;
        max-width: 800px;
        height: auto !important;
    }
	
	
	.trimmed_Boot .modal-body{
		padding: 0;
		margin: 0
		
		
		
	}
	
	.trimmed_Boot .modal-header{
		background-color: #024a94;
		color: white;
		font-weight: bold;
	}
	
	.trimmed_Boot .modal-header .close{
		color: white;
		font-weight: bold;
	}

	
	
	
</style>
<?php if( DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->exists() ){
	?>
	<div class="card border-0 p-0 m-0">
	<div class="card-body m-0 p-0">
		<div class="row d-flex">
	<div class="ml-auto">
						<a href="OccuranceExport?<?php echo $_SERVER["QUERY_STRING"] ?>" class="card text-white green mb-3" >
						<div class="card-body text-center p-2">
						<h6 class="card-title m-0"><i class="fas fa-file-excel"></i></h6>
						</div>
						</a>
					</div>
			
			</div>
		<div class="row m-0 p-0" style="overflow: hidden">
		<div class="col-md-12 row">
			
			
			
			<div class="col-md">
			<div class="card text-white bg-info text-center mb-3 Expandable_Card point" >
  <div class="card-body overflow-hidden">
	  	  <h5 class="card-title text-center ">Total HART's</h5>
		  <span class="ml-auto"> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->count()}} </span> 
  </div>
				<div class="card-footer note-info text-dark text-left m-2"  style="display: none">

					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('HS',1)->exists())
									<small><div  class="text-left "><strong>Health and Safety</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('HS',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('ENV',1)->exists())
				<small><div  class="text-left "><strong>Environment</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('ENV',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Q',1)->exists())
				<small><div  class="text-left "><strong>Quality</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Q',1)->count()}} </span> 
				</small>
					@endif
				</div>
</div>
				</div>
			
			
			
			<div class="col-md">
			<div class="card text-white bg-danger text-center mb-3 Expandable_Card point" >
  <div class="card-body overflow-hidden">
	  <h5 class="card-title text-center ">Accidents </h5>
    <span class="ml-auto">{{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4)->count()}} </span>
	  
  </div>
					<div class="card-footer note-danger text-dark text-left m-2"  style="display: none">
						@foreach(DB::table('Project')->whereIn('Project_ID',DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4)->pluck('Site'))->get() as $Project)
						<small><div  class="text-left "><strong>{{$Project->Name}}</strong></div>
							<span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Site',$Project->Project_ID)->where('Occurance',4)->count()}} </span> 
				</small>
						
						@endforeach
		
				</div>
				
</div>	
				</div>
			<div class="col-md">
			<div class="card text-white mb-3 text-center Expandable_Card point" style="background-color: coral">
				<div class="card-body overflow-hidden">
					<h5 class="card-title text-center ">Incidents </h5>
    <span class="ml-auto">{{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->count()}}</span>
	  
  </div>
				<div class="card-footer note-warning text-dark text-left m-2"  style="display: none">
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('HS',1)->exists())
									<small><div  class="text-left "><strong>Health and Safety</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('HS',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('ENV',1)->exists())
				<small><div  class="text-left "><strong>Environment</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('ENV',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('Q',1)->exists())
				<small><div  class="text-left "><strong>Quality</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('Q',1)->count()}} </span> 
				</small>
					@endif
				</div>
</div>
				</div>
			<div class="col-md">
					
			<div class="card text-white bg-warning text-center mb-3 Expandable_Card point" >
  <div class="card-body overflow-hidden">
	  <h5 class="card-title text-center ">Service Strikes</h5>
    <span class="ml-auto">{{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where(function($query){
		$query->where('Sub','Service Strike');
		$query->orwhere('Category','Service Strike');
		})->count()}}</span>
	  
  </div>
				
				<div class="card-footer note-warning text-dark text-left m-2" style="display: none">
						@foreach(DB::table('Project')->whereIn('Project_ID',DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where(function($query){
		$query->where('Sub','Service Strike');
		$query->orwhere('Category','Service Strike');
		})->pluck('Site'))->get() as $Project)
						<small><div  class="text-left "><strong>{{$Project->Name}}</strong></div>
							<span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where(function($query){
		$query->where('Sub','Service Strike');
		$query->orwhere('Category','Service Strike');
		})->where('Site',$Project->Project_ID)->count()}} </span> 
				</small>
						
						@endforeach
		
				</div>
</div>
				</div>
			<div class="col-md">
				
					<div class="card text-white text-center bg-primary mb-3 Expandable_Card point" >
  <div class="card-body overflow-hidden">
	  <h5 class="card-title text-center ">Close Calls </h5>
    <span class="ml-auto">{{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->count()}}</span>
	  
  </div>
						<div class="card-footer note-primary text-dark text-left m-2"  style="display: none">

					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('HS',1)->exists())
											<small><div  class="text-left "><strong>Health and Safety</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('HS',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('ENV',1)->exists())
				<small><div  class="text-left "><strong>Environment</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('ENV',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('Q',1)->exists())
				<small><div  class="text-left "><strong>Quality</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('Q',1)->count()}} </span> 
				</small>
					@endif
				</div>
</div>	
				</div>
			<div class="col-md">
					<div class="card text-white bg-success text-center mb-3 Expandable_Card point" >
  <div class="card-body overflow-hidden">
	  <h5 class="card-title text-center ">Good Practice</h5>
    <span class="ml-auto">{{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->count()}}</span>
	  
  </div>
							<div class="card-footer note-success text-dark text-left m-2"  style="display: none">
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('HS',1)->exists())
												<small><div  class="text-left "><strong>Health and Safety</strong></div>

		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('HS',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('ENV',1)->exists())
				<small><div  class="text-left "><strong>Environment</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('ENV',1)->count()}} </span> 
				</small>
					@endif
					@if(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('Q',1)->exists())
				<small><div  class="text-left "><strong>Quality</strong></div>
		  <span class=""> {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('Q',1)->count()}} </span> 
				</small>
					@endif
				</div>
</div>
</div>
			
			</div>
			
			<div class="col-md-12">
				
				@php
				$Pertotal = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->count();
				$PerHUK = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Member_Of_Public','HOCHTIEF Employee')->count();
				$PerSUB = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Member_Of_Public','Subcontractor')->count();
				$PerMOP = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Member_Of_Public','Member of Public')->count();
				$PerNUL = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->whereNull('Member_Of_Public')->count();
				
				$PercentHUK = number_format(($PerHUK/$Pertotal) * 100,2); 
				$PercentSUB = number_format(($PerSUB/$Pertotal) * 100,2);
				$PercentMOP = number_format(($PerMOP/$Pertotal) * 100,2);
				$PercentNUL = number_format(($PerNUL/$Pertotal) * 100,2);
				
				@endphp
				
					<div class="progress">
  <div class="progress-bar bg-primary" role="progressbar" style="width: {{$PercentHUK}}%" aria-valuenow="{{$PercentHUK}}" aria-valuemin="0" aria-valuemax="100">{{$PercentHUK}}%</div>
  <div class="progress-bar bg-success" role="progressbar" style="width: {{$PercentSUB}}%" aria-valuenow="{{$PercentSUB}}" aria-valuemin="0" aria-valuemax="100">{{$PercentSUB}}%</div>
  <div class="progress-bar bg-warning" role="progressbar" style="width: {{$PercentMOP}}%" aria-valuenow="{{$PercentMOP}}" aria-valuemin="0" aria-valuemax="100">{{$PercentMOP}}%</div>
  <div class="progress-bar bg-light" role="progressbar"  style="width: {{$PercentNUL}}%" aria-valuenow="{{$PercentNUL}}" aria-valuemin="0" aria-valuemax="100">{{$PercentNUL}}%</div>
</div>
				
				<div class="row mt-2">
					<span class="col-md"><div class="badge badge-primary p-2"> </div> HOCHTIEF Employees - {{$PerHUK}} ({{$PercentHUK}}%)</span>
					<span class="col-md"><div class="badge badge-success p-2"> </div> Subcontractors - {{$PerSUB}} ({{$PercentSUB}}%)</span>
					<span class="col-md"><div class="badge badge-warning p-2"> </div> Member of Public - {{$PerMOP}} ({{$PercentMOP}}%)</span>
					<span class="col-md"><div class="badge badge-light p-2"> </div> Not recorded - {{$PerNUL}} ({{$PercentNUL}}%) </span>
				
				</div>
		
			</div>
			
		
			<div class="col-md-12 m-0 p-0 " style="display: block">
			
			<div class="col-xl-6 col-lg-12 float-left" style="display: block">
			
			<div class="card text-center border-0" style="height: auto" style="display: block">
									<div class="card-header bg-transparent border-primary">HART Reports over Time</div>

					<div class="card-body" style="height: auto">
					<canvas id="time-chart"></canvas>
				
					</div>
			
					</div>
			</div>
				
					
				
				
				<div class="col-xl-6 col-lg-12  float-left" style="display: block">
				<div class="card text-center border-0" style="display: block">
									<div class="card-header bg-transparent border-primary">HART Reports by Category</div>

					<div class="card-body">
					<canvas id="category-chart"></canvas></div>
			
					</div>
			</div>
				
				
				
					
					<div class="col-xl-6 col-lg-12 float-left" style="display: block">
				<div class="card text-center border-0" style="display: block">
									<div class="card-header bg-transparent border-primary">Accidents by Category</div>

					<div class="card-body">
					<canvas id="AccidentPie-chart"></canvas></div>
			
					</div>
			</div>	
				
				<div class="col-xl-6 col-lg-12 float-left" style="display: block">
				<div class="card text-center border-0" style="display: block">
									
					
					
					
					
					
					
					
					
					
					
					
					<div class="card-header bg-transparent border-primary">Close Calls by Category (Top 15)</div>

					
					
				
					
					
					
					
					
					
					
					
					<div class="card-body">
					<canvas id="HART-chart"></canvas></div>
			
					</div>
			</div>	
			
		</div>
			
			
		
			<div class="col-md-12 m-0 p-0 row">
			
	
				<div class="card bg-transparent border-0 mb-3"  style="height: 300px">
				<div class="card-header bg-transparent border-primary">Recent HART Reports (100)</div>
				<div class="card-body p-0 m-0 h-100 fh-card custom-scroll"  id="Timeline"  style="overflow: auto">
				<ul class="list-group list-group-flush">
			<?php 
				$Recents = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt);
					$Recents = $Recents->orderby('Date','desc')->take(100)->get(); 
				
				foreach($Recents as $Recent){
					if($Recent->Sign_Off){
						$Color = 'list-group-item-success';
					}else{
						$Color = 'list-group-item-danger';
					}
					?>
				<a href="OccuranceView?id={{$Recent->ID}}" target="new" class="list-group-item list-group-item-action small p-1 text-truncate {{$Color}}">
					<?php 
					if($Recent->Occurance == 1){ echo '<i class="fas fa-closed-captioning" style="color: #024a94"></i>'; }
					if($Recent->Occurance == 2){ echo '<i class="fas fa-check text-success"></i>'; }
					if($Recent->Occurance == 3){ echo '<i class="fas fa-exclamation-triangle text-warning"></i>'; }
					if($Recent->Occurance == 4){ echo '<i class="fas fa-user-injured text-danger"></i>'; }
					if($Recent->Occurance == 5){ echo '<i class="far fa-lightbulb text-info"></i>'; }
					
					
					
					
					?>
					
					{{Carbon::parse($Recent->Date)->diffForHumans(Carbon::now(), [
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
    'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
])}} - {{$Recent->Location}}
					
					 / <?php 
					
					if($Recent->Occurance != 3 || $Recent->Occurance != 4){ echo urldecode($Recent->Details); } else{ echo "Click to view"; }
					?>
					
					</a>
				<?php
					
				}
				
				
				?>
			</ul>
				</div>
				</div>

			
			
				
			
			
				<div class="col-md">
									<div class="card text-white secondary-color text-center mb-3" >
  <div class="card-body overflow-hidden">
	  <h6 class="card-title text-center ">Common Category</h6>
    <small class="text-white"><?php 
		
	$cat = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select('Category')->groupby('Category')->orderBy(db::raw('Count(*)','desc'))->get(); 
		
	echo $cat->last()->Category;
																														  ?>
	  
	  </small>
  </div>
</div>	
</div>	

				<div class="col-md">
									<div class="card text-white info-color text-center mb-3" >
  <div class="card-body overflow-hidden">
	  <h6 class="card-title text-center ">Common Sub Category</h6>
    <small class="text-white"><?php 
		
	$cat = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->whereNotNull('sub')->select('Sub')->groupby('Sub')->orderBy(db::raw('Count(*)','desc'))->get(); 
		
	echo $cat->last()->Sub;
																														  ?>
	  
	  </small>
  </div>
</div>	
</div>	
<div class="col-md">
						<div class="card text-white primary-color text-center mb-3" >
  <div class="card-body overflow-hidden">
	  <h6 class="card-title text-center ">Common Occurance Day</h6>
    <small class="text-white"><?php 
		
		$number = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select(db::raw('DATEPART(Weekday, Date) as day'))->groupby(db::raw('DATEPART(Weekday, Date)'))->orderBy(db::raw('Count(*)'),'desc')->first()->day; 
		
		if($number == 2){ echo "Monday";}
		if($number == 3){ echo "Tuesday";}
		if($number == 4){ echo "Wednesday";}
		if($number == 5){ echo "Thursday";}
		if($number == 6){ echo "Friday";}
		if($number == 7){ echo "Saturday";}
		if($number == 1){ echo "Sunday";}
																														  
																														  ?>
	  
	  </small>
  </div>
</div>	
</div>	
		
			<div class="col-md">
			<div class="card text-white  text-center bg-dark mb-3">
  <div class="card-body overflow-hidden">
	  	  <i class="fal fa-stopwatch position-absolute fa-6x m-2" style="right: 0; opacity: 0.3"></i>

    <h6 class="card-title">Average Time to Close</h6>
    <small class="text-white">
		<?php
		
		$d = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select(DB::raw("DATEDIFF(day,Date, Closed_Date)AS day_diff"))->get()->avg('day_diff');
			$Days = floor($d);      
			$dayFraction = $d - $Days;
		
		$h = 24*$dayFraction;
			$hours = floor($h); 
			$hourFraction = $h - $hours;
		
		$m = 60*$hourFraction;
			$minutes = floor($m);
				
				echo "$Days days, $hours hours and $minutes minutes";
			
			?>
	  </small>
  </div>
</div>
</div>
		
	
	
			
			</div>
		</div>
		
		
		
		
		</div>
	</div>



<?php
}else{
	?>
	<div class="alert alert-danger" role="alert">
  <h4 class="alert-heading">No Occurances!</h4>
  <p>Either your search turned up no results or no Occurances has been logged against this project yet. </p>
  <hr>
  <p class="mb-0">Please try a different search</p>
</div>
<?php
}

?>




<?php

function percentDifference($a,$b){
	if($a == 0 && $b == 0){
		echo "No Improvement";
	}else{
			if($a < $b){
				$percent = round((($a - $b)/(($a+$b)/2))*100);
				echo "Less than last week (".str_replace('-','',$percent)."%)";
			}else{
				$percent = round((($a - $b)/(($a+$b)/2))*100);
				echo "More than last week (".$percent."%)";
			}
	}
			}
function NpercentDifference($a,$b){
	if($a == 0 && $b == 0){
		echo "0%";
	}else{
			if($a < $b){
				$percent = (($a - $b)/(($a+$b)/2))*100;
				echo str_replace('-','',$percent)."%; background-color: red !important";
			}else{
				$percent = (($a - $b)/(($a+$b)/2))*100;
				echo $percent."%; background-color: green !important";
			}
	}
				
			}


?>

<script>
	
	$(document).ready(function(){
		var Scrollbar = document.querySelector('.custom-scroll');
	if(Scrollbar){
var ps = new PerfectScrollbar(Scrollbar);
	}
		
	})

	<?php 
	
	$Categories = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt);
		$Categories = $Categories->select('Category', DB::raw('count(*) as count'))
             ->groupBy('Category')->get();
	
	?>
//bar
	var ctxP = document.getElementById("category-chart").getContext('2d');
var myPieChart = new Chart(ctxP, {
  plugins: [ChartDataLabels],
  type: 'bar',
  data: {
    labels: ['Health and Safety',
			 'Environment',
			 'Quality'],
	  
	  datasets: [{
		  label: 'Close Calls',
		  backgroundColor: '#024a94',
		  hoverBackgroundColor: '#151e5f',
		  data: [
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('HS',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('ENV',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',1)->where('Q',True)->count()}},
		  ]
	  },{
		  label: 'Good Practice',
		  backgroundColor: 'green',
		  hoverBackgroundColor: 'darkgreen',
		  data: [
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('HS',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('ENV',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',2)->where('Q',True)->count()}},
		  ]
	  },{
		  label: 'Incidents',
		  backgroundColor: 'orange',
		  hoverBackgroundColor: 'amber',
		  data: [
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('HS',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('ENV',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',3)->where('Q',True)->count()}},
		  ]
	  },{
		  label: 'Accidents',
		  backgroundColor: 'red',
		  hoverBackgroundColor: 'darkred',
		  data: [
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4)->where('HS',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4)->where('ENV',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4)->where('Q',True)->count()}},
		  ]
	  },{
		  label: 'Innovation',
		  backgroundColor: 'lightblue',
		  hoverBackgroundColor: 'blue',
		  data: [
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',5)->where('HS',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',5)->where('ENV',True)->count()}},
			  {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',5)->where('Q',True)->count()}},
		  ]
	  },
				],
	
  },
  options: {
	  
	  scales: {
            xAxes: [{
                stacked: true
            }],
            yAxes: [{
                stacked: true
            }]
        },
    responsive: true,
	  tooltips:{
		  mode: 'index',
		  intersect: false
	  },
    legend: {
      display: false
    },
    plugins: {
      datalabels: {
        formatter: function(value, ctx) {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map(function(data){
            sum = {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->count()}};
          });
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: 'white',
        labels: {
          title: {
            font: {
              size: '0'
            }
          }
        }
      }
    }
  }
});
	
	
	
	<?php 
	if($_GET['Time'] === "Week" || $_GET['Time'] === "Month" || $DateDiff < 31){
		
	$CloseCalls = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select(DB::raw("DAY(Date) as day"),DB::raw("MONTH(Date) as month"),DB::raw("YEAR(Date) as year"),DB::raw("count(*) as count"),"Occurance")->groupby(DB::raw("DAY(Date)"),DB::raw("MONTH(Date)"),DB::raw("YEAR(Date)"), "Occurance")->orderby('year','asc')->orderby('month','asc')->orderby('day','asc')->get();
	
	$Labels = []; 
	$Labels1 = []; 
	$Labels2 = []; 
	$Labels3 = []; 
	$Labels4 = []; 
	$Labels5 = []; 
	$Data1 = [];
	$Data2 = [];
	$Data3 = [];
	$Data4 = [];
	$Data5 = [];

	foreach(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select(DB::raw("DAY(Date) as day"),DB::raw("MONTH(Date) as month"),DB::raw("YEAR(Date) as year"),DB::raw("count(*) as count"))->groupby(DB::raw("DAY(Date)"),DB::raw("MONTH(Date)"),DB::raw("YEAR(Date)"))->orderby('year','asc')->orderby('month','asc')->orderby('day','asc')->get() as $D){
		$date = Carbon::parse($D->year."-".$D->month."-".$D->day);
		$year = $date->year;
		$month = $date->englishMonth;
		$day = $date->day;
		
		array_push($Labels, "'$day $month $year'");
	
	}
	
	
	
	
		
		foreach($CloseCalls->where('Occurance',1) as $cc){
		
		$date = Carbon::parse($cc->year."-".$cc->month."-".$cc->day);
		$year = $date->year;
		$month = $date->englishMonth;
		$day = $date->day;
		$thislabel = "'$day $month $year'";
		
			array_push($Data1, $cc->count);
			array_push($Labels1, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',2) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-".$D->day);
		$year = $date->year;
		$month = $date->englishMonth;
		$day = $date->day;
		$thislabel = "'$day $month $year'";
		
		
			array_push($Data2, $D->count);
			array_push($Labels2, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',3) as $D){
		$date = Carbon::parse($D->year."-".$D->month."-".$D->day);
		$year = $date->year;
		$month = $date->englishMonth;
		$day = $date->day;
		$thislabel = "'$day $month $year'";
		
		
			array_push($Data3, $D->count);
			array_push($Labels3, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',4) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-".$D->day);
		$year = $date->year;
		$month = $date->englishMonth;
		$day = $date->day;
		$thislabel = "'$day $month $year'";
		
			array_push($Data4, $D->count);
			array_push($Labels4, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',5) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-".$D->day);
		$year = $date->year;
		$month = $date->englishMonth;
		$day = $date->day;
		$thislabel = "'$day $month $year'";
		
		
			array_push($Data5, $D->count);
			array_push($Labels5, $thislabel);
	
	}
		
	}
	else{
		
	
	$CloseCalls = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select(DB::raw("MONTH(Date) as month"),DB::raw("YEAR(Date) as year"),DB::raw("count(*) as count"),"Occurance")->groupby(DB::raw("MONTH(Date)"),DB::raw("YEAR(Date)"), "Occurance")->orderby('year','asc')->orderby('month','asc')->get();
	
	$Labels = []; 
	$Labels1 = []; 
	$Labels2 = []; 
	$Labels3 = []; 
	$Labels4 = []; 
	$Labels5 = []; 
	$Data1 = [];
	$Data2 = [];
	$Data3 = [];
	$Data4 = [];
	$Data5 = [];

	foreach(DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->select(DB::raw("MONTH(Date) as month"),DB::raw("YEAR(Date) as year"),DB::raw("count(*) as count"))->groupby(DB::raw("MONTH(Date)"),DB::raw("YEAR(Date)"))->orderby('year','asc')->orderby('month','asc')->get() as $D){
		$date = Carbon::parse($D->year."-".$D->month."-1");
		$year = $date->year;
		$month = $date->englishMonth;
		
		array_push($Labels, "'$month $year'");
	
	}
	
	
	
	
		
		foreach($CloseCalls->where('Occurance',1) as $cc){
		
		$date = Carbon::parse($cc->year."-".$cc->month."-1");
		$year = $date->year;
		$month = $date->englishMonth;
		$thislabel = "'$month $year'";
		
			array_push($Data1, $cc->count);
			array_push($Labels1, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',2) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-1");
		$year = $date->year;
		$month = $date->englishMonth;
		$thislabel = "'$month $year'";
		
			array_push($Data2, $D->count);
			array_push($Labels2, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',3) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-1");
		$year = $date->year;
		$month = $date->englishMonth;
		$thislabel = "'$month $year'";
		
			array_push($Data3, $D->count);
			array_push($Labels3, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',4) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-1");
		$year = $date->year;
		$month = $date->englishMonth;
		$thislabel = "'$month $year'";
		
			array_push($Data4, $D->count);
			array_push($Labels4, $thislabel);
	
	}
	
		
		foreach($CloseCalls->where('Occurance',5) as $D){
		
		$date = Carbon::parse($D->year."-".$D->month."-1");
		$year = $date->year;
		$month = $date->englishMonth;
		$thislabel = "'$month $year'";
		
			array_push($Data5, $D->count);
			array_push($Labels5, $thislabel);
	
	}
	
	}
	foreach ($Labels as $Label)
{
    $index1 = 0;
  
		
        if (!in_array($Label, $Labels1))
           {
		   array_splice($Data1, $index1, 0, 0);
		   }
        else
           {
		   
		   }
        if (!in_array($Label, $Labels2))
           {
		   array_splice($Data2, $index1, 0, 0);
		   }
        else
           {
		   
		   }
        if (!in_array($Label, $Labels3))
           {
		   array_splice($Data3, $index1, 0, 0);
		   }
        else
           {
		   
		   }
        if (!in_array($Label, $Labels4))
           {
		   array_splice($Data4, $index1, 0, 0);
		   }
        else
           {
		   
		   }
        if (!in_array($Label, $Labels5))
           {
		   array_splice($Data5, $index1, 0, 0);
		   }
        else
           {
		   
		   }
		
$index1++;
		
       
    }
		

	
	?>
	
	
	
	//line
var ctxL = document.getElementById("time-chart").getContext('2d');
var myLineChart = new Chart(ctxL, {
type: 'line',
data: {
labels: [<?php echo implode(",",$Labels) ?>],
datasets: [
	<?php if($_GET['CloseCalls'] !== 'false'){
	?>
	{
label: "Close Calls",
data: [<?php echo implode(",",$Data1) ?>],
backgroundColor: [
'rgba(63, 114, 155, 0.2)',
],
borderColor: [
'#024a94',
],
borderWidth: 2
},
	<?php
	
} ?>

	<?php if($_GET['GoodPractice'] !== 'false'){
	?>
	
{
label: "Good Practice",
data: [<?php echo implode(",",$Data2) ?>],
backgroundColor: [
'rgba(0, 126, 51, .2)',
],
borderColor: [
'#00C851',
],
borderWidth: 2
},
	<?php
	
} ?>
	<?php if($_GET['Incidents'] !== 'false'){
	?>
	
{
label: "Incidents",
data: [<?php echo implode(",",$Data3) ?>],
backgroundColor: [
'rgba(255, 136, 0, 0.2)',
],
borderColor: [
'#ffbb33',
],
borderWidth: 2
},
		<?php
	
} ?>
	<?php if($_GET['Accident'] !== 'false'){
	?>
	
{
label: "Accidents",
data: [<?php echo implode(",",$Data4) ?>],
backgroundColor: [
'rgba(204, 0, 0, 0.2)',
],
borderColor: [
'#ff4444',
],
borderWidth: 2
},
		<?php
	
} ?>
	<?php if($_GET['Innovation'] !== 'false'){
	?>
	
{
label: "Innovation",
data: [<?php echo implode(",",$Data5) ?>],
backgroundColor: [
'rgba(0, 153, 204, 0.22)',
],
borderColor: [
'#33b5e5',
],
borderWidth: 2
}
		<?php
	
} ?>
]
},
options: {
responsive: true
}
});

	
	$(function() {
		if($(".fh-card").length > 0){
		var height = $(window).height();
		console.log(height)
		var offset = $(".fh-card").offset();
		height = height-offset.top-10;
		
		
		$(".fh-card").css("max-height", height)
		}
	})
	
	
	$(function () {
  $('.min-chart#chart-accidentCount').easyPieChart({
    barColor: "red",
    onStep: function (from, to, percent) {
		var total = {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->count()}};
		var accident = {{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4)->count()}};
		var percent = (accident/total)*100
	$(this.el).attr('data-percent',percent.toFixed(2))
      $(this.el).find('.percent').text(percent.toFixed(2));
    }
  });
});
	
	//pie
	@php
	$AccidentCategories = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance',4);
		$AccidentCategories = $AccidentCategories->select('RIDDOR', DB::raw('count(*) as count'))
             ->groupBy('RIDDOR')->get();
	@endphp
	
	var AccidentPie = document.getElementById("AccidentPie-chart").getContext('2d');
var AccidentPieChart = new Chart(AccidentPie, {
  plugins: [ChartDataLabels],
  type: 'pie',
  data: {
    labels: [<?php foreach($AccidentCategories as $Cat){ echo "'$Cat->RIDDOR'," ; } ?>],
    datasets: [{
      data: [<?php foreach($AccidentCategories as $Cat){ echo "$Cat->count," ; } ?>],
      backgroundColor: [
		  <?php foreach($AccidentCategories as $Cat){
	$color =  DB::table('UKHT_Occurance_RIDDOR')->where('name','like','%'.$Cat->RIDDOR.'%' )->first()->color;
			echo '"';
			echo $color ? $color : 'grey';
			echo '",';

} ?>
	  ],
      hoverBackgroundColor: [
		  <?php foreach($AccidentCategories as $Cat){
	$color =  DB::table('UKHT_Occurance_RIDDOR')->where('name','like','%'.$Cat->RIDDOR.'%' )->first()->HOVERcolor;
			echo '"';
			echo $color ? $color : 'grey';
			echo '",';

} ?>
	  ]
    }]
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom',
      labels: {
        padding: 0,
        boxWidth: 10
      }
    },
    plugins: {
      datalabels: {
        formatter: function(value, ctx) {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map(function(data){
            sum += data;
          });
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return value;
        },
        
        labels: {
          title: {
            font: {
              size: '16'
            }
          }
        }
      }
    }
  }
});
	
	
	<?php 
	
	
	$DistinctCat = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance' ,1)->select('Category', DB::raw('count(*) as count'))->groupBy('Category')->orderby('count','desc')->take(15)->get();
	?>
	
	
	var HARTChartArea = document.getElementById('HART-chart').getContext('2d');
	var HartChart = new Chart(HARTChartArea,{
		type: 'horizontalBar',
		
data: {
labels: [
			@foreach($DistinctCat as $Cat)
	"{{$Cat->Category}}",
	@endforeach
	
		],
datasets: [{
label: 'Count',
data: [
	
	@foreach($DistinctCat as $Cat)
	{{DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance' ,1)->where('Category',$Cat->Category)->count()}},
	@endforeach
	
	],
backgroundColor: [
'green',
'yellow',
'red',
	@foreach($DistinctCat as $Cat)	
'{{'#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)]}}',
	@endforeach

],
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
},
	responsive: true,
	  tooltips:{
		  mode: 'index',
		  intersect: false
	  },
    legend: {
      display: false
    },
	onClick: function(evt){
	var activePoints = HartChart.getElementsAtEvent(evt);
      if (activePoints[0]) {
        var chartData = activePoints[0]['_chart'].config.data;
        var idx = activePoints[0]['_index'];

        var label = chartData.labels[idx];
        var value = chartData.datasets[0].data[idx];

        $.get('HARTChartData', {name: label, 
								@foreach($_GET as $key => $value)
								{{$key}}: 
			  @if($value === true || $value === false)
			  {{$value}}
		  @else
		  '{{$value}}'
			  @endif
			  ,
			  					@endforeach
			  }, function(result) {
        
				  console.log(result)
		
			bootbox.alert({
				title: label,
    message: result,
				backdrop: true,
				className: 'trimmed_Boot',
				scrollable: true
});
			
    });
      }	
	}
}
});
	
	
	$('.Expandable_Card').on('click',function(){
		$('.Expandable_Card').children('.card-footer').slideToggle();
	})
	
	
</script>

<?php use Carbon\Carbon; 
 use Carbon\CarbonInterface; 
$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$Occurances = DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code']);

$OccurancesFilt = DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code']);


?>

@extends('project')
@section('content')
<!--Main Layout-->

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
.card-wrapper.card-action {
  min-height: 400px;
}
	
		
	#SidePanel{
		
		z-index: 10; 
		opacity: 0%;
		transition: 0.5s;
	}
</style>


<div class="modal fade left" id="FiltersActions" tabindex="-1" role="dialog" aria-labelledby="FiltersActionsLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-full-height modal-left " role="document">
    <div class="modal-content">
      <div class="modal-header  bg-primary text-white">
        <h5 class="modal-title" id="FiltersActionsLabel">Filters and Actions</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-dark ">
        

		<ul class="list-group list-group-flush">
	

	
			<li data-id="CloseCalls" class="list-group-item list-group-item-action mt-1 point hide"> <i class="fas fa-closed-captioning" style="color: #024a94"></i> <span>Hide Close Calls</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Occurance',1)->count()}}</div></li>
			<li data-id="GoodPractice" class="list-group-item list-group-item-action point hide"><i class="fas fa-check text-success"></i> <span>Hide Good Practices</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Occurance',2)->count()}}</div></li>
			<li data-id="Incidents" class="list-group-item list-group-item-action point hide"><i class="fas fa-exclamation-triangle text-warning"></i> <span>Hide Incidents</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Occurance',3)->count()}}</div></li>
			<li data-id="Accident" class="list-group-item list-group-item-action point hide"><i class="fas fa-user-injured text-danger"></i> <span>Hide Accidents</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Occurance',4)->count()}}</div></li>
			<li data-id="Innovation" class="list-group-item list-group-item-action point hide"><i class="far fa-lightbulb text-info"></i> <span>Hide Innovation</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Occurance',5)->count()}}</div></li>
			
			<li data-id="HealthAndSafety" class="list-group-item list-group-item-action mt-1 point hide"> <i class="fas fa-heartbeat" style="color: tomato"></i> <span>Hide Health and Safety</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('HS',1)->count()}}</div></li>
			<li data-id="Environment" class="list-group-item list-group-item-action point hide"><i class="fas fa-leaf text-success"></i> <span>Hide Environment</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('ENV',1)->where('Site',$_GET['code'])->count()}}</div></li>
			<li data-id="Quality" class="list-group-item list-group-item-action point hide"><i class="fas fa-tasks text-info"></i> <span>Hide Quality</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Q',1)->where('Site',$_GET['code'])->count()}}</div></li>
			
			<li data-id="Closed" class="list-group-item list-group-item-action mt-1 point hide"><i class="fas fa-door-closed text-success"></i> <span>Hide Closed</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Sign_Off',1)->count()}}</div></li>
			<li data-id="Open" class="list-group-item list-group-item-action point mb-1 hide"><i class="fas fa-door-open text-danger"></i> <span>Hide Open</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$_GET['code'])->where('Sign_Off',0)->count()}}</div></li>
			
				
			<?php 
	
	$Locations = DB::table('UKHT_Occurance_Location')->where([['Site',$_GET['code']],['Removed',0]])->get(); 
	   
	   foreach($Locations as $Location){
		   ?>
			<li data-id="Location_{{$Location->ID}}"  class="list-group-item list-group-item-action point hide"><i class="fas fa-map-marker-alt text-secondary"></i> <span>Hide {{$Location->Name}}</span></li>
			
			<?php
		   
	   }
	?>
		
			
			<li class="list-group-item list-group-item-action mt-1 point bg-success text-white"  onClick="saveSettings()"><i class="fas fa-save"></i> Save my View</li>
			
			<li hidden="" class="list-group-item list-group-item-action mt-1 point blue text-white"><i class="far fa-bell"></i> Notifications</li>
			
			
			
			
	</ul>
	


		  
      </div>
   
		
	  </div>
	  </div>
	  </div>


<div class="row p-1 m-0 h-100">

	
<div class="col-12">
	
	
	<ul class="nav md-pills nav-justified">
		
		<a href="https://themis.ukht.org/XWeb/PublicAssets/external/public/observations?id=<?php echo $_GET['code'] ?>" target="new" ><li class="nav-item">
    	<div class="point bg-success text-white rounded p-2"><i class="fas fa-sign-out-alt"></i> Report a HART </div>
	</li>
  </a>
		
		 <li class="nav-item">
    <div class="point bg-primary text-white rounded p-2" data-toggle="modal" data-target="#FiltersActions">
Other Filters</div>
  </li>  
 
  <li class="nav-item time">
    <div class="nav-link active point" data-id="All">All Time</div>
  </li>
  <li class="nav-item time">
    <div class="nav-link point" data-id="Week">Last Week</div>
  </li>
  <li class="nav-item time">
    <div class="nav-link point" data-id="Month">Last Month</div>
  </li>
  <li class="nav-item time">
    <div class="nav-link point" data-id="ThisYear">This Year</div>
  </li>
  <li class="nav-item time">
    <div class="nav-link point" data-id="Year">Last Year</div>
  </li>
		
		<li class="nav-item time date">
  <input placeholder="From date" type="text" id="fromDate" class="form-control datepicker nav-link point">
 
</li>
		
		<li class="nav-item time date">
  <input placeholder="To date" type="text" id="toDate" class="form-control datepicker nav-link point">
  
</li>
</ul>
	
<div  id="filter">
	<div class="d-flex justify-content-center text-primary fas-2x" >
  <div class="spinner-grow" role="status" style="width: 5rem; height: 5rem;">
    <span class="sr-only">Loading...</span>
  </div>
</div>
	</div>
	
	
 </div>


</div>







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



<div class="modal fade top" id="furtherInformationModal" tabindex="-1" role="dialog" aria-labelledby="furtherInformationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-fluid modal-full-height modal-top p-4" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="furtherInformationModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="Info">
       <div class="preloader-wrapper big active">
  <div class="spinner-layer spinner-blue-only">
    <div class="circle-clipper left">
      <div class="circle"></div>
    </div>
    <div class="gap-patch">
      <div class="circle"></div>
    </div>
    <div class="circle-clipper right">
      <div class="circle"></div>
    </div>
  </div>
</div>
      </div>
  
    </div>
  </div>
</div>
<script type="text/javascript" src="mdbootstrap/js/mdb.min.js"></script>

<script>
	var dataArray = [];
	var Time = "All";
	var startRange = ""
	var endRange = ""
	
$('#furtherInformationModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var table = button.data('table');
var title = button.data('title');
var type = button.data('type');
var occurance = button.data('occurance');
	$('#Info').load('occuranceFurtherInfo?type='+type+'&table='+table+'&occurance='+occurance)

var modal = $(this)
modal.find('.modal-title').text('Further information for ' + title)
	
	
	
})
	
	var from_input = $('#fromDate').pickadate({formatSubmit: 'yyyy/mm/dd',format: 'dd-mm-yyyy'});
    var from_picker = from_input.pickadate('picker');
  var to_input = $('#toDate').pickadate({formatSubmit: 'yyyy/mm/dd',format: 'dd-mm-yyyy'});
   var to_picker = to_input.pickadate('picker');

  // Check if there’s a “from” or “to” date to start with and if so, set their appropriate properties.
  if (from_picker.get('value')) {
    to_picker.set('min', from_picker.get('select'))
	 
  }
  if (to_picker.get('value')) {
    from_picker.set('max', to_picker.get('select'))
	 
  }

  // Apply event listeners in case of setting new “from” / “to” limits to have them update on the other end. If ‘clear’ button is pressed, reset the value.
  from_picker.on('set', function (event) {
	   
    if (event.select) {
      to_picker.set('min', from_picker.get('select'))
		 loadDash()
    } else if ('clear' in event) {
      to_picker.set('min', false)
    }
	  
  })
  to_picker.on('set', function (event) {
	  
    if (event.select) {
      from_picker.set('max', to_picker.get('select') )
		 loadDash()
    } else if ('clear' in event) {
      from_picker.set('max', false)
    }
	  
  })
	
	
	
	$('.nav-item.time').on('click',function(){
		$(this).children('.nav-link').addClass('active');
		$(this).siblings('.nav-item').children('.nav-link').removeClass('active');
		if($(this).hasClass('date')){
			Time = 'Range'
			$(this).siblings('.nav-item.date').children('.nav-link').addClass('active');
			
		}else{
			
			Time = $(this).children('.nav-link').data('id')
			$('#fromDate').val('');
			from_picker.clear();
			from_picker.set('max', false);
			$('#toDate').val('');
			to_picker.clear();
			to_picker.set('min', false)
			
			
			
		}
		loadDash()
	})
	
	$('.hide').on('click',function(){
		
		var text = $(this).children('span').text()
		if($(this).hasClass('strike')){
			$(this).removeClass('strike list-group-item-info');
			$(this).children('span').text(text.replace('Show','Hide'))
		}else{
			$(this).addClass('strike list-group-item-info');
			$(this).children('span').text(text.replace('Hide','Show'))
		}
		
		loadDash()
	});
	
	

	
	function loadDash(){
		dataArray = [];
			var url = "OccuranceProjectFilter?code=<?php echo $_GET['code'] ?>"
	$('.hide').each(function(){
		url += "&"+$(this).data('id')+"=";
		if($(this).hasClass('strike')){
			url += "false"
			dataArray.push({Title:$(this).data('id'),On:false})
		}else{
			url += "true"
			dataArray.push({Title:$(this).data('id'),On:true})
		}
	});
		
		url += "&Time="+Time
		dataArray.push({Title:'Time',On:Time})
		if($('#fromDate').val()){
		url += "&fromRange="+  encodeURI($('#fromDate').val())
			dataArray.push({Title:'fromDate',On:encodeURI($('#fromDate').val())})
		}
		if($('#toDate').val()){
		url += "&toRange="+ encodeURI($('#toDate').val())
			dataArray.push({Title:'toDate',On:encodeURI($('#toDate').val())})
		}
		$('#filter').load(url)
	}
	
	
	
		function saveSettings(){
		var String = '{"items":[ {"Title":"","Data":""}'; 
		var i;
for (i = 0; i < dataArray.length; ++i) {
    String += ',{"Title":"'+dataArray[i]['Title']+'","Data":"'+dataArray[i]['On']+'"}';
}
		
		String += ']}';
		console.log(String)
	
		$.post('OccuranceSaveSettings',{String:String, Entity:{{request('code')}}})
			location.reload();
	}
	
	
	
	<?php 
	$UserSettings = DB::table('UKHT_Occurance_User_Settings')->where(['Contact_ID' => session('MY_ID'),'Entity_ID' => request('code')]);
	if($UserSettings->exists()){
		
		$Settings =  DB::table('UKHT_Occurance_User_Settings')->where(['Contact_ID' => session('MY_ID'),'Entity_ID' => request('code')])->first()->String;
		
		$Settings = json_decode($Settings);
		
		foreach($Settings as $Item){
			foreach($Item as $Setting){
			
				?>
	@if($Setting->Data == "false")
	var {{$Setting->Title}}text = $('[data-id="{{$Setting->Title}}"]').find('span').text();
	$('[data-id="{{$Setting->Title}}"]').addClass('strike list-group-item-info');
	$('[data-id="{{$Setting->Title}}"]').find('span').text({{$Setting->Title}}text.replace('Hide','Show'))
	
	@endif
		 
		 @if($Setting->Data !== "false" && $Setting->Data !== "true")
	$('[data-id="{{$Setting->Data}}"]').parent().siblings('li').children('.nav-link').removeClass('active')
	$('[data-id="{{$Setting->Data}}"]').addClass('active');
		 Time = "{{$Setting->Data}}";
	
	@endif
		 
		@if($Setting->Title == "fromDate" || $Setting->Title == "toDate")
		 $('.nav-item.time').children('div').removeClass('active');
		 $('#{{$Setting->Title}}').addClass('active');
		 $('#{{$Setting->Title}}').val("{{urldecode($Setting->Data)}}");
		 Time = "Range";
		 @endif
	
	
	<?php
				
				
		}
		}
		
		
		
	}
	
	?>
	
	
	loadDash();
</script>
@stop
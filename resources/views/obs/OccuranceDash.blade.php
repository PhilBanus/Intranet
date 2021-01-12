<?php use Carbon\Carbon; 
$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');

?>

@extends('intranet')
@section('content')
<!--Main Layout-->
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
	

			
			<li data-id="CloseCalls" class="list-group-item list-group-item-action mt-1 point hide"> <i class="fas fa-closed-captioning" style="color: #024a94"></i> <span>Hide Close Calls</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Occurance',1)->count()}}</div></li>
			<li data-id="GoodPractice" class="list-group-item list-group-item-action point hide"><i class="fas fa-check text-success"></i> <span>Hide Good Practices</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Occurance',2)->count()}}</div></li>
			<li data-id="Incidents" class="list-group-item list-group-item-action point hide"><i class="fas fa-exclamation-triangle text-warning"></i> <span>Hide Incidents</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Occurance',3)->count()}}</div></li>
			<li data-id="Accident" class="list-group-item list-group-item-action point hide"><i class="fas fa-user-injured text-danger"></i> <span>Hide Accidents</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Occurance',4)->count()}}</div></li>
			<li data-id="Innovation" class="list-group-item list-group-item-action point hide"><i class="far fa-lightbulb text-info"></i> <span>Hide Innovation</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Occurance',5)->count()}}</div></li>
			
			<li data-id="HealthAndSafety" class="list-group-item list-group-item-action mt-1 point hide"> <i class="fas fa-heartbeat" style="color: tomato"></i> <span>Hide Health and Safety</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('HS',1)->count()}}</div></li>
			<li data-id="Environment" class="list-group-item list-group-item-action point hide"><i class="fas fa-leaf text-success"></i> <span>Hide Environment</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('ENV',1)->count()}}</div></li>
			<li data-id="Quality" class="list-group-item list-group-item-action point hide"><i class="fas fa-tasks text-info"></i> <span>Hide Quality</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Q',1)->count()}}</div></li>
			
			
			<li data-id="Closed" class="list-group-item list-group-item-action mt-1 point hide"><i class="fas fa-door-closed text-success"></i> <span>Hide Closed</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Sign_Off',1)->count()}}</div></li>
			<li data-id="Open" class="list-group-item list-group-item-action point mb-1 hide"><i class="fas fa-door-open text-danger"></i> <span>Hide Open</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Sign_Off',0)->count()}}</div></li>
			
			
			<li data-id="Project_0" class="list-group-item list-group-item-action mt-1 point hide"><i class="fas fa-location text-primary"></i> <span>Hide Head Office</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',0)->count()}}</div></li>
			@foreach(DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->get() as $Project)
			<li data-id="Project_{{$Project->Linked_Entity}}" class="list-group-item list-group-item-action point hide"><i class="fas fa-location text-primary"></i> <span>Hide {{$Project->Name}}</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->where('Site',$Project->Linked_Entity)->count()}}</div></li>
			@endforeach
			
			<li data-id="Project_History" class="list-group-item list-group-item-action mt-1 point hide"><i class="fas fa-history text-primary"></i> <span>Hide Historic Projects</span><div class="badge badge-primary float-right">{{DB::table('UKHT_Occurance_Close_Call')->whereNotIn('Site',DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->pluck('Linked_entity'))->where('Site', '!=',0)->count()}}</div></li>
			
			
				
	
		
			
			<li class="list-group-item list-group-item-action mt-1 point bg-success text-white" onClick="saveSettings()"><i class="fas fa-save"></i> Save my View</li>
			
			<li  hidden="" class="list-group-item list-group-item-action mt-1 point blue text-white"><i class="far fa-bell"></i> Notifications</li>
			
			
			
			
	</ul>
	


		  
      </div>
   
		
	  </div>
	  </div>
	  </div>


<div class="row p-1 m-0 h-100">
	
<div class="col-12">
	
	
	<ul class="nav md-pills nav-justified">
					
	<li onclick="newOccurance()" id="hiddenNotify" class="nav-item"><div class="point bg-success text-white rounded p-2"><i class="fas fa-sign-out-alt"></i> Report HART</div></li>
	
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
  <div class="spinner-grow" role="status" style="min-width: 5rem; height: 5rem;">
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
			var url = "OccuranceFilter?empty=true"
			
	$('.hide').each(function(){
		url += "&"+$(this).data('id')+"=";
		if($(this).hasClass('strike')){
			url += "false"
			dataArray.push({Title:$(this).data('id'),On:false})
		}else{
			url += "true";
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
		
		console.log(dataArray)
		
	}
	
	function saveSettings(){
		var String = '{"items":[ {"Title":"","Data":""}'; 
		var i;
for (i = 0; i < dataArray.length; ++i) {
    String += ',{"Title":"'+dataArray[i]['Title']+'","Data":"'+dataArray[i]['On']+'"}';
}
		
		String += ']}';
		console.log(String)
	
		$.post('OccuranceSaveSettings',{String:String, Entity:-1})
		location.reload();
	}
	
	function newOccurance(){
		
		bootbox.prompt({
    title: "Please choose a Location",
    inputType: 'select',
    inputOptions: [
    {
        text: 'Choose one...',
        value: '',
    },
    {
        text: 'Head Office',
        value: '0',
    },
		@foreach(DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->get() as $Project)
    {
        text: '{{$Project->Name}}',
        value: '{{$Project->Linked_Entity}}',
    },
		@endforeach
  
    ],
    callback: function (result) {
        if(result){
			window.open('https://themis.ukht.org/XWeb/PublicAssets/external/public/observations?id='+result)
		}
    }
});
		
		
		
	}

	<?php 
	$UserSettings = DB::table('UKHT_Occurance_User_Settings')->where(['Contact_ID' => session('MY_ID'),'Entity_ID' => -1]);
	if($UserSettings->exists()){
		
		$Settings =  DB::table('UKHT_Occurance_User_Settings')->where(['Contact_ID' => session('MY_ID'),'Entity_ID' => -1])->first()->String;
		
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
		 
		 
		 @if(session('MY_ID') == 7006)
		 
		 $('#hiddenNotify').mousedown(function(event) {
    switch (event.which) {
        case 1:

            break;
        case 2:

            break;
        case 3:
            $('#NotifyModal').modal('show');
            break;
        default:

    }
});
		 
		 @endif
</script>

	<div class="modal fade" id="NotifyModal" tabindex="-1" aria-labelledby="NotifyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fluid w-75 modal-dialog-centered  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header  bg-primary text-white font-weight-bold">
        <h5 class="modal-title" id="NotifyModalLabel">Subscribe to Notifications</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		   

      </div>
		<div class="width-100 overflow-hidden" style="min-height: 111px" id="NotificationHead">
		<table class="table table-striped m-0 " >
		  			<thead>
			<tr>
				<th style="min-width: 250px" rowspan="2">Location</th>
				<th colspan="3" class="text-center">Close Calls</th>
				<th colspan="3" class="text-center">Good Practices</th>
				<th colspan="3" class="text-center">Accidents</th>
				<th colspan="3" class="text-center">Incidents</th>
				
				</tr>
			<tr>
				
				<th class="text-center" style="min-width: 80px">New</th>
				<th class="text-center"  style="min-width: 80px">Updates</th>
				<th class="text-center"  style="min-width: 80px">Closed</th>
				<th class="text-center"  style="min-width: 80px">New</th>
				<th class="text-center"  style="min-width: 80px">Updates</th>
				<th class="text-center"  style="min-width: 80px">Closed</th>
				<th class="text-center"  style="min-width: 80px">New</th>
				<th class="text-center"  style="min-width: 80px">Updates</th>
				<th class="text-center"  style="min-width: 80px">Closed</th>
				<th class="text-center"  style="min-width: 80px">New</th>
				<th class="text-center"  style="min-width: 80px">Updates</th>
				<th class="text-center"  style="min-width: 80px">Closed</th>
				
				</tr>
	
				
			
			</thead>
		  </table>
			</div>
      <div class="modal-body  table-responsive p-0 m-0"  id="NotificationBody">
        <table class="table table-striped m-0 ">
			<tbody>
			<tr>
				<td  style="min-width: 250px" >Head Office</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 1, 'New' => 1])->exists())
						<input id="NHQ1New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New" value="1" checked>
						@else
						<input id="NHQ1New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ1New"></label>
					</div>
					
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 1, 'Updated' => 1])->exists())
						<input id="NHQ1Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1" checked>
						@else
						<input id="NHQ1Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ1Updated"></label>
					</div>
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 1, 'Closed' => 1])->exists())
						<input id="NHQ1Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1" checked>
						@else
						<input id="NHQ1Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ1Closed"></label>
					</div>
				</td>
				<!-- Good Practice -->
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 2, 'New' => 1])->exists())
						<input id="NHQ2New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New" value="1" checked>
						@else
						<input id="NHQ2New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ2New"></label>
					</div>
					
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 2, 'Updated' => 1])->exists())
						<input id="NHQ2Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1" checked>
						@else
						<input id="NHQ2Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ2Updated"></label>
					</div>
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 2, 'Closed' => 1])->exists())
						<input id="NHQ2Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1" checked>
						@else
						<input id="NHQ2Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ2Closed"></label>
					</div>
				</td>
				<!-- Incidents -->
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 3, 'New' => 1])->exists())
						<input id="NHQ3New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New" value="1" checked>
						@else
						<input id="NHQ3New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ3New"></label>
					</div>
					
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 3, 'Updated' => 1])->exists())
						<input id="NHQ3Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1" checked>
						@else
						<input id="NHQ3Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ3Updated"></label>
					</div>
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 3, 'Closed' => 1])->exists())
						<input id="NHQ3Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1" checked>
						@else
						<input id="NHQ3Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ3Closed"></label>
					</div>
				</td>
				<!-- Accidents -->
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 4, 'New' => 1])->exists())
						<input id="NHQ4New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New" value="1" checked>
						@else
						<input id="NHQ4New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ4New"></label>
					</div>
					
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 4, 'Updated' => 1])->exists())
						<input id="NHQ4Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1" checked>
						@else
						<input id="NHQ4Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ4Updated"></label>
					</div>
				</td>
				<td  style="min-width: 80px">
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => 0, 'Occurance' => 4, 'Closed' => 1])->exists())
						<input id="NHQ4Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1" checked>
						@else
						<input id="NHQ4Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="0"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NHQ4Closed"></label>
					</div>
				</td>
				</tr>
				
			<tr>
				<td class="text-danger" colspan="13"><small>Please note that the below will subscribe you to all notifications across all projects and locations.</small></td></tr>
			<tr>
				<td>Global</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 1, 'New' => 1])->exists())
						<input id="NG1New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New" value="1" checked>
						@else
						<input id="NG1New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG1New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 1, 'Updated' => 1])->exists())
						<input id="NG1Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1" checked>
						@else
						<input id="NG1Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG1Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 1, 'Closed' => 1])->exists())
						<input id="NG1Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1" checked>
						@else
						<input id="NG1Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG1Closed"></label>
					</div>
				</td>
				<!-- Good Practice -->
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 2, 'New' => 1])->exists())
						<input id="NG2New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New" value="1" checked>
						@else
						<input id="NG2New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG2New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 2, 'Updated' => 1])->exists())
						<input id="NG2Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1" checked>
						@else
						<input id="NG2Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG2Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 2, 'Closed' => 1])->exists())
						<input id="NG2Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1" checked>
						@else
						<input id="NG2Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG2Closed"></label>
					</div>
				</td>
				<!-- Incidents -->
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 3, 'New' => 1])->exists())
						<input id="NG3New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New" value="1" checked>
						@else
						<input id="NG3New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG3New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 3, 'Updated' => 1])->exists())
						<input id="NG3Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1" checked>
						@else
						<input id="NG3Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG3Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 3, 'Closed' => 1])->exists())
						<input id="NG3Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1" checked>
						@else
						<input id="NG3Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG3Closed"></label>
					</div>
				</td>
				<!-- Accidents -->
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 4, 'New' => 1])->exists())
						<input id="NG4New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New" value="1" checked>
						@else
						<input id="NG4New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG4New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 4, 'Updated' => 1])->exists())
						<input id="NG4Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1" checked>
						@else
						<input id="NG4Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG4Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Global' => 1, 'Occurance' => 4, 'Closed' => 1])->exists())
						<input id="NG4Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1" checked>
						@else
						<input id="NG4Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="Global"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NG4Closed"></label>
					</div>
				</td>
				</tr>			
			
						<tr>
				<td class="text-danger" colspan="13"><small>	Ticking a box below will subscribe you to  notifications in <strong>All Locations</strong> under that project and category. If you want more Site specific notifications please navigate to the Project Record and subscribe via the project's HART Dashboard. </small></td></tr>

			
				@foreach(DB::table('UKHT_Locations')->where(['Type' => 'Project', 'Removed' => 0])->get() as $Project)
							<tr>
				<td>{{DB::table('Project')->where('Project_ID',$Project->Linked_Entity)->first()->Name}}</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 1, 'New' => 1])->exists())
						<input id="NPRO1New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New" value="1" checked>
						@else
						<input id="NPRO1New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO1New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 1, 'Updated' => 1])->exists())
						<input id="NPRO1Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1" checked>
						@else
						<input id="NPRO1Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO1Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 1, 'Closed' => 1])->exists())
						<input id="NPRO1Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1" checked>
						@else
						<input id="NPRO1Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO1Closed"></label>
					</div>
				</td>
				<!-- Good Practice -->
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 2, 'New' => 1])->exists())
						<input id="NPRO2New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New" value="1" checked>
						@else
						<input id="NPRO2New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO2New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 2, 'Updated' => 1])->exists())
						<input id="NPRO2Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1" checked>
						@else
						<input id="NPRO2Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO2Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 2, 'Closed' => 1])->exists())
						<input id="NPRO2Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1" checked>
						@else
						<input id="NPRO2Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO2Closed"></label>
					</div>
				</td>
				<!-- Incidents -->
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 3, 'New' => 1])->exists())
						<input id="NPRO3New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New" value="1" checked>
						@else
						<input id="NPRO3New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO3New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 3, 'Updated' => 1])->exists())
						<input id="NPRO3Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1" checked>
						@else
						<input id="NPRO3Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO3Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 3, 'Closed' => 1])->exists())
						<input id="NPRO3Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1" checked>
						@else
						<input id="NPRO3Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO3Closed"></label>
					</div>
				</td>
				<!-- Accidents -->
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 4, 'New' => 1])->exists())
						<input id="NPRO4New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New" value="1" checked>
						@else
						<input id="NPRO4New" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="New"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO4New"></label>
					</div>
					
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 4, 'Updated' => 1])->exists())
						<input id="NPRO4Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1" checked>
						@else
						<input id="NPRO4Updated" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}" data-type="Updated"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO4Updated"></label>
					</div>
				</td>
				<td>
					<div class="custom-control custom-checkbox text-center">
						@if(DB::table('UKHT_HART_Notifications')->where(['Contact_ID' => session('MY_ID'), 'Project' => 1, 'Project_ID' => $Project->Linked_Entity, 'Occurance' => 4, 'Closed' => 1])->exists())
						<input id="NPRO4Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1" checked>
						@else
						<input id="NPRO4Closed" class="custom-control-input NotifyCheck m-0" type="checkbox" data-id="{{$Project->Linked_Entity}}"  data-type="Closed"  value="1">
						@endif
						 <label class="custom-control-label p-0 m-0" for="NPRO4Closed"></label>
					</div>
				</td>
				</tr>

				@endforeach
				
				
			
			</tbody>
		  </table>
      </div>
 
    </div>
  </div>
</div>
	

<script>


  
  $("#NotificationBody").scroll(function() {
	  var target = $("#NotificationHead");
    target.prop("scrollLeft", this.scrollLeft);
	  console.log('scroll')
  });


</script>


@stop
<?php 
use Carbon\Carbon;

$EntityLink = DB::table('Entity_Contacts')->distinct('Entity_Identifier')->where(['Contact_ID' => session('MY_ID'), 'Entity_Class_ID' => 3])->pluck('Entity_Identifier');

$Projects = DB::table('Project')->whereIn('Project_ID',$EntityLink)->get();

$Pending = DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where('Submitted',1)->where('HR_Approved',0)->exists();
$Approved = DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where('Submitted',1)->where('HR_Approved',1)->exists();
$Rejected = DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where('Submitted',1)->where('Removed',1)->exists();

$CurrentItems = DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where('Submitted',0)->get();
?>
@extends('intranet')

@section('content')

<div class="col-md-12 hidden" style="display: none">
	<div class="card">
		<div class="card-body">
			@if(date('d') > 8)
			<?php 
			$min = "new Date(".date('Y', strtotime("-5 month",strtotime('first day this month'))).",".date('m', strtotime("-5 month",strtotime('first day this month')))."-1,".date('01', strtotime("-5 month",strtotime('first day this month'))).")";
			$max = "moment()";
			$submitMonth = date('F Y', strtotime("-0 month", strtotime('first day this month'))); 
			?>
			<p class="note note-success">Current Submission Month: <strong class="text-primary">{{date('F Y', strtotime("-0 month", strtotime('first day this month')))}}</strong>
			</p>
			<p class="note note-info">
			The current month ({{date('F Y', strtotime("+0 month", strtotime('first day this month')))}}) dates will not be available to book overtime for until the begining of the following month ({{date('F Y', strtotime("+1 month", strtotime('first day this month')))}})
			<br>
			<br>
			<strong>You may claim for previous dates (since {{date('F Y', strtotime("-5 month", strtotime('first day this month')))}}) if you have forgotten to do so in previous months. You will not be able claim for repeated dates.</strong>
			<br>
			<br>
			The deadline for {{date('F Y', strtotime("+0 month", strtotime('first day this month')))}} claims is 8th {{date('F Y', strtotime("+1 month", strtotime('first day this month')))}}
			</p>
			@else
			<?php 
			$min = "new Date(".date('Y', strtotime("-6 month",strtotime('first day this month'))).",".date('m', strtotime("-6 month",strtotime('first day this month')))."-1,".date('01', strtotime("-6 month",strtotime('first day this month'))).")";
			$max = "new Date(<".date('Y', strtotime("-1 month",strtotime('first day this month'))).",".date('m', strtotime("-1 month",strtotime('first day this month')))."-1,".date('t', strtotime("-1 month",strtotime('first day this month'))).")";
			$submitMonth = date('F Y', strtotime("-1 month", strtotime('first day this month')))
			?>
			<p class="note note-success">Current Submission Month: <strong class="text-primary">{{date('F Y', strtotime("-1 month", strtotime('first day this month')))}}</strong>
			</p>
			<p class="note note-info">
			The current month ({{date('F Y', strtotime("+0 month", strtotime('first day this month')))}}) dates will not be available to book overtime for until the begining of the following month ({{date('F Y', strtotime("+1 month", strtotime('first day this month')))}})
			<br>
			<br>
			<strong>You may claim for previous dates (since {{date('F Y', strtotime("-6 month", strtotime('first day this month')))}}) if you have forgotten to do so in previous months. You will not be able claim for repeated dates.</strong>
			<br>
			<br>
			The deadline for {{date('F Y', strtotime("-1 month", strtotime('first day this month')))}} claims is 8th {{date('F Y', strtotime("-0 month", strtotime('first day this month')))}}
			</p>

			@endif
	
				
			<!-- Editable table -->

    <div id="table" class="table-editable">
      <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i
            class="fas fa-plus-square fa-2x" aria-hidden="true"></i></a></span>
      <table class="table table-bordered table-responsive-md table-striped text-center">
        <thead>
          <tr>
			<th></th>
			<th class="text-center">Project</th>
            <th class="text-center">Start of Shift Date</th>
            <th class="text-center">Start Time</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Hours</th>
            <th class="text-center">Day or Night</th>
            <th class="text-center">Description</th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody class="tbody">
  @foreach($CurrentItems as $Item)
			<tr class="hide" globalid="{{$Item->Global_ID}}">
<td class="pt-3-half validation red lighten-4" contenteditable="false"> <i class="fas fa-check valid" style="display:none"></i> <i class="fas fa-question invalid"></i> </td>	
<td class="pt-3-half" contenteditable="false">
<select class="browser-default custom-select">
  <option value="" disabled selected>Choose your option</option>
@foreach($Projects as $Project)
	@if($Item->Project === $Project->Project_ID)
  <option value="{{$Project->Project_ID}}" selected>{{$Project->Name}}</option>
	@else
	  <option value="{{$Project->Project_ID}}">{{$Project->Name}}</option>
    @endif
@endforeach
</select>	
</td>
  <td class="pt-3-half" contenteditable="false">
<div class="md-form p-0 m-0">
	@if($Item->Date)
  <input placeholder="Select start date" id="{{$Item->Global_ID}}" value="{{carbon::create($Item->Date)->format('l, d M, Y')}}" type="text" class="form-control StartDatepicker">
	@else
  <input placeholder="Select start date" id="{{$Item->Global_ID}}" type="text" class="form-control StartDatepicker">	
	@endif
</div>
	</td>
  <td class="pt-3-half" contenteditable="false">
	<div class="md-form p-0 m-0">
  <input placeholder="Start time" value="{{$Item->Start_Time}}" type="text" class="form-control StartTimepicker">
</div>
	</td>
  <td class="pt-3-half" contenteditable="false"><div class="md-form p-0 m-0">
  <input placeholder="End time" value="{{$Item->End_Time}}" type="text" class="form-control EndTimepicker">
</div></td>
  <td class="pt-3-half hours" contenteditable="false">{{$Item->Hours}}</td>
  <td class="pt-3-half timeofday" contenteditable="false">{{$Item->Time_Of_Day}}</td>
  <td class="pt-3-half"><div class=" Description" contenteditable="true" style="max-width: 300px"><?php echo base64_decode($Item->Description) ?></div></td>
  <td>
    <span class="table-remove"><div type="button" class="text-danger my-0 waves-effect waves-light"><i class="fas fa-trash"></i></div></span>
  </td>
</tr>
			@endforeach
         
        </tbody>
      </table>
    </div>

			
			<div class="d-flex justify-content-between">
				
							<p class="note note-danger"><strong>Auto-Save:</strong> This form will track and save changes automatically, <strong>Deletes at this stage are permanent.</strong></p>
			
			<button class="btn btn-primary btn-lg rounded" id="SubmitOvertime"><i class="far fa-envelope mr-1"></i> Submit </button>
			</div>
			
			<div id="Routes">
				<div id="RouteRefresh">
					<blockquote class="blockquote bq-info">
					  <p class="bq-title">Routes</p>
					
						  <?php $DistinctProjects = DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where('Submitted',0)->Distinct('Project')->get() ?>
						  @foreach($DistinctProjects as $Proj)
						  	<p>
								<span class="mr-4">
								{{DB::table('Project')->where('Project_ID',$Proj->Project)->first()->Name}}:
								</span>
								
							<?php 
	$LineManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => session('MY_ID'), 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
						
	$ProjectManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Proj->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
						
	
	
	?>
								@if($ProjectManager->Contact_ID != $LineManager->Contact_ID)
								<span><span class="badge badge-primary">1st</span> {{$LineManager->Forename}} {{$LineManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">2nd</span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">3rd</span> HR <i class="fas fa-user-alt"></i></span>
								@else
								<span><span class="badge badge-primary">1st</span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">2nd</span> HR <i class="fas fa-user-alt"></i></span>
								@endif
					
						</p>
						  @endforeach
					 
					</blockquote>
				</div>
			</div>

			
			
		
			
		</div>
	</div>
</div>

<script>
const $tableID = $('#table');
 const $BTN = $('#export-btn');
 const $EXPORT = $('#export');

 const newTr = '\
 <tr class="hide needsID">\
<td class="pt-3-half validation red lighten-4" contenteditable="false"> <i class="fas fa-check valid" style="display:none"></i> <i class="fas fa-question invalid"></i> </td>	\
<td class="pt-3-half" contenteditable="false">\
<select class="browser-default custom-select">\
  <option value="" disabled selected>Choose your option</option>\
@foreach($Projects as $Project)\
  <option value="{{$Project->Project_ID}}">{{$Project->Name}}</option>\
@endforeach\
</select>	\
</td>\
  <td class="pt-3-half" contenteditable="false">\
<div class="md-form p-0 m-0">\
  <input placeholder="Select start date" type="text" class="form-control StartDatepicker aStartDatepicker">\
</div>\
	</td>\
  <td class="pt-3-half" contenteditable="false">\
	<div class="md-form p-0 m-0">\
  <input placeholder="Start time" type="text" class="form-control StartTimepicker">\
</div>\
	</td>\
  <td class="pt-3-half" contenteditable="false"><div class="md-form p-0 m-0">\
  <input placeholder="End time" type="text" class="form-control EndTimepicker">\
</div></td>\
  <td class="pt-3-half hours" contenteditable="false">Please Select Start and End Time</td>\
  <td class="pt-3-half timeofday" contenteditable="false">Please Select a Start Time</td>\
  <td class="pt-3-half"><div class="Description" contenteditable="true"></div></td>\
  <td>\
    <span class="table-remove"><div type="button" class="btn btn-sm btn-danger my-0 waves-effect waves-light"><i class="fas fa-trash-alt"></i></div></span>\
  </td>\
</tr>\
';

 $('.table-add').on('click', 'i', function() {

  
     $('.tbody').append(newTr);
	 
	 $.post('OvertimePosts',{Type:'GETID'}).done(function(ID){
		 console.log(ID)
		$('.needsID').attr('GlobalID',ID);
		$('.aStartDatepicker').attr('id',ID);
		$('.needsID').removeClass('needsID');
		 
		 $('#Routes').load('MyOvertime?t='+moment()+' #RouteRefresh')
	 })

	 
	

	 $('.aStartDatepicker').pickadate({
		 
min : {{$min}},
max : {{$max}},
// Escape any “rule” characters with an exclamation mark (!).
format: 'dddd, dd mmm, yyyy',
formatSubmit: 'yyyy/mm/dd',
hiddenPrefix: 'prefix__',
hiddenSuffix: '__suffix',
		  onOpen: function(event) {
            console.log($(this).parents('tr').attr('globalid'))
			disable(this, this.get('id'))

					  
					  
					  
  }
})
	 
	 	$('.aStartDatepicker').removeClass('aStartDatepicker')
	
	 	 $('.StartTimepicker').pickatime();
	 	$('.EndTimepicker').pickatime()
	 
	
 
	$('.custom-select, .StartDatepicker, .EndTimepicker, .StartTimepicker, .Description').on('change keyup select', function(){
			
			var parent = $(this).parents('tr');
			
			startTime(parent.find('.StartTimepicker'));
			endTime(parent.find('.EndTimepicker'));
			

 
			
			
			
		var Project = parent.find('.custom-select').val();
		var globalid = parent.attr('globalid');
		var Date = parent.find('.StartDatepicker').val();
		var ETime = parent.find('.EndTimepicker').val();
		var STime = parent.find('.StartTimepicker').val();
		var Description = parent.find('.Description').html();
		var Contact = {{ session('MY_ID') }};
		var Type = "AutoSave";	
																							  var Hours = parent.find('.hours').text();
																							  var TimeOfDay = parent.find('.timeofday').text();
																							  
				$.post('OvertimePosts',{globalid:globalid,Project:Project,Date:Date,STime:STime,ETime:ETime,Description:Description,Contact:Contact,Type:Type, TimeOFDay:TimeOfDay,Hours:Hours}).done(function(res){
					console.log(res)
					$('#Routes').load('MyOvertime?t='+moment()+' #RouteRefresh')
				})																
												
																						  
																						  })
	 
		 
 });


 $tableID.on('click', '.table-remove', function () {

	 var parent = $(this).parents('tr');
		
			
			
	
		var globalid = parent.attr('globalid');
		
		var Type = "DELETE";	
																							  
				$.post('OvertimePosts',{globalid:globalid,Type:Type}).done(function(res){
					console.log(res)
					$('#Routes').load('MyOvertime?t='+moment()+' #RouteRefresh')
				})					
	 
   $(this).parents('tr').detach();
 });

 $tableID.on('click', '.table-up', function () {

   const $row = $(this).parents('tr');

   if ($row.index() === 0) {
     return;
   }

   $row.prev().before($row.get(0));
 });

 $tableID.on('click', '.table-down', function () {

   const $row = $(this).parents('tr');
   $row.next().after($row.get(0));
 });

 // A few jQuery helpers for exporting only
 jQuery.fn.pop = [].pop;
 jQuery.fn.shift = [].shift;

 $BTN.on('click', function() {

   const $rows = $tableID.find('tr:not(:hidden)');
   const headers = [];
   const data = [];

   // Get the headers (add special header logic here)
   $($rows.shift()).find('th:not(:empty)').each(function () {

     headers.push($(this).text().toLowerCase());
   });

   // Turn all existing rows into a loopable array
   $rows.each(function () {
     const $td = $(this).find('td');
     const h = {};

     // Use the headers from earlier to name our hash keys
     headers.forEach(function(header, i) {

       h[header] = $td.eq(i).text();
     });

     data.push(h);
   });

   // Output the result
   $EXPORT.text(JSON.stringify(data));
 });
	
	$(document).ready(function(){
		

			 $('.StartDatepicker').pickadate({
		 
min : {{$min}},
max : {{$max}},
// Escape any “rule” characters with an exclamation mark (!).
format: 'dddd, dd mmm, yyyy',
formatSubmit: 'yyyy/mm/dd',
hiddenPrefix: 'prefix__',
hiddenSuffix: '__suffix',
		
				  onOpen: function(event) {
            console.log(this.get('id'))
			disable(this, this.get('id'))

					  
					  
					  
  }
				 
				 
})
	 
	
	 	 $('.StartTimepicker').pickatime();
	 	$('.EndTimepicker').pickatime()
	 

	
		$('select').hide();
	
		
		$('.hidden').fadeIn();

	})
	
	
	function round(val) {
  var time = val,
      arr = time.split(':'),
      hour = arr[0],
      min = arr[1],
      newMin = ((Math.round(parseInt(min) / 15)) * 15);
		
		hour = parseInt(hour); 
		
	if(newMin == 60){ newMin = 0; hour = hour+1 }
  return (hour > 9 ? '' : '0') + hour + ':' + (newMin > 9 ? '' : '0') + newMin;
}
	
	

		$('.custom-select, .StartDatepicker, .EndTimepicker, .StartTimepicker, .Description').on('change keyup select', function(){
			
			var parent = $(this).parents('tr');
			
			startTime(parent.find('.StartTimepicker'));
			endTime(parent.find('.EndTimepicker'));
			

 
			
			
			
		var Project = parent.find('.custom-select').val();
		var globalid = parent.attr('globalid');
		var Date = parent.find('.StartDatepicker').val();
		var ETime = parent.find('.EndTimepicker').val();
		var STime = parent.find('.StartTimepicker').val();
		var Description = parent.find('.Description').html();
		var Contact = {{ session('MY_ID') }};
		var Type = "AutoSave";	
																							  var Hours = parent.find('.hours').text();
																							  var TimeOfDay = parent.find('.timeofday').text();
																							  
				$.post('OvertimePosts',{globalid:globalid,Project:Project,Date:Date,STime:STime,ETime:ETime,Description:Description,Contact:Contact,Type:Type, TimeOFDay:TimeOfDay,Hours:Hours}).done(function(res){
					console.log(res)
					
					$('#Routes').load('MyOvertime?t='+moment()+' #RouteRefresh')
					
				})
	
	
												
																						  
																						  })
	 
	

				
																						  
																						  function startTime(item){
																							  
																							  if(item.val()){
	 			item.val(round(item.val()))
			
			var hour =  parseInt(item.val().substring(0, 2))
			console.log("the hour is " + hour)
			if( 7 <= hour && hour < 19 ){
				var timeofday = "Day"
			}else{
				var timeofday = "Night"
			}
				item.parents('tr').find('.timeofday').text(timeofday)
			
			if(item.parents('tr').find('.EndTimepicker').val()){
			var start = moment("1970-01-01 " + item.val()).format('x')
			
			var end = moment("1970-01-01 " + item.parents('tr').find('.EndTimepicker').val()).format('x')

			console.log(start)
					if(start < end){
					var calc = start-end
					var add = 0
					var times = -1
				}else{
					var calc = end-start
					var add = 24
					var times = 1
				}
				
				var hours = ((( calc ) / 1000 / 60 / 60 )+add)*times
				
				if(hours > 12){
					item.parents('tr').addClass('red lighten-5')
				}else{
					item.parents('tr').removeClass('red lighten-5')
				}
			
				item.parents('tr').find('.hours').text(hours)
			}
			
  }
																						  }
	
	function endTime(item){
		if(item.val()){
			item.val(round(item.val()))
			
			
			if(item.parents('tr').find('.StartTimepicker').val()){
			
				var end = moment("1970-01-01 " + item.val()).format('x')
				var start = moment("1970-01-01 " + item.parents('tr').find('.StartTimepicker').val()).format('x')
					console.log(item.val())
				if(item.val() === ':0NaN' || item.parents('tr').find('.StartTimepicker').val() === ':0NaN'){}else{

					console.log('Calculating')
			
				if(start < end){
					var calc = start - end
					var add = 0
					var times = -1
				}else{
					var calc = end - start
					var add = 24
					var times = 1
				}
				
			
				var hours = ((( calc ) / 1000 / 60 / 60 )+add)*times
				console.log(hours)
				if(hours > 12){
					item.parents('tr').addClass('red lighten-5')
				}else{
					item.parents('tr').removeClass('red lighten-5')
				}
				
				
				item.parents('tr').find('.hours').text(hours)
					
						}
			}
			
  }
	}
	
	
	function disable(item, ID){
		
		$.post('OvertimePosts', {GlobalID: $('#'+ID).parents('tr').attr('globalid'),Type:"GetDisabled", Contact: {{session('MY_ID')}}}).done(function(res){
			console.log(res);
			
			item.set( 'disable', res)
			
				$('#Routes').load('MyOvertime?t='+moment()+' #RouteRefresh')
		})
		
	}
	
	
	$('#SubmitOvertime').on('click',function(){
		bootbox.confirm({
    		message: "Are you sure you would send this claim?",
			centerVertical: true,
    		
			buttons: {
        confirm: {
            label: 'Yes',
            className: 'green text-white'
        },
			cancel:{
				label: 'No',
				className: 'btn-danger'
			}},
			callback: function(result){
			var Contact = {{ session('MY_ID') }};
			var Type = "SUBMIT";	
			var SubmitMonth = {{$submitMonth}};
			
			
				$.post('OvertimePosts',{Type:Type,Contact:Contact,SubmitMonth:SubmitMonth}).done(function(res){
			console.log(res)
		})
				
			}
});
		
			
	})
																						  
</script>
@stop

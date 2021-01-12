
@extends('intranet')
@section('content')

<?php

$Projects = DB::table('UKHT_Locations')->where('Type','Project')->where('Removed',0)->get();

foreach($Projects as $Project){
	
	$Color = "Color_$Project->Linked_Entity";
	$$Color = random_color();
	

}


?>


<style>

.fc-event-title-container{
text-align: center;
	}
</style>
<link rel="stylesheet" href="{{ asset('fullcalendar/main.css') }}">
<script type="text/javascript" src="{{ asset('fullcalendar/main.js') }}"></script>
<div class="container-fluid m-0 p-4  row">

	<div class="col-md-6 mb-2">
	
	
	
<div id="calendar"></div>

	</div>
		<div class="col-md-6">
	<div class="card">
		<div class="card-header bg-light text-white" style="background-color: #25475f !important" id="CardTitle"></div>
		<div class="card-body row">
		
			<div class="col-md-4">
			<blockquote class="note note-primary ">
  <p class="bq-title">HOCHTIEF Total Man Hours</p>
  <div><strong>Male: </strong> <span id="HTUK_Male"></span></div>
  <div><strong>Female: </strong> <span id="HTUK_Female"></span></div>
</blockquote>
				</div>
			
			<div class="col-md-4">
			<blockquote class="note note-warning ">
  <p class="bq-title">Agency Total Man Hours</p>
  <div><strong>Male: </strong> <span id="Agency_Male"></span></div>
  <div><strong>Female: </strong> <span id="Agency_Female"></span></div>
</blockquote>
				</div>
			
			<div class="col-md-4">
			<blockquote class="note note-danger ">
  <p class="bq-title">Sub Contractor Total Man Hours</p>
  <div><strong>Male: </strong> <span id="Sub_Male"></span></div>
  <div><strong>Female: </strong> <span id="Sub_Female"></span></div>
</blockquote>
				</div>
			
			
			<div class="col-md-6">
			<blockquote class="note note-secondary ">
  <p class="bq-title">Visitor Total Man Hours</p>
				<div><strong><span id="Visitors"></span></strong></div>
</blockquote>
				</div>
			
			
			<div class="col-md-6">
			<blockquote class="note note-info ">
  <p class="bq-title">Delivery Total Man Hours</p>
				<div><strong><span id="Delivery"></span></strong></div>
</blockquote>
				</div>
		
		</div>
		<div class="card-footer d-flex">
		<h5 class="ml-auto"><strong>Total: </strong> <span id="Sum"></span> Hours</h5>
		</div>
		
		<div class="card-body">
		<div class="card-title">Key</div>
			 @foreach($Projects as $Project)
			<div > <span class="badge p-2 rounded" style="background-color: #{{ ${"Color_".$Project->Linked_Entity} }}" > </span> {{$Project->Name}}</div>
@endforeach
		</div>
		
		<div class="card-body row" hidden="">
		<div class="col-md-4">
			<blockquote class="note note-primary ">
  <p class="bq-title">Average Workforce per Day</p>
  <div><strong>HOCHTIEF Male: </strong> <span id="HTUK_Male_No_Avg"></span></div>
  <div><strong>HOCHTIEF Female: </strong> <span id="HTUK_Female_No_Avg"></span></div>
  <div><strong>Agency Male: </strong> <span id="Agency_Male_No_Avg"></span></div>
  <div><strong>Agency Female: </strong> <span id="Agency_Female_No_Avg"></span></div>
  <div><strong>Sub Contractor Male: </strong> <span id="Sub_Male_No_Avg"></span></div>
  <div><strong>Sub Contractor Female: </strong> <span id="Sub_Female_No_Avg"></span></div>
  <div><strong>Visitors: </strong> <span id="Visitor_No_Avg"></span></div>
  <div><strong>Deliveries: </strong> <span id="Delivery_No_Avg"></span></div>
</blockquote>
		</div>
			
			
		</div>
		
		</div></div>
		</div></div>

</div>


<div class="modal fade right" id="EditDay" tabindex="-1" role="dialog" aria-labelledby="EditDayLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-full-height modal-right" role="document">
    <form class="modal-content" method="post" action="SaveManHours" enctype="application/x-www-form-urlencoded">
      <div class="modal-header bg-light text-white" style="background-color: #25475f !important">
        <h5 class="modal-title" id="EditDayLabel"></h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		
		
      <div class="modal-body p-0">
		  
		  <table class="table  table-responsive-md table-striped">
		  	<thead>
				<tr>
					<th class="text-center"></th>
					<th class="text-center  bg-primary text-white font-weight-bold">Number Of People</th>
					<th class="text-center  bg-primary text-white font-weight-bold">Total Man Hours</th>
				</tr>
			  </thead>
			  <tbody>
				  <tr>
					  <th class="text-right table-primary font-weight-bold">HOCHTIEF Male Staff</th>
					  <td class=""><input id="Input_HTUK_Male_No" name="Input_HTUK_Male_No" type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_HTUK_Male" name="Input_HTUK_Male"  type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-primary font-weight-bold">HOCHTIEF Female Staff</th>
					  <td class=""><input id="Input_HTUK_Female_No" name="Input_HTUK_Female_No"  type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_HTUK_Female" name="Input_HTUK_Female"  type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-warning font-weight-bold">Agency Male Staff</th>
					  <td class=""><input id="Input_Agency_Male_No" name="Input_Agency_Male_No"  type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_Agency_Male" name="Input_Agency_Male" type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-warning font-weight-bold">Agency Female Staff</th>
					  <td class=""><input id="Input_Agency_Female_No" name="Input_Agency_Female_No" type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_Agency_Female" name="Input_Agency_Female" type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-danger font-weight-bold">Subcontractor Male Staff</th>
					  <td class=""><input id="Input_Sub_Male_No" name="Input_Sub_Male_No" type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_Sub_Male" name="Input_Sub_Male"  type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-danger font-weight-bold">Subcontractor Female Staff</th>
					  <td class=""><input id="Input_Sub_Female_No" name="Input_Sub_Female_No"  type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_Sub_Female" name="Input_Sub_Female" type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-secondary font-weight-bold">Visitors</th>
					  <td class=""><input id="Input_Visitors_No" name="Input_Visitors_No"  type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_Visitors" name="Input_Visitors"  type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  <tr>
					  <th class="text-right table-info font-weight-bold">Delivery</th>
					  <td class=""><input id="Input_Delivery_No" name="Input_Delivery_No"  type="number" min="0" step="1" value="0" class="form-control form-control-sm"></td>
					  <td class=""><input id="Input_Delivery" name="Input_Delivery" type="number" min="0" step="0.01" value="0" class="form-control form-control-sm"></td>
				  </tr>
				  
				  <input type="date"  id="Input_Date_Field" name="Input_Date_Field" hidden="" >
				  <input type="text"  id="Input_ID" name="Input_ID" value="{{request('code')}}" hidden="" >
				  
			   </tbody>
		  </table>


		</div> 
		  
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
		  </form>
    
  </div>
</div>

<script>

	$(document).ready(function(){
	
		  var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
			//themeSystem: 'bootstrap',
			contentHeight: 'auto',
			//height: '100%',
			headerToolbar: {
				start: 'prev',
				center: 'title',
				end: 'next'
			},
			footerToolbar:{
				start: '',
				center: 'today',
				end: ''
			},
          initialView: 'dayGridMonth',
			
			loading: function(bool) {
      if (bool){
         
      }
      else{
		  
		  
		  $('.fc-daygrid-day-number').each(function(){
			  if($(this).children('span').length){}else{
			   $(this).prepend('<span class="mr-auto"> ')
			 $(this).prepend('<small><i class="fal fa-search ml-auto"></i></small> ')
			
			 $(this).append('</span>')
			  $(this).addClass('btn btn-dark text-white m-0 z-depth-0 p-2 w-100 border border-light rounded-0 d-flex')
		 }
		  })
		  
	
		  
		  
		  
        updateCard(calendar);
		
		
      }
			},
			
				 eventSources: [
    //'GETmanhours?ID=37&color=75aab2',
    @foreach($Projects as $Project)
					'GETmanhours?ID={{$Project->Linked_Entity}}&color={{ ${"Color_".$Project->Linked_Entity} }}',
@endforeach
  ],
			  eventClick: function(info) {
   
    console.log(info.event);
    console.log(info.event.extendedProps.editor);
 

    // change the border color just for fun
    info.el.style.borderColor = 'red';
  },
			eventMouseEnter : function(info) {
   
    console.log(info.event);
    console.log(info.event.extendedProps.editor);
 

    // change the border color just for fun
    info.el.style.borderColor = 'red';
  }

			
			
        });
        calendar.render();
		

		
		
      });

	
function updateCard(calendar){
	
	
  var date = calendar.getDate();
  var Start = moment(date).startOf('month').format('YYYY-MM-DD');
  var End = moment(date).endOf('month').format('YYYY-MM-DD');
$('#CardTitle').text("Statistics for: " + moment(date).format('MMMM YYYY'))
 
	
	
	$.post('GlobalManHoursGetCardData',{Start:Start, End:End}).done(function(result){
		
		console.log(result)
		
					   $('#HTUK_Male').text(result.HTUK_Male)
					  $('#HTUK_Female').text(result.HTUK_Female)
					  $('#Agency_Male').text(result.Agency_Male)
					  $('#Agency_Female').text(result.Agency_Female)
					  $('#Sub_Male').text(result.Sub_Male)
					  $('#Sub_Female').text(result.Sub_Female)
					  $('#Visitors').text(result.Visitors)
					  $('#Delivery').text(result.Delivery)
					  $('#Sum').text(result.Sum)
		
	})
	
	
 
	
	
	
	
	
 
	
}
	
	
	


</script>

@php
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
@endphp


@endsection
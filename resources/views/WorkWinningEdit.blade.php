@extends('intranet')
@section('color')
bg-dark
@stop
@section('content')
<!--Main Layout-->

<?php 


use Carbon\Carbon;

?>




<style>
td{ 
	padding: 0.5% !important; 
	
	}
	
	th{
		text-align: center
	}
	
	.glowPurple-Text{
		color: #bbdefb;
	}
	
	.glowGreen-Text{
		color:#2e7d32;
	}
	
	.darkCyan {
		color: #00838f; 
	}

	.etaTime {
		text-align: center;
		white-space: nowrap
		
	}
	
	.table-bordered, tr, td, thead, th{
		  border-color: black !important;
	}
	
* {
  box-sizing: border-box;
}
	
	.next{
		font-weight: bold;
	}

@-webkit-keyframes ticker {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    visibility: visible;
  }
  100% {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}
@keyframes ticker {
  0% {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    visibility: visible;
  }
  100% {
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}
.ticker-wrap {
  position: fixed;
  bottom: 0;
  width: 100%;
  overflow: hidden;
  height: 4rem;
  background-color: rgba(0, 0, 0, 0.9);
  padding-left: 100%;
  box-sizing: content-box;
}
.ticker-wrap .ticker {
  display: inline-block;
  height: 4rem;
  line-height: 4rem;
  white-space: nowrap;
  padding-right: 100%;
  box-sizing: content-box;
  -webkit-animation-iteration-count: infinite;
  animation-iteration-count: infinite;
  -webkit-animation-timing-function: linear;
  animation-timing-function: linear;
  -webkit-animation-name: ticker;
  animation-name: ticker;
  -webkit-animation-duration: 30s;
  animation-duration: 30s;
}
.ticker-wrap .ticker__item {
  display: inline-block;
  padding: 0 2rem;
  font-size: 2rem;
  color: white;
}
</style>
<div class="bg-dark" id="container">
<!-- Editable table -->
<div class="d-flex p-2 text-warning"><div id="date" class="text-warning mr-1 fa-2x"></div><spa class="fa-2x"> - </spa><div id="time" class="text-warning ml-1 fa-2x"></div> <div class="ml-auto bg-white rounded p-2"><img src="{{ asset('images/HochtiefLogo.png') }}" alt="" height="50px"></div></div>
	



<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
		
		<h4>Type</h4>  
		  <!-- Material inline 1 -->
<div class="form-check form-check-inline">
  <input type="radio" class="form-check-input" id="materialInline1" value="OPP" name="AddType">
  <label class="form-check-label" for="materialInline1">OPP</label>
</div>

<!-- Material inline 2 -->
<div class="form-check form-check-inline">
  <input type="radio" class="form-check-input" id="materialInline2" value="PQQ/EOI" name="AddType">
  <label class="form-check-label" for="materialInline2">PQQ/EOI</label>
</div>

<!-- Material inline 3 -->
<div class="form-check form-check-inline">
  <input type="radio" class="form-check-input" id="materialInline3" value="TENDER" name="AddType">
  <label class="form-check-label" for="materialInline3">TENDER</label>
</div>
		  
		  
		  <select id="AddState" class="mdb-select md-form colorful-select dropdown-primary text-warning" name="AddState" style="color: #E1B600 !important">
							<option value="" class="text-warning" disabled selected>Select State</option>
					

		<option value="AWAITING PQQ">AWAITING PQQ</option>
		<option value="WON">WON</option>
	    <option value="PENDING/POST">PENDING/POST</option>
		<option value="IN-PROGRESS">IN-PROGRESS</option>
		<option value="LOST">LOST</option>
		<option value="AWAITING ITT">AWAITING ITT</option>
					  
					  
					</select>
		  
        <div class="md-form mb-5">
          <input type="text" id="AddTitle" name="AddTitle" class="form-control validate">
          <label data-error="wrong" data-success="right" for="AddTitle">Title</label>
        </div>

        <div class="md-form mb-5">
          <input type="text" id="AddClient" name="AddClient" class="form-control validate">
          <label data-error="wrong" data-success="right" for="AddClient">Client</label>
        </div>
		  
		  
		  
		  									<select id="AddOwner" name="AddOwner" class="mdb-select md-form colorful-select dropdown-primary text-warning" searchable="Search here.." style="color: #E1B600 !important">
							<option value="" class="text-warning" disabled selected>Select Owner</option>
						<?php
						
			$Users = DB::table("User")
					->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
				->orderby("Forename",'asc')
				->orderby("Surname",'asc')
					->get();
						
					foreach($Users as $User){

						?>

						<option value="{{$User->Contact_ID}}" data-jobtitle="{{$User->Job_Title}}">{{$User->Forename}} {{$User->Surname}}</option>

						<?php
							}
						?>
					  
					  
					</select>


        <div class="md-form mb-5">
          <input type="text" id="AddPartners" name="AddPartners" class="form-control validate">
          <label data-error="wrong" data-success="right" for="AddPartners">Partners</label>
        </div>
		  
	
		  
		  <div class="md-form">
  <input placeholder="Selected date" name="AddEta" type="text" id="date-picker-example" class="form-control datepicker">
  <label for="date-picker-example">ETA</label>
</div>
		  

        <div class="md-form mb-5">
          <input type="text" id="AddNext" name="AddNext" class="form-control validate">
          <label data-error="wrong" data-success="right" for="AddNext">Next</label>
        </div>



		
		  
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button name="button" id="addNew" class="btn btn-unique">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
      </div>
		
    </div>
  </div>
</div>


<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Detail</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
		
		<h4>Type</h4>  
		  <!-- Material inline 1 -->
<div class="form-check form-check-inline">
  <input type="radio" class="form-check-input" id="amaterialInline1" value="OPP" name="EditType">
  <label class="form-check-label" for="amaterialInline1">OPP</label>
</div>

		  <input type="text" hidden id="itemid">
<!-- Material inline 2 -->
<div class="form-check form-check-inline">
  <input type="radio" class="form-check-input" id="amaterialInline2" value="PQQ/EOI" name="EditType">
  <label class="form-check-label" for="amaterialInline2">PQQ/EOI</label>
</div>

<!-- Material inline 3 -->
<div class="form-check form-check-inline">
  <input type="radio" class="form-check-input" id="amaterialInline3" value="TENDER" name="EditType">
  <label class="form-check-label" for="amaterialInline3">TENDER</label>
</div>
		  
		  
		  <select id="EditState" class="mdb-select md-form colorful-select dropdown-primary text-warning" name="EditState" style="color: #E1B600 !important">
							<option value="" class="text-warning" disabled selected>Select State</option>
					

		<option value="AWAITING PQQ">AWAITING PQQ</option>
		<option value="WON">WON</option>
	    <option value="PENDING/POST">PENDING/POST</option>
		<option value="IN-PROGRESS">IN-PROGRESS</option>
		<option value="LOST">LOST</option>
		<option value="AWAITING ITT">AWAITING ITT</option>
					  
					  
					</select>
		  
        <div class="md-form mb-5">
          <input type="text" id="EditTitle" value="..." name="EditTitle" class="form-control validate">
          <label data-error="wrong" data-success="right" for="EditTitle">Title</label>
        </div>

        <div class="md-form mb-5">
          <input type="text" id="EditClient" value="..." name="EditClient" class="form-control validate">
          <label data-error="wrong" data-success="right" for="EditClient">Client</label>
        </div>
		  
		  
		  
		  									<select id="EditOwner" name="EditOwner" class="mdb-select md-form colorful-select dropdown-primary text-warning" searchable="Search here.." style="color: #E1B600 !important">
							<option value="" class="text-warning" disabled selected>Select Owner</option>
						<?php
						
			$Users = DB::table("User")
					->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
				->orderby("Forename",'asc')
				->orderby("Surname",'asc')
					->get();
						
					foreach($Users as $User){

						?>

						<option value="{{$User->Contact_ID}}" data-jobtitle="{{$User->Job_Title}}">{{$User->Forename}} {{$User->Surname}}</option>

						<?php
							}
						?>
					  
					  
					</select>


        <div class="md-form mb-5">
          <input type="text" id="EditPartners" value="..." name="EditPartners" class="form-control validate">
          <label data-error="wrong" data-success="right" for="EditPartners">Partners</label>
        </div>
		  
	
		  
		  <div class="md-form">
  <input placeholder="Selected date" name="EditEta"  type="text" id="date-picker-example2" class="form-control datepicker">
  <label for="date-picker-example">ETA</label>
</div>
		  

        <div class="md-form mb-5">
          <input type="text" id="EditNext" value="..." name="EditNext" class="form-control validate">
          <label data-error="wrong" data-success="right" for="EditNext">Next</label>
        </div>



		
		  
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button data-id="" name="button" id="editNew" class="btn btn-unique">Save <i class="fas fa-paper-plane-o ml-1"></i></button>
        <button data-id="" name="button" id="editDelete" class="btn btn-danger">Delete <i class="fas fa-paper-plane-o ml-1"></i></button>
      </div>
		
    </div>
  </div>
</div>
	
	
	
<div class="text-center">
  <a href="" class="btn btn-primary btn-rounded mb-4" data-toggle="modal" data-target="#modalContactForm"> Add</a>
</div>

		<table class="table table-bordered data ">
  <thead class="text-white" style="background-color: #151e53">    

	  <tr>
      <th scope="col">Type</th>
      <th scope="col">State</th>
      <th scope="col">Title</th>
      <th scope="col">Client</th>
      <th scope="col">Owner</th>
      <th scope="col">Partners</th>
      <th scope="col">ETA</th>
      <th scope="col">Days to arrival</th>
      <th scope="col">Next?</th>
    </tr>
  </thead>
  <tbody class="white">
   
	    <?php 
	  
	  $Opps = DB::table('UKHT_WorkWinning_Dash')->join("Contact","Contact.Contact_ID","UKHT_WorkWinning_Dash.Owner")->where('UKHT_WorkWinning_Dash.Type','=','OPP')->where("UKHT_WorkWinning_Dash.Removed",false)
		  ->select('ID','Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Contact_ID','Partners','ETA','Next')->orderby('ETA','asc')->get();	  
	  foreach($Opps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm:ss'));
		  $minutes = new Carbon($left->isoFormat('h:mm:ss'));
		  $seconds = new Carbon($left->isoFormat('h:mm:ss'));
		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	   <tr data-id="{{$Opp->ID}}" class="edit point">
      <td class="type font-weight-bold text-center">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center">{{$Opp->State}}</td>
      <td class="title win font-weight-bold text-center">{{$Opp->Title}}</td>
      <td class="client win font-weight-bold text-center">{{$Opp->Client}}</td>
      <td data-id="{{$Opp->Contact_ID}}" class="owner win font-weight-bold text-center">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="partners win font-weight-bold text-center">{{$Opp->Partners}}</td>
      <td data-value="{{$left->day}} {{$left->englishMonth}}, {{$left->year}}" class="win eta font-weight-bold text-center">{{$left->toRfc850String()}}</td>	  <td class="etaTime" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td class="next text-center font-weight-bold">{{$Opp->Next}}</td>
    </tr>
	  
	  <?php
		  
	  }
	  
	  ?>
    
  </tbody>

  <thead class="text-white " style="background-color: #151e53">
    <tr>
      <th scope="col">Type</th>
      <th scope="col">State</th>
      <th scope="col">Title</th>
      <th scope="col">Client</th>
      <th scope="col">Owner</th>
      <th scope="col">Partners</th>
      <th scope="col">Clients Deadline</th>
      <th scope="col">Countdown</th>
      <th scope="col">Next?</th>
    </tr>
  </thead>
  <tbody class="white">
	  
	  <?php 
	  
	  $NotOpps = DB::table('UKHT_WorkWinning_Dash')->join("Contact","Contact.Contact_ID","UKHT_WorkWinning_Dash.Owner")->where('UKHT_WorkWinning_Dash.Type','!=','OPP')->where("UKHT_WorkWinning_Dash.Removed",false)
		  ->select('ID','Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Contact_ID','Partners','ETA','Next')->orderby('Type','asc')->orderby('ETA','asc')->get();	
	  
	  foreach($NotOpps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm:ss'));
		  $minutes = new Carbon($left->isoFormat('h:mm:ss'));
		  $seconds = new Carbon($left->isoFormat('h:mm:ss'));
		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	   <tr data-id="{{$Opp->ID}}" class="edit point">
      <td class="type font-weight-bold text-center">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center">{{$Opp->State}}</td>
      <td class="title win font-weight-bold text-center">{{$Opp->Title}}</td>
      <td class="client win font-weight-bold text-center">{{$Opp->Client}}</td>
      <td data-id="{{$Opp->Contact_ID}}" class="owner win font-weight-bold text-center">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="partners win font-weight-bold text-center">{{$Opp->Partners}}</td>
      <td data-value="{{$left->day}} {{$left->englishMonth}}, {{$left->year}}" class="win eta font-weight-bold text-center">{{$left->toRfc850String()}}</td>
	  <td class="etaTime" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td class="next text-center font-weight-bold">{{$Opp->Next}}</td>
    </tr>
	  
	  
	  <?php
		  
	  }
	  
	  ?>
   
  </tbody>
</table>

<?php 

$Quote = DB::table('UKHT_WorkWinning_Dash_Scroller')->where("Type", 1)->first();

$Scrollers = DB::table('UKHT_WorkWinning_Dash_Scroller')->where("Type", 2)->get();


?>


  <h1 class="text-white font-italic"><input type="text" id="slogan" value="{{$Quote->Text ?? ''}} " class="border-0 p-2 w-100 bg-transparent text-white"></h1>

<!-- Editable table -->
  <div class="fixed-bottom d-flex point">
	<div class="ticker-wrap" data-toggle="modal" data-target="#basicExampleModal">
<div class="ticker">
	
	<?php 
	
	foreach($Scrollers as $Scroller){
		echo "<div class='ticker__item'>$Scroller->Text</div>";
	}
  ?>
  
</div>
</div>

</div>


<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Ticker</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div  class="btn btn-primary btn-rounded mb-4" id="TickerAdd"> Add</div>

		  <div id="TickerList">
		  <?php
		  
		  foreach($Scrollers as $Scroller){
		echo "<div><span>$Scroller->Text</span> <i class='fas fa-trash-alt delete-ticker'></i></div>";
	}
		?>  
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="SaveTicker">Save changes</button>
      </div>
    </div>
  </div>
</div>




</div>
<script type="text/javascript">

	$('#container').parents('body').addClass('bg-dark ')
		$(document).ready(function() {
	
	$('.type').each(function(){
		var text = $(this).text(); 
		
		if(text === "OPP"){ $(this).addClass('bg-info text-white font-weight-bold text-center') }
		if(text === "PQQ/EOI"){ $(this).addClass('bg-success text-white font-weight-bold text-center') }
		if(text === "TENDER"){ $(this).addClass('bg-danger text-white font-weight-bold text-center') }
		
		
	})
	
	$('.state').each(function(){
		var text = $(this).text(); 
		
		if(text === "AWAITING PQQ"){ $(this).addClass('cyan lighten-4 darkCyan  font-weight-bold text-center') }
		if(text === "WON"){ $(this).addClass('light-green accent-1 glowGreen-Text font-weight-bold text-center'); $(this).siblings('.win').addClass('light-green accent-1 glowGreen-Text  font-weight-bold text-center'), $(this).siblings('.eta').addClass('strike') }
		if(text === "PENDING/POST"){ $(this).addClass('light-blue darken-2 glowPurple-Text font-weight-bold text-center') }
		if(text === "IN-PROGRESS"){ $(this).addClass('amber accent-1 deep-orange-text font-weight-bold text-center') }
				if(text === "LOST"){ $(this).addClass('red lighten-1 amber-text font-weight-bold text-center');
						   $(this).siblings('.win').addClass('red lighten-1 amber-text  font-weight-bold text-center'), $(this).siblings('.eta').addClass('strike')}
		if(text === "AWAITING ITT"){ $(this).addClass('deep-purple lighten-2 deep-purple-text font-weight-bold text-center') }
		
		
	})
		
	
	
	showTime();
		setInterval(showTime, 1000);
		
	});
	
  function showTime() {
    var date = new Date(),
        utc = new Date(Date.UTC(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('date').innerHTML = utc.toLocaleDateString();
    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
	  getDateTime()
  }



<?php 
	
	$holidays = Yasumi\Yasumi::create('UnitedKingdom', 2020);
	
	?>
	

		function getDateTime(){
			
			$('.etaTime').each(function(){
			
			
				
				moment.updateLocale('uk', {
   workingWeekdays: [1, 2, 3, 4, 5],
					holidays: [<?php foreach($holidays as $holiday){ echo "'$holiday',";} ?>],
					holidayFormat: 'YYYY-MM-DD'
});
				
				var time = $(this).data('value');
				var countdownTime = moment(time).businessDiff(moment());
				

				
					
					
								
			
			$(this).countdown(time,{elapse: true}).on('update.countdown',function(event){
				if (event.elapsed) {
				countdownTime = "- "+countdownTime+" "+event.strftime('days %H:%M:%S')
				$(this).addClass('blue font-weight-bold text-white')
				$(this).removeClass('bg-success')
					$(this).text(countdownTime)
				}else{
					
					if(countdownTime > 20){ $(this).addClass('bg-success font-weight-bold text-white')
												   }
					if(countdownTime <= 20 && countdownTime > 10){ $(this).addClass('bg-warning font-weight-bold')
														}
					if(countdownTime <= 10 && countdownTime > 0){ $(this).addClass('bg-danger font-weight-bold text-white')
													   }
					countdownTime += " "+event.strftime('days %H:%M:%S')
					$(this).text(countdownTime)
												 
					
								}
			}) 
				
			
				
			}
				
			)
			
			
		}

	
	


	$('#slogan').on('keyup',function(){
		
		
		$.post('sloganNewWorkWinning',{ 
			
			text: $(this).val(), 
			UPDATE: 'EDITSlogan'
									
									
									
									})
		
		
	})
	
	$('tr.edit').on('click',function(){
		$('#modalEdit').modal('show');
	
		$('#modalEdit').find('input[value="'+$(this).children('.type').text()+'"]').prop("checked",true)
		$('#EditState').val($(this).children('.state').text())
		$('#EditTitle').val($(this).children('.title').text())
		$('#EditPartners').val($(this).children('.partners').text())
		$('#date-picker-example2').val($(this).children('.eta').data('value'))
		$('#EditNext').val($(this).children('.next').text())
		$('#EditClient').val($(this).children('.client').text())
		$('#EditOwner').val($(this).children('.owner').data('id'))
		$('#itemid').val($(this).data('id'))
	
		
		
		
	})
	
	$('.delete-ticker').on('click',function(){
		$(this).parent('div').remove(); 
		$(this).remove();
	});
	
	$('#SaveTicker').on('click',function(){
		
		var Text = [];
		
		$('#TickerList').find('span').each(function(){
			Text.push($(this).text())
		})
		
		console.log(Text)
		$.post('tickerNewWorkWinning',{ 
			
			text: Text, 
			UPDATE: 'EDITTicker'
									
									
									
									}).done(function(result){
			console.log(result);
			location.reload();
		})
		
		
	})
	
	$('#editDelete').on('click',function(){
		
		$.post('DeletepostNewWorkWinning',{ 
			
			id: $('#itemid').val(),
			UPDATE: 'DELETE'
									
									
									
									}).done(function(result){
			console.log(result)
			
			if(result !== "complete"){
				alert("Please fill in all fields")
			}else{
			location.reload()
			}
	})
	});
	
	$('#editNew').on('click', function(){
		
		console.log($("input[name='EditType']:checked").val())
		console.log($('#EditState').val())
		console.log($('#EditTitle').val())
		console.log($('#EditClient').val())
		console.log($('#EditOwner').val())
		console.log($('#EditPartners').val())
		console.log($('#EditNext').val())
		console.log($('#date-picker-example2').val())
		
		$.post('postNewWorkWinning',{ 
			
			type: $("input[name='EditType']:checked").val(), 
			state: $('#EditState').val(),
			title: $('#EditTitle').val(),
			client: $('#EditClient').val(),
			owner: $('#EditOwner').val(),
			partners: $('#EditPartners').val(),
			next: $('#EditNext').val(),
			eta: $('#date-picker-example2').val(),
			id: $('#itemid').val(),
			UPDATE: 'UPDATE'
									
									
									
									}).done(function(result){
			console.log(result)
			
			if(result !== "complete"){
				alert("Please fill in all fields")
			}else{
			location.reload()
			}
		})
		
		
	})

	$('#addNew').on('click', function(){
		
		console.log($("input[name='AddType']:checked").val())
		console.log($('#AddState').val())
		console.log($('#AddTitle').val())
		console.log($('#AddClient').val())
		console.log($('#AddOwner').val())
		console.log($('#AddPartners').val())
		console.log($('#AddNext').val())
		console.log($('#date-picker-example').val())
		
		$.post('postNewWorkWinning',{ 
			
			type: $("input[name='AddType']:checked").val(), 
			state: $('#AddState').val(),
			title: $('#AddTitle').val(),
			client: $('#AddClient').val(),
			owner: $('#AddOwner').val(),
			partners: $('#AddPartners').val(),
			next: $('#AddNext').val(),
			eta: $('#date-picker-example').val(),
			UPDATE: 'ADD'
									
									
									
									}).done(function(result){
			console.log(result)
			
			if(result !== "complete"){
				alert("Please fill in all fields")
			}else{
			location.reload()
			}
		})
		
		
	})

$('#TickerAdd').on('click', function(){
	
	bootbox.prompt({
    title: "Ticker Text:", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		if(result){
			$('#TickerList').append('<div><span>'+result+'</span> <i class="fas fa-trash-alt delete-ticker"></i> <br></div>');
		}
    }
});
	
	
})
	
</script>


<?php 

	function timeleft(){
		$subscription_end = new Carbon('2016-08-19 00:56:48');

$left = $subscription_end->subDays(Carbon::now()->dayOfWeek());

return $left->diffForHumans();
	}

?>





  <!--Main Layout-->
<!--/.Card-->

@stop
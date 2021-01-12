@extends('dashboard')
@section('content')
<!--Main Layout-->
<meta http-equiv="refresh" content="300" />

<?php 

use Carbon\Carbon;

?>

<style>
	html{
		font-size: 120%;
		
	}
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

<!-- Editable table -->
<div class="d-flex p-2 text-warning" id="Main_div"><div id="date" class="text-warning mr-1 fa-2x"></div><spa class="fa-2x"> - </spa><div id="time" class="text-warning ml-1 fa-2x"></div> <div class="ml-auto bg-white rounded p-2"><img src="{{ asset('images/HochtiefLogo.png') }}" alt="" height="50px"></div></div>
		
		<table class="table table-bordered data ">
  <thead class="text-white" style="background-color: #151e53">    

	  <tr>
      <th scope="col align-middle">Type</th>
      <th scope="col align-middle">State</th>
      <th scope="col align-middle">Title</th>
      <th scope="col align-middle">Client</th>
      <th scope="col align-middle">Owner</th>
      <th scope="col align-middle">Partners</th>
      <th scope="col align-middle">ETA</th>
      <th scope="col align-middle">Days to arrival</th>
      <th scope="col align-middle">Next?</th>
    </tr>
  </thead>
  <tbody class="white">
   
	    <?php 
	  
	  $Opps = DB::table('UKHT_WorkWinning_Dash')->join("Contact","Contact.Contact_ID","UKHT_WorkWinning_Dash.Owner")->where('UKHT_WorkWinning_Dash.Type','=','OPP')->where("UKHT_WorkWinning_Dash.Removed",false)
		  ->select('Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Partners','ETA','Next')->orderBy('State', 'desc')->get();	 
	  foreach($Opps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm'));
		  $minutes = new Carbon($left->isoFormat('h:mm'));

		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	    <tr>
      <td class="type font-weight-bold text-center align-middle">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center align-middle">{{$Opp->State}}</td>
      <td class="win font-weight-bold text-center align-middle">{{$Opp->Title}}</td>
      <td class="win font-weight-bold text-center align-middle">{{$Opp->Client}}</td>
      <td class="win font-weight-bold text-center align-middle">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="win font-weight-bold text-center align-middle">{{$Opp->Partners}}</td>
      <td class="win eta font-weight-bold text-center align-middle">{{str_replace('UTC','',$left->toRfc850String())}}</td>
	  <td class="etaTime align-middle" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td class="next align-middle">{{$Opp->Next}}</td>
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
	  
	  $NotOpps = DB::table('UKHT_WorkWinning_Dash')->join("Contact","Contact.Contact_ID","UKHT_WorkWinning_Dash.Owner")->where('UKHT_WorkWinning_Dash.Type','=','PQQ/EOI')->where("UKHT_WorkWinning_Dash.Removed",false)
		  ->select('Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Partners','ETA','Next')->orderBy('State', 'desc')->get();	
	  
	  foreach($NotOpps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm'));
		  $minutes = new Carbon($left->isoFormat('h:mm'));
		  
		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	    <tr>
      <td class="type font-weight-bold text-center align-middle">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center align-middle">{{$Opp->State}}</td>
      <td class="win font-weight-bold text-center align-middle">{{$Opp->Title}}</td>
      <td class="win font-weight-bold text-center align-middle">{{$Opp->Client}}</td>
      <td class="win font-weight-bold text-center align-middle">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="win font-weight-bold text-center align-middle">{{$Opp->Partners}}</td>
      <td class="win eta font-weight-bold text-center align-middle">{{str_replace('UTC','',$left->toRfc850String())}}</td>
	  <td class="etaTime align-middle" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td class="next align-middle">{{$Opp->Next}}</td>
    </tr>
	  
	  
	  <?php
		  
	  }
	  
	  ?>
   
  </tbody>
 <thead class="text-white" style="background-color: #151e53">    

	  <tr class="p-2">
      <th class="p-2" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
      <th class="p-0" scope="col"></th>
    </tr>
  </thead>
<tbody class="white">
	  
	  <?php 
	  
	  $NotOpps = DB::table('UKHT_WorkWinning_Dash')->join("Contact","Contact.Contact_ID","UKHT_WorkWinning_Dash.Owner")->where('UKHT_WorkWinning_Dash.Type','=','TENDER')->where("UKHT_WorkWinning_Dash.Removed",false)
		  ->select('Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Partners','ETA','Next')->get();	
	  
	  foreach($NotOpps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm'));
		  $minutes = new Carbon($left->isoFormat('h:mm'));
		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	    <tr>
      <td class="type font-weight-bold text-center align-middle">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center align-middle">{{$Opp->State}}</td>
      <td class="win font-weight-bold text-center align-middle">{{$Opp->Title}}</td>
      <td class="win font-weight-bold text-center align-middle">{{$Opp->Client}}</td>
      <td class="win font-weight-bold text-center align-middle">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="win font-weight-bold text-center align-middle">{{$Opp->Partners}}</td>
      <td class="win eta font-weight-bold text-center align-middle">{{str_replace('UTC','',$left->toRfc850String())}}</td>
	  <td class="etaTime align-middle" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td class="next align-middle">{{$Opp->Next}}</td>
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


  <h1 id="slogan" class="text-white font-italic">{{$Quote->Text ?? ''}}</h1>

<!-- Editable table -->
  <div class="fixed-bottom d-flex" hidden>
	<div class="ticker-wrap">
<div class="ticker">
	
	<?php 
	
	foreach($Scrollers as $Scroller){
		echo "<div class='ticker__item'>$Scroller->Text</div>";
	}
  ?>
  
</div>
</div>

</div>

<script type="text/javascript">
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
          date.getHours() - 1,
          date.getMinutes(),
          date.getSeconds()
          
        ));

    document.getElementById('date').innerHTML = utc.toLocaleDateString();
    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
	 
  }

	<?php 
	
	$holidays = Yasumi\Yasumi::create('UnitedKingdom', 2020);
	
	?>
	
$(document).ready(function() {
			
			$('.etaTime').each(function(){
			$(this).text("");
			
				
				moment.updateLocale('uk', {
   workingWeekdays: [1, 2, 3, 4, 5],
					holidays: [<?php foreach($holidays as $holiday){ echo "'$holiday',";} ?>],
					holidayFormat: 'YYYY-MM-DD'
});
				
				
				var daysmom = "";
				var countdownTime = "";
				
				var time = $(this).data('value');
				daysmom = moment(time).businessDiff(moment());
				

				
					
					
								
			
		$(this).countdown(time,{elapse: true}).on('update.countdown',function(event){
				if (event.elapsed) {
				countdownTime = "- "+event.strftime(daysmom+' days %H:%M:%S')
				$(this).addClass('blue font-weight-bold text-white')
				$(this).removeClass('bg-success')
					
				}else{
					
					if(daysmom > 20){ $(this).addClass('bg-success font-weight-bold text-white')
												   }
					if(daysmom <= 20 && daysmom > 10){ $(this).addClass('bg-warning font-weight-bold')
														}
					if(daysmom <= 10 && daysmom > 0){ $(this).addClass('bg-danger font-weight-bold text-white')
													   }
					countdownTime = event.strftime(daysmom+'  days %H:%M:%S');
				
					
								}
			
			$(this).html(countdownTime)
			}) 
				
			
				
			}
				
			); 
	
})
			

	
	


/*	$(document).ready(function(){
	var currHeight = 0;
	var totalHeight = $("#Main_div").outerHeight;
	
	function scroll_down_XD(){
		//var myVar = setInterval(myTimer, 1000);
		
		
	}
	});
	
	function myTimer(){
			
	}
	

	function timerchecker(){
			< ?php
				$tester = false;
		
				$newTime = db::table('UKHT_WorkWinning_Dash')
					->select('Updated')
					->orderBy("Updated",'desc')
					->first();
		
		if (Carbon::create($newTime->Updated)->hour() >= Carbon::create()->hour()){
			if (Carbon::create($newTime->Updated)->hour() > Carbon::create()->hour()){
				$tester = true;
			}else{
				if (Carbon::create($newTime->Updated)->minute() >= Carbon::create()->minute()){
					if (Carbon::create($newTime->Updated)->minute() > Carbon::create()->minute()){
						$tester = true;	
					} else if(Carbon::create($newTime->Updated)->second() > Carbon::create()->second()){
						$tester = true;	
					}
				}
			}
		};
		
		if ($tester == true){
		?>
			location.reload();
		< ?php
		};
		
		?>
	}
	
	$(document).ready(function(){
		window.setInterval(timerchecker, 300000)
	});
	
	*/

</script>

  <!--Main Layout-->
<!--/.Card-->

@stop
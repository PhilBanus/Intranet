@extends('dash')
@section('content')
<!--Main Layout-->
 <meta http-equiv="refresh" content="300" />

<?php 

use Carbon\Carbon;

?>

<script type="text/javascript" src="../countdown/jquery.countdown.js"></script>


<style>

	.table-bordered, tr, td, thead, th{
		  border-color: black !important;
	}
	
* {
  box-sizing: border-box;
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
<div class="d-flex p-2 text-warning"><div id="date" class="text-warning mr-1 fa-2x"></div><spa class="fa-2x"> - </spa><div id="time" class="text-warning ml-1 fa-2x"></div> <div class="ml-auto bg-white rounded p-2"><img src="{{ asset('/images/HochtiefLogo.png') }}" alt="" height="50px"></div></div>
		
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
		  ->select('Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Partners','ETA','Next')->get();	 
	  foreach($Opps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm:ss'));
		  $minutes = new Carbon($left->isoFormat('h:mm:ss'));
		  $seconds = new Carbon($left->isoFormat('h:mm:ss'));
		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	    <tr>
      <td class="type font-weight-bold text-center">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center">{{$Opp->State}}</td>
      <td class="win font-weight-bold text-center">{{$Opp->Title}}</td>
      <td class="win font-weight-bold text-center">{{$Opp->Client}}</td>
      <td class="win font-weight-bold text-center">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="win font-weight-bold text-center">{{$Opp->Partners}}</td>
      <td class="win eta font-weight-bold text-center">{{$left->toRfc850String()}}</td>
	  <td class="etaTime" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td>{{$Opp->Next}}</td>
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
		  ->select('Type','State','UKHT_WorkWinning_Dash.Title','Client','Forename','Surname','Partners','ETA','Next')->get();	
	  
	  foreach($NotOpps as $Opp){
		  
		  $left = new Carbon($Opp->ETA);
		  $hours = new Carbon($left->isoFormat('h:mm:ss'));
		  $minutes = new Carbon($left->isoFormat('h:mm:ss'));
		  $seconds = new Carbon($left->isoFormat('h:mm:ss'));
		  
		  if($left < new Carbon()){ $symb = "-" ; }else {  $symb = "" ;}
		  ?>
	  
	    <tr>
      <td class="type font-weight-bold text-center">{{$Opp->Type}}</td>
      <td class="state font-weight-bold text-center">{{$Opp->State}}</td>
      <td class="win font-weight-bold text-center">{{$Opp->Title}}</td>
      <td class="win font-weight-bold text-center">{{$Opp->Client}}</td>
      <td class="win font-weight-bold text-center">{{substr($Opp->Forename,0,1)}}{{substr($Opp->Surname,0,1)}}{{substr($Opp->Surname,-1)}} </td>      	  
	  <td class="win font-weight-bold text-center">{{$Opp->Partners}}</td>
      <td class="win eta font-weight-bold text-center">{{$left->toRfc850String()}}</td>
	  <td class="etaTime" data-value="{{$left}}">		  {{$left->diffForHumans([
    'parts' => 5,
		  'join' => true,
    
])}}
		   </td>
		  
		  
		  </td>
      <td>{{$Opp->Next}}</td>
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
	
	$('.type').each(function(){
		var text = $(this).text(); 
		
		if(text === "OPP"){ $(this).addClass('bg-info text-white font-weight-bold text-center') }
		if(text === "PQQ/EOI"){ $(this).addClass('bg-success text-white font-weight-bold text-center') }
		if(text === "TENDER"){ $(this).addClass('bg-danger text-white font-weight-bold text-center') }
		
		
	})
	
	$('.state').each(function(){
		var text = $(this).text(); 
		
		if(text === "AWAITING PQQ"){ $(this).addClass('cyan lighten-4 cyan-text font-weight-bold text-center') }
		if(text === "WON"){ $(this).addClass('light-green accent-1 green-text font-weight-bold text-center'); $(this).siblings('.win').addClass('light-green accent-1 green-text font-weight-bold text-center'), $(this).siblings('.eta').addClass('strike') }
		if(text === "PENDING/POST"){ $(this).addClass('light-blue darken-2 deep-purple-text font-weight-bold text-center') }
		if(text === "IN-PROGRESS"){ $(this).addClass('amber accent-1 deep-orange-text font-weight-bold text-center') }
		if(text === "LOST"){ $(this).addClass('red lighten-3 deep-orange-text font-weight-bold text-center') }
		if(text === "AWAITING ITT"){ $(this).addClass('deep-purple lighten-2 deep-purple-text font-weight-bold text-center') }
		
		
	})
	
	
	
  function show
	() {
    var date = new Date();
		var hours = parseInt(date.getHours()) - 1;
		console.log(hours);
       var utc = new Date(Date.UTC(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          hours,
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('date').innerHTML = utc.toLocaleDateString();
    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
	  getDateTime()
  }

	showTime();
  setInterval(showTime, 1000);


		function getDateTime(){
			
			$('.etaTime').each(function(){
			
				var time = $(this).data('value');
			
			$(this).countdown(time,{elapse: true}).on('update.countdown',function(event){
				if (event.elapsed) {
				$(this).text(event.strftime('- %D days %H:%M:%S'))
				$(this).addClass('blue font-weight-bold text-white')
				}else{
					if(event.offset.totalDays > 20){ $(this).text(event.strftime('%D days %H:%M:%S'))
												   $(this).addClass('bg-success font-weight-bold text-white')
												   }
					if(event.offset.totalDays < 20 > 10){ $(this).text(event.strftime('%D days %H:%M:%S'))
														$(this).addClass('bg-warning font-weight-bold')
														}
					if(event.offset.totalDays < 10 > 0){ $(this).text(event.strftime('%D days %H:%M:%S'))
													   $(this).addClass('bg-danger font-weight-bold text-white')
													   }
					
								}
			})
			}
				
			)
			
			
		}

	
	


	
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
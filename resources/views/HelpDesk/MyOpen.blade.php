@extends('intranet')
@section('bg')
style="background-color: #f9f9f9!important"
@stop
@section('content')
<?php use Carbon\Carbon ?>
<style type="text/css">
<!--
/* @group Blink */
.blink {
	-webkit-animation: blink 1s linear infinite;
	-moz-animation: blink 1s linear infinite;
	-ms-animation: blink 1s linear infinite;
	-o-animation: blink 1s linear infinite;
	 animation: blink 1s linear infinite;
}
@-webkit-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@-moz-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@-ms-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@-o-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
/* @end */
-->
	

</style>
<?php $r = \Route::getCurrentRoute()->uri();
echo $r; ?>

@include('HelpDesk.AdminNav')
	
	

<div class="card bg-transparent mt-5 border-0 h-100">

<div class="card-header bg-transparent font-weight-bold border-primary">Your Tickets</div>

	
	<div class="card-body ">
	<?php 
		
		$Calls = db::table('HELPDESK_Calls')->where('Contact',session('MY_ID'))->get()->take(50);
		
		foreach($Calls as $Call){
			?>
		
			<a href=""><div class="card rounded-0 border-0 z-depth-1-half">
  <div class="card-body row" style="white-space: nowrap;">
	  <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 col-4 ">
	  	  <img src="https://themis.ukht.org/__files/rendition/1853289/-9/photo.jpg" class="rounded z-depth-1 w-100 mx-auto my-auto techimg"  alt="...">
</div>
	  <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7 col-7">
    <h5 class="card-title" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; ">{{$Call->Subject}}</h5>
    <p class="card-text text-truncate" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; " >{{$Call->Description}}</p>
    
		  
		  <div class="float-left small text-muted mr-4">Update: {{Carbon::create($Call->Last_Updated)->toDayDateTimeString()}}</div>
		  <div class="float-left small {{DB::table('HELPDESK_Category')->where('ID',$Call->Category)->first()->Color}} text-primary mr-4">{{DB::table('HELPDESK_Category')->where('ID',$Call->Category)->first()->Name}}</div>
		  <div class="float-left small text-muted mr-4">Comments: 5</div>
		  <div class="float-left small text-success mr-4 small blink">unread comments</div>
		 
		  
  </div>
	  
	  <div class="col-1 {{DB::table('HELPDESK_Status')->where('ID',$Call->Status)->first()->Color}} my-auto mx-auto"> <small>{{DB::table('HELPDESK_Status')->where('ID',$Call->Status)->first()->Name}}</small>  </div>
	    
			
			</div>
</div></a>
		
		
		<?php
		}
		
		?>
	
	
	
	
	</div>


</div>



@stop



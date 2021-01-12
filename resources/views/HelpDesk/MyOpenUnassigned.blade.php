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

@include('HelpDesk.AdminNav')
	
	

<div class="card bg-transparent mt-5 border-0 h-100">

<div class="card-header bg-transparent font-weight-bold border-primary">Calls Assigned to You</div>

	
	<div class="card-body ">
	<?php 
		
		$Calls = db::table('HELPDESK_Calls')->where('Technician',session('MY_ID'))->whereIn('Status',[1,2,3,5])->get()->take(50);
		
		foreach($Calls as $Call){
			?>
		
			<a data-toggle="modal" data-target="#Ticket" data-id="{{$Call->ID}}"><div class="card rounded-0 border-0 z-depth-1-half mb-2">
  <div class="card-body row" style="white-space: nowrap;">
	 	  <div class="col-lg-11 col-md-10 col-sm-9 col-xs-8 col-8">
    <h5 class="card-title" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; ">{{base64_decode($Call->Subject)}}</h5>
    <p class="card-text text-truncate" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; " >{{base64_decode($Call->Description)}}</p>
    
		  
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

<div class="card bg-transparent mt-5 border-0 h-100">

<div class="card-header bg-transparent font-weight-bold border-primary">Unassigned</div>

	
	<div class="card-body ">
	<?php 
		
		$Calls = db::table('HELPDESK_Calls')->whereNull('Technician')->whereIn('Status',[1,2,3,4])->get()->take(50);
		
		foreach($Calls as $Call){
			?>
		
			<a data-toggle="modal" data-target="#Ticket" data-id="{{$Call->ID}}"><div class="card rounded-0 border-0 z-depth-1-half mb-2">
  <div class="card-body row" style="white-space: nowrap;">
	 	  <div class="col-lg-11 col-md-10 col-sm-9 col-xs-8 col-8">
    <h5 class="card-title" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; ">{{base64_decode($Call->Subject)}}</h5>
    <p class="card-text text-truncate" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; " >{{base64_decode($Call->Description)}}</p>
    
		  
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



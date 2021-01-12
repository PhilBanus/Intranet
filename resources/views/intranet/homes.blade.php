
@extends('intranet')
@section('content')
<!--Main Layout-->

 
@include("cards.MyMeeting")

<div class="m-0 " >

 <div class="col-12 card-columns">
	  @include('cards.stayInTouch')	 
	 
	

<!-- <div class="card">@include("cards.guidanceDoc")
	</div> -->

@include("cards.LiveProjects")



	
	
 @include("cards.Alert")
	 

		 @include("cards.projectGallery")
	 @include('cards.opex')
	  @include('cards.usefulDocs')	 
	 
	


	
		@include("cards.Values") 
		
		 
		 
		 
		 
	 	 </div>


</div>
  <!--Main Layout-->
<!--/.Card-->

<?php

$Projects = DB::table("UKHT_Alerts")->join("UKHT_Alert_Recipients","UKHT_Alert_Recipients.Alert_ID","=","UKHT_Alerts.ID")->where("UKHT_Alert_Recipients.Contact_ID","=",session('MY_ID'))->where("Active","=","1")->orderby('Read','asc')->orderby('Alert_ID','desc')->take(5);
	
	if($Projects->exists()){
	
	foreach($Projects->get() as $Project)
	{
	
	
	?>
    
	
				
				<div class="modal fade right" id="alert{{$Project->ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header {{$Project->Color}}">
        <h5 class="modal-title " id="exampleModalPreviewLabel"><i class="{{$Project->Type}}"></i> {{urldecode($Project->Subject)}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-2">
		<p>
       <?php echo urldecode($Project->Body) ?>
			</p>
      </div>
     
    </div>
  </div>
</div>
	
<?php } } ?>

@stop
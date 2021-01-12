@extends('intranet')
@section('content')
<!--Main Layout-->

 
@include("cards.MyMeetings")

 <div class="col-12 card-columns border-top pt-2">
@include("cards.guidanceDoc")
@include("cards.LiveProjects")

	 

@include("cards.projectGallery")

	 
@include("cards.Values")
	 	 
	 
</div>



  <!--Main Layout-->
<!--/.Card-->

@stop
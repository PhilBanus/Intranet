@extends('intranet')

@section('content')
@include('humantimer')

<ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTabJust" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab-just" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just"
      aria-selected="true">ICT Projects</a>
  </li>
 
</ul>
<div class="tab-content card pt-5" id="myTabContentJust">
  <div class="tab-pane fade show active" id="home-just" role="tabpanel" aria-labelledby="home-tab-just">
    
	  <a href="ictProjectCreate" class="btn text-white primary-color">Create New Project</a>
	
	  {{View::make('ICT.projectView')}}
 
	  
  </div>
 
</div>




@stop



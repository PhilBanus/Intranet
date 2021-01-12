@extends('intranet')

@section('content')

<!-- add card for each project-->
<div class="row" >
	<div class=" card card-cascade text-white blue-gradient  col-md-12">
		<div class="row py-3">
<a href="ictProjectCreate" class="btn text-white primary-color col-md-3 float-left text-center">Create New Project</a>
	<h1 class="col-md-4 float-right">Projects</h1> 
			</div>
		</div>
</div>
<div class="row ">
<?php 
$related_projects = db::table('UKHT_ICT_Projects')
				->join('UKHT_ICT_Projects_Contacts' ,'UKHT_ICT_Projects_Contacts.Project_ID', '=', 'UKHT_ICT_Projects.ID')
				->where('UKHT_ICT_Projects_Contacts.Contact_ID', session('MY_ID'))
				->get();

foreach($related_projects as $related_project){
	?>
	<div class="col-md-3 mt-2">
	<div class="card text-center">
	  <div class="card-header  text-white blue-gradient" >
		<a href="projectExtendedView?id={{$related_project->ID}}" style="color: white">{{$related_project->Name}}</a> 
	  </div>
	  <div id="{{$related_project->ID}}" class="card-body" style="overflow-y: auto; height: 150px">
		 <script>
		  $('#{{$related_project->ID}}').load('ictUserTasks?id={{$related_project->ID}}');
		 </script>
		  
	  </div>
	  <div class="card-footer text-muted">
		  >XD
	  </div>
	</div>
	</div>
	
	<?php
			}
	?>
</div>



@stop


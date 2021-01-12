@extends('intranet')

@section('content')

<?php

			$Users = DB::table("User")
					->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
				->orderby('Forename','asc')
				->orderby('Surname','asc')
					->get();
?>

<script>
var searchInput = "";

</script>


<div class="row">
	<div class="col-md-12 float left">
		<div class="card card-cascade">
		  <div class="view view-cascade gradient-card-header blue-gradient">
			<h2 class="card-header-title mb-3"> New Project</h2>
		  </div>
		</div>
	</div>
	
	<div class="col-md-12">
		<div class="card card-cascade">
			<div class="card-header bg-dark">
				<div class="row d-flex justify-content-around ">
					<div class="md-form col-md-5">
					<input type="text" id="Project_Title" class="form-control text-warning">
					<label for="form1 " class="text-warning">Project Title</label>
					</div>
					<select id="Project_Creator" class="mdb-select md-form col-md-5 colorful-select dropdown-primary text-warning" searchable="Search..." style="color: #E1B600 !important">
							<option value="" class="text-warning" disabled selected>Choose The Owner</option>
						<?php
					foreach($Users as $User){

						?>

						<option value="{{$User->Contact_ID}}" data-jobtitle="{{$User->Job_Title}}">{{$User->Forename}} {{$User->Surname}}</option>

						<?php
							}
						?>
					  
					  
					</select>
				</div>
				
			</div>
		</div>
	</div>
	
	
	<div class="col-md-12">
		<div class="card card-cascade">
			<div class="card-header white">
				<h3 class="text-center">Start date</h3>
				<div class="row d-flex justify-content-around ">
					<div class="md-form col-md-5">
					<input placeholder="" type="text" id="Project_startDate" class="form-control datepicker">
					<label for="date-picker-example2" class="">Start date</label>
					</div>
					
				</div>
			</div>
			
			<div class="card-header white">
				<h3 class="text-center">Status</h3>
				<div class="row d-flex justify-content-around ">
					<div class="md-form col-md-8">
					<input type="text" id="Project_StatusDescription" class="form-control ">
					<label for="form1 " class="">Status</label>
					</div>
				</div>
			</div>
			
			<div class="card-header white">
				<h3 class="text-center">Description</h3>
				<div class="row d-flex justify-content-around ">
					<div class="md-form col-md-8">
					  <textarea id="Project_Description" class="form-control md-textarea" rows="3"></textarea>
					  <label for="textarea-char-counter">Description</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	

</div>



<div   class="fixed-action-btn" style="bottom: 45px; right: 24px;" >
  <a id="Create_button" class="btn-floating btn-lg green nav-link">
    <i class="fas fa-check"></i>
  </a>


</div>



<script>
	
	
	
	$(document).ready(function(){
		$('#Create_button').on('click',function(){
			//Add an if so can only add project if all fields are filled.
			
			if ($('#Project_Title').val() == ""){ alert("Please enter a Project Title");
			}else if($('#Project_Creator').val() == null){ alert("Please enter a Project Creator");
			}else if($('#Project_startDate').val() == ""){ alert("Please enter a Project Start Date");
			}else if($('#Project_StatusDescription').val() == ""){ alert("Please enter a Project Status");
			}else if($('#Project_Description').val() == ""){ alert("Please enter a Project Description");
			}else {
				
			$.post('AddProjectPHP', {
				Project_name: $('#Project_Title').val(),
				Project_Creator: $('#Project_Creator').val(),
				Project_StartDate: $('#Project_startDate').val(),
				Project_Status: $('#Project_StatusDescription').val(),
				$Project_Description: $('#Project_Description').val()
				
			})
				
				alert("Project Saved");
				window.location.href = 'ICTProjects';
			}
		})
	});
	
	
	/* contact adder
	
	$(document).ready(function(){
		$("#addColab").click(function(){
			var newcontact = "<li class='list-group-item float-right'> <div  class='d-flex justify-content-between '> " + '<img src="" width="80" height="80" alt="avatar" class="avatar rounded-circle mr-2 z-depth-1"> <div class="text-small">' + "<strong>Colab name</strong>" + ' <p class="last-message text-muted"> job title </p> </div> <div class="chat-footer"> <p class="text-smaller text-muted mb-0 badge badge-primary"> colab name </p> </div> </div> </li>';
			$("#contactAdder").append(newcontact);
		})
		
	})
	*/

</script>


@stop


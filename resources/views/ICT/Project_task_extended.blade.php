<?php
session_start();
$task_ID = $_GET['id'];
$project_ID = $_GET['project'];
$project_location = $_GET['location'];

$current_Task =db::table('UKHT_ICT_Projects_Tasks_New')
			  ->where('ID', $task_ID)
			  ->first();
?>




			  <div class="col-md-5 float-left">
				  <div> Order: #{{$current_Task->Task_Order}}</div>
			  		<hr/>
				  <div>
					  Linked Tasks
					  <hr/>
					  <ul class="connectedSortable list-group" id="linked_tasksUl">
						<!-- php in all selected tasks  -->
						  <li class="list-group-item" style="font-size: 15px"> <span class="badge badge-secondary">anyone</span> Test </li>
						  <?php 
						  	
						  ?>
					  </ul>
				  </div>
			  </div>
		  
        <div class="mx-auto justify-content-around col-md-7 float-right">
		  
		  <div class="md-form col-md-10">
			  <textarea id="textarea-cha-counter" class="form-control md-textarea" >i</textarea>
			  <label for="textarea-char-counter">Description</label>
			</div>
		
		  
		  <select class="mdb-select md-form float-right col-md-12 " searchable="Search here..">
			  <option value="" disabled selected>Choose your dependent tasks</option>
			  <!-- php for all tasks within this project and area where (order < this.order) -->
			  <?php 
			  $dependants = db::table('UKHT_ICT_Projects_Tasks_New')
				  		->where('Location', $project_location)
				  		->where('Task_Order', "<" ,$current_Task->Task_Order)
				  		->where('ID', "<>", $task_ID)
				  		->get();
			  if ($dependants != null){
			  foreach ($dependants as $dependant) {
				  
				  ?>
			  
			  	<option value="{{$dependant->ID}}">{{$dependant->Description}}</option>
			  
			  <?php
				  }
			  }
			  
			  ?>
			</select>
		 
		  <select id="linked-tasks" class="mdb-select md-form float-right col-md-12" multiple>
			  <option value="" disabled selected>Choose your linked tasks</option>
			  <!-- php for all tasks within this project and area  -->
			  <?php
			  	$links = db::table('UKHT_ICT_Projects_Tasks_New')
						->where('Location', $project_location)
						->where('ID', "<>", $task_ID)
				  		->get();
			  if ($links != null){
			  foreach($links as $link) {
				  ?>
			  
			  <option value="{{$link->ID}}">{{$link->Description}}</option>
			  
			  <?php
				  }
			  }
			  ?>
			</select>
			<label class="mdb-main-label"></label>
			<button class="btn-save btn btn-primary btn-sm ">Save</button>
		  
		  <select class="mdb-select md-form float-right col-md-12" searchable="Search here..">
			  <option value="" disabled selected>Optional: choose contact</option>
			  <!-- php for optional contacts -->
			  <?php
			  $users = db::table('UKHT_ICT_Projects_contacts')
					->join('Contact','Contact.Contact_ID','=','UKHT_ICT_Projects_Contacts.Contact_ID')
				  ->where([["UKHT_ICT_Projects_Contacts.Project_ID","=",$project_ID], ["UKHT_ICT_Projects_Contacts.Disabled","=",false]])
				  ->get();
			  foreach ($users as $user) {
				  ?>
			  
			  	<option value="{{$user->Contact_ID}}">{{$user->Forename}} {{$user->Surname}}</option>
			  
			  <?php
			  }
			  
			  ?>
			</select>
			  </div>

<script>
$(document).ready(function(){
	$('.mdb-select').materialSelect();
	$('.md-textarea').text('{{$current_Task->Description}}');
	
	$('btn-save').on('click', function(){
		var Linked_task_val = $('#linked-tasks:checked').val();
		var Linked_task_text = $('#linked-tasks:checked').text();
		Linked_task_val.forEach(function(item, index){
			var linked_DIV = '<li class="list-group-item" style="font-size: 15px" data-id="' + item + '"> <span class="badge badge-secondary">anyone</span>' + Linked_task_text[index] + '</li>';
			$('#linked_tasksUl').append('<li>hello</li>');
			
		})
		
		})
});



</script>
			 


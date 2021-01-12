@extends('intranet')

@section('content')
<?php

$project_ID = $_GET['ID']

?>


<style>
	.connectedSortable {
		height: 100px;
		font-size: 12px;
	}




</style>




<div class="row justify-content-around mx-auto col-md-12" >

	<div class="card text-center col-md-3">
	  <div class="card-header  text-white blue-gradient" data-id='1'>
		Discussions
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable1" class="connectedSortable  list-group">
		  <li class="list-group-item"> testing  testing  testing  </li>
		  
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	
	<div class="card text-center col-md-3">
	  <div class="card-header  text-white blue-gradient" data-id='2'>
		Tasks To Start
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable2" class="connectedSortable  list-group">
		  <li class="list-group-item"> testing  testing  testing  </li>
		  
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	
	<div class="card text-center col-md-3">
	  <div class="card-header text-white  blue-gradient" data-id='3'>
		Ongoing Tasks
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable3" class="connectedSortable  list-group">
		  <li class="list-group-item"> testing  testing  testing  </li>
		  
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	
</div>


<div class="row justify-content-around mx-auto pt-3 col-md-12">

	<div class="card text-center col-md-4">
	  <div class="card-header text-white blue-gradient" data-id='4'>
		Completed Tasks
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable4" class="connectedSortable  list-group">
		  <li class="list-group-item "> testing  testing  testing  </li>
		  
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	
	<div class="card text-center col-md-4">
	  <div class="card-header text-white blue-gradient" data-id='5'>
		Post Production
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable5" class="connectedSortable list-group">
			  <li class="list-group-item"> testing  testing  testing </li>
			  
			  
			  
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		 + Add Task Here 
	  </div>
	</div>


</div>
	
<!-- add stuff button -->
<div class="fixed-action-btn" id="add_StuffBtn" style="bottom: 5px; right: 5px;">
  <a class="btn-floating btn-lg blue-gradient">
    <i class="fas fa-plus"></i>
  </a>
</div>



<!-- Modal -->
<div class="modal fade" id="TaskExtended" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Task Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  <div  style="overflow-y: auto; max-height: 350px">
			  <div class="col-md-5 float-left">
			  	<div class="md-form col-md-4">
				  <input type="text" id="form1" class="form-control">
				  <label for="form1">Order</label>
				</div>
			  
				  <div>
					  Linked Tasks
					  <ul class="connectedSortable list-group" id="linked_tasksUl">
						<!-- php in all selected tasks  -->
					  </ul>
				  </div>
			  </div>
			  
        <div class="mx-auto justify-content-around col-md-7 float-right">
		  
		  <div class="md-form col-md-10">
			  <textarea id="textarea-cha-counter" class="form-control md-textarea" ></textarea>
			  <label for="textarea-char-counter">Description</label>
			</div>
		
		  
		  <select class="mdb-select md-form float-right " searchable="Search here..">
			  <option value="" disabled selected>Choose your dependent tasks</option>
			  <!-- php for all tasks within this project and area where (order < this.order) -->
			</select>
		 
		  <select class="mdb-select md-form float-right " multiple>
			  <option value="" disabled selected>Choose your linked tasks</option>
			  <!-- php for all tasks within this project and area  -->
			</select>
			<label class="mdb-main-label">Example label</label>
			<button class="btn-save btn btn-primary btn-sm">Save</button>
		  
		  <select class="mdb-select md-form float-right" searchable="Search here..">
			  <option value="" disabled selected>Optional: choose contact</option>
			  <!-- php for optional contacts -->
			</select>
			  </div>
			 </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>




<script>
var add_flipswitch = true;
var stuff_flipswitch = true;
var	temp_taskInfo = "";
	
$(document).ready(function(){
	
	
	
	
	$('.add_Task').on('click', function(){
		if (add_flipswitch == true) {
			$(this).text("add");
			$(this).siblings('.card-body').children('.connectedSortable').append("<li class='temp_taskDiv list-group-item'><div class='md-form'><input type='text' id='form1' class='form-control temp_taskInput'><label for='form1'>enter task</label></div></li>");
			add_flipswitch = false;
		} else {
			temp_taskInfo = $('.temp_taskInput').val();
			$('.temp_taskDiv').remove()
			$(this).siblings('.card-body').children('.connectedSortable').append('<li class="list-group-item">' + temp_taskInfo +  '</li>')
			$(this).text("+ Add Task Here ");
			//php post here
			$.post('AddNewTaskPHP', {
				project_id: "{{$project_ID}}",
				location_id: $(this).siblings('.blue-gradient').data('id'),
				task_Description: temp_taskInfo,
				
			})
			add_flipswitch = true;
		}
	});
	
	
	
	
	$('#SortableTable1, #SortableTable2, #SortableTable3, #SortableTable4, #SortableTable5').sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();
	
	
	$('.list-group-item').on('dblclick', function(){
		$('#TaskExtended').modal('show');
	})
	
	
	
	$('#add_StuffBtn').on('click', function(){
		if (stuff_flipswitch == true){
			 $(this).hide();
			stuff_flipswitch = false;
			} else {
			$(this).show();
			stuff_flipswitch = true;
			}
	})
	
  } );			  
		
					  
				 
				



</script>






@stop


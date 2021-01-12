@extends('intranet')

@section('content')
<?php

$project_ID = $_GET['id']

?>


<style>
	.connectedSortable {
		height: 100px;
		font-size: 12px;
	}




</style>




<div class="row justify-content-around mx-auto col-md-12" >
<div class="col-md-3">
	<div class="card text-center" data-id='1'>
	  <div class="card-header  text-white blue-gradient" >
		Discussions
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable1" class="connectedSortable  list-group">
			  <!-- php for all items in this catagory -->
			  <?php
			  	$idea_tasks = db::table('UKHT_ICT_Projects_Tasks_New')
					->where('Location', 1)
					->orderBy('Task_Order', 'asc')
					->get();
			  
					
					if ($idea_tasks == null) {
						
					} else {
					$curr_pos1 = 0;
				foreach ($idea_tasks as $idea){	
					$curr_pos1 += 1;
					?>
			  
			  
			  	<li class="list-group-item" data-pos="{{$curr_pos1}}" data-id="{{$idea->ID}}">{{$idea->Description}}</li>
			  
			  
			  
			  <?php
					}
				}

			  ?>
		  
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	</div>
	<div class="col-md-3">
	<div class="card text-center" data-id='2'>
	  <div class="card-header  text-white blue-gradient" >
		Tasks To Start
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable2" class="connectedSortable  list-group">
		  <!-- php for all items in this catagory -->
			  <?php
			  	$idea_tasks = db::table('UKHT_ICT_Projects_Tasks_New')
					->where('Location', 2)
					->orderBy('Task_Order', 'asc')
					->get();
			  
					
					if ($idea_tasks == null) {
						
					} else {
					$curr_pos2 = 0;
				foreach ($idea_tasks as $idea){	
					$curr_pos2 += 1;
					?>
			  
			  
			  	<li class="list-group-item" data-pos="{{$curr_pos2}}" data-id="{{$idea->ID}}">{{$idea->Description}}</li>
			  
			  
			  
			  <?php
					}
				}

			  ?>
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	</div>
	<div class="col-md-3">
	<div class="card text-center" data-id='3'>
	  <div class="card-header text-white  blue-gradient" >
		Ongoing Tasks
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable3" class="connectedSortable  list-group">
		  <!-- php for all items in this catagory -->
			  <?php
			  	$idea_tasks = db::table('UKHT_ICT_Projects_Tasks_New')
					->where('Location', 3)
					->orderBy('Task_Order', 'asc')
					->get();
			  
					
					if ($idea_tasks == null) {
						
					} else {
					$curr_pos3 = 0;
				foreach ($idea_tasks as $idea){	
					$curr_pos3 += 1;
					?>
			  
			  
			  	<li class="list-group-item" data-pos="{{$curr_pos3}}" data-id="{{$idea->ID}}">{{$idea->Description}}</li>
			  
			  
			  
			  <?php
					}
				}

			  ?>
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	</div>
</div>


<div class="row justify-content-around mx-auto pt-3 col-md-12">
	<div class="col-md-4">
	<div class="card text-center" data-id='4'>
	  <div class="card-header text-white blue-gradient" >
		Completed Tasks
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable4" class="connectedSortable  list-group">
		  <!-- php for all items in this catagory -->
			  <?php
			  	$idea_tasks = db::table('UKHT_ICT_Projects_Tasks_New')
					->where('Location', 4)
					->orderBy('Task_Order', 'asc')
					->get();
			  
					
					if ($idea_tasks == null) {
						
					} else {
					$curr_pos4 = 0;
				foreach ($idea_tasks as $idea){	
					$curr_pos4 += 1;
					?>
			  
			  
			  	<li class="list-group-item" data-pos="{{$curr_pos4}}" data-id="{{$idea->ID}}">{{$idea->Description}}</li>
			  
			  
			  
			  <?php
					}
				}

			  ?>
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		  + Add Task Here
	  </div>
	</div>
	</div>
	<div class="col-md-4">
	<div class="card text-center" data-id='5'>
	  <div class="card-header text-white blue-gradient" >
		Post Production
	  </div>
	  <div class="card-body" style="overflow-y: auto">
		  <ul id="SortableTable5" class="connectedSortable list-group">
			  <!-- php for all items in this catagory -->
			  <?php
			  	$idea_tasks = db::table('UKHT_ICT_Projects_Tasks_New')
					->where('Location', 5)
					->orderBy('Task_Order', 'asc')
					->get();
			  
					
					if ($idea_tasks == null) {
						
					} else {
					$curr_pos5 = 0;
				foreach ($idea_tasks as $idea){	
					$curr_pos5 += 1;
					?>
			  
			  
			  	<li class="list-group-item" data-pos="{{$curr_pos5}}" data-id="{{$idea->ID}}">{{$idea->Description}}</li>
			  
			  
			  
			  <?php
					}
				}

			  ?>
		  </ul>
	  </div>
	  <div class="card-footer text-muted add_Task">
		 + Add Task Here 
	  </div>
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
		  <div id="detail_Container" style="overflow-y: auto; max-height: 350px">
		  
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
var pos_order
	
$(document).ready(function(){
	reindex()
	
	
	
	$('.add_Task').on('click', function(){
		if (add_flipswitch == true) {
			$(this).text("add");
			$(this).siblings('.card-body').children('.connectedSortable').append("<li class='temp_taskDiv list-group-item'><div class='md-form'><input type='text' id='form1' class='form-control temp_taskInput'><label for='form1'>enter task</label></div></li>");
			add_flipswitch = false;
		} else {
			if ($('.temp_taskInput').val() == ""){
				
				}else {
			if ($(this).siblings('.card-body').children('ul').children().length == 0){
				pos_order = 1;
			} else {
				pos_order =  verifier1($(this).parents('.card').data('id'));
			} 
			temp_taskInfo = $('.temp_taskInput').val();
			$('.temp_taskDiv').remove()
			$(this).siblings('.card-body').children('.connectedSortable').append('<li class="list-group-item">' + temp_taskInfo +  '</li>')
			$(this).text("+ Add Task Here ");
			//php post here
			$.post('AddNewTask', {
				project_id: "<?php echo $project_ID ?>",
				location_id: $(this).parents('.card').data('id'),
				task_Description: temp_taskInfo,
				type: "create",
				order: pos_order
			})
			add_flipswitch = true;
			location.reload();
			}
		}
	});
	
	
	
	
	$('#SortableTable1, #SortableTable2, #SortableTable3, #SortableTable4, #SortableTable5').sortable({
      connectWith: ".connectedSortable",
		update: function( event, ui ) {
			reindex();
			reindex_Post();
			$.post('AddNewTask', {
				project_id: $(ui.item).data('id'),
				location_id: $(this).parents('.card').data('id'),
				task_Description: "random",
				type: "update_location",
				order: " "
			}).done(function(result){
				console.log(result)
			})
			
		}
    }).disableSelection();
	
	
	$('.list-group-item').on('dblclick', function(){
		$('#detail_Container').load('ictTaskextended?id=' + $(this).data('id') + "&project={{$project_ID}}&location=" +  $(this).parents().parents('.card').data('id'));
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
	
	
	
	
	
  });			  
		
					  
				 
				
function verifier1(tester) {
	if (tester == 1){
		return {{$curr_pos1}}
	} else if (tester == 2){
		return {{$curr_pos2}}
	} else if (tester == 3){
		return {{$curr_pos3}}
	} else if (tester == 4){
		return {{$curr_pos4}}
	} else if (tester == 5){
		return {{$curr_pos5}}
	}
	
}


function reindex(){
	$('.connectedSortable').each(function(){
		$(this).find('li').each(function(index){
					 $(this).attr('data-index', index)
					 })
	})
}
	
function reindex_Post(){
	$('.connectedSortable').each(function(){
		$(this).find('li').each(function(index){
			$.post('AddNewTask', {
				project_id: $(this).data('id'),
				location_id: "",
				task_Description: "",
				type: "update_order",
				order: $(this).data('index') + 1
			})
		})
								
})
}

</script>






@stop


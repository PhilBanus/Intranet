@extends('intranet')

@section('content')





<?php
$StdPhoto = "data:image/png;base64,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";

$currentproject = $_GET['id'];

$Project = DB::table('UKHT_ICT_Projects')->select('UKHT_ICT_Projects.*','Contact.Forename','Contact.Surname','UKHT_ICT_Projects_Status.Name as StatusName','UKHT_ICT_Projects_Status.Color')
				->join('Contact','Contact.Contact_ID','=','UKHT_ICT_Projects.Owner_ID')
				->join('UKHT_ICT_Projects_Status','UKHT_ICT_Projects_Status.ID','=','UKHT_ICT_Projects.Status_ID')
				->where("UKHT_ICT_Projects.ID","=",$currentproject)
				->first();

$Collaborators = DB::table('UKHT_ICT_Projects_Contacts')
				->join('Contact','Contact.Contact_ID','=','UKHT_ICT_Projects_Contacts.Contact_ID')
				->join('UKHT_ICT_Projects_Contacts_Role', "UKHT_ICT_Projects_Contacts_Role.ID", "=", "UKHT_ICT_Projects_Contacts.Role_ID")
				->where([["UKHT_ICT_Projects_Contacts.Project_ID","=",$currentproject], ["UKHT_ICT_Projects_Contacts.Disabled","=",false]])
				->get();

$CollaboratorsCheck = DB::table('UKHT_ICT_Projects_Contacts')
				->join('Contact','Contact.Contact_ID','=','UKHT_ICT_Projects_Contacts.Contact_ID')
				->join('UKHT_ICT_Projects_Contacts_Role', "UKHT_ICT_Projects_Contacts_Role.ID", "=", "UKHT_ICT_Projects_Contacts.Role_ID")
				->where("UKHT_ICT_Projects_Contacts.Project_ID","=",$currentproject)
				->where("UKHT_ICT_Projects_Contacts.disabled", false)
				->pluck('Contact.Contact_ID');

$statuss = DB::table('UKHT_ICT_Projects_Status')
		 ->get();

$DPhoto = "data:image/png;base64,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";



$ITteams = DB::table("UKHT_ICT_Team")
		->get();


$isIT = false;

foreach ($ITteams as $ITteam) {
	if (session('MY_ID') == $ITteam->ID){
	$isIT = true;	
	}
};
?>



<div class="row">
<!-- Card -->
<div class="col-md-8 float left">
	<div class="card card-cascade mb-2">

  <!-- Card image -->
  <div class="view view-cascade gradient-card-header blue-gradient">

    <!-- Title -->
    <h2 class="card-header-title mb-3" id="Project_name_title">{{$Project->Name}}</h2>
    <!-- Subtitle -->
    <p class="card-header-subtitle mb-0" id="Project_owner_title">{{$Project->Forename}} {{$Project->Surname}} </p>

  </div>

  <!-- Card content -->
	
  <div class="card-body card-body-cascade  bg-dark">

    <!-- Text <-->
    	<div class="row">

	 
	  	<div class="col-sm-4 text-center text-warning">
			<div class="label small text-muted">Start - End</div>
			<div id="Project_dates_title">
			{{date("l jS \of F Y",strtotime($Project->Start_Date))}} - {{date("l jS \of F Y",strtotime($Project->End_Date))}}
			</div>
			
		</div>
	  <div class="col-sm-4 text-center text-warning">
		  <div class="label small text-muted">Last Updated</div>
		  <div id="project_lastUpdate_title">
			{{date("l jS \of F Y",strtotime($Project->Last_Update))}}
		  </div>
		</div>
	  <div class="col-sm-4 text-center text-warning">
		  <div class="label small text-muted">Status</div>
		  <div id="project_Status_title" >
		  {{$Project->Status_Description}}
		  </div>
		</div>
	  
		 </div>
	</div>
	


    <div class="card-body card-body-cascade  row">

    <!-- Text -->
	 	<div class="col-md-12 text-center">
			<h2> Description </h2>
		</div>
	  	
		<div class="col-md-12 text-center">
			<h4 id="project_description_title"> {{$Project->Description}} </h4>
		</div>
	  
		
</div>

</div>
	
	<!-- tasks html -->
	<div class="card card-cascade ">
		<div class="card-header blue-gradient text-white d-flex ">
			<span class="mr-auto"></span><h3 class="mx-auto text-center"><a href="ictProjectTasks?id=<?php echo $currentproject ?>" class="text-white">Tasks</a></h3> 
			<div class="btn btn-success btn-sm ml-auto" id="Task_View_Btn"><i class="fas fa-search" aria-hidden="true"></i></div>
			<div class="btn btn-secondary btn-sm ml-2" data-toggle="modal" data-target="#Task_modal"><i class="fas fa-plus" aria-hidden="true"></i></div>
			
			</div>
		<div class="fh-card card-body" id="Taskbar">
			
			<!-- tasks php -->
			<ul class="list-group list-group-flush" id="Task_List">
			<?php 
			$tasks = DB::table('UKHT_ICT_Projects_Tasks')
				->where('Project_ID', $currentproject)
				->where('isRemoved', 0)
				->leftJoin('Contact','Contact.Contact_ID','=','UKHT_ICT_Projects_Tasks.Contact')
				->get();
			
			foreach($tasks as $task){
				if ($task->isCompleted == 1){
					?>
				<li class='list-group-item'>
				<div  class='row'>
					<!-- checkbox -->
                <div class="form-check col-md-1">
					<input data-id="{{$task->ID}}" type="checkbox" class="form-check-input task_checkbox" checked id="materialUnchecked{{$task->ID}}">
					<label class="form-check-label" for="materialUnchecked{{$task->ID}}"></label>
				</div>
					
                <div class="text-left task_strikeout strike col-md-9"><strong>{{$task->Description}}</strong></div>
					
				<div class="text-right">
						<span type="button" data-toggle="modal" data-id="{{$task->Contact}}" data-task='{{$task->ID}}' data-target="#Tasks_editor" class="badge badge-primary task-badge">
							<?php
							if (!isset($task->Contact)) {
								echo "Anyone";
								
							}else {
							 echo $task->Forename . " " . $task->Surname;
							};
							?>
							</span>
					</div>
					
				</div>
            </li>     
			
			<?php
					
					
				}else{
					?>
				<li class='list-group-item'>
				<div  class='row'>
					<!-- checkbox -->
                <div class="form-check col-md-1">
					<input data-id="{{$task->ID}}" type="checkbox" class="form-check-input task_checkbox" id="materialUnchecked{{$task->ID}}">
					<label class="form-check-label" for="materialUnchecked{{$task->ID}}"></label>
				</div>
					
                <div class="text-left task_strikeout col-md-9"><strong>{{$task->Description}} </strong></div>
					
					<div class="text-right">
						<span type="button" data-toggle="modal" data-id="{{$task->Contact}}" data-target="#Tasks_editor" class="badge badge-primary task-badge">
							<?php
							if (!isset($task->Contact)) {
								echo "Anyone";
								
							}else {
							 echo $task->Forename . " " . $task->Surname;
							};
							?>
							</span>
					</div>
					
					
				</div>
					
					
					
            </li>     
			
			<?php	
				}
				
			}
			?>
				</ul>
		</div>
		</div>	
</div>
	
	

	<div class="col-md-4 h-100 float-right">
	
		<div class="card">
		<div class="card-header blue-gradient">Collaborators</div>
			
			<div class="card-body ">
			
				<ul id="colabList" class="list-group list-group-flush">
				
				
			
			<?php
			foreach($Collaborators as $Collaborator)
			{
				
				$Query =DB::table('Contact')->select(DB::raw("'/__files/rendition/' + CONVERT(nvarchar(10), (SELECT TOP 1  dc.Document_ID
                FROM Document_Categories dc
                INNER JOIN Document_Entities de ON de.Document_ID = dc.Document_ID
                INNER JOIN Document d ON d.Document_ID = dc.Document_ID
                WHERE dc.Category_ID = 444 AND de.Entity_Class_ID = 1 AND de.Entity_Identifier = $Collaborator->Contact_ID
                    AND LOWER(d.File_Type) IN ('png', 'jpg', 'jpeg', 'gif', 'bmp', 'tif', 'tiff') AND d.Superceded_By IS NULL
                ORDER BY dc.Document_ID DESC)) + '/-9/photo.jpg' as Photo"))->where("Contact_ID","=",$Collaborator->Contact_ID)->first();

if($Query->Photo){

$Photo = "https://themis.ukht.org$Query->Photo";

}else{
	
	$Photo = "data:image/png;base64,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";
}
				
				?>
				<li class='list-group-item'>
				<div  class='d-flex'>
					<div class="view  rounded-circle mr-2 z-depth-1" data-id="{{$Collaborator->Contact_ID}}">
					<img src="{{$Photo}}" width="80" alt="avatar" class="avatar">
					 <div width="80" style="display: none" class="mask flex-center rgba-red-strong text-center text-white"><i class="far fa-times-circle fa-2x"></i></div>
					</div>
                
					<div class="text-left">
                <div class="text-small ml-2">
                  <strong>{{$Collaborator->Forename}} {{$Collaborator->Surname}}</strong>
                  <p class="last-message text-muted"> {{$Collaborator->Job_Title}} </p>
                </div>
						</div>
                <div class="chat-footer ml-auto">
                  <p class="text-smaller text-muted mb-0 badge badge-primary"> {{$Collaborator->Name}} </p>                  
                </div>
              </div>
            </li>            
          
				<?php
			}
			
			
			?>
				</ul>
			
			</div>
			
		
		</div>
		
	
		
	</div>
</div>

<div class="row">
	<div class="col-md-8 float left">
		
	</div>
</div>


	

    <!-- Text -->
	 	<div class="modal fade left " id="exampleModalPreview" tabindex="-1" role="dialog" style="" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-full-height modal-left primary-color h-100" role="document"> 

    <div class="modal-content primary-color h-100" id="messagebox">
		
		
	
    </div>
  </div>
</div>
	  	
			
			<script>
				$(document).ready(function(){
    			   $("#messagebox").load("ictProjectMessages?id={{$_GET['id']}}");
					
				

    			});
				
				
				$('#exampleModalPreview').on('shown.bs.modal', function (e) {
 
					var data = $(this).find('#data');
						data.animate({ scrollTop: data.prop("scrollHeight")}, 0);
			 
				
					
})
				
				
			</script>
						
				


		
<!-- menu buttons  -->

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
  <a class="btn-floating btn-lg blue-gradient">
    <i class="fas fa-list"></i>
  </a>

  <ul class="list-unstyled">
  
    <?php if($isIT == true){ ?>
    <li data-toggle="modal" data-target="#exampleModalCenter"><a class="btn-floating dusty-grass-gradient"><i class="fas fa-user"></i></a></li>
    <li data-toggle="modal" data-target="#Editor_model" ><a class="btn-floating near-moon-gradient"><i class="fas fa-pen"></i></a></li>
	  
	 <?php } ?>
	  <?php if($isIT == false){ ?>
    <li><a class="btn-floating border-0 bg-transparent shadow-0" style="opacity: 0"></a></li>
    <li><a class="btn-floating border-0 bg-transparent shadow-0" style="opacity: 0"></a></li>
   
	  
	 <?php } ?>
	<li id="modalActivate"  data-toggle="modal" data-target="#exampleModalPreview"><a class="btn-floating sunny-morning-gradient"><i class="fas fa-envelope"></i></a></li>
    <li data-toggle="modal" data-target="#Historic_form" ><a class="btn-floating purple-gradient" ><i class="fas fa-book"></i></a></li>
  
  </ul>
</div>
		




<!-- add collaborators tab -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-dialog-centered" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Collaborators</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		
      <div class="modal-body" style="height: ">
        
		  <!-- Material input -->
<select class="mdb-select md-form" id="collab" searchable="Search here..">
  <option value="" disabled selected>Select User</option>
  	  
		  <?php
		  	
		$Users = DB::table("User")
			->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
			->whereNotIn('Contact.Contact_ID', $CollaboratorsCheck)
			->get();

foreach($Users as $User){
	
	?>
	
	<option value="{{$User->Contact_ID}}" data-jobtitle="{{$User->Job_Title}}">{{$User->Forename}} {{$User->Surname}}</option>
	
	<?php
}
		  ?>
	
	
</select>
		  
	<select class="mdb-select md-form" id="collabTitle" searchable="Search here..">
		<option value="" disabled selected>Select Role</option>
		<?php
			$roles = DB::table("UKHT_ICT_Projects_Contacts_Role")
			->get();
		foreach($roles as $role){
			?>
				<option value="{{$role->ID}}"> {{$role->Name}}</option>
		<?php
		}
		?>
		  
		  
		  
	</select>	  
		  
		  
		  
		  
		  <!-- php for collaborators 
	
		  -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="submit_stuff" type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
      </div>
		
    </div>
  </div>
</div>



<div class="modal fade" id="Editor_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 500px; overflow-y: scroll">
		  
		  <div class="row d-flex justify-content-around ">
        <div class="md-form col-md-5">
  			<input type="text" id="Project_Name" value="<?php echo $Project->Name ?>" class="form-control">
  			<label for="form1"> Title </label>
		</div>
			  
		<div class="md-form col-md-5">
			<input type="text" id="Project_Owner" value="<?php echo $Project->Forename ?> <?php echo $Project->Surname ?>" class="form-control">
  			<label for="form1"> Creator </label>
		</div>
			  
		  </div>
		  
		<div class="row d-flex justify-content-around ">
			<div class="md-form col-md-5">
			<input placeholder="" type="text" id="Project_Start_Date" value="<?php echo date('Y-m-d', strtotime($Project->Start_Date) ) ?>" class="form-control datepicker">
			<label for="date-picker-example2" class="">Start date</label>
			</div>
			<div class="md-form col-md-5">
			<input placeholder="" type="text" id="Project_End_Date" value="<?php echo date('Y-m-d', strtotime($Project->End_Date) ) ?>" class="form-control datepicker">
			<label for="date-picker-example2" class="">End date</label>
			</div>	
		</div>
		 
		  <div class="row d-flex justify-content-around ">
			  <div class="md-form col-md-5">
			  	<input type="text" id="Project_StatusDescription" value="<?php echo $Project->Status_Description ?>" class="form-control">
  				<label for="form1"> Status Description </label>
			  </div>
			  
			  <select id="Project_Status" class="mdb-select md-form col-md-5">
				  <option value="{{$Project->Status_ID}}" selected>{{$statuss[$Project->Status_ID - 1]->Name}}</option>
				  <!-- insert php here  -->
				  <?php 
				  	
					foreach($statuss as $status) {
						if($status->ID === $Project->Status_ID){}else{
						?>
				  
				  	<option value="{{$status->ID}}">{{$status->Name}}</option>
				  
				  
				  <?php
						}
					}
	
				  ?>
				  
				  
				</select>
		  </div>
		  
		  <div class="row d-flex justify-content-around ">
		  	<div class="md-form col-md-10">
			  <textarea id="ProjectDescription" class="form-control md-textarea" rows="3">{{$Project->Description}}</textarea>
			  <label for="textarea-char-counter">Description</label>
			</div>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="submit_changes" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Historic   -->

<div class="modal fade " id="Historic_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg " role="document">

    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Previous Versions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body " style="height: 500px">
        <!-- PHP searching for historic data  -->
		  <?php 
		  $historics = DB::table("UKHT_ICT_Projects_Historic")
			  		 ->where('Project_ID', '=' ,$currentproject)
			  		 ->get();
		  
		  $historics_check = DB::table("UKHT_ICT_Projects_Historic")
			  		 ->where('Project_ID', '=' ,$currentproject)
			  		 ->exists();
		  
		  
		  if($historics_check == true){
			  $array_count = 0;
			  ?>
		  			<select class="mdb-select gradient-blue md-form" id="Historic_select">
		  		
		  	<?php
			  foreach ($historics as $historic) {
				 
				  ?>
		  			<option value="{{$historic->ID}}">{{$historic->Modify}}</option>
		  
		  	<?php
				  $array_count += 1;
			  }
			  
			  ?>
		 		 </select>
		  
		  	<?php
			  
		  } else {
			  ?>
		  <h3 class="text-center"> No records exist</h3>
		  <h3 class="text-center"> O_o </h3>
		  
		  
		  
		  <?php
		  }
		  ?>
		  
		  
		  <!-- PHP to show historic data if exists -->
		  
		  <?php
		   if($historics_check == true){
			   ?>
		  <div class="morpheus-den-gradient card card-cascade" style="height: 360px; overflow-y: auto; overflow-x:hidden">
		  			<div id="histLoader" > </div>
		  </div>
		  
		    <script>
		  			$(document).ready(function(){
						$('#Historic_select').change(function(){
							var id = $('#Historic_select').val();
							console.log(id)
							$.post("Historic_View",{id: id }).always(function(result) {
								$('#histLoader').html(result);
								$(this).parent(".list-group-item").remove();
						})
					});
					});
					
				
		  		</script>
		  		
		  	<?php 
			   
		   }
		  ?>
		  
		  
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- add task button -->
<div class="modal fade" id="Task_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">

  
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">


    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		  
		<div class="row d-flex justify-content-around">
			
		  <div class="md-form col-md-10">
			  <textarea id="task_Description" class="form-control md-textarea" length="120" rows="3"></textarea>
  			<label for="textarea-char-counter">Description</label>
			</div>
		  
		 </div>  
		  
        <div class="row d-flex justify-content-around">
			
		  	<div class="md-form col-md-5">
			  <input placeholder="" type="text" id="date-picker-Startdate" class="form-control datepicker">
  			  <label for="date-picker-example">Start Date</label>
			</div>
			
			<div class="md-form col-md-5">
			  <input placeholder="" type="text" id="date-picker-Enddate" class="form-control datepicker">
  			  <label for="date-picker-example">End Date</label>
			</div>
			
		  </div>
		  
		  <div class="row d-flex justify-content-around">
		  	<div class="md-form col-md-5">
				<!-- add selector -->
				<select class="mdb-select md-form" id="task_collaborator">
					<option value="" disabled selected>Optional Collaborator</option>
				  <?php
		  	
							$Users = DB::table("User")
								->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
								->whereIn('Contact.Contact_ID', $CollaboratorsCheck)
								->get();

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
      <div class="modal-footer">
        <button type="button" id="submit_task" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- modal for editing tasks -->

<div class="modal fade" id="Tasks_editor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editing Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="md-form">
		  <textarea id="textarea-task-description" class="form-control md-textarea" length="120" rows="3">i</textarea>
		  <label for="textarea-task-description">Description</label>
		</div>
		  <select class="mdb-select md-form" id="task-editor-option">
			<option value="" id="0" >anyone</option>
			  
		  	<?php
			  $Task_Users = DB::table("User")
								->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
								->whereIn('Contact.Contact_ID', $CollaboratorsCheck)
								->get();
			  
			  foreach($Task_Users as $Task_User) {
				  
				  ?>
			  <option value="{{$Task_User->Contact_ID}}">{{$Task_User->Forename}} {{$Task_User->Surname}}</option>
			  <?php
			  }
			  
			  
			  
			  
			  ?>
		  </select>
      </div>
      <div class="modal-footer">
        <button type="button" id="taskDeleteBtn" class="btn btn-danger" data-dismiss="modal">Delete</button>
        <button type="button" class="btn btn-success" id="taskSubmitBtn" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- All actions i.e. button presses  -->

<script>
$(document).ready(function(){
	var tasks_flipswitch = true;
	
	$('#taskSubmitBtn').on('click', function(){
		$.post('AddTask', {
					project_id: $('#textarea-task-description').data('task'),
					contact_id:  $('#task-editor-option').val(),
					start_date: "",
					end_date: "",
					description: $('#textarea-task-description').val() ,
					type: "edit"
				});
		location.reload()
	});
	
	$('#taskDeleteBtn').on('click', function(){
		if(confirm("Are you sure?"))
			{
				//'Remove' task
				$.post('AddTask', {
					project_id: $('#textarea-task-description').data('task'),
					contact_id: "",
					start_date: "",
					end_date: "",
					description: "",
					type: "Remove"
				});
				location.reload()
			}
	});
	
	
	$(".task-badge").on('click', function(){
		console.log($(this).data('id'))
		$('#textarea-task-description').val($(this).parent().siblings('.task_strikeout').text());
		$('#textarea-task-description').data('task', $(this).data('task'))
		$('#task-editor-option').materialSelect('destroy');
		$('#task-editor-option').val($(this).data('id'));
		$('#task-editor-option').materialSelect();
	});
	
	
	$("#Task_View_Btn").on('click', function(){
		if (tasks_flipswitch == true){
			$(this).removeClass("btn-success");
			$(this).addClass("btn-danger");
			tasks_flipswitch = false;
			$('input:checked').each(function(){
				$(this).parents('.list-group-item').hide()
			})
			//add line to remove completed tasks
		} else {
			$(this).removeClass("btn-danger");
			$(this).addClass("btn-success");
			tasks_flipswitch = true;
			$('input:checked').each(function(){
				$(this).parents('.list-group-item').show()
			})
		}
		
		
	});
	
	
	$("#submit_task").on('click', function(){
		if ($("#date-picker-Startdate").val() == ""){
			alert("please add a start date")
			} else if($("#date-picker-Enddate").val() == "") {
				alert("please add an end date")			 
			} else if ($("#task_Description").val() == "") {
				alert("please add a task description")
			}else {
				$.post("AddTask" ,{
				project_id: "<?php echo $_GET['id'] ?>",
				contact_id: $("#task_collaborator").val(),
				start_date: $("#date-picker-Startdate").val(),
				end_date: $("#date-picker-Enddate").val(),
				description: $("#task_Description").val(),
				type: "dw"
				})
				
				location.reload()
			}
		
		
		
	});
	
	
	$(".task_checkbox").on("click", function(){
						   if ($(this).is(':checked')){
							  $(this).parent().parent().children('.task_strikeout').addClass("strike");
							  	$.post("AddTask" , {
									project_id: $(this).data("id"),
									contact_id: "",
									start_date: "",
									end_date: "",
									description: "",
									type: "checked"
								})	
						   }else{
							   $(this).parent().parent().children('.task_strikeout').removeClass("strike");
							   $.post("AddTask" , {
								   project_id: $(this).data("id"),
									contact_id: "",
									start_date: "",
									end_date: "",
									description: "",
									type: "unchecked"
								})
						   }
						   
						   });
	
	
	
	$(".view").on('click',function(){
		var Contact_ID = $(this).data('id');
		$.post("AddContact", {
			contact_id: Contact_ID ,
				project_id:"<?php echo $_GET['id'] ?>",
				Role_ID:"ignore",		
				Type: "Delete"
		}).done(function(result){
			
		
		})
		
		$(this).parents('li').remove()
		
	});
	
	
	
	
	$('.view').hover(function(){
		$(this).children('.mask').stop().fadeIn();
	}, function(){
		$(this).children('.mask').stop().fadeOut();
	})
		
	
		$('#collab').on("change select", function(){
			console.log($(this).val())
			console.log($(this).find("option:selected").text())
			console.log($(this).find("option:selected").data('jobtitle'))
		})
	
	$('#collabTitle').on("change select", function(){
			console.log($(this).val())
			console.log($(this).find("option:selected").text())
		})
	$("#submit_stuff").click(function(){
			$.post("AddContact", {
				'_token': $('meta[name=csrf-token]').attr('content'),
				contact_id: $("#collab").val(),
				project_id:"<?php echo $_GET['id'] ?>",
				Role_ID:$("#collabTitle").val(),		
				Type: "Add"
			})
						var newcontact ="<li class='list-group-item'><div  class='d-flex'>" + '<img src="{{$StdPhoto}}" width="80" alt="avatar" class="avatar rounded-circle mr-2 z-depth-1"><div class="text-small"><strong>' + $("#collab").find("option:selected").text() + '</strong><p class="last-message text-muted">' + $("#collab").find("option:selected").data('jobtitle') + '</p></div><div class="chat-footer"><p class="text-smaller text-muted mb-0 badge badge-primary ml-auto"> {{$Collaborator->Name ?? ''}} </p></div></div>'
				
				
				$("#colabList").append(newcontact);
		location.reload();
		
		})
	
	
	
	$('#submit_changes').click(function(){
			//add php stuff to add to historic database
			
			
			
			
			$.post("EditDetails", {
				'_token': $('meta[name=csrf-token]').attr('content'),				   
				projectname: $("#Project_Name").val(),
				projectID: "<?php echo $currentproject?>",
				projectowner: $("#Project_Owner").val(),
				projectstartdate: $("#Project_Start_Date").val(),
				projectenddate: $("#Project_End_Date").val(),
				projectstatusdescription: $("#Project_StatusDescription").val(),
				projectstatusid: $("#Project_Status").val(),
				projectDescription: $("#ProjectDescription").val(),
				User: "<?php echo session('MY_ID') ?>"
			})	
				
				location.reload()
		})
});
	
		
	
//6ny1443
//07130520130616
</script>


@stop



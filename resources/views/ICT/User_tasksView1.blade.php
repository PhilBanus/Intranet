<?php
$project_ID = $_GET['id'];

$tasks = db::table('UKHT_ICT_Projects_Tasks_New')
		->where('Project_ID', $project_ID)
		->where('Location', 3)
		->orderBy('Task_Order','asc')
		->get();



?>


<ul class="list-group">
	<?php
	
	if ($tasks == "[]"){
		?>
	
	<li class="list-group-item" style="font-size: 15px">No Current Ongoing Tasks</li>
	<?php
	}else{
		foreach($tasks as $task) {
		?>
	
	<li class="list-group-item" style="font-size: 15px">{{$task->Description}}</li>
	<?php
		}
	}
	?>


</ul>
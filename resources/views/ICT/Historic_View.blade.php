	<?php		
		$id = $_POST['id'];

		$historics = DB::table("UKHT_ICT_Projects_Historic")
			->join('Contact','Contact.Contact_ID',"=", "UKHT_ICT_Projects_Historic.Update_Contact")
			  		 ->where('ID', '=' ,$id) 
			  		 ->first();	

		
	?>

	<div class="row d-flex justify-content-around card-body">
		<h4 class="col-md-5 text-white"><strong class="text-warning">Title:</strong> {{$historics->Name}}</h4>
		<h4 class="col-md-5 text-white"><strong class="text-warning">Last Updater:</strong> {{$historics->Forename}} {{$historics->Surname}}</h4>
	</div>
	<div class="row d-flex justify-content-around card-body">
		<h4 class="col-md-5 text-white"><strong class="text-warning">Start Date:</strong> {{date("Y-m-d" ,strtotime($historics->Start_Date))}}</h4>
		<h4 class="col-md-5 text-white"><strong class="text-warning">End Date:</strong> {{date("Y-m-d" ,strtotime($historics->End_Date))}}</h4>
	</div>
	<div class="row d-flex justify-content-around card-body">
		<h4 class="col-md-8 text-white"><strong class="text-warning">Status description:</strong> {{$historics->Status_Description}}</h4>
	</div>
	<div class="row d-flex justify-content-around card-body">
		<h4 class="col-md-11 text-white"><strong class="text-warning">Description:</strong></h4>
		<h5 class="col-md-11 text-white">{{$historics->Description}}</h5>
	</div>
	

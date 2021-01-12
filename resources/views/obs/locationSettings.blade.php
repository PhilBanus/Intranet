
<div class="row"><div class="col-md-6">
	
	<div class="card">
	<div class="card-header d-flex align-items-center text-white primary-color">Locations <div class="btn btn-sm btn-primary ml-auto" id="addLocation"><i class="fas fa-plus"></i></div></div>
		<div class="card-body p-0">
		<div class="list-group list-group-flush">
		<?php 

$ID = $_GET['id']; 

			DB::table('UKHT_Occurance_Location')->updateOrInsert([
				'Site' => $ID, 'Removed' => 0, 'Name' => 'Site Wide'
			]);
			
 $Locations = DB::table('UKHT_Occurance_Location')->where(['Site' => $ID, 'Removed' => 0 ])->get();
							
							foreach($Locations as $location){
								?>
							<div class="list-group-item list-group-item-action d-flex"><?php echo $location->Name ?> 
								<i class="fad fa-trash text-danger ml-auto waves-effect" onClick="removeLocation({{$ID}},'{{$location->Name}}')"></i>
			</div>
							
							<?php
							}
							
					
?>
	
		</div></div></div>
	
	
	
	
	</div>
	
<div class="col-md-6">
	
	<div class="card">
	<div class="card-header d-flex align-items-center text-white primary-color">HSQE Team </div>
		<div class="card-body p-0">
			
			<select class="mdb-select md-form m-1" id="collab" searchable="Search here..">
  <option value="" disabled selected>Select User</option>
  	  
		  <?php
		  	$TeamCheck = DB::table('UKHT_Occurance_Teams')->where(['Site' => $ID, 'Removed' => 0 ])->pluck('Member_ID');
		$Users = DB::table("User")
			->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
			->whereNotIn('Contact.Contact_ID', $TeamCheck)
			->orderby('Forename','asc')
			->orderby('Surname' ,'asc')
			->get();

foreach($Users as $User){
	
	?>
	
	<option value="<?php echo $User->Contact_ID?>" data-jobtitle="<?php echo $User->Job_Title?>"><?php echo $User->Forename." ".$User->Surname ?></option>
	
	<?php
}
		  ?>
	
	
</select>
			
			
		<div class="list-group list-group-flush">
		<?php 

$ID = $_GET['id']; 

			
 $Team = DB::table('UKHT_Occurance_Teams')->where(['Site' => $ID, 'Removed' => 0 ])->join("Contact","Contact_ID","Member_ID")->get();
							
							foreach($Team as $Member){
								?>
							<div class="list-group-item list-group-item-action d-flex" data-id="<?php echo $Member->ID ?>"><?php echo $Member->Forename." ".$Member->Surname ?>
			<i class="fad fa-trash text-danger ml-auto waves-effect" onClick="removeUser({{$Member->Contact_ID}},{{$Member->Site}})"></i>
			</div>
							
							<?php
							}
							
					
?>
	
		</div></div></div>
	
	
	
	
	</div>
	
	</div>

<script>

$('.mdb-select').materialSelect();
	
	$('#collab').on('change', function(){
		var Member = $(this).val();
		var id = {{$ID}}; 
		
		$.post('OccuranceMember',{id:id,Member:Member,Type:"Member",Removed:0}).done(function(){
			$('#Settings').load('locationSettings?id='+id)
		})
	})
	
	function removeUser(Member,id){
			console.log(Member + id)
		$.post('OccuranceMember',{id:id,Member:Member,Type:"Member",Removed:1}).done(function(){
			$('#Settings').load('locationSettings?id='+id)
		})
	}
	
	
	$('#addLocation').on('click', function(){
		bootbox.prompt({
    title: "Enter Location Name", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			var id = {{$ID}}; 
		
				$.post('OccuranceLocations',{id:id,Location:result,Type:"Location",Removed:0}).done(function(){
			$('#Settings').load('locationSettings?id='+id)
		})
		}
    }
});
	})
	
	function removeLocation(id,Location){
		$.post('OccuranceLocations',{id:id,Location:Location,Type:"Location",Removed:1}).done(function(){
			$('#Settings').load('locationSettings?id='+id)
		})
		
	}
	
	
	
</script>
@extends("Intranet")
@section('content')



<div class="col-12">

<div class="card border-0 bg-transparent">
	<div class="card-body">
	<div class="md-form">
  <input type="text" id="form1" class="form-control">
  <label for="form1">Create Group</label>
		
		<button type="submit" id="CreateGroup" disabled class="btn btn-primary btn-md">Create</button>
</div>
	</div>
	</div></div>


<div class="col-12">
<div class="card">
	
	
	<div class="card-header primary-color text-white">Groups</div>
	
	<!--Accordion wrapper-->
<div class="accordion md-accordion" id="Groups" role="tablist" aria-multiselectable="true">
<?php 
	
	$Groups = DB::table('UKHT_Alert_Groups')->get();
	foreach($Groups as $Group){
		
		?>
  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="GroupHeader{{$Group->ID}}">
      <a class="collapsed" data-toggle="collapse" data-parent="#Groups" href="#Group{{$Group->ID}}"
        aria-expanded="false" aria-controls="Group{{$Group->ID}}">
        <h5 class="mb-0">
          {{$Group->Name}} <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="Group{{$Group->ID}}" class="collapse" role="tabpanel" aria-labelledby="GroupHeader{{$Group->ID}}"
      data-parent="#Groups">
      <div class="card-body ">
		  
	
		  
       
		  <ul class="list-group list-group-flush ">
		  
			  <li class="list-group-item">	  <select class="mdb-select md-form p-0 m-0" onChange="addUser($(this),{{$Group->ID}})" searchable="Search here..">
  <option class="selectdis" value="" disabled selected>Add User</option>
  <?php
		
			$Users = DB::table("User")
					->join("Contact","Contact.Contact_ID","=","User.Contact_ID")
					->get();
		
			  foreach($Users as $User){

						?>
			  <option value="{{$User->Contact_ID}}">{{$User->Forename}} {{$User->Surname}}</option>
			  <?php
							}
						?>
			  
</select></li>
		  
		  <?php 
	
	$Contacts = DB::table('UKHT_Alert_Group_Contacts')->join('Contact','Contact.Contact_ID','UKHT_Alert_Group_Contacts.Contact_ID')->where('Group_ID',$Group->ID)->orderby('Forename','asc')->orderby('Surname','asc')->get();
	foreach($Contacts as $Contact){
		
		?>
			  <li class="list-group-item list-group-item-action list-group-item-info"><button class="btn-floating btn-sm waves-effect btn-danger border-0" onClick="DeleteUser({{$Contact->Contact_ID}},{{$Group->ID}},$(this).parent())"><i class="fas fa-user-minus"></i></button>{{$Contact->Forename}} {{$Contact->Surname}} <kbd>{{DB::table('Contact_Email')->where('Contact_ID',$Contact->Contact_ID)->first()->Email ?? ''}}</kbd> </li>
			  
			  
			  
			  <?php } ?>
		  
		  
		  
		  </ul>
		  
      </div>
    </div>

  </div>
  <!-- Accordion card -->
  <?php 
  }
	
	?>


</div>
<!-- Accordion wrapper -->
	
	
	</div></div>
<script>

function DeleteUser(id,user,itme){
	$.post('alertGroupDeleteUser',{ID: user, USER: id, TYPE: 'REMOVE'}).done(function(result){
						console.log(result);
			
			
						//location.reload();
					});;
	itme.remove()
}

	
	function addUser(id, group){
	
		var name = id.find('option:selected').text();
		id.find("option:selected").removeAttr("selected");
		id.find(".selectdis").attr("selected");
		
		
		id.parents('ul').append('<li class="list-group-item list-group-item-action list-group-item-info"><button class="btn-floating btn-sm waves-effect btn-danger border-0" onClick="DeleteUser('+id.val()+','+group+',$(this).parent())"><i class="fas fa-user-minus"></i></button>'+name+'</li>')
		
		
		var aid = id.val(); 
		
	
		$.post('alertGroupDeleteUser',{ID: group, USER: aid, TYPE: 'ADD'}).done(function(result){
						console.log(result);
			
			
						//location.reload();
					});;
	
		
	}
	
	$('#form1').on('keyup',function(){
		
		if($(this).val()){
			$('#CreateGroup').prop("disabled", false)
		}else{
			$('#CreateGroup').prop("disabled", true)
		}
		
		
	})
	

	$('#CreateGroup').on('click',function(){
		var val = $('#form1').val()
		$.post('alertGroupDeleteUser',{ID: '', USER: val, TYPE: 'CREATE'}).done(function(result){
						console.log(result);
			
			
						location.reload();
					});;
	
		
	})


</script>

@stop
@extends('intranet')

@section('content')
<div class="col-12">

<div class="card border-0 bg-transparent">
	<div class="card-body">
	<div class="md-form">
  <input type="text" id="form1" class="form-control">
  <label for="form1">Search Users</label>
		
</div>
	</div>
	</div></div>
<!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">


<?php 

$Roles = DB::table('Role_Membership')
		->join('User','User.Contact_ID','Role_Membership.Contact_ID')
		->join('Contact as c','c.Contact_ID','Role_Membership.Contact_ID')
		->where('Role_Membership.User_Role_ID',199)
		->where('c.Organisation_ID','<',0)
		->where('c.Organisation_ID','!=',-2)
		->where('c.Contact_ID','<>',1)
		->where('c.Contact_ID','<>',11831)
		->whereNULL('c.Superceded_By_Date')
		->whereNotNULL('c.User_Password')
		->select(DB::raw("*, (Select Forename+' '+Surname from Contact where Contact_ID = (Select top 1 Contact_ID from Entity_Contacts where Entity_Identifier = c.Contact_ID and Contact_Role_ID = 4)) as Linemanager "))
		->orderby('Forename','asc')
		->orderby('Surname','asc')
		->get();

foreach($Roles as $Role){
	
	?>



  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="headingTwo1">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapse{{$Role->Contact_ID}}"
        aria-expanded="false" aria-controls="collapse{{$Role->Contact_ID}}">
        <h5 class="mb-0">
          {{$Role->Forename}} {{$Role->Surname}}<i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="collapse{{$Role->Contact_ID}}" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
      data-parent="#accordionEx1">
      <div class="card-body">
		  
		  
        <ul class="list-group" id="list">
		  <?php
	
	$Access = DB::table('UKHT_Roles')
		->select('UKHT_Roles.Name as Name','UKHT_Roles.ID', DB::raw("(Select 'checked' from UKHT_User_Role where UKHT_User_Role.Role_ID = UKHT_Roles.ID and UKHT_User_Role.User_ID = $Role->Contact_ID ) as Active"))
		
		->get(); 

	foreach($Access as $Nav){
		?>
			
			<div class="form-check">
    <input type="checkbox" data-id="{{$Nav->ID}}" data-role="{{$Role->Contact_ID}}" class="form-check-input access-modify" {{$Nav->Active}} id="nav{{$Role->Contact_ID}}{{$Nav->ID}}">
    <label class="form-check-label"  for="nav{{$Role->Contact_ID}}{{$Nav->ID}}">{{$Nav->Name}}</label>
</div>
			
	
		  <?php
	}
	
	
	
	
	?>
		</ul>  
		  
		  
      </div>
    </div>

  </div>
  <!-- Accordion card -->


<?php } ?>
</div>


<script>
	
	
	$('#form1').on('keyup',function(){
		
		var val = $(this).val();
		consol.log(val)
		$('#list').children('li').each(function(){
			if($(this).is(':contains('+val+')')){
				$(this).show() }else{ $(this).hide(); }
			
		})
		
		
	})
	
	$('.access-modify').on('click', function(){
		var type = $(this).prop('checked');
		var id = $(this).data('id');
		var role = $(this).data('role');
		
		$.post("userRoleAccess",{'_token': $('meta[name=csrf-token]').attr('content'), ID: role, Nav: id, Type: type })
		
	})


</script>

@stop



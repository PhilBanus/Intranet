@extends('intranet')

@section('content')

<!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">


<?php 

$Roles = DB::table('UKHT_Roles')->get();

foreach($Roles as $Role){
	
	?>



  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="headingTwo1">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#collapse{{$Role->ID}}"
        aria-expanded="false" aria-controls="collapse{{$Role->ID}}">
        <h5 class="mb-0">
          {{$Role->Name}}<i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="collapse{{$Role->ID}}" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
      data-parent="#accordionEx1">
      <div class="card-body">
		  
		  
        <ul class="list-group">
		  <?php
	
	$Access = DB::table('UKHT_Nav')
		
		->join('UKHT_Nav_Headers','UKHT_Nav.Header','=','UKHT_Nav_Headers.ID')
		->select('UKHT_Nav.Name as Name','UKHT_Nav_Headers.Name as Header','UKHT_Nav.ID', DB::raw("(Select 'checked' from UKHT_Nav_Access where UKHT_Nav.ID = UKHT_Nav_Access.Nav_ID and UKHT_Nav_Access.Role_ID = $Role->ID ) as Active"))
		->orderby('UKHT_Nav_Headers.Name', 'asc')
		->get(); 

	foreach($Access as $Nav){
		?>
			
			<div class="form-check">
    <input type="checkbox" data-id="{{$Nav->ID}}" data-role="{{$Role->ID}}" class="form-check-input access-modify" <?php echo $Nav->Active ?> id="nav_{{$Role->ID}}_{{$Nav->ID}}">
    <label class="form-check-label"  for="nav_{{$Role->ID}}_{{$Nav->ID}}">{{$Nav->Header}} - {{$Nav->Name}}</label>
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
	
	$('.access-modify').on('click', function(){
		var type = $(this).prop('checked');
		var id = $(this).data('id');
		var role = $(this).data('role');
		
		$.post("navRoleAccess",{'_token': $('meta[name=csrf-token]').attr('content'), ID: role, Nav: id, Type: type })
		
	})


</script>

@stop



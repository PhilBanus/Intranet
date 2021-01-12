




<div class="card card-cascade narrower primary-color darker-5">

 <div class="view view-cascade  gradient-card-header blue-gradient">
	 <h4 class="card-header-title"> Please Select a Project Below </h4>
  </div>

  <div class="card-body card-body-cascade">
	  
	  
	  <!--Accordion wrapper-->
<div class="accordion md-accordion accordion-1" id="accordionEx1" role="tablist" aria-multiselectable="true">

  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="Project1">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#ProjectCollapse1"
        aria-expanded="false" aria-controls="ProjectCollapse1">
        <h5 class="mb-0">
			<span class="badge badge-primary badge-pill">
	<?php 
	echo DB::table('UKHT_Monitors')->where('Location','=',1)->count();
	?>
	</span>
			
         Head Office <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="ProjectCollapse1" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
      data-parent="#accordionEx1">
      <div class="card-body rgba-teal-strong white-text">
		  <a href="Monitorinput?id=1" class="btn btn-sm primary-color text-light">
Add or Edit Monitors

</a>
		
		  <ul class="list-group">
		  
			  <?php 
			  
			  $Monitors = DB::table('UKHT_Monitors')->where('Location',1)->get();
			  
			  foreach($Monitors as $Monitor){
				  
				  echo "<li class='list-group-item list-group-item-action list-group-item-secondary' data-id='$Monitor->Serial_Number' data-make='$Monitor->Make' data-model='$Monitor->Model'> <span>$Monitor->Make: $Monitor->Serial_Number</span> </li>";
				  
			  }
		  
			  
			  ?>
		  
		  
		  </ul>
		  
		
      </div>
    </div>

  </div>
	
	<?php 

$Locations = DB::table('UKHT_Locations')
	->join("Project","Project.Project_ID","=","UKHT_Locations.Linked_Entity")
	->where("UKHT_Locations.Type","=","Project")
	->where("UKHT_Locations.Removed",0)
	->orderby("Project.Name")
	->get();


foreach($Locations as $Location){
	?>
  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="Project1">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx1" href="#ProjectCollapse{{$Location->ID}}"
        aria-expanded="false" aria-controls="ProjectCollapse{{$Location->ID}}">
        <h5 class="mb-0">
			<span class="badge badge-primary badge-pill">
	<?php 
	echo DB::table('UKHT_Monitors')->where('Location','=',$Location->ID)->count();
	?>
	</span>
			
         {{$Location->Name}} <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="ProjectCollapse{{$Location->ID}}" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
      data-parent="#accordionEx1">
      <div class="card-body">
		  <a href="Monitorinput?id={{$Location->ID}}"  class="btn btn-sm primary-color text-light">
Add or Edit Monitors

</a>
		  
		  		  <ul class="list-group">
		  
			  <?php 
			  
			  $Monitors = DB::table('UKHT_Monitors')->where('Location',$Location->ID)->get();
			  
			  foreach($Monitors as $Monitor){
				  
				  echo "<li class='list-group-item list-group-item-action list-group-item-secondary' data-id='$Monitor->Serial_Number' data-make='$Monitor->Make' data-model='$Monitor->Model'> <span>$Monitor->Make: $Monitor->Serial_Number</span> </li>";
				  
			  }
		  
			  
			  ?>
		  
		  
		  </ul>

		
      </div>
    </div>

  </div>
	
<?php } ?>	
	
  <!-- Accordion card -->



</div>
<!-- Accordion wrapper -->
	  
	  
	  
	</div>
</div>

<div class="card border-0 primary-color p-2 mb-3">
<!--Grid row-->
<div class="card-header text-center bg-transparent mb-2 text-white">Live Projects</div>

  <!--Grid column-->
<div class="list-group-flush fix-at-5" style="overflow-y: auto">
<?php 
	
	$Projects = DB::table("UKHT_Locations")->join("Project","Project.Project_ID","=","UKHT_Locations.Linked_Entity")->where("Type","=","Project")->where("Removed","=","0")->get();
	
	foreach($Projects as $Project)
	{
	
	
	?>
    <!-- Card -->
<div class="list-group-item list-group-item-action border-0 fixed-at-5-item">

        <a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=3&code={{$Project->Linked_Entity}}&Latest=true" target="_blank">

          <!-- Content -->
   <p class="mb-0"><div class="rounded float-left mr-4"  style="overflow: hidden !important; width: 50px; height: 50px;"><img src="https://themis.ukht.org/__files/rendition/{{$Project->Photo_ID}}/-5" class="h-100"> </div> <span>{{$Project->Name}}</span></p>
            
    

        </a>



    </div>   
	
	
	<?php 
	
	}
	
	
	
	
	?>

	</div>
    </div>
	
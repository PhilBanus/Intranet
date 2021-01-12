@extends('intranet')

@section('content')

<?php use Carbon\Carbon ?>


<div class="row h-100" style="overflow: hidden">

<div class="col-md-10 h-100" >
	
	<div class="card h-100">
	
	<div class="card-header primary-color text-white ">Timeline</div>
	
		<div class="card-body h-100 fh-card"  id="Timeline"  style="overflow: auto">
		
			
			<?php
			
			$Dates = DB::table('UKHT_Audit_Timeline')->select('Rough_Date','Date')->distinct('Rough_Date')->orderby(DB::raw('Date'))->get();
			
			foreach($Dates as $Date){
			?>
			
			<div class="card-header bg-light date-header" id="{{str_replace(' ','',$Date->Rough_Date)}}">{{$Date->Rough_Date}}</div>
		

			<!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx{{str_replace(' ','',$Date->Rough_Date)}}" role="tablist" aria-multiselectable="true">



<!-- Accordion wrapper -->
		
			<?php
			
				$Timelines = DB::table('UKHT_Audit_Timeline')
					->where('Rough_Date',$Date->Rough_Date)
					
					->pluck('Location');
				
				
				
				$Locations = DB::table('UKHT_Locations')
					->whereIn('UKHT_Locations.ID',$Timelines)
					->where('UKHT_Locations.Removed',0)
					->distinct()
					->orderby('UKHT_Locations.ID','asc')
					->get();
				
				foreach($Locations as $Location){
			
			
			?>
			
	
		<div class="card Location-{{$Location->ID}} location-cards">

    <!-- Card header -->
    <div class="card-header" role="tab" id="headingTwo1">
      <a class="collapsed" data-toggle="collapse" data-parent="#{{str_replace(' ','',$Date->Rough_Date)}}" href="#Location{{$Location->ID}}{{str_replace(' ','',$Date->Rough_Date)}}"
        aria-expanded="false" aria-controls="collapseTwo1">
        <h6 class="mb-0">
           {{$Location->Name}} <i class="fas fa-angle-down rotate-icon"></i>
        </h6>
      </a>
    </div>

    <!-- Card body -->
    <div id="Location{{$Location->ID}}{{str_replace(' ','',$Date->Rough_Date)}}" class="collapse" role="tabpanel" aria-labelledby="headingTwo1"
      data-parent="#{{str_replace(' ','',$Date->Rough_Date)}}">
      <div class="card-body">
        
		<table class="table table-striped table-responsive-md btn-table">

  <thead>
    <tr>
      <th></th>
      <th>Category</th>
      <th>Scheduled</th>
      
    </tr>
  </thead>

  <tbody>
   <?php
					$Details = DB::table('UKHT_Audit_Timeline')
						->join('UKHT_Audit_Types','UKHT_Audit_Types.ID','UKHT_Audit_Timeline.Type')
						->join('UKHT_Audit_Category','UKHT_Audit_Category.ID','UKHT_Audit_Timeline.Category')
						->join('UKHT_Audit_Discipline','UKHT_Audit_Discipline.ID','UKHT_Audit_Timeline.Discipline')
					->where('Rough_Date',$Date->Rough_Date)
						->where('Location',$Location->ID)
						->select('UKHT_Audit_Types.Icon','UKHT_Audit_Category.Name as Category','UKHT_Audit_Discipline.Name as Discipline',db::raw("cast(Scheduled as bit) as Scheduled"))
						->get();
						
						foreach($Details as $Detail){
						
						?>
    <tr>
      <th scope="row"><span class="fa-stack ">
  <i class="fas fa-square fa-stack-2x text-primary"></i>
  <i class="{{$Detail->Icon}} fa-stack-1x fa-inverse"></i>
</span> </th>
      <td>{{$Detail->Discipline}} - {{$Detail->Category}}</td>
      <td><?php if($Detail->Scheduled){ echo "Scheduled"; }else{ echo "TBC" ; } ?></td>
      
    </tr>
	  
	  <?php } ?>
  </tbody>

</table>
		  
      </div>
    </div>

  </div>
	
		
			<?php 
			}
				
				?>

</div>
			
			<?php
			} 
			
			?>
			
		
		
		</div>
	
	
	</div>
	
	
	</div>
	
	
	
	
<div class="col-md-2 ">


<div class="card ">
	
	<div class="card-header primary-color text-white">Actions</div>
	
	<div class="btn btn-lg secondary-color text-white">Audit Calendar</div>
	
	<div class="card-body">
	<div class="card-title mb-0">Timeline View<br></div>
	<small class="text-muted mb-2"><small>Click to filter</small></small>
			
		
		
		
		<div class="card-text mt-2">
			
			<div class="form-check">
    <input type="checkbox" class="form-check-input" id="materialUnchecked">
    <label class="form-check-label check-history" for="materialUnchecked">Show Historic</label>
</div>
			
		<ul class="list-group list-group-flush">
			<?php 
			$Timelines2 = DB::table('UKHT_Audit_Timeline')
					 ->pluck('Location');
				
				
				
				$Locations2 = DB::table('UKHT_Locations')
					->whereIn('UKHT_Locations.ID',$Timelines2)
					->where('UKHT_Locations.Removed',0)
					->distinct()
					->orderby('UKHT_Locations.ID','asc')
					->get();
			
			foreach($Locations2 as $Location){
				
				?>
			
			<li class="list-group-item location-hider point" data-class="Location-{{$Location->ID}}" id="Location{{$Location->ID}}"><span class="text-danger mr-2">&#9679;</span>{{$Location->Name}}</li>

			
			<?php } ?>
			</ul>
		
		</div>
	
	
	</div>
	
	
	
	</div>

</div>


</div>


<script>

	$(document).ready(function(){
		$.fn.scrollTo = function(elem, speed) { 
    $(this).animate({
        scrollTop:  $(this).scrollTop() - $(this).offset().top + $(elem).offset().top -5
    }, speed == undefined ? 1000 : speed); 
    return this; 
};
	
		var thismonth = '#<?php echo Carbon::now()->format('FY') ?>'
		
	
		
		$(thismonth).prevAll('.accordion').hide();
		$(thismonth).prevAll('.date-header').hide();
		$('#Timeline').scrollTo(thismonth)
		
		$('.check-history').on('click',function(){
			$(thismonth).prevAll('.accordion').toggle();
		$(thismonth).prevAll('.date-header').toggle();
			$('#Timeline').scrollTo(thismonth)
		
		})
		
		$('.location-hider').on('click',function(){
			var classed = $(this).data('class'); 
			$('.'+classed).toggle();
			$(this).toggleClass('strike');
			
			
			$('.date-header').each(function(){
				var hidden = $(this).next('.accordion').children('.card:visible').length 
				
				if(hidden > 0){
					$(this).show()
				}else{$(this).hide();}
				
			})
			
			
		})

	
		
		
})
	



</script>



@stop



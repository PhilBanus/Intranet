<?php 


$ID = session(['MY_ID']);
?>


@extends('intranet')

@section('content')
<div class="row">

	<div class="col-md-8">
	
		<div class="card">
		<div class="card-header primary-color text-white">Internal Employees</div></div>
		
		<div class="card-body">
		
		
		<!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

	<div class="card">

		 {{View::make('HR.InternalEmployees')}}
		
		</div>


</div>
<!-- Accordion wrapper -->
		
		
		</div>
		
	</div>
	
	
							 <div class="col-md-4">
						<div class="card">
						   <div class="card-header primary-color text-white">Available Appraisals</div>
							 <div class="card-body">
							 <ul class="list-group">
								  <?php 
								 $Months = DB::table('UKHT_Appraisal_Months')
									 ->get();

							foreach($Months as $Month) { 
								
								?> 
								 <li class="list-group-item d-flex p-2 ">
									 
									 <span class="p-2">{{$Month->Name}}</span> 
									 
									 
									 <?php if($Month->Active == false && $Month->Complete == false ){
									
									?>  <div class="btn btn-lg btn-primary ml-auto rounded activate" data-name="{{$Month->Name}}" data-id="{{$Month->ID}}">Activate</div></li> <?php
									
								}
									
								if($Month->Active == true){
									
									?>  <div class="bg-success ml-auto text-white rounded btn m-0">Active</div></li> <?php
									
								}
								
								if($Month->Complete == true){
									
									?>  <div class="bg-info ml-auto text-white rounded btn disabled">Complete</div></li> <?php
									
								}
									 
									 
									
										

							}
		
		?> 
								 
								 </ul>
							 </div>
							 </div>
						</div>

	
</div>



<script>
	$(document).ready(function(){

$('.activate').on('click',function(){
	var id = $(this).data('id');
	var date = $(this).data('name');
	bootbox.confirm({ 
    
		centerVertical: 1,
    message: "Are you sure you want to activate this appraisal? <br> <small>Doing so will complete current active appraisals.</small>",
    callback: function(result){ 
	
		if(result == true){
			
			var dialog = bootbox.dialog({
    message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Please wait while the appraisal is activated...</p>',
				centerVertical: 1,
    closeButton: false
});
			
			$.post("/XWeb/Forms/HR Admin/activteAppraisal.php", {id: id, date: date}).done(function( data ) { 
		 var content = $(data).children("#content").text();
				
				 if(data.status == 'success'){
        dialog.modal('hide');
		location.reload();			 
					 
    }else if(data.status == 'error'){
		dialog.find('.bootbox-body').html('Error! Please contact ICT');
        
    }
				
			})
			
		}
		
	}
})
	
	
})

})
</script>

@stop
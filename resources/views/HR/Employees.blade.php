<?php 



$ID = session(['MY_ID']);
?>


@extends('intranet')

@section('content')
<div class="row">

	<div class="col-md-12">
	
		<div class="card">
		<div class="card-header primary-color text-white">Internal Employees</div></div>
		
		<div class="card-body">
		
		
		<!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

	<div class="card">

		 {{View::make('HR.InternalEmployeesPD')}}
		
		</div>


</div>
<!-- Accordion wrapper -->
		
		
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
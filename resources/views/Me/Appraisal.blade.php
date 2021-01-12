<?php 


$ID = session('MY_ID');
?>


@extends('intranet')

@section('content')
<div class="row">

	<div class="col-md-8">
	
		<div class="card">
		<div class="card-header primary-color text-white">My Completed Appraisals </div>
		
		<div class="card-body">
		
		
		<!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx1" role="tablist" aria-multiselectable="true">

	
	<?php 
	
	$MyCompleted = DB::table('UKHT_Appraisal_Complete')
			->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Complete.Completed_By')
			->where('UKHT_Appraisal_Complete.Contact_ID',session('MY_ID'))
		    ->get();
		
		foreach($MyCompleted as $MyComplete){
			
			?>
	
	
	

  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header row m-0 p-0" role="tab" id="headingAppraisal{{$MyComplete->ID}}">
			<a href="DownloadAppraisal?content={{$MyComplete->ID}}&date={{$MyComplete->Appraisal_Date}}&App={{$MyComplete->Forename}} {{$MyComplete->Surname}}" class=" col-1 text-word waves-effect bg-light m-0 p-2 text-center"><i class="fas fa-2x fa-file-word"></i> </a>
      <a class="collapsed col-11 m-0 p-2" data-toggle="collapse" data-parent="#accordionEx1" href="#collapseAppraisal{{$MyComplete->ID}}"
        aria-expanded="false" aria-controls="collapseAppraisal{{$MyComplete->ID}}">
        <h5 class="mb-0 p-2">
		
			
          <span class="col-11">{{$MyComplete->Appraisal_Date}} </span>  <i class="fas fa-angle-down rotate-icon col-1 text-right"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="collapseAppraisal{{$MyComplete->ID}}" class="collapse" role="tabpanel" aria-labelledby="headingAppraisal{{$MyComplete->ID}}"
      data-parent="#accordionEx1">
      <div class="card-body">
		  <div class="card-title d-flex">
			  <span>
			  Completed By:
			  {{$MyComplete->Forename}}
			  {{$MyComplete->Surname}}
				  </span>
			 
		  </div>
        <?php echo urldecode($MyComplete->Summary) ?>
      </div>
    </div>

  </div>
  <!-- Accordion card -->

 	<?php
		}
		
		?>

</div>
<!-- Accordion wrapper -->
		
		
		</div>
		
	</div>
	</div>
	<div class="col-md-4">

		<div class="card">
		
<?php 	



$IsLine = DB::table('Entity_Contacts')
	->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')
	->where('Entity_Class_ID',1)
	->where('Contact_Role_ID',4)
	->where('Entity_Contacts.contact_id',$ID)
	->exists();


			$isDelegate = DB::table('UKHT_Appraisal_Delegate')
									->select('Contact.Forename','Contact.Surname','Contact.Contact_ID')
									->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Delegate.Contact_ID')
									->whereNull('Contact.Superceded_By_Date')
									->where('UKHT_Appraisal_Delegate.Delegate_ID',$ID)
									->whereNotNull('Contact.User_Password')->exists();

	
		
							if ($IsLine || $isDelegate){ 
								
				
		
		?>
						
						
						<div class="card-header primary-color text-white">My Employee Appraisals</div>
			
			      <a href="{{asset('docs/APPRAISALS 2020 - Guidance  Notes.docx')}}" download class="btn btn-primary rounded-0">Appraisal Guidance</a>
			
            
			<div class="card-body">
				
			
							<?php 	
					
							
								$Months = DB::table('UKHT_Appraisal_Months')
									->orderby('ID','asc')
									->get();
								
								foreach($Months as $Month){
									
									
								?>
				
				
				
				<?php
					
								}
								
							
								$ActiveMonth = DB::table('UKHT_Appraisal_Months')
									->where('Active',1)
									->orderby('ID','asc')
									->First();
								
								$Delegates = DB::table('UKHT_Appraisal_Delegate')
									->select('Contact.Forename','Contact.Surname','Contact.Contact_ID')
									->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Delegate.Contact_ID')
									->whereNull('Contact.Superceded_By_Date')
									->where('UKHT_Appraisal_Delegate.Delegate_ID',$ID)
									->whereNotNull('Contact.User_Password');
								
								
								
								$Employees = DB::table('Entity_Contacts')
									->select('Contact.Forename','Contact.Surname','Contact.Contact_ID')
									->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')
									->where('Entity_Class_ID',1)
									->where('Contact_Role_ID',4)
									->whereNull('Contact.Superceded_By_Date')
									->where('Entity_Contacts.contact_id',$ID)
									->whereNotNull('Contact.User_Password')
									->union($Delegates)
									->get();
								
								
								
								
								foreach($Employees as $Employee){
								
									$ParentCategory = DB::table('Category')
										->where('Parent_Category_ID','=',3849)
										->pluck('Category_ID');
							
							
									 $Category = DB::table('Category')
										->where('Parent_Category_ID','=',3849)
										->orWhereIn('Parent_Category_ID',$ParentCategory)
										->where('Name','=','Job Descriptions')
										->pluck('Category_ID');
				
									
									
									$DocumentCategory = DB::table('Document_Categories')
										->whereIn('Category_ID',$Category)
										->pluck('Document_ID');
							
									
									$Documents = DB::table('Document')
										->whereIn('Document_ID',$DocumentCategory)
										->pluck('Document_ID');
								
								
									$Document = DB::table('Document_Entities')
										->join('Document','Document.Document_ID','Document_Entities.Document_ID')
										->where('Document_Entities.Entity_Identifier',$Employee->Contact_ID)
										->whereIn('Document_Entities.Document_ID',$Documents)
										->select('Document.Document_ID')
										->first();
								
									
								
								?>
				<div class="card mb-2">
				
				<div class="card-header stylish-color text-white">{{$Employee->Forename}} {{$Employee->Surname}} </div>
					
					<?php 
									if($Document){ ?>
									
				<a class="btn btn-sm btn-primary " href="http://themis.ukht.org/DMS/view_document.aspx?ID={{$Document->Document_ID}}&Latest=true" target="Job_Role"><i class="fas fa-file-word"></i> Click to  Review Job Role</a>
				
					<?php } ?>
					
					
					<div class="card-body">
					<?php 
								
									if(DB::table('UKHT_Appraisal_Answers')->where('Contact_ID',$Employee->Contact_ID)->exists() ){
									
							$PercentComplete = DB::table('UKHT_Appraisal_Answers')
								->select(DB::raw('count([ID]) as Questions, count(Completed_By)  as Answered, convert(decimal(5,2),((Cast(count(Completed_By) as Float)/Cast(count([ID]) as Float))*100)) as [Percent]'))
								->where('Contact_ID',$Employee->Contact_ID)
								->where('Appraisal_Date',$ActiveMonth->Name)
								->first();
										
										$Percent = $PercentComplete->Percent;
									
									}else{
										
										$Percent = 0;
									}
								
									
									?>
					<div class="card-text"> {{$ActiveMonth->Name}} Appraisal {{$Percent}}% Complete</div>
					<div class="progress md-progress" style="height: 20px">
    <div class="progress-bar" role="progressbar" style="width: {{$Percent}}%; height: 20px" aria-valuenow="{{$Percent}}" aria-valuemin="0" aria-valuemax="100">{{$Percent}}%</div>
</div>
					
					
					</div>
					
					
					<div class="card-footer">
								
								<?php 
								$Complete = DB::table('UKHT_Appraisal_Complete')
									->where('Contact_ID',$Employee->Contact_ID)
									->where('Appraisal_Date',$ActiveMonth->Name);
								
									
								
								
			
		
	
		if($Complete->exists()){
			?>
		<div id="modalActivate{{$Employee->Contact_ID}}" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalPreview{{$Employee->Contact_ID}}">View Appraisal</div>
						
						
						
						<div class="modal fade right" id="exampleModalPreview{{$Employee->Contact_ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">{{$ActiveMonth->Name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
   
		  <?php 
			
				$Completed = $Complete->first();
			
			echo urldecode($Completed->Summary);
			
			?>
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
						
	<?php
			
		} 
		else{ ?>
								
								<a href="https://themis.ukht.org/xweb/Forms/Dashboard/apprasial.php?id={{$Employee->Contact_ID}}&Appraisal={{$ActiveMonth->Name}}" class="btn btn-sm btn-primary rounded appraisal_conduct" target="new">Conduct Appraisal </a>
								
					
								<div class="btn btn-sm btn-primary rounded float-right delegate" data-id="{{$Employee->Contact_ID}}" data-appraisal="{{$ActiveMonth->Name}}" target="new" style="cursor: pointer">Delegate</div>
								
								<?php } ?>
							</div>
					
				
				</div>
								
								
								<?php
					
							
								
						
									
									
									
									
									
									
								}
									
									
										
						
							
								
							?>
			
			
			
			
			</div>
						
						
						
						
				<?php } ?>

</div>
</div>
</div>



<script>


	$('.delegate').on('click', function(){
			
			var id = $(this).data("id");
			var appraisal = $(this).data("appraisal"); 
			
			bootbox.prompt({
    title: "Who would you like to delegate responsibility to?",
	message: "<strong class='text-center'>You will still be able to see and access the appraisal.</strong>",
    inputType: 'select',
    inputOptions: [
    {
        text: 'Choose one...',
        value: '',
    },
		
		 
								 <?php 
		
		$INTEmployees = DB::table('Role_Membership')
			->join('User','User.Contact_ID','Role_Membership.Contact_ID')
			->join('Contact','Contact.Contact_ID','Role_Membership.Contact_ID')
			->where('Role_Membership.User_Role_ID',199)
			->whereNull('Contact.Superceded_By_Date')
			->where('Contact.Organisation_ID','<',0)
			->where('Contact.Organisation_ID','!=',-2)
			->where('Contact.Contact_ID','!=', 11831)
			->whereNotNull('Contact.User_Password')
			->orderby('Forename','asc')
			->orderby('Surname','asc')
			->get();
			
		

							foreach($INTEmployees as $IEmployee) { 
								?> 
	
	
		 {
        text: "<?php echo $IEmployee->Forename.' '.$IEmployee->Surname ?>",
        value: <?php echo $IEmployee->Contact_ID ?>,
    },
	
		
		<?php
								
								
							}
								?> 
		
   
    
    ],
    callback: function (result) {
		
		if(result == id){
			bootbox.alert("You can not delegate responsibility to the employee")
		}
		
		if(result > 0 && result != id ){
		
			var dialog = bootbox.dialog({
    message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Please wait while the appraisal is delegated...</p>',
				centerVertical: 1,
    closeButton: false
});
		
       $.post("https://themis.ukht.org/xweb/Forms/Dashboard/Delegate.php", { delgate: result, id: id, appraisal: appraisal} ).done(function( data ) { 
		 var content = $(data).children("#content").text();
				
				 if(data.status == 'success'){
        dialog.modal('hide');
		location.reload();			 
					 
    }else if(data.status == 'error'){
		dialog.find('.bootbox-body').html('Error! Please contact ICT');
		console.log(data)
        
    }
				
			});
    }

	}
			});
			
			
			
			
			
		})



</script>
@stop
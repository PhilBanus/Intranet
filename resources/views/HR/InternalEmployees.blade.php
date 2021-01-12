		@extends('table')


@section('headers')
<tr>
      <th>Employee
      </th>
      <th>Linemanager
      </th>
	<th>Job Description
      </th>
      <th>Completed Appraisals
      </th>  
	
	<th>Delegate
      </th>  
	
   
    
    </tr>


@overwrite
@section('rows')



<?php 

$ActiveAppraisal = DB::table('UKHT_Appraisal_Months')->where('Active',1)->first();

	$Employees = DB::table('Role_Membership')
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
		->get();
	foreach($Employees as $Empoyee){

		
		$CompletedAppraisals = DB::table('UKHT_Appraisal_Complete')
			->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Complete.Completed_By')
			->where('UKHT_Appraisal_Complete.Contact_ID',$Empoyee->Contact_ID);
			
		
		$ParentCategory = DB::table('Category')
										->where('Parent_Category_ID','=',3849)
										->pluck('Category_ID');
							
							
									 $Category = DB::table('Category')
										->where('Name','=','Job Descriptions')
										->whereIn('Parent_Category_ID',$ParentCategory)
										
										->pluck('Category_ID');
				
									
									
									$DocumentCategory = DB::table('Document_Categories')
										->whereIn('Category_ID',$Category)
										->pluck('Document_ID');
							
									
					
								
									$Document = DB::table('Document_Entities')
										->join('Document','Document.Document_ID','Document_Entities.Document_ID')
										->where('Document_Entities.Entity_Identifier',$Empoyee->Contact_ID)
										->whereIn('Document_Entities.Document_ID',$DocumentCategory)
										->select('Document.Document_ID','Document.Title')
										->first();

	?>

 <tr>
      <td><?php echo $Empoyee->Forename ?> <?php echo $Empoyee->Surname ?></td>
      <td><?php echo $Empoyee->Linemanager ?></td>
      <td><?php if($Document){ ?>
									
				<a class="" href="http://themis.ukht.org/DMS/view_document.aspx?ID={{$Document->Document_ID}}&Latest=true" target="Job_Role"><i class="fas fa-file-word"></i> {{$Document->Title}}</a>
				
					<?php }else{ echo "no job role "; } ?></td>
      <td><?php if($CompletedAppraisals->exists()){ ?>
		  
		  <!-- Button trigger modal-->
<button type="button" class="btn btn-primary btn-sm m-0 p-1" data-toggle="modal" data-target="#Employee{{$Empoyee->Contact_ID}}">{{$CompletedAppraisals->count()}} - Click to View</button>

<!-- Modal: modalCart -->
<div class="modal fade" id="Employee{{$Empoyee->Contact_ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Appraisals</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--Body-->
      <div class="modal-body">

		  <?php 
												   
												   $Appraises = DB::table('UKHT_Appraisal_Complete')
			->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Complete.Completed_By')
			->where('UKHT_Appraisal_Complete.Contact_ID',$Empoyee->Contact_ID)->get(); 
		  
		  
		  foreach($Appraises as $Appraise){
			  
			  ?>
		  <div class="row rounded border m-1  p-0">
		  <a href="DownloadAppraisal?content={{$Appraise->ID}}&date={{$Appraise->Appraisal_Date}}&App={{$Appraise->Forename}} {{$Appraise->Surname}}" class=" col-1 text-primary waves-effect bg-light m-0 p-2 text-center"><i class="fas fa-2x fa-file-word "></i>  </a>
			  <span class=" col-11 m-0 p-2">{{$Appraise->Appraisal_Date}}</span>
		  </div>
		  
		
		  <?php 
			  
		  }
		  
		  
		  ?>
     

      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
  
      </div>
    </div>
  </div>
</div>
<!-- Modal: modalCart -->
		  
		  
		  
		  
		  <?php }else{?> {{$CompletedAppraisals->count()}} <?php } ?>
	 </td>
     
	 
      <td><div class="btn btn-sm btn-primary rounded float-right delegate" data-id="{{$Empoyee->Contact_ID}}" data-appraisal="{{$ActiveAppraisal->Name}}" target="new" style="cursor: pointer">Delegate</div></td>
      
    </tr>

<?php } ?>
 
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
			->whereIn('Role_Membership.User_Role_ID',[199,802])
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


@overwrite
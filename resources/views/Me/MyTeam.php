
@extends('intranet')
@section('content')


<div class="card">
		
<?php 	
$ID = session('MY_ID');


$IsLine = DB::table('Entity_Contacts')
	->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')
	->where('Entity_Class_ID',1)
	->where('Contact_Role_ID',4)
	->where('Entity_Contacts.contact_id',$ID)
	->exists();


	
		
							if ($IsLine){ 
								
				
		
		?>
						
						
						<div class="card-header primary-color text-white">My Employee Appraisals</div>
			
			
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
								
								$Employees = DB::table('Entity_Contacts')
									->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')
									->where('Entity_Class_ID',1)
									->where('Contact_Role_ID',4)
									->whereNull('Contact.Superceded_By_Date')
									->where('Entity_Contacts.contact_id',$ID)
									->whereNotNull('Contact.User_Password')
									->get();
								
								$Delegates = DB::table('UKHT_Appraisal_Delegate')
									->join('Contact','Contact.Contact_ID','UKHT_Appraisal_Delegate.Contact_ID')
									->whereNull('Contact.Superceded_By_Date')
									->where('UKHT_Appraisal_Delegate.Delegate_ID',$ID)
									->whereNotNull('Contact.User_Password')
									->get();
								
								
								
								foreach($Employees as $Employee){
									/*
									$ParentCategory = DB::table('Category')
										->where('Parent_Category_ID','=',3849)
										->pluck('Category_ID');
							
									 $Category = DB::table('Category')
										
										->whereIn('Parent_Category_ID',$ParentCategory)
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
									echo $Document; 
									
								
								?>
								<a class="btn btn-sm btn-yuk w-100 mt-0" href="http://themis.ukht.org/DMS/view_document.aspx?ID={{$Document->Document_ID}}&Latest=true" target="Job_Role"><i class="fas fa-file-word"></i> Click to  Review Job Role</a>
								
								<?php
					
							
								
							*/
									
									
									
									
									echo $Employee->Forename;
									
									
								}
									
									
										
						
							
								
							?>
			
			
			
			
			</div>
						
						
						
						
				<?php } ?>

</div>


@stop
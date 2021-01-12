
<?php 
use Carbon\Carbon;
if($_GET['Type'] === "pending"){
	
	$Title = "Submitted Overtime Items";
	
	$DistinctProjects = DB::table('UKHT_Overtime_Items')->select('Project','Contact')->Distinct('Project', 'Contact')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'Removed' => 0])->where( function ($query){ $query->orWhere([['HR_Approved'], 'HR_Approved' => 0]); });

    
	$DistinctMonths = DB::table('UKHT_Overtime_Items')->select('Submitted_Month')->where('Contact', session('MY_ID'))->where( function ($query){ $query->where(['Submitted' => 1, 'Removed' => 0])->where( function ($query){ $query->orWhere([['HR_Approved'], 'HR_Approved' => 0]); }); })->Distinct('Submitted_Month')->get();
	$CurrentItems = function ($query){ $query->where(['Submitted' => 1, 'Removed' => 0])->where( function ($query){ $query->orWhere([['HR_Approved'], 'HR_Approved' => 0]); }); };
	
}

if($_GET['Type'] === "approved"){
	
	$Title = "Submitted Overtime Items";
	
	$DistinctProjects = DB::table('UKHT_Overtime_Items')->select('Project','Contact')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'Removed' => 0, 'HR_Approved' => 1])->Distinct('Project', 'Contact');
	$DistinctMonths = DB::table('UKHT_Overtime_Items')->select('Submitted_Month')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'Removed' => 0, 'HR_Approved' => 1])->Distinct('Submitted_Month')->get();
	$CurrentItems = ['Submitted' => 1, 'Removed' => 0, 'HR_Approved' => 1];
	
}

if($_GET['Type'] === "rejected"){
	
	$Title = "Submitted Overtime Items";
	
	$DistinctProjects = DB::table('UKHT_Overtime_Items')->select('Project','Contact')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'Removed' => 1])->Distinct('Project', 'Contact');
	$DistinctMonths = DB::table('UKHT_Overtime_Items')->select('Submitted_Month')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'Removed' => 1])->Distinct('Submitted_Month')->get();
	$CurrentItems = ['Submitted' => 1, 'Removed' => 1];
	
}




?>




<div class="modal-header">
        <h4 class="modal-title" id="OvertimeModalLabel">{{$Title}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
		@foreach($DistinctMonths as $DistinctMonth)
		  				<h4 class="primary-color p-2 text-white ">{{$DistinctMonth->Submitted_Month}}</h4>
		        <table class="table table-bordered table-responsive-md table-striped text-center">
 <thead>
          <tr>
            <th class="text-center">Start of Shift Date</th>
            <th class="text-center">Start Time</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Hours</th>
            <th class="text-center">Day or Night</th>
            <th class="text-center">Description</th>
            <th class="text-center">Route/Status</th>
           
          </tr>
        </thead>
						  @foreach($DistinctProjects->where('Submitted_Month', $DistinctMonth->Submitted_Month)->get() as $Proj)
						
								<tr>
								<td colspan="7" class="text-white bg-dark p-2">
									<div class="d-flex justify-content-between">
								<span class="mr-4">
								{{DB::table('Project')->where('Project_ID',$Proj->Project)->first()->Name}}:
								</span>
								
							<?php 
	$LineManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => session('MY_ID'), 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
						
	$ProjectManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Proj->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
						
	
	
	?><span>
								@if($ProjectManager->Contact_ID != $LineManager->Contact_ID)
										@if( $ProjectManager->Contact_ID == $Proj->Contact )
											<span><span class="badge badge-primary">1st</span> {{$LineManager->Forename}} {{$LineManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
											<span><span class="badge badge-primary">2nd</span> HR <i class="fas fa-user-alt"></i></span>
										@else
											<span><span class="badge badge-primary">1st</span> {{$LineManager->Forename}} {{$LineManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
											<span><span class="badge badge-primary">2nd</span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
											<span><span class="badge badge-primary">3rd</span> HR <i class="fas fa-user-alt"></i></span>
										@endif
								@else
								<span><span class="badge badge-primary">1st</span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">2nd</span> HR <i class="fas fa-user-alt"></i></span>
								@endif
										</span>
										</div>
					</td>
		  
		  </tr>
		  
       
        <tbody>
            
            
			
  @foreach( DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where('Submitted_Month',$DistinctMonth->Submitted_Month )->where('Project', $Proj->Project)->where($CurrentItems)->get() as $Item)
			<tr class="hide" globalid="{{$Item->Global_ID}}">
  <td class="pt-3-half" contenteditable="false">
	  {{carbon::create($Item->Date)->format('l, d M, Y')}}
				</td>
  <td class="pt-3-half" contenteditable="false">
	  {{$Item->Start_Time}}
				</td>
  <td class="pt-3-half" contenteditable="false">
	  {{$Item->End_Time}}
				</td>
  <td class="pt-3-half hours" contenteditable="false">{{$Item->Hours}}</td>
  <td class="pt-3-half timeofday" contenteditable="false">{{$Item->Time_Of_Day}}</td>
  <td class="pt-3-half"><div class=" Description"><?php echo base64_decode($Item->Description) ?></div></td>
 
				
				<td>
				
					
					@if($ProjectManager->Contact_ID != $LineManager->Contact_ID)
										
					@if( $ProjectManager->Contact_ID == $Item->Contact )
											<span>
												@if($Item->Line_Approved == NULL)
												<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> {{$LineManager->Forename}} {{$LineManager->Surname}}
												
												
												@elseif($Item->Line_Approved != 1)
												<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
												{{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Surname}}
												
												@else
												<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span>
												{{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Surname}}
													<i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
													
														<span>
														
															@if($Item->HR_Approved == NULL)
														<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> 
														
															@elseif($Item->HR_Approved == 1)
														<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span> 
														
															@else
														<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
														
															@endif

														HR <i class="fas fa-user-alt"></i></span>
												
												
					
					
					
					
												
					@endif
												
												
											
										
					@else
											
												@if($Item->LineManager == NULL)
												<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> {{$LineManager->Forename}} {{$LineManager->Surname}}
												
												
												@elseif($Item->Line_Approved != 1)
												<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
												{{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Surname}}
												@else
												<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span>
												{{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->LineManager)->first()->Surname}}
													<i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
													
												@if($Item->PM == NULL)
												<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}}
												
												
												@elseif($Item->PM_Approved != 1)
												<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
												{{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Surname}}
												@else
												<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span>
												{{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Surname}}
													<i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
													
														<span>
														@if($Item->HR_Approver == NULL)
														<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> 
														@elseif($Item->HR_Approved == 1)
														<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span> 
														@else
														<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
														@endif

														HR <i class="fas fa-user-alt"></i></span>
												
												
					
					
					
					
												@endif
												
												
					
					
					
					
												@endif
											
										@endif
								@else
									@if($Item->PM == NULL)
												<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}}
												
												
									@elseif($Item->PM_Approved != 1)
												<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
												{{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Surname}}
									@else
												<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span>
												{{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$Item->PM)->first()->Surname}}
													<i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
													
														<span>
											@if($Item->HR_Approver == NULL)
														<span class="badge badge-warning" data-toggle="popover-hover" data-content="Awaiting Approval"><i class="far fa-clock"></i></span> 
														@elseif($Item->HR_Approved == 1)
														<span class="badge badge-success"><i class="fas fa-thumbs-up"></i></span> 
														@else
														<span class="badge badge-danger"><i class="fas fa-thumbs-down"></i></span> 
											@endif

														HR <i class="fas fa-user-alt"></i></span>
												
												
					
					
					
					
												@endif
												
												
					
					
					
								@endif
					
				</td>
				
				

				
				
				
</tr>
			@endforeach
         
        </tbody>
   

					
						  @endforeach
   </table>
		@endforeach
					 
			
		  
		  
      </div>

<script>

$(document).ready(function(){
		$('[data-toggle="popover-hover"]').popover({
  html: true,
  trigger: 'hover',
  placement: 'bottom', 
content: function () { return $(this).data('content') ; }
});
		
	})

</script>

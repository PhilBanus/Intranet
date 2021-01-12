
<?php 

if($_GET['Type'] === "pending"){
	
	$Title = "Submitted Overtime Items";
	
	$DistinctProjects = DB::table('UKHT_Overtime_Items')->select('Project')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'HR_Approved' => 0])->Distinct('Project');
	$DistinctMonths = DB::table('UKHT_Overtime_Items')->select('Submitted_Month')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'HR_Approved' => 0])->Distinct('Submitted_Month')->get();
	$CurrentItems =  DB::table('UKHT_Overtime_Items')->where('Contact', session('MY_ID'))->where(['Submitted' => 1, 'HR_Approved' => 0]);
	
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
						  @foreach($DistinctProjects->where('Submitted_Month', $DistinctMonth->Submitted_Month)->get() as $Proj)
						
								
								<div class="text-muted ml-2  mdb-color lighten-5 p-2">
								<span class="mr-4">
								{{DB::table('Project')->where('Project_ID',$Proj->Project)->first()->Name}}:
								</span>
								
							<?php 
	$LineManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => session('MY_ID'), 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
						
	$ProjectManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Proj->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
						
	
	
	?>
								@if($ProjectManager->Contact_ID != $LineManager->Contact_ID)
								<span><span class="badge badge-primary">1st</span> {{$LineManager->Forename}} {{$LineManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">2nd</span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">3rd</span> HR <i class="fas fa-user-alt"></i></span>
								@else
								<span><span class="badge badge-primary">1st</span> {{$ProjectManager->Forename}} {{$ProjectManager->Surname}} <i class="ml-2 mr-2 fas fa-arrow-right text-primary"></i></span>
								<span><span class="badge badge-primary">2nd</span> HR <i class="fas fa-user-alt"></i></span>
								@endif
					</div>
		  
		  
		  
      <table class="table table-bordered table-responsive-md table-striped text-center">
        <thead>
          <tr>
			<th></th>
            <th class="text-center">Start of Shift Date</th>
            <th class="text-center">Start Time</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Hours</th>
            <th class="text-center">Day or Night</th>
            <th class="text-center">Description</th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody class="tbody">
  @foreach($CurrentItems->where('Project', $Proj->Project)->get() as $Item)
			<tr class="hide" globalid="{{$Item->Global_ID}}">
  <td class="pt-3-half" contenteditable="false">
	  {{carbon::create($Item->Date)->format('l, d M, Y')}}
				</td>
  <td class="pt-3-half" contenteditable="false">
	  {{$Item->Start_Time}}
				</td>
  <td class="pt-3-half" contenteditable="false">
	  {{$Item->End_Time}}"
				</td>
  <td class="pt-3-half hours" contenteditable="false">{{$Item->Hours}}</td>
  <td class="pt-3-half timeofday" contenteditable="false">{{$Item->Time_Of_Day}}</td>
  <td class="pt-3-half"><div class=" Description" style="max-width: 300px"><?php echo base64_decode($Item->Description) ?></div></td>
 
</tr>
			@endforeach
         
        </tbody>
      </table>

					
						  @endforeach
		@endforeach
					 
			
		  
		  
      </div>

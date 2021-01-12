<?php use Carbon\Carbon;
 ?>
@extends('intranet')
@section('content')


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
						
			<div class="row">
    
                
                <div class="col">
                <a href="MyOvertimeDash" target="new" class="card w-100 rounded waves-effect">
                    <div class="card-body bg-info text-white  fa-2x"><i class="fas fa-clock"></i> Overtime Dashboard</div>
                    </div></a>
     
                <div class="col">
                <div class="card">
                    <div class="card-header text-white">Approvals</div>
                    
                    
                    <div class="card-body">
                        
                        <?php 

$Employees = DB::table('Entity_Contacts')
									->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')
									->where('Entity_Class_ID',1)
									->where('Contact_Role_ID',4)
									->whereNull('Contact.Superceded_By_Date')
									->where('Entity_Contacts.contact_id',session('MY_ID'))
									->whereNotNull('Contact.User_Password')
									->pluck('Contact.Contact_ID')->toArray();
$PMEMP =  DB::table('UKHT_Overtime_Items')->where('PM', session('MY_ID'))->pluck('Contact')->toArray();

$Employees = array_unique(array_merge($Employees,$PMEMP));


$InitalSearch = DB::table('UKHT_Overtime_Items')->whereIn('Contact',$Employees)->where(['Submitted' =>  1]);
$Search = [];

$ValidContacts = DB::table('Contact')->whereIn('Contact_ID',DB::table('UKHT_Overtime_Items')->where(['Submitted' =>  1])->whereNotNULL('Contact')->Distinct('Contact')->pluck('Contact'))->pluck('Contact_ID');

    array_push($Search,array('HR_Paid','=',0));


?>


<table id="dt-multi-checkbox" class="table table-dark table-striped w-auto table-bordered table-sm" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm">Actions
      </th>

      <th class="th-sm">Name
      </th>
      <th class="th-sm">Project
      </th>
      <th class="th-sm">Type
      </th>
        
        <th class="th-sm">Submitted
      </th>
      
     
        
    </tr>
  </thead>
<tbody>
    @foreach($InitalSearch->select('*','UKHT_Overtime_Items.Global_ID as GUID','UKHT_Overtime_Items.Description as DESC')->join('Project','Project.Project_ID','UKHT_Overtime_Items.Project')->where($Search)->whereIn('Contact',$ValidContacts)->get() as $Row)
    @if($Row->Removed == 0)
    @if( ($Row->PM_Approved != true && $Row->Line_Approved == true && $Row->PM == session('MY_ID')) || ($Row->Line_Approved != true && $Row->LineManager == session('MY_ID')))
        <?php 
    
    $holidays = Yasumi\Yasumi::create('UnitedKingdom', carbon::create($Row->Date)->year);

    $bankHoliday = false;
  foreach ($holidays->getHolidayDates() as $thdate) {

    if(carbon::create($thdate) == carbon::create($Row->Date)){
        $bankHoliday = true;
    }
}
    
    
    $Contact = db::table('contact')->where('Contact_ID',$Row->Contact)->first();
    if(db::table('contact')->where('Contact_ID',$Row->LineManager)->exists()){
    $LineManager = db::table('contact')->where('Contact_ID',$Row->LineManager)->first();
    }else{
        $LineManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Row->Contact, 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
    }
    if(db::table('contact')->where('Contact_ID',$Row->PM)->exists()){
    $ProjectManager = db::table('contact')->where('Contact_ID',$Row->PM)->first()->Forename.' '.db::table('contact')->where('Contact_ID',$Row->PM)->first()->Surname;
    }else{
        
        if(!$Row->Project){
            $ProjectManager = "N/A";
        }else{
        $ProjectManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Row->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first()->Forename.' '.DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Row->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first()->Surname;
        }
    }
    
    
    if($Row->Line_Approved == 1)
                {if($Row->PM_Approved == 1)
          { $Status = 'Approved';}
           else
           {$Status = 'PM';}}
            
            else
            {$Status = 'Line';}
    
        
        
        ?>
     @if($Row->Time_Of_Day === "Day")
             @if(!carbon::create($Row->Date)->isWeekend() && !$bankHoliday)
    <tr class="overlay-weekday animated bounce slow">
        @else
    <tr> 
        @endif
        @else
    <tr>
        @endif
        
        <td> 
             <a href="OvertimeApproval?id={{$Row->GUID}}" target="new" class="material-tooltip-main mr-2" data-toggle="tooltip"
               title="View Full Submission"><i class="fas fa-eye text-info waves-effect"></i></a>
            
         
            
            
        </td>
        <td>{{$Contact->Forename ?? ''}} {{$Contact->Surname ?? ''}}</td>
        <td>{{db::table('Project')->where('Project_ID',$Row->Project)->first()->Name ?? 'Head Office'}}</td>
        <td>Overtime</td>
        <td data-sort="{{carbon::create($Row->Submitted_Date)}}">{{carbon::create($Row->Submitted_Date)->toFormattedDateString()}}</td>
       
        
        
    </tr>
    
    @endif
    @endif
    @endforeach
    </tbody>  
    
    
</table>

<script>
$(document).ready(function () {
$('#dtBasicExample').DataTable();
$('.dataTables_length').addClass('bs-select');
    
    
    $(function () {
  $('.material-tooltip-main').tooltip({
    template: '<div class="tooltip md-tooltip"><div class="tooltip-arrow md-arrow"></div><div class="tooltip-inner md-inner"></div></div>'
  });
})
    
    
});
    
    $(document).ready(function () {
  $('#dt-multi-checkbox').dataTable({
"pagingType": "full_numbers",
     
  });
   

});
    
    
    
    
    $('.PMreject_claim').on('click',function(){
        var Reject;
         var data = $(this).data('id');
        
        bootbox.prompt("Please provide a reason.", function(result){ 
    Reject = btoa(result); 

        
       
         $.post('OvertimeApprovalPosts',{Type:'PM_Reject',id:data, HR:{{session('MY_ID')}}, Reject:Reject})
            
      reLoad()
            
            });
    })
    
     $('.PMapprove_claim').on('click',function(){
        var data = $(this).data('id');
       $.post('OvertimeApprovalPosts',{Type:'PM_Approval',id:data, HR:{{session('MY_ID')}}})
            
            reLoad()
    })
    
    
    $('.LNreject_claim').on('click',function(){
        var Reject;
         var data = $(this).data('id');
        
        bootbox.prompt("Please provide a reason.", function(result){ 
    Reject = btoa(result); 

        
       
         $.post('OvertimeApprovalPosts',{Type:'LN_Reject',id:data, HR:{{session('MY_ID')}}, Reject:Reject})
            
      reLoad()
            
            });
    })
    
     $('.LNapprove_claim').on('click',function(){
        var data = $(this).data('id');
       $.post('OvertimeApprovalPosts',{Type:'LN_Approval',id:data, HR:{{session('MY_ID')}}})
            
            reLoad()
    })
    
    
     $('.mark-as-paid').on('click',function(){
        var data = $(this).data('id');
       
            $.post('OvertimeApprovalPosts',{Type:'HR_Paid',id:data, HR:{{session('MY_ID')}}})
            reLoad()
    })

</script>


<?php 
    
 
    function is_base64_encoded($data)
{
    if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data)) {
       return TRUE;
    } else {
       return FALSE;
    }
};
     

      
      ?>




                    
                    </div>
                    
                    
                    
                    
                    
                    
                    </div></div>
                
                
                <div class="col">
                <div class="card">
                    <div class="card-header text-white">My Team</div>
                    
                    <div class="list-group">
                        
                        <?php $Employees = DB::table('Entity_Contacts')
									->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')
									->where('Entity_Class_ID',1)
									->where('Contact_Role_ID',4)
									->whereNull('Contact.Superceded_By_Date')
									->where('Entity_Contacts.contact_id',session('MY_ID'))
									->whereNotNull('Contact.User_Password')
									->get();
                                
                                ?>
                        @foreach($Employees as $Mem)
                        
                        <?php $MYPhoto = DB::table('Document_Categories')
	->join('Document_Entities','Document_Entities.Document_ID','=','Document_Categories.Document_ID')
	->join('Document','Document.Document_ID','=','Document_Categories.Document_ID')
    ->where('Document_Categories.Category_ID',444)
	->where('Document_Entities.Entity_Class_ID',1)
	->where('Document_Entities.Entity_Identifier', $Mem->Contact_ID)
	->orderby('Document_Categories.Document_ID','desc')
	->first();
                          if($MYPhoto){
                              
                              $Photo =' https://themis.ukht.org/__files/rendition/'.$MYPhoto->Document_ID.'/-9/photo.jpg';
                          }else{
                              $Photo = "data:image/png;base64,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";
                          }
                                
                                
                                ?>
                    <a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=1&code={{$Mem->Contact_ID}}" target="_blank" class="list-group-item">
                        <p class="mb-0"><img src="{{$Photo}}" class="mr-4 blue p-0 white-text rounded " height="80px" aria-hidden="true"></i>{{$Mem->Forename}} {{$Mem->Surname}}</p>
                        </a>
                    @endforeach
                    
                    </div>
                    </div></div>
                
                
                
    
    
    </div>
						
						
				<?php } ?>


@stop
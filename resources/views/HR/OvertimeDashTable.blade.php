<?php 
use Carbon\Carbon;


$InitalSearch = DB::table('UKHT_Overtime_Items')->where(['Submitted' =>  1]);
$Search = [];

$ValidContacts = DB::table('Contact')->whereIn('Contact_ID',DB::table('UKHT_Overtime_Items')->where(['Submitted' =>  1])->whereNotNULL('Contact')->Distinct('Contact')->pluck('Contact'))->pluck('Contact_ID');

if($_GET['HidePaid'] === 'true'){
    array_push($Search,array('HR_Paid','=',0));
}else{
   
}

if(isset($_GET['HideUnPaid'])){
if($_GET['HideUnPaid'] === 'true'){
     array_push($Search,array('HR_Paid','=',1));
}
}

if(isset($_GET['Project'])){
if($_GET['Project']){
     array_push($Search,array('Project.Name','like','%'.base64_decode($_GET['Project']).'%'));
}
}


if(isset($_GET['ToDate'])){
if($_GET['ToDate']){
     array_push($Search,array('Date','<=',carbon::create(base64_decode($_GET['ToDate']))));
}
}
if(isset($_GET['FromDate'])){
if($_GET['FromDate']){
     array_push($Search,array('Date','>=',carbon::create(base64_decode($_GET['FromDate']))));
}
}

if(isset($_GET['ClaimMonth'])){
if($_GET['ClaimMonth']){
     array_push($Search,array('Submitted_Month','=',base64_decode($_GET['ClaimMonth'])));
}
}

$PMS =  DB::table('UKHT_Overtime_Items')->distinct('PM')->where(['Submitted' =>  1])->whereNotNull('PM')->pluck('PM');


if(isset($_GET['PM'])){
    $ProjectManagers = DB::table('Contact')->distinct('Contact_ID')->whereIn('Contact_ID',$PMS)->whereRaw("concat(Forename,' ',Surname) like '%".base64_decode($_GET['PM'])."%'")->pluck('Contact_ID');
    
    $InitalSearch->whereIn('PM', $ProjectManagers);
}

$LINES =  DB::table('UKHT_Overtime_Items')->distinct('LineManager')->where(['Submitted' =>  1])->whereNotNull('LineManager')->pluck('LineManager');


if(isset($_GET['Line'])){
    $LineManagers = DB::table('Contact')->distinct('Contact_ID')->whereIn('Contact_ID',$LINES)->whereRaw("concat(Forename,' ',Surname) like '%".base64_decode($_GET['Line'])."%'")->pluck('Contact_ID');
    
    $InitalSearch->whereIn('LineManager', $LineManagers);
}

$Employees =  DB::table('UKHT_Overtime_Items')->distinct('Contact')->where(['Submitted' =>  1])->whereNotNull('Contact')->pluck('Contact');


if(isset($_GET['Employee'])){
    $Employee = DB::table('Contact')->distinct('Contact_ID')->whereIn('Contact_ID',$Employees)->whereRaw("concat(Forename,' ',Surname) like '%".base64_decode($_GET['Employee'])."%'")->pluck('Contact_ID');
    
    $InitalSearch->whereIn('Contact', $Employee);
}

if(isset($_GET['Status'])){
    
    
if($_GET['Status'] == 1){
     array_push($Search,array('Line_Approved','=',1));
     array_push($Search,array('PM_Approved','=',1));
}  
    
if($_GET['Status'] == 2){
     array_push($Search,array('Line_Approved','=',0));
     array_push($Search,array('PM_Approved','=',0));
    array_push($Search,array('HR_Approved','=',0));
}  
if($_GET['Status'] == 3){
     array_push($Search,array('Line_Approved','=',1));
     array_push($Search,array('PM_Approved','=',0));
     array_push($Search,array('HR_Approved','=',0));
}
if($_GET['Status'] == 4){
     array_push($Search,array('Removed','=',1));
}
    
    
}

?>

<style>
    table, tr, td{
        position: relative;
    }
  
.overlay-weekday td:after {
position: absolute;
z-index: 1;
  text-align: center; 
    left: 0; 
    height: 100%; 
    line-height: 100%; 
    width: 100%; 
    padding: auto;
    top: 0 ; 
    content: '';
display: block;
text-align: center;
    border: none; 
background-color: rgba(255, 0, 0, 1);
color: white;
    -webkit-animation: flickerAnimation 3s infinite;
   -moz-animation: flickerAnimation 3s infinite;
   -o-animation: flickerAnimation 3s infinite;
    animation: flickerAnimation 3s infinite;
    }
    .overlay-weekday td:nth-child(1):after{
        content: none
    } .overlay-weekday td:nth-child(1){
        background-color: none
    }
    .overlay-weekday td:nth-child(6):after{
        content: 'Claiming for Weekday - Day';
        margin-top: auto; 
        margin-bottom: auto; 
        font-size: 2em;  
        z-index: 2;
        vertical-align: middle;
        padding-top: 1.5%;
    }
    
    @keyframes flickerAnimation {
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
@-o-keyframes flickerAnimation{
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
@-moz-keyframes flickerAnimation{
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
@-webkit-keyframes flickerAnimation{
  0%   { opacity:1; }
  50%  { opacity:0; }
  100% { opacity:1; }
}
</style>
<div class="table-responsive text-nowrap">
<table id="dt-multi-checkbox" class="table table-dark table-striped w-auto table-bordered table-sm" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm">Actions
      </th>
         <th class="th-sm text-center"><i class="fas fa-money-bill-alt text-success p-0"></i>
      </th>
      <th class="th-sm">Name
      </th>
      <th class="th-sm">Payroll No.
      </th>
      <th class="th-sm">Line Manager
      </th>
      <th class="th-sm">Project Manager
      </th>
      <th class="th-sm">Project
      </th>
      <th class="th-sm">Month
      </th>
      <th class="th-sm">Date
      </th>
      <th class="th-sm">OT 1.5
      </th>
      <th class="th-sm">OT 1.8
      </th>
      <th class="th-sm">30% uplift
      </th>
      <th class="th-sm">Status
      </th>
      <th class="th-sm">Submitted
      </th>
     
        
    </tr>
  </thead>
<tbody>
    @foreach($InitalSearch->select('*','UKHT_Overtime_Items.Global_ID as GUID')->join('Project','Project.Project_ID','UKHT_Overtime_Items.Project')->where($Search)->whereIn('Contact',$ValidContacts)->get() as $Row)
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
            
            @if($Status === 'Approved' && ($Row->HR_Approved == 0 || $Row->HR_Approved == null) && $Row->Removed == 0)
            <span href="" class="material-tooltip-main approve_claim" data-id="{{$Row->GUID}}" style="z-index: 100" data-toggle="tooltip"
  title="Approve"><i class="fas fa-thumbs-up text-success mr-2 waves-effect"></i></span>
            
            <span href="" class="material-tooltip-main reject_claim" data-id="{{$Row->GUID}}" data-toggle="tooltip"
               title="Reject"><i class="fas fa-thumbs-down text-danger mr-2 waves-effect"></i></span> 
            
            
           
            
            
            @elseif (($Row->HR_Approved == 0 || $Row->HR_Approved == null) && $Row->Removed == 0)
        
            <span href="" class="material-tooltip-main mr-2" data-id="{{$Row->GUID}}" data-toggle="tooltip"
               title="Delegate Current Stage"><i class="fas fa-directions text-secondary waves-effect"></i></span>
            
            @endif
            
            @if($Row->HR_Approved == 1 && $Row->HR_Paid == 0)
       
             <span href="" class="material-tooltip-main mr-2 mark-as-paid" data-id="{{$Row->GUID}}" data-toggle="tooltip"
               title="Mark as Paid">
        
  <i class="fas fa-money-bill-wave-alt text-success waves-effect"></i>
 
            </span>
            
            @endif
            
            @if($Row->Removed == 1)
       <span class=" material-tooltip-main" data-toggle="tooltip" title="Rejected - {{base64_decode($Row->Reject_Reason)}}">
             <i class="fas fa-times text-danger"></i>
            </span>
            @endif
            
            
        </td>
         <td class="text-center"  style="width: 25px !important">
            @if($Row->HR_Paid)
              <i class="fas fa-thumbs-up text-success p-0 m-0"></i> 
            @else
            <i class="fas fa-hourglass text-warning fa-spin  p-0 m-0"></i>
            @endif
        </td>
        <td>{{$Contact->Forename ?? ''}} {{$Contact->Surname ?? ''}}</td>
        <td>{{$Contact->Tax_Code ?? ''}}</td>
        <td>{{$LineManager->Forename ?? ''}} {{$LineManager->Surname ?? ''}}</td>
        <td>{{$ProjectManager}}</td>
        <td>{{db::table('Project')->where('Project_ID',$Row->Project)->first()->Name ?? 'Head Office'}}</td>
        <td data-sort="{{carbon::create($Row->Submitted_Month)}}">{{$Row->Submitted_Month}}</td>
        <td data-sort="{{carbon::create($Row->Date)}}">{{carbon::create($Row->Date)->toFormattedDateString()}}</td>
        <td>
        <!--WeekendDay -->
        @if($Row->Time_Of_Day === "Day")
            @if(carbon::create($Row->Date)->isWeekend() || $bankHoliday)
             {{$Row->Hours}}
            @endif
        @endif
        </td>
        <td>
        <!--WeekendNight -->
        @if($Row->Time_Of_Day === "Night")
             @if(carbon::create($Row->Date)->isWeekend() || $bankHoliday)
             {{$Row->Hours}}
            @endif
        @endif
        </td>
        <td>
        <!--WeekNight -->
        @if($Row->Time_Of_Day === "Night")
             @if(!carbon::create($Row->Date)->isWeekend())
             {{$Row->Hours}}
            @endif
        @endif
        </td>
        <td>
            
            @if($Row->Line_Approved == 1)
                @if($Row->PM_Approved == 1)
                @if($Row->Removed == 1)
                     <div class="badge badge-danger"><span class="text-dark">Rejected By HR</span></div>
                @else
                    <div class="badge badge-success"><span class="text-dark">Approved</span></div>
                    @endif
            @else
             @if($Row->Removed == 1)
                     <div class="badge badge-danger"><span class="text-dark">Rejected By Project Manager</span></div>
                @else
                <div class="badge badge-warning"><span class="text-dark">With Project Manager</span></div>
            @endif
            @endif
            
            @else
             @if($Row->Removed == 1)
                     <div class="badge badge-danger"><span class="text-dark">Rejected By Line Manager</span></div>
                @else
            <div class="badge badge-info"><span class="text-dark">With Line Manager</span></div>
            @endif
            @endif
        </td>
        <td data-sort="{{carbon::create($Row->Submitted_Date)}}">{{carbon::create($Row->Submitted_Date)->toFormattedDateString()}}</td>
       
        
        
    </tr>
    @endforeach
    </tbody>  
    
    
</table>
</div>
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
    
    
    
    
    $('.reject_claim').on('click',function(){
        var Reject;
         var data = $(this).data('id');
        
        bootbox.prompt("Please provide a reason.", function(result){ 
    Reject = btoa(result); 

        
       
         $.post('OvertimeApprovalPosts',{Type:'HR_Reject',id:data, HR:{{session('MY_ID')}}, Reject:Reject})
            
      reLoad()
            
            });
    })
    
     $('.approve_claim').on('click',function(){
        var data = $(this).data('id');
       $.post('OvertimeApprovalPosts',{Type:'HR_Approval',id:data, HR:{{session('MY_ID')}}})
            
            reLoad()
    })
    
    
     $('.mark-as-paid').on('click',function(){
        var data = $(this).data('id');
       
            $.post('OvertimeApprovalPosts',{Type:'HR_Paid',id:data, HR:{{session('MY_ID')}}})
            reLoad()
    })

</script>




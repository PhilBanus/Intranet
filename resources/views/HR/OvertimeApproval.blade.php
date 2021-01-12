<?php 

use Carbon\Carbon;

$Title = 'Overtime Approval';

?>

@extends('project')
@section('content')

<?php


 if(!isset($_GET['id'])){
   
     $Employees = [];
     $MyLineemployees = [];
     $MyPMemployees = [];
     $MYID = 7006;
     
    $Lineemployees = DB::table('Entity_Contacts')->where(['Entity_Contacts.Contact_ID' => session('MY_ID'), 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Entity_Identifier')->whereNull('Superceded_By_Date')->get();

     foreach($Lineemployees as $Employee){
         
         if(in_array($Employee->Contact_ID , DB::table('UKHT_Overtime_Items')->where('Removed',0)->where(function($query){ $query->orWhere(['Line_Approved' => 0, 'Line_Approved' => NULL]); })->pluck('Contact')->toArray())){
             
             array_push($Employees, $Employee->Contact_ID );
             array_push($MyLineemployees, $Employee->Contact_ID );
             
         }
         
         
     }
        
    $PMProjects = DB::table('Entity_Contacts')->where(['Entity_Contacts.Contact_ID' => session('MY_ID'), 'Contact_Role_ID' => 2])->pluck('Entity_Identifier');
    
     $PMemployees =  DB::table('Entity_Contacts')->where('Entity_Class_ID',3)->whereIn('Entity_Contacts.Entity_Identifier', $PMProjects)->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->get();
     
     foreach($PMemployees as $Employee){
         
         if(in_array($Employee->Contact_ID , DB::table('UKHT_Overtime_Items')->where('Removed',0)->where('Line_Approved' , 1)->where(function($query){ $query->orWhere(['PM_Approved' => 0, 'PM_Approved' => NULL]); })->pluck('Contact')->toArray())){
             
             array_push($Employees, $Employee->Contact_ID );
             array_push($MyPMemployees, $Employee->Contact_ID );
         }
         
         
     }
     
     
     $Employees = array_unique($Employees, SORT_REGULAR);
   
     
     

$CurrentItems = db::table('UKHT_Overtime_Items')
    ->where(function($query){ $query->orWhere(['HR_Approved' => 0, 'HR_Approved' => NULL]); })
    ->where(function($query){ $query->orWhere(['Line_Approved' => 0, 'Line_Approved' => NULL]); })
    ->where(function($query){ $query->orWhere(['PM_Approved' => 0, 'PM_Approved' => NULL, 'Line_Approved' => 1]); })
    ->where('Removed', 0)->whereIn('Contact', $Employees)->get()
  
  
    
        
        
    ?>

    <div  class="table-editable table-responsive">
      <table id="dt-multi-checkbox" class="table table-bordered table-responsive-md table-striped text-center">
        <thead>
          <tr class="text-nowrap">
    <th></th>
              <th class="text-center">Name</th>
			<th class="text-center">Project</th>
            <th class="text-center">Start of Shift Date</th>
            <th class="text-center">Start Time</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Hours</th>
            <th class="text-center">Day or Night</th>
            <th class="text-center">Description</th>

            <th class="text-center">Status</th>
          </tr>
        </thead>
        <tbody class="tbody">
  @foreach($CurrentItems as $Item)
         <?php 
    $Contact = db::table('contact')->where('Contact_ID',$Item->Contact)->first();
    if(db::table('contact')->where('Contact_ID',$Item->LineManager)->exists()){
    $LineManager = db::table('contact')->where('Contact_ID',$Item->LineManager)->first();
    }else{
        $LineManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Contact, 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
    }
    if(db::table('contact')->where('Contact_ID',$Item->PM)->exists()){
    $ProjectManager = db::table('contact')->where('Contact_ID',$Item->PM)->first()->Forename.' '.db::table('contact')->where('Contact_ID',$Item->PM)->first()->Surname;
    }else{
        
        if(!$Item->Project){
            $ProjectManager = "N/A";
        }else{
        $ProjectManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first()->Forename.' '.DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first()->Surname;
        }
    }
    
      $Ready = false;
               $css = '';
          if($Item->Removed == 1)  {
          $css = "red lighten-5 text-danger";
          }
        

             
   
    
        if($Item->HR_Paid == 1){
            $Status = '<i class="fas fa-money-bill-wave-alt"></i> Paid';
             $css = 'green darken-5 text-white';
        }else{
        
    if($Item->Line_Approved == 1){
          //Line Approved
        if($Item->PM_Approved == 1){
            //PM Approved 
            if($Item->HR_Approved == 1) {
                //HR Approved 
                $Status = 'Approved'; 
                $css = 'green lighten-5 green-text';
            }else{
                //HR Not Approved
              
                  if($Item->Removed == 1)  {
                      //HR Rejected
                      $Status = "Rejected by HR <div class='small text-muted'>".base64_decode($Item->Reject_Reason)."</div>";
                  }else{
                      // HR Approval Required
                      $Status = 'HR Approval required'; $Ready = true; $AnyReady = true; 
                  }
            }
        }
        else{
            if($Item->Removed == 1)  {
                      //PM Rejected
                      $Status = "Rejected by Project Manager <div class='small text-muted'>".base64_decode($Item->Reject_Reason)."</div>";
            }else{
                //PM Required
                $Status = "Project Manager Approval Required <div class='small text-muted'>".$ProjectManager."</div>";
            }
        }
    }
            else{
                if($Item->Removed == 1)  {
                      //Line Rejected
                      $Status = "Rejected by Line Manager <div class='small text-muted'>".base64_decode($Item->Reject_Reason)."</div>";
                  }else{
                $Status = "Line Manager Approval Required <div class='small text-muted'>$LineManager->Forename $LineManager->Surname</div>";
                }
            }
        }
          
        ?>
			<tr class="hide {{$css ?? ''}}" globalid="{{$Item->Global_ID}}">
                <td>
                  
                   <div class="btn btn-success btn-sm approve_claim" data-id="{{$Item->Global_ID}}" >Approve Claim</div>
                   <div class="btn btn-danger btn-sm reject_claim" data-id="{{$Item->Global_ID}}" >Reject Claim</div>
                    
                
                </td>
                <td class="pt-3-half">{{$Contact->Forename}} {{$Contact->Surname}}</td>
<td class="pt-3-half" contenteditable="false">
{{DB::TABLE('Project')->where('Project_ID', $Item->Project)->first()->Name}}	
</td>
  <td class="pt-3-half" contenteditable="false">
<div class="md-form p-0 m-0">
	{{$Item->Date}}
</div>
	</td>
  <td class="pt-3-half" contenteditable="false">
	{{$Item->Start_Time}}
	</td>
  <td class="pt-3-half" contenteditable="false">{{$Item->End_Time}}</td>
  <td class="pt-3-half hours" contenteditable="false">{{$Item->Hours}}</td>
  <td class="pt-3-half timeofday" contenteditable="false">{{$Item->Time_Of_Day}}</td>
  <td class="pt-3-half"><?php if(is_base64_encoded($Item->Description)){ echo base64_decode($Item->Description);}else{ echo $Item->Description; }  ?></td>
  <td><?php echo $Status ?>
  </td>
</tr>
			@endforeach
         
        </tbody>
      </table>
    </div>
        

<script>

 $(document).ready(function () {
  $('#dt-multi-checkbox').dataTable({
"pagingType": "full_numbers",
     
  });
     
 });

</script>
        
     <?php
     
     
     
     // End of Line and PM approval
     
  
    }else{


$Item = db::table('UKHT_Overtime_Items')->where('Global_ID',$_GET['id'])->first();


$HR = DB::TABLE('Role_Membership')->where(['User_Role_ID' => 13, 'Contact_ID' => session('MY_ID')])->exists();
 $AnyReady = false;
 $PMAnyReady = false;
 $LNAnyReady = false;


 $isLine = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Contact, 'Contact_Role_ID' => 4, 'Contact_ID' => session('MY_ID')])->exists();
if(!$isLine){
    if(session('MY_ID') == 70061){
        $isLine = true;
    }
}
 $isPM = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Contact, 'Contact_Role_ID' => 2, 'Contact_ID' => session('MY_ID')])->exists();
if(!$isPM){
    if(session('MY_ID') == 70061){
        $iisPM = true;
    }
}

     

?>



@if($Item)

<div class="card">
<div class="card-header text-white">
    {{db::table('Contact')->where('Contact_ID',$Item->Contact)->first()->Forename}}  {{db::table('Contact')->where('Contact_ID',$Item->Contact)->first()->Surname}}
    <div class="card-title text-muted mb-0">{{$Item->Submitted_Month}}</div>
    </div>


    <div class="card-body">





<?php 
$CurrentItems = db::table('UKHT_Overtime_Items')->where(['Submitted_Month' => $Item->Submitted_Month, 'Contact' => $Item->Contact ])->get()
  
  
    
        
        
    ?>

    <div id="table" class="table-editable table-responsive">
      <table class="table table-bordered table-responsive-md table-striped text-center">
        <thead>
          <tr class="text-nowrap">
    <th></th>
			<th class="text-center">Project</th>
            <th class="text-center">Start of Shift Date</th>
            <th class="text-center">Start Time</th>
            <th class="text-center">End Time</th>
            <th class="text-center">Hours</th>
            <th class="text-center">Day or Night</th>
            <th class="text-center">Description</th>
            <th class="text-center">Status</th>
          </tr>
        </thead>
        <tbody class="tbody">
  @foreach($CurrentItems as $Item)
         <?php 
    $Contact = db::table('contact')->where('Contact_ID',$Item->Contact)->first();
    if(db::table('contact')->where('Contact_ID',$Item->LineManager)->exists()){
    $LineManager = db::table('contact')->where('Contact_ID',$Item->LineManager)->first();
    }else{
        $LineManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Contact, 'Contact_Role_ID' => 4])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first();
    }
    if(db::table('contact')->where('Contact_ID',$Item->PM)->exists()){
    $ProjectManager = db::table('contact')->where('Contact_ID',$Item->PM)->first()->Forename.' '.db::table('contact')->where('Contact_ID',$Item->PM)->first()->Surname;
    }else{
        
        if(!$Item->Project){
            $ProjectManager = "N/A";
        }else{
        $ProjectManager = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first()->Forename.' '.DB::table('Entity_Contacts')->where(['Entity_Identifier' => $Item->Project, 'Contact_Role_ID' => 2])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->whereNull('Superceded_By_Date')->first()->Surname;
        }
    }
    
      $Ready = false;
               $css = '';
          if($Item->Removed == 1)  {
          $css = "red lighten-5 text-danger";
          }
        

             
   
    
        if($Item->HR_Paid == 1){
            $Status = '<i class="fas fa-money-bill-wave-alt"></i> Paid';
             $css = 'green darken-5 text-white';
        }else{
        
    if($Item->Line_Approved == 1){
          //Line Approved
        if($Item->PM_Approved == 1){
            //PM Approved 
            if($Item->HR_Approved == 1) {
                //HR Approved 
                $Status = 'Approved'; 
                $css = 'green lighten-5 green-text';
            }else{
                //HR Not Approved
              
                  if($Item->Removed == 1)  {
                      //HR Rejected
                      $Status = "Rejected by HR <div class='small text-muted'>".base64_decode($Item->Reject_Reason)."</div>";
                  }else{
                      // HR Approval Required
                      $Status = 'HR Approval required'; $Ready = true; $AnyReady = true; 
                  }
            }
        }
        else{
            if($Item->Removed == 1)  {
                      //PM Rejected
                      $Status = "Rejected by Project Manager <div class='small text-muted'>".base64_decode($Item->Reject_Reason)."</div>";
            }else{
                //PM Required
                $Status = "Project Manager Approval Required <div class='small text-muted'>".$ProjectManager."</div>"; $Ready = true; $PMAnyReady = true;
            }
        }
    }
            else{
                if($Item->Removed == 1)  {
                      //Line Rejected
                      $Status = "Rejected by Line Manager <div class='small text-muted'>".base64_decode($Item->Reject_Reason)."</div>";
                  }else{
                $Status = "Line Manager Approval Required <div class='small text-muted'>$LineManager->Forename $LineManager->Surname</div>"; $Ready = true; $LNAnyReady = true;
                }
            }
        }
          
        ?>
			<tr class="hide {{$css ?? ''}}" globalid="{{$Item->Global_ID}}">
                <td>
                    @if($HR && $Ready  && $Item->Line_Approved == true  && $Item->PM_Approved == true)
                   <div class="btn btn-success btn-sm approve_claim" data-id="{{$Item->Global_ID}}" >Approve Claim</div>
                   <div class="btn btn-danger btn-sm reject_claim" data-id="{{$Item->Global_ID}}" >Reject Claim</div>
                    @endif 
                    
                    @if($isLine && $Ready)
                   <div class="btn btn-success btn-sm Eapprove_claim" data-approval="LN_Approval" data-id="{{$Item->Global_ID}}" >Approve Claim</div>
                   <div class="btn btn-danger btn-sm Ereject_claim" data-id="{{$Item->Global_ID}}" data-approval="LN_Reject"  >Reject Claim</div>
                    @elseif($isPM && $Ready && $Item->Line_Approved == true)
                   <div class="btn btn-success btn-sm Eapprove_claim" data-approval="PM_Approval" data-id="{{$Item->Global_ID}}" >Approve Claim</div>
                   <div class="btn btn-danger btn-sm Ereject_claim" data-approval="PM_Reject" data-id="{{$Item->Global_ID}}" >Reject Claim</div>
                    @endif
                
                </td>
<td class="pt-3-half" contenteditable="false">
{{DB::TABLE('Project')->where('Project_ID', $Item->Project)->first()->Name}}	
</td>
  <td class="pt-3-half" contenteditable="false">
<div class="md-form p-0 m-0">
	{{$Item->Date}}
</div>
	</td>
  <td class="pt-3-half" contenteditable="false">
	{{$Item->Start_Time}}
	</td>
  <td class="pt-3-half" contenteditable="false">{{$Item->End_Time}}</td>
  <td class="pt-3-half hours" contenteditable="false">{{$Item->Hours}}</td>
  <td class="pt-3-half timeofday" contenteditable="false">{{$Item->Time_Of_Day}}</td>
  <td class="pt-3-half"><?php if(is_base64_encoded($Item->Description)){ echo base64_decode($Item->Description);}else{ echo $Item->Description; }  ?></td>
                <td><?php echo $Status ?>
  </td>
</tr>
			@endforeach
         
        </tbody>
      </table>
    </div>
        
        
@if($HR && $AnyReady)
                   <div class="btn btn-success float-right approve-all">Approve all Claims</div>
                   <div class="btn btn-danger float-right reject-all">Reject all Claims</div>

                    @endif   
        
        
@if(($isLine || $isPM) && ( $PMAnyReady || $LNAnyReady))
                   <div class="btn btn-success float-right Eapprove-all">Approve all Claims</div>
                   <div class="btn btn-danger float-right Ereject-all">Reject all Claims</div>

                    @endif
</div></div>



<script>

    $('.approve_claim').on('click',function(){
        var data = $(this).data('id');
        approve(data,'HR_Approval')
            
            location.reload()
    })
    
    $('.approve-all').on('click',function(){
         $('.approve_claim').each(function(){
        var data = $(this).data('id');
        approve(data, 'HR_Approval')
         
    })
      location.reload()
    })
    
    $('.Eapprove_claim').on('click',function(){
        var data = $(this).data('id');var approval = $(this).data('approval');
        approve(data, approval)
            
            location.reload()
    })
    
    $('.Eapprove-all').on('click',function(){
         $('.Eapprove_claim').each(function(){
        var data = $(this).data('id');
        var approval = $(this).data('approval');
        approve(data, approval)
         
    })
                   location.reload()
    })
    
    function approve(data, approval){
        
        $.post('OvertimeApprovalPosts',{Type: approval ,id:data, HR:{{session('MY_ID')}}})
        
    }
    
    
    $('.reject_claim').on('click',function(){
        var Reject;
         var data = $(this).data('id');
        
        bootbox.prompt("Please provide a reason.", function(result){ 
    Reject = btoa(result); 

        
       
        reject(data, Reject)
            
      location.reload()
            
            });
    })
    
    $('.reject-all').on('click',function(){
        var Reject; 
            bootbox.prompt("Please provide a reason.", function(result){ 
    Reject = btoa(result); 

         $('.reject_claim').each(function(){
        var data = $(this).data('id');
          
    
        
       
        reject(data, Reject)
            
            
         
    })
                
                setInterval(function(){ location.reload() }, 1000);
         
         
                
            })
        
          
    })
    
    function reject(data, reject){
        
        $.post('OvertimeApprovalPosts',{Type:'HR_Reject',id:data, HR:{{session('MY_ID')}}, Reject:reject})
        
    }
    
    
    
$(document).ready(function(){
		$('[data-toggle="popover-hover"]').popover({
  html: true,
  trigger: 'hover',
  placement: 'bottom', 
content: function () { return $(this).data('content') ; }
});
		
	})
    
</script>

@else

No access


@endif
<?php } ?>

@stop


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


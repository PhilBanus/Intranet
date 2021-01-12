<?php
use Carbon\Carbon;
use Carbon\CarbonInterface;
?>
@extends('sections')
@section('content')
@if(DB::table('UKHT_Acquisition')->where('Entity_ID',$_GET['code'])->exists())
<?php 

$Acq = DB::table('UKHT_Acquisition')->where('Entity_ID',$_GET['code'])->first();

$ENQ = DB::table('Enquiry')->join('Enquiry_Status','Enquiry_Status.Enquiry_Status_ID','Enquiry.Enquiry_Status_ID')->where('Enquiry_ID',$_GET['code'])->select('Enquiry.Name as EnquiryName', 'Enquiry_Status.Name as StatusName', '*')->first();


if($ENQ->Display_Colour === 'Red'){
    $Status = 'danger';
}elseif($ENQ->Display_Colour === 'Yellow'){
    $Status = 'warning';
}else{
    $Status = 'success';
}

$confidence = DB::table('UKHT_Acquistion_Procurement_Confidence')->where('Entity',request('code'))->exists() ? DB::table('UKHT_Acquistion_Procurement_Confidence')->where('Entity',request('code'))->first()->Confidence : 0;

?>

<div id="cont" style="font-size: 90%" class="row h-100">
    
<div class="col-md-9 float-right">
    
    

    
    <div class="alert alert-{{$Status}} d-flex justify-content-between" role="alert">
  <div>{{$ENQ->Enquiry_Code}}</div>
  <div>{{$ENQ->EnquiryName}}</div>
  <div>{{$ENQ->StatusName}}</div>
</div>
    
    <div class="col-12 text-right" style="font-size: 110%">
    
    <a href="https://themis.ukht.org/xweb/entity/bulkemail.aspx?ec=4&code={{$_GET['code']}}" class="" target="_blank" title="Bulk Email"><i class="fas fa-1x fa-mail-bulk"></i></a>
     
        @if(DB::table('Role_Membership')->where(['User_Role_ID' => 1, 'Contact_ID' => session('MY_ID')])->exists() && $ENQ->Enquiry_Status_ID == 23 && !DB::table('Project')->where('Enquiry_ID', $_GET['code'])->exists())
    <a href="Posts?code={{$_GET['code']}}&ec={{request('ec')}}&UserID={{session('MY_ID')}}" class="ml-2" title="Create Project"><i class="fas fa-1x fa-thumbs-up"></i></a>
@endif
        @if(DB::table('Role_Membership')->where(['User_Role_ID' => 573, 'Contact_ID' => session('MY_ID')])->exists())
    <a href="General_Edit?code={{$_GET['code']}}&ec={{request('ec')}}&UserID={{session('MY_ID')}}" class="ml-2" ><i class="fas fa-1x fa-pen"></i></a>
@endif
        </div>
    
    <div class="row m-0 p-0">
        
   
            
            <div class="col-md-6 pl-4">
            
                <blockquote  class="blockquote bq-primary p-2 mb-1 pb-0 pt-0" >
  <p class="bq-title mb-1 pb-1" style="font-size: 90% !important">Client: <a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=2&code={{$Acq->Client_Name}}" target="new">{{DB::table('Organisation')->where('Organisation_ID',$Acq->Client_Name)->first()->Name ?? ''}} <small><i>{{DB::table('Organisation')->where('Organisation_ID',$Acq->Client_Name)->first()->Branch_Name ?? ''}}</i></small></a></p>
  <p style="font-size: 80% !important">{{$Acq->Project_Description}}
  </p>
</blockquote>
                
                
                    
                    <dl >
       
  <dt>Form of Contract:</dt>
  <dd>{{DB::Table('UKHT_Acquisition_Form_Of_Contract')->where('Form_Of_Contract_ID',$Acq->Form_of_Contract)->first()->Name ?? ''}}</dd>
                        
  <dt>Contract Category:</dt>
  <dd>{{DB::Table('UKHT_Acquisition_Contract_Category')->where('Contract_Category_ID',$Acq->Contract_Category)->first()->Name ?? ''}}</dd>
                                   
  <dt>Client Value:</dt>
  <dd>£{{number_format($Acq->Client_Value)}}</dd>
                        
  <dt>Known Competitors (PQQ):</dt>
  <dd>{{$Acq->Competitors}}</dd>
                        
  <dt>Known Competitors (Tender):</dt>
  <dd>{{$Acq->Supply_Chain}}</dd>
                    </dl>
                
            </div>
        
      
            
                
            <div class="col-md-3">
            @if($Acq->Joint_Venture === "Yes"   || $Acq->Joint_Venture === "on")
                  <p class="note note-warning"><strong>Joint Venture</strong></p>       
          
               <dl>
 <dt>JV Partners:</dt>
  <dd><a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=2&code={{$Acq->JV_Partner}}" target="new">
      {{db::table('Organisation')->where('Organisation_ID', $Acq->JV_Partner)->first()->Name ?? ''}} <small><i>{{DB::table('Organisation')->where('Organisation_ID',$Acq->JV_Partner)->first()->Branch_Name ?? ''}}</i></small></a></dd>
    
                   <dt>HT JV Share:</dt>
  <dd>{{$Acq->HT_JV_Share}}</dd>
                  
                   
                   
                    </dl>
                
                <hr>
                
                @endif
                
                 <dl >
       @if(!empty($Acq->Designer))
  <dt>Lead Designer:</dt>
  <dd><a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=2&code={{$Acq->Designer}}" target="new">
      {{db::table('Organisation')->where('Organisation_ID', $Acq->Designer)->first()->Name ?? ''}} <small><i>{{DB::table('Organisation')->where('Organisation_ID',$Acq->Designer)->first()->Branch_Name ?? ''}}</i></small></a></dd>
      
                     @endif
                     
                     
  <dt>Approval Status:</dt>
  <dd>{{$Acq->CRC_Submitted}}</dd>
           
                     <hr>
  <dt>Contract Duration:</dt>
  <dd>{{carbon::create($Acq->Contract_End)->diffForHumans($Acq->Contract_Start,['parts' => 3, 'syntax' => CarbonInterface::DIFF_ABSOLUTE])}}</dd>
					 
  <dt>Confidence on procurement timescales:</dt>
  <dd>
	  @if($confidence == 0 )
		<p class="note note-light"><strong>Not Set</strong></p></a>	
	  @elseif($confidence == 1 )
		<p class="note note-success"><strong>High level of confidence</strong></p></a>	
	  @elseif($confidence == 2 )
		<p class="note note-warning"><strong>Medium level of confidence</strong></p></a>	
	  @elseif($confidence == 3 )
		<p class="note note-danger"><strong>Low level of confidence</strong></p></a>	
	  @endif
					 </dd>
        
                     @if(!empty($Acq->Win_Bid))
  <dt>Winning Bidder:</dt>
  <dd>{{$Acq->Win_Bid}}</dd>
      
                     @endif
                     
                     @if(DB::table('Project')->where('Enquiry_ID', $_GET['code'])->exists())
              @foreach(DB::table('Project')->where('Enquiry_ID', $_GET['code'])->get() as $Proj)       
  <p><strong>Project:</strong></p>
  <a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=3&code={{$Proj->Project_ID}}&UserID={{session('MY_ID')}}" target="_blank"><p class="note note-primary"><strong>{{$Proj->Name}}</strong></p></a>
                @endforeach
                @endif
                
            </div>
        
      
                
            <div class="col-md-3">
     <p class="note note-primary"><strong>Dates</strong></p>       
               
                
                  <dl class="row">
                     
  <dt class="col-sm-7">PQQ Start Date</dt>
  <dd class="col-sm-5">{{$Acq->PQQ_Start ? carbon::create($Acq->PQQ_Start)->toFormattedDateString(): 'N/A'}}</dd>
                     
  <dt class="col-sm-7">PQQ Submission Date</dt>
  <dd class="col-sm-5">{{$Acq->PQQ_Submit ? carbon::create($Acq->PQQ_Submit)->toFormattedDateString() : 'N/A'}}   {{$Acq->PQQ_Deadline_Time ?? ''}}</dd>
                     
  <dt class="col-sm-7">Tender Start Date</dt>
  <dd class="col-sm-5">{{$Acq->Tender_Start ? carbon::create($Acq->Tender_Start)->toFormattedDateString() : 'N/A'}} {{$Acq->Tender_Query_Deadline_Time ?? 'N/A'}}</dd>
                     
  <dt class="col-sm-7">Tender Submission Date</dt>
  <dd class="col-sm-5">{{$Acq->Tender_Submit ? carbon::create($Acq->Tender_Submit)->toFormattedDateString() : 'N/A' }} {{$Acq->Tender_Submission_Deadline_Time ?? 'N/A'}}</dd>
                     
  <dt class="col-sm-7">Contract Award Date</dt>
  <dd class="col-sm-5">{{$Acq->Contract_Award ? carbon::create($Acq->Contract_Award)->toFormattedDateString() : 'N/A'}}</dd>
                     
  <dt class="col-sm-7">Contract Start Date</dt>
  <dd class="col-sm-5">{{$Acq->Contract_Start ? carbon::create($Acq->Contract_Start)->toFormattedDateString() : 'N/A'}}</dd>
                     
  <dt class="col-sm-7">Contract End Date</dt>
  <dd class="col-sm-5">{{$Acq->Contract_End ? carbon::create($Acq->Contract_End)->toFormattedDateString() : 'N/A'}}</dd>
                     
                     
                     
                    </dl>
				
				@if(DB::table('UKHT_Acquisition_Dates_Notes')->where('id',request('code'))->exists())
				@if(!empty(preg_replace('/\s+/', '',DB::table('UKHT_Acquisition_Dates_Notes')->where('id',request('code'))->first()->note)))
				  <p class="note note-primary">
                <strong>Commentary on Dates:</strong>
{{DB::table('UKHT_Acquisition_Dates_Notes')->where('id',request('code'))->first()->note ?? '' }}
                    </p>
				
				@endif
				@endif
                
                <hr>
                
                  <dl class="row">
                     
  <dt class="col-sm-7">Last Updated</dt>
  <dd class="col-sm-5">{{carbon::create($Acq->Last_Update)->toDayDateTimeString()}}</dd>
                     
  <dt class="col-sm-7">Updated By</dt>
  <dd class="col-sm-5">{{db::table('Contact')->where('Contact_ID',$Acq->Last_Update_Contact)->first()->Forename ?? ''}} {{db::table('Contact')->where('Contact_ID',$Acq->Last_Update_Contact)->first()->Surname ?? ''}}</dd>
                     
  <dt class="col-sm-7">Created</dt>
  <dd class="col-sm-5">{{carbon::create($ENQ->Created_Date)->toFormattedDateString()}}</dd>
            
                     
                     
                    </dl>
              
                
              
                @if(!empty($Acq->No_Bid))
                
                  <hr>
                <p class="note note-danger">
                <strong>Reason for bid rejection / no bid:</strong>
  {{$Acq->No_Bid}}
                    </p>
              
                @endif
                
            </div>
        
    
        
        
    </div>
    
    
</div>


    
<div class="col-md-3 m-0 h-100 float-left">
    <div class="card p-0 m-0 rounded-0 h-100">
<iframe class="w-100"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/search?key=AIzaSyBPVHaD75EzmfHiLoQX9moPGtUYLilKGS8&q={{$Acq->Location}}&zoom=15"></iframe>
    </div>
</div>

</div>

<script>

$('iframe').height($('#cont').height())

</script>
@else

<?php  

DB::table('UKHT_Acquisition')->insert([
    'Entity_ID' => $_GET['code'], 'Location' => 'United Kingdom'
])


?>


<script type="text/javascript">
location.reload();
    
    
    
</script> 


@endif
@stop
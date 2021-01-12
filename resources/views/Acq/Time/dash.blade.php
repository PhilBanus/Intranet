@extends('project')
@section('content')
<?php 
use Carbon\Carbon; 
$col3 = 100/3;
$col4 = 100/4;
$FullWeek = 37.5;
setlocale(LC_MONETARY,"en_GB");
       
          
          $Roles = DB::table('UKHT_Acquisition_Time_Roles')->where('ACQ_ID',$_GET['code'])->get();
          
          ?>
<style>

    table {
  position: relative;
border-collapse: collapse;
}

    
thead tr:nth-child(2) th {
  position: -webkit-sticky; 
  position: sticky;
  top: 65px;

}
thead tr:first-child th {
  position: -webkit-sticky; 
  position: sticky;
  top: 0;
      z-index: 1;
    background: white

}

thead th:first-child {
  left: 0;
  z-index: 3 !important;
}
    


tbody th {
  position: -webkit-sticky; 
  position: sticky;
  left: 0;
  background: #FFF;
    z-index: 1
}
   
    thead tr .stuck:first-child{
     position: -webkit-sticky; 
  position: sticky;
  left: 0;
  background: #FFF;
    z-index: 1
    }
    
    thead tr .stuck:nth-child(2), tbody tr .stuck:nth-child(2){
     position: -webkit-sticky; 
  position: sticky;
  left: 200px;
  background: #FFF;
    z-index: 1
    }
    
    thead tr .stuck:nth-child(3), tbody tr .stuck:nth-child(3){
     position: -webkit-sticky; 
  position: sticky;
  left: 275px;
  background: #FFF;
    z-index: 1
    }
    
    thead tr .stuck:nth-child(4), tbody tr .stuck:nth-child(4){
     position: -webkit-sticky; 
  position: sticky;
  left: 350px;
  background: #FFF;
    z-index: 1
    }
    
    thead tr .stuck:nth-child(5), tbody tr .stuck:nth-child(5){
     position: -webkit-sticky; 
  position: sticky;
  left: 425px;
  background: #FFF;
    z-index: 1
    }
    
   tbody tr .stuck:first-child{
     position: -webkit-sticky; 
  position: sticky;
  left: 0;
  background: #FFF;
    z-index: 1
    }
    
	.popover-body{
		padding: 0 !important; 
	}

	.popover-header{
		background-color: #024a94;
		color: white;
	}
    
	.popover .arrow::after, .popover .arrow::before{
		border-bottom-color: #024a94;
	}
 
	.popover,.bs-popover-bottom .popover-header::before{
		border-color: #024a94
	}
    .snapto{
         scroll-snap-align: start ;
        
    }

    
    .card-body{
        scroll-snap-type: x mandatory;
        scroll-padding: 0
    }

     .stuck{
      background-color: #B2D8FF !important;  
    }
    
    .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
   background-color: #D2E8FE;
}    
    
    .table-striped > tbody > tr:nth-child(2n+1) > td:first-child, .table-striped > tbody > tr:nth-child(2n+1) > th:first-child {
   background-color: #B2D8FF;
}  
    
   
    .table-striped > tbody > tr:nth-child(2n) > td:first-child, .table-striped > tbody > tr:nth-child(2n) > th:first-child {
   background-color: #eee;
}  
    .table-striped > tbody > tr:nth-child(2n) > td, .table-striped > tbody > tr:nth-child(2n) > th {
   background-color: #fff;
}
   
	
	    .modal-dialog-full-width {
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 1% !important;
        max-width:none !important;

    }

    .modal-content-full-width  {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
        background-color: #ececec !important 
    }

    .modal-header-full-width  {
        border-bottom: 1px solid #9ea2a2 !important;
    }

    .modal-footer-full-width  {
        border-top: 1px solid #9ea2a2 !important;
    }
    
</style>

    <div class="col-12">
<div class="float-right col-12 col-md-9">
    <div class="alert alert-danger red lighten-3" role="alert">
  <i class="fad fa-siren-on text-white"  style="--fa-primary-color: #024a94; --fa-secondary-color: yellow; --fa-secondary-opacity: 1.0"></i><strong> Please Note:</strong> This is an estimation tool and should not be used for Actual Cost reporting. Speak to Finance for Actual Costs. 
</div>
 </div>   
    
  
    <div class="col-12 col-md-3 float-left">    
	<div class="btn btn-lg p-0 text-success z-depth-0 " onClick="pleasewait()" data-toggle="modal" data-target="#PleaseWait"><i class="fad fa-sync"></i> Refresh Data</div>
    <div class="btn btn-primary" hidden="" id="Tender">Tender Costs</div>
    <div class="btn btn-white " hidden="" id="PQQ">PQQ Costs</div>
    <div class="btn btn-lg p-0 text-info z-depth-0  " data-toggle="modal" data-target=".UnplannedModal">Unplanned / Unassigned Time</div>
    <a href="https://themis.ukht.org/XWeb/ICT_Portal/public/ACQ/ExcelExport?code={{request('code')}}" class="p-0 text-success z-depth-0  "><i class="fad fa-2x fa-file-excel pt-2"></i></a>


		
    </div>
    </div>

      <div class="col-12 float-left">
		  <?php 
		  
		  $Variance = DB::table('UKHT_Acquisition_Time_Weekly_Results')->where([['Date_From','<=', Carbon::now()->startOfWeek(Carbon::MONDAY)],'Entity' => request('code')])->select(DB::raw('SUM(Varience) as Varience'))->first()->Varience; 
		  
		 
		  DB::Table('UKHT_Acquisition_Time_Extra')->updateOrInsert(['Entity' => request('code')],['Entity' => request('code')]);
		  
		  $Extra=DB::Table('UKHT_Acquisition_Time_Extra')->where(['Entity' => request('code')])->first()->Est_Cost;
		  
		  
		   $TVariance =  ($Roles->sum('Est_Cost')+$Extra) - DB::table('UKHT_Acquisition_Time_Weekly_Results')->where(['Entity' => request('code')])->select(DB::raw('SUM(Actual_Costs) as Actual_Costs'))->first()->Actual_Costs;
		  
		  
		  ?>
		  
		       <div class="h-10 p-2 col-12 row">
				   <div class="col-6">
					   <div class="col-12 bg-primary text-white p-2">Total Costs:</div>
					   <div class="col-12 row font-weight-bold p-2">
					   <div class="col-4">Estimated: £{{number_format($Roles->sum('Est_Cost')+$Extra)}}</div>
					   <div class="col-4">Actual:  £<?php echo number_format(DB::table('UKHT_Acquisition_Time_Weekly_Results')->where(['Entity' => request('code')])->select(DB::raw('SUM(Actual_Costs) as ACT'))->first()->ACT) ?></div>
					   <div class="col-4">Variance: @if($TVariance < 0)
									<span class="text-danger font-weight-bold">-£{{number_format($TVariance*-1)}}	   </span>
								 @else
								  <span class="text-success font-weight-bold">£{{number_format($TVariance)}}</span>
								 @endif
								 </span></div>
					   </div>
				   </div> 
				   
				   <div class="col-6">
					   <div class="col-12 bg-primary text-white p-2">Accumulated Totals for {{Carbon::now()->startOfWeek(Carbon::MONDAY)->toFormattedDateString()}}:</div>
					   <div class="col-12 row font-weight-bold p-2">
					   <div class="col-4">Estimated:   £<?php echo number_format(DB::table('UKHT_Acquisition_Time_Weekly_Results')->where([['Date_From','<=', Carbon::now()->startOfWeek(Carbon::MONDAY)],'Entity' => request('code')])->select(DB::raw('SUM(Estimated_Costs) as EST'))->first()->EST) ?></div>
					   <div class="col-4">Actual:  £<?php echo number_format(DB::table('UKHT_Acquisition_Time_Weekly_Results')->where([['Date_From','<=', Carbon::now()->startOfWeek(Carbon::MONDAY)],'Entity' => request('code')])->select(DB::raw('SUM(Actual_Costs) as ACT'))->first()->ACT) ?></div>
					   <div class="col-4">Variance:   @if($Variance < 0)
									<span class="text-danger font-weight-bold">-£{{number_format($Variance*-1)}}	   </span>
								 @else
								  <span class="text-success font-weight-bold">£{{number_format($Variance)}}</span>
								 @endif
								 </span></div>
					   </div>
				   </div>

	
		
       
		
          </div>
		  
        <div class="card mb-1 z-depth-0" style="height: 80% !important">
        <div class="card-body z-depth-1 rounded h-100 p-0 Flipped" style="overflow: auto" id="TheData">
        
        
     
                <table class="table text-nowrap table-striped table-hover Content">
      <thead>
   
        <tr>
          <th  style="max-width: 500px  !important; min-width: 500px  !important " colspan="5" class="fixed-side grey lighten-4  snapto border-0"><h5 class="text-primary d-flex">Planned Time <div id="addRole" class=" btn btn-sm btn-success border-0 ml-auto z-depth-0 waves-effect"><i class=" fa fa-plus"></i> add role </div></h5> </th>
          
            <?php
            
            $Acqu = db::Table('UKHT_Acquisition')->where('Entity_ID',$_GET['code'])->first(); 
            
            if(!isset($_GET['pqq'])){
                $TenderStart = $Acqu->Tender_Start;
            $TenderEnd = $Acqu->Tender_Submit;
            }else{
                if($_GET['pqq'] === 'true'){
                $TenderStart = $Acqu->PQQ_Start;
            $TenderEnd = $Acqu->PQQ_Submit;
            }else{
                  $TenderStart = $Acqu->Tender_Start;
            $TenderEnd = $Acqu->Tender_Submit;  
                }
            }
            
            $StartWeek = $TenderStart;
            $i = 1;    
            
            $HeadStartWeek = $TenderStart;
            $Headi = 1;   
            
			
            $dateArray = '';
			  $fromArray = [];
			  $toArray = [];
			 
            
             while(strtotime($StartWeek) <= strtotime($TenderEnd)){
                
				 $dateArray .= '{text: "'.Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString().'", value:"'.Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString().'"},';
				 
				 array_push($fromArray, Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString());
				 array_push($toArray, Carbon::create($StartWeek)->endOfWeek(Carbon::SUNDAY)->toFormattedDateString());
				 
				 DB::table('UKHT_Acquisition_Time_Weekly_Results')->updateOrInsert(
					 ['Entity' => request('code'), 'Date_From' => Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString(), 'Date_To' => Carbon::create($StartWeek)->endOfWeek(Carbon::SUNDAY)->toFormattedDateString()],
				 ['Entity' => request('code'), 'Date_From' => Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString(), 'Date_To' => Carbon::create($StartWeek)->endOfWeek(Carbon::SUNDAY)->toFormattedDateString()]
				 );
					 
				 DB::table('UKHT_Acquisition_Time_Extra_Results')->updateOrInsert(
					 ['Entity' => request('code'), 'Date_From' => Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString(), 'Date_To' => Carbon::create($StartWeek)->endOfWeek(Carbon::SUNDAY)->toFormattedDateString()],
				 ['Entity' => request('code'), 'Date_From' => Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString(), 'Date_To' => Carbon::create($StartWeek)->endOfWeek(Carbon::SUNDAY)->toFormattedDateString()]
				 )
				 
            ?>
            
           
            
            
            
            <th scope="col" colspan="4" class=" text-primary snapto border-bottom-0 border-top-0 border-left-0 border-right border-primary" style="min-width: 500px; font-size: 80%"><strong>Week {{$i++}} ({{Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString()}})</strong></th>
      
            
            <?php 
             $StartWeek  = Carbon::create($StartWeek)->addWeek()->format('Y-m-d');
             
             } 
			
			  
			  DB::table('UKHT_Acquisition_Time_Extra_Results')->whereNotIn('Date_From',$fromArray)->delete();
			  DB::table('UKHT_Acquisition_Time_Weekly_Results')->whereNotIn('Date_From',$fromArray)->delete();
			
			
			
			?>
     
 
        </tr>
          
          <tr>
          <th class="grey darken-3 text-white fixed-side  border-0 stuck" style="width: 200px">Role</th>
          <th class="grey darken-3 text-white fixed-side  border-0 stuck" style="width: 75px">Weeks</th>
          <th class="grey darken-3 text-white fixed-side  border-0 stuck" style="width: 75px">%</th>
          <th class="grey darken-3 text-white fixed-side  border-0 stuck" style="width: 75px">Rate</th>
          <th class="grey darken-3 text-white fixed-side  border-0 stuck" style="width: 75px">Est. Cost</th>
          
              
              <?php
             while(strtotime($HeadStartWeek) <= strtotime($TenderEnd)){
              
				 
				 
            ?>
             
           
            
            
            <th scope="col" class=" bg-dark text-white border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Est Qty</strong></th>
            <th scope="col" class=" bg-dark text-white border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Act Qty</strong></th>
            <th scope="col" class=" bg-dark text-white border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Act Cost</strong></th>
            <th scope="col" class=" bg-dark text-white  border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Varience</strong></th>
      
            
            <?php 
             $HeadStartWeek  = Carbon::create($HeadStartWeek)->addWeek()->format('Y-m-d');
             
             } ?>
          
          </tr>
              
            
      </thead>
      <tbody>
	
		  
   
          
          @foreach($Roles as $Role)
          
          <?php 
          
          $BodyStartWeek = $TenderStart;
            $Bodyi = 1; 
          
          ?>
        <tr>
          <th scope="row" class="fixed-side text-primary border-bottom-0 border-top-0 border-left-0 border-right border-light stuck"><span class="updateField" data-id="{{$Role->ID}}" data-field='Role' contenteditable="true">{{$Role->Role}}</span></th>
          <th scope="row" class="fixed-side text-primary border-bottom-0 border-top-0 border-left-0 border-right border-light stuck"><span class="updateField"  contenteditable="true" data-id="{{$Role->ID}}" data-field='Week'>{{$Role->Week}}</span></th>
          <th scope="row" class="fixed-side text-primary border-bottom-0 border-top-0 border-left-0 border-right border-light stuck"><span class="updateField"  contenteditable="true" data-id="{{$Role->ID}}" data-field='Percentage'>{{$Role->Percentage}}</span>%</th>
          <th scope="row" class="fixed-side text-primary border-bottom-0 border-top-0 border-left-0 border-right border-light stuck">£<span class="updateField"  contenteditable="true" data-id="{{$Role->ID}}" data-field='Rate'>{{$Role->Rate}}</span></th>
          <th scope="row" class="fixed-side text-primary border-bottom-0 border-top-0 border-left-0 border-right border-light stuck"><span id="RefreshField{{$Role->ID}}">£{{$Role->Est_Cost}}</span></th>
            
           <?php
             while(strtotime($BodyStartWeek) <= strtotime($TenderEnd)){
                
                $Contacts = DB::table('UKHT_Acquisition_Time_Contacts')->where('Role_ID',$Role->ID)->whereRaw('\''.carbon::parse($BodyStartWeek)->format('Y-m-d').'\' between Date_From and Date_To')->pluck('Contact_ID');
                
                $TimeBasic = DB::table('Timesheet_Item_Time')->join('Timesheet_Item','Timesheet_Item_Time.Timesheet_Item_ID', 'Timesheet_Item.Timesheet_Item_ID')->join('Timesheet','Timesheet_Item.Timesheet_ID', 'Timesheet.Timesheet_ID')->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID', 'Timesheet.Timesheet_Period_ID')->where(['Entity_Identifier' => $_GET['code']])->whereIn('Contact_ID',$Contacts)->whereRaw("'".carbon::create($BodyStartWeek)."' between Date_From and Date_To")->sum('Time_Basic'); 
                 
                 $Est = floatval(number_format(DB::table('UKHT_Acquisition_Time_Weekly_Est')->where(['Entity_ID' => request('code'), 'Role_ID' => $Role->ID])->whereRaw('\''.carbon::parse($BodyStartWeek)->format('Y-m-d').'\' between Date_From and Date_To')->first()->EST_QTY ?? '0',2)) ;
            ?>
            
           
       
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-light editEst" data-week="{{$BodyStartWeek}}" data-id="{{$Role->ID}}" data-code="{{request('code')}}" style="width: {{$col3}}% !important" contenteditable="true">{{$Est}}</td>
			<td  tabindex="0"  class="border-bottom-0 border-top-0 border-left-0 border-right border-light" style="width: {{$col3}}% !important" role="button" data-toggle="modal" data-target="#userBreakdown" title="Users"
  data-content="<table class='table-striped table-bordered m-0 w-100'>
				<tbody>
				@foreach($Contacts as $Contact)
				@php  $CTimeBasic = DB::table('Timesheet_Item_Time')->join('Timesheet_Item','Timesheet_Item_Time.Timesheet_Item_ID', 'Timesheet_Item.Timesheet_Item_ID')->join('Timesheet','Timesheet_Item.Timesheet_ID', 'Timesheet.Timesheet_ID')->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID', 'Timesheet.Timesheet_Period_ID')->where(['Entity_Identifier' => $_GET['code'], 'Contact_ID' => $Contact])->whereRaw("'".carbon::create($BodyStartWeek)."' between Date_From and Date_To")->sum('Time_Basic');
				@endphp
				<tr> <td class='p-2'>{{DB::table('Contact')->where('Contact_ID',$Contact)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$Contact)->first()->Surname}}</td> <td  class='p-2'>{{round($CTimeBasic/$FullWeek,1)}}</td> <td class='p-2'><div class='btn btn-sm deleteUserFromWeek' onclick='deleteUserFromWeek({{$Contact}},{{'"'.$BodyStartWeek.'"'}},{{$Role->ID}})' ><i class='fad fa-trash'></i> Delete </div></td></tr>
				@endforeach
				</tbody>
				</table>
				"><small><i class="fad fa-sm fa-question"></i></small> {{round($TimeBasic/$FullWeek,1)}}</td>
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-light" style="width: {{$col3}}% !important">
			
			£{{number_format(round($TimeBasic/$FullWeek,1) * $Role->Rate,2)}}
			
			</td>
			
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-primary" style="width: {{$col3}}% !important"><span id="refreshVarience{{$Role->ID}}">
			@if($Est * $Role->Rate >= (round($TimeBasic/$FullWeek,1) * $Role->Rate))
				<span class="text-success font-weight-bold">£{{number_format(($Est * $Role->Rate) - (round($TimeBasic/$FullWeek,1) * $Role->Rate),2)}}
					@else
				<span class="text-danger font-weight-bold">-£{{number_format(($Est * $Role->Rate) - (round($TimeBasic/$FullWeek,1) * $Role->Rate *-1),2)}}
					@endif
				
					</span></span>
			</td>
            
         
              <?php 
             $BodyStartWeek  = Carbon::create($BodyStartWeek)->addWeek()->format('Y-m-d');
             
             } ?>
            
        </tr>
       
          @endforeach
          
		    <tr>
          <th scope="row" class="fixed-side text-primary border-bottom border-top border-left-0 border-right-0 border-light stuck"><span class="updateField" data-field='Role' contenteditable="true">Extra Costs</span></th> 
			<th scope="row" class="fixed-side text-primary border-bottom border-top border-left-0 border-right-0 border-light stuck"><span class="updateField" data-field='Role' contenteditable="true"></span></th>
			<th scope="row" class="fixed-side text-primary border-bottom border-top border-left-0 border-right-0 border-light stuck"><span class="updateField"  data-field='Role' contenteditable="true"></span></th>
			<th scope="row" class="fixed-side text-primary border-bottom border-top border-left-0 border-right border-light stuck"><span class="updateField" data-field='Role' contenteditable="true"></span></th>
          <th scope="row" class="fixed-side text-primary border-bottom-0 border-top-0 border-left-0 border-right border-light stuck"><span >£<input id="EstExtraTotal" value="{{number_format(DB::table('UKHT_Acquisition_Time_Extra')->where('Entity',request('code'))->first()->Est_Cost ?? '0.00',2)}}"  size="" style="width:100% !important " class="border-0 bg-transparent editExtraTotal"  data-code="{{request('code')}}"  type="text"></span></th>
            
  
            @foreach(DB::table('UKHT_Acquisition_Time_Extra_Results')->where('Entity',request('code'))->orderby('Date_From','asc')->get() as $ExtraRow)
                
    
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-light"  style="width: {{$col3}}% !important">Estimated Cost:</td>
			<td  tabindex="0"  class="border-bottom-0 border-top-0 border-left-0 border-right border-light " style="width: {{$col3}}% !important" >£ <input value="{{number_Format($ExtraRow->Estimated_Cost,2)}}"  size="" style="width:100% !important "  class="border-0 bg-transparent editExtraEst" data-week="{{$ExtraRow->Date_From}}" data-id="{{$ExtraRow->id}}" data-code="{{request('code')}}"  type="text"></td>
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-light" style="width: {{$col3}}% !important">
			
			£<input  value="{{number_Format($ExtraRow->Actual_Cost,2)}}"  size="" style="width:100% !important " class="border-0 bg-transparent editExtraAct" data-week="{{$ExtraRow->Date_From}}" data-id="{{$ExtraRow->id}}" data-code="{{request('code')}}"  type="text">
			
			</td>
			
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-primary" style="width: {{$col3}}% !important">
			
				@if($ExtraRow->Estimated_Cost >= $ExtraRow->Actual_Cost)
				<span class="text-success font-weight-bold">£{{number_format(($ExtraRow->Variance),2)}}</span>
					@else
				<span class="text-danger font-weight-bold">-£{{number_format(number_format(($ExtraRow->Variance),2) *-1,2)}}</span>
					@endif
				
			</td>
            
				@endforeach
         
            
        </tr>
		  
		  
		  
          
      </tbody>
  
    </table>
            
            
        </div>
</div>  
          
     

        

   
         </div>

<div class="modal fade right" id="userBreakdown" tabindex="-1" role="dialog" aria-labelledby="userBreakdownLabel" aria-hidden="true">
  <div class="modal-dialog modal-full-height modal-right" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userBreakdownLabel">Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        ...
      </div>

    </div>
	</div></div>


        <div class="modal fade UnplannedModal"  tabindex="-1" role="dialog" aria-labelledby="UnplannedModal"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-full-width ">
    <div class="modal-content-full-width modal-content w-100 h-100" style="overflow: scroll">
            
    <table class="table text-nowrap table-striped table-hover" style="overflow: scroll" id="UnplannedData">
      <thead>
        <tr>
          <th     style="max-width: 500px  !important; min-width: 500px  !important"  class="fixed-side  grey lighten-4  snapto border-0"><h5 class="text-primary">    <button type="button" class="close "  data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>Unplanned / Unassigned Time</h5></th>
          
            <?php
            
            $Acqu = db::Table('UKHT_Acquisition')->where('Entity_ID',$_GET['code'])->first(); 
            
            if(!isset($_GET['pqq'])){
                $TenderStart = $Acqu->Tender_Start;
            $TenderEnd = $Acqu->Tender_Submit;
            }else{
                if($_GET['pqq'] === 'true'){
                $TenderStart = $Acqu->PQQ_Start;
            $TenderEnd = $Acqu->PQQ_Submit;
            }else{
                  $TenderStart = $Acqu->Tender_Start;
            $TenderEnd = $Acqu->Tender_Submit;  
                }
            }
            
            $StartWeek = $TenderStart;
            $i = 1;    
            
            $HeadStartWeek = $TenderStart;
            $Headi = 1;   
            
            
            
             while(strtotime($StartWeek) <= strtotime($TenderEnd)){
                 
            ?>
            
           
            
            
            
            <th scope="col" colspan="3" class=" text-primary snapto border-bottom-0 border-top-0 border-left-0 border-right border-primary" style="min-width: 500px; font-size: 80%"><strong>Week {{$i++}} ({{Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString()}})</strong></th>
      
            
            <?php 
             $StartWeek  = Carbon::create($StartWeek)->addWeek()->format('Y-m-d');
             
             } ?>
     
 
        </tr>
          
          <tr>
          <th class=" grey darken-3 text-white fixed-side  border-0">User</th>
          
              
              <?php
             while(strtotime($HeadStartWeek) <= strtotime($TenderEnd)){
                 
            ?>
            
           
            
            
            <th scope="col" class=" bg-dark text-white border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Hours</strong></th>
            <th scope="col" class=" bg-dark text-white border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Week</strong></th>
            <th scope="col" class=" bg-dark text-white  border-bottom-0 border-top-0 border-left-0 border-right border-white"><strong>Action</strong></th>
      
            
            <?php 
             $HeadStartWeek  = Carbon::create($HeadStartWeek)->addWeek()->format('Y-m-d');
             
             } ?>
          
          </tr>
      </thead>
      <tbody>
          
          <?php 
          
          $aUsers = DB::table('Timesheet_Item')->join('Timesheet','Timesheet_Item.Timesheet_ID', 'Timesheet.Timesheet_ID')->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID', 'Timesheet.Timesheet_Period_ID')->where(['Entity_Identifier' => $_GET['code'],['Date_From','>',carbon::create($TenderStart)->toFormattedDateString()]])->select('Contact_ID');
		 
		  $bUsers = DB::table('Entity_Contacts')->where(['Entity_Identifier' => request('code')],['Entity_Class_ID' => 4])->select('Contact_ID')
			  ->union($aUsers)
			  ->pluck('Contact_ID');

		  $Users = DB::table('Contact')->whereIn('Contact_ID',$bUsers)->where('Organisation_ID', '<' ,0)->whereNull('Superceded_By_Date')->where('Contact_ID','!=',8670)->get();
          ?>
          
          @foreach($Users as $User)
          
          <?php 
          
          $BodyStartWeek = $TenderStart;
            $Bodyi = 1; 
          
          ?>
        <tr>
          <th scope="row" class="fixed-side text-primary border-0"><div class="d-flex justify-content-between"><span><a class="btn border-0 p-0 z-depth-0 waves-effect m-0" href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=1&code={{$User->Contact_ID}}" target="_blank"><i class="fad fa-address-card"></i></a> | <div class="btn border-0 p-0 z-depth-0 waves-effect text-nowrap m-0" onClick="BulkassignWeek({{$User->Contact_ID}})"><i class="fad fa-user-tag"></i> Bulk assign to role</div></span><span style="min-width: 50px"></span> <span>{{db::table('Contact')->where('Contact_ID',$User->Contact_ID)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$User->Contact_ID)->first()->Surname}}</span></div></th>
            
           <?php
             while(strtotime($BodyStartWeek) <= strtotime($TenderEnd)){
                
                $TimeBasic = DB::table('Timesheet_Item_Time')->join('Timesheet_Item','Timesheet_Item_Time.Timesheet_Item_ID', 'Timesheet_Item.Timesheet_Item_ID')->join('Timesheet','Timesheet_Item.Timesheet_ID', 'Timesheet.Timesheet_ID')->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID', 'Timesheet.Timesheet_Period_ID')->where(['Entity_Identifier' => $_GET['code'], 'Contact_ID' => $User->Contact_ID])->whereRaw("'".carbon::create($BodyStartWeek)."' between Date_From and Date_To")->sum('Time_Basic');
                
                 
                 
                 
            ?>
            
            @if(($TimeBasic) == 0)
            
            <td class="text-muted text-center  border-bottom-0 border-top-0 border-left-0 border-right border-primary" colspan="3">No Time Allocated</td>
            
            @else
			
			@if(DB::table('UKHT_Acquisition_Time_Contacts')->where('Contact_ID',$User->Contact_ID)->whereRaw('\''.carbon::parse($BodyStartWeek)->format('Y-m-d').'\' between Date_From and Date_To')->exists())
			
			<td class="text-muted text-center  border-bottom-0 border-top-0 border-left-0 border-right border-success bg-success" colspan="3">Time Allocated</td>
			
			@else
			
       <td class="border-bottom-0 border-top-0 border-left-0 border-right border-light" style="width: {{$col3}}% !important">{{round($TimeBasic,2)}}</td>
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-light" style="width: {{$col3}}% !important">{{round($TimeBasic/$FullWeek,1)}}</td>
			<td class="border-bottom-0 border-top-0 border-left-0 border-right border-primary" style="width: {{$col3}}% !important"><div class="btn border-0 p-0 z-depth-0 waves-effect text-nowrap m-0" data-id="{{$User->Contact_ID}}" data-week="{{$BodyStartWeek}}" onClick="assignWeek({{$User->Contact_ID}},'{{$BodyStartWeek}}')"><i class="fad fa-user-tag"></i> Assign</div></td>
            
            @endif
            @endif
              <?php 
             $BodyStartWeek  = Carbon::create($BodyStartWeek)->addWeek()->format('Y-m-d');
             
             } ?>
            
        </tr>
       
          @endforeach
          
      </tbody>
  
    </table> 

    
</div>
    </div>
  </div>




		<div class="modal fade top" id="PleaseWait" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true" data-backdrop="true">
  <div class="modal-dialog rounded modal-dialog-centered modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Body-->
      <div class="modal-body">
        <div class="row d-flex justify-content-center align-items-center">

          <p class="pt-3 pr-2">Please wait . . . <i class="fad fa-hourglass fa-spin"></i></p>

      
        </div>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>


<script>
$(document).ready(function() {

	

	$('#userBreakdown').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var body = button.data('content') // Extract info from data-* attributes
// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).

var modal = $(this)
modal.find('.modal-body').html(body)
});
	
	
	
      $('.card-body').on('scroll', function() {
            console.log($(this).scrollLeft())
            console.log($(this).width())
    $('.card-body').scrollLeft($(this).scrollLeft());
  });
    
    

    
    $('#PQQ').on('click', function(){
        
       var url = window.location.href;
        console.log(url)
 
         var ec = getQueryVariable(url, 'ec');
  var code = getQueryVariable(url, 'code');
  var pqq = getQueryVariable(url, 'pqq');
   
         var params = { 'code':{{$_GET['code']}},'ec':ec,  'pqq':'true' };
  var new_url = 'https://themis.ukht.org/XWeb/ICT_Portal/public/ACQ/Time?' + $.param(params);
     

        location.href = new_url
        
        })
    
    
        $('#Tender').on('click', function(){
        
       var url = window.location.href;
        console.log(url)
 
         var ec = getQueryVariable(url, 'ec');
  var code = getQueryVariable(url, 'code');
  var pqq = getQueryVariable(url, 'pqq');
   
         var params = { 'code':{{$_GET['code']}},'ec':ec,  'pqq':'false' };
  var new_url = 'https://themis.ukht.org/XWeb/ICT_Portal/public/ACQ/Time?' + $.param(params);
     

        location.href = new_url
        
        })
    
    
     });
    
     function getQueryVariable(url, variable) {
  	 var query = url.substring(0);
     var vars = query.split('&');
     for (var i=0; i<vars.length; i++) {
          var pair = vars[i].split('=');
          if (pair[0] == variable) {
            return pair[1];
          }
     }

     return false;
  }
    
	
	function assignWeek(User,Week){
		<?php $SelectRoles =  DB::table('UKHT_Acquisition_Time_Roles')->where('ACQ_ID',$_GET['code'])->get() 
		?>
		bootbox.prompt({
    title: "Please select a role!",
    inputType: 'select',
    inputOptions: [
		{
        text: 'Choose one...',
        value: '',
    },
		<?php foreach($SelectRoles as $Role){ ?>
    {
        text: '<?php echo $Role->Role ?>',
        value: '<?php echo $Role->ID ?>',
    },
		
		<?php } ?>
    
    ],
    callback: function (result) {
        $.post('OneOffAssign',{Role_ID:result, Contact_ID: User, Week:Week, Entity_ID:{{request('code')}} }).done(function(){
					$('#PleaseWait').modal({
	backdrop: 'static',
	
	});
			$('#TheData').load(window.location.href + ' #TheData');
			$('#UnplannedData').parent('div').load(window.location.href + ' #UnplannedData', function(){
				$('#PleaseWait').modal('hide');
			});
		})
    }
});
		
	}
    
	
	function BulkassignWeek(User){
		

		
		<?php
				$chooseStartWeek = $TenderStart;
			$chooseStartWeeki = 1;
			$chooseEndWeek = $TenderStart;
			$chooseEndWeeki = 1;
			
		$SelectRoles =  DB::table('UKHT_Acquisition_Time_Roles')->where('ACQ_ID',$_GET['code'])->get() 
		?>
		bootbox.prompt({
    title: "Please select a role!",
    inputType: 'select',
    inputOptions: [
		{
        text: 'Choose one...',
        value: '',
    },
		<?php foreach($SelectRoles as $Role){ ?>
    {
        text: '<?php echo $Role->Role ?>',
        value: '<?php echo $Role->ID ?>',
    },
		
		<?php } ?>
    
    ],
    callback: function (role) {
		
		if(role){
		
       
			bootbox.prompt({
    title: "Please select start week.",
    inputType: 'select',
    inputOptions: [
		{
        text: 'Choose one...',
        value: '',
    },
		<?php echo $dateArray ?>
    
    ],
    callback: function (start) {
		
		if(start){
		
      
			bootbox.prompt({
    title: "Please select end week.",
    inputType: 'select',
    inputOptions: [
		{
        text: 'Choose one...',
        value: '',
    },
		<?php echo $dateArray ?>
    
    ],
    callback: function (end) {
		
		if(end){
		
        $.post('BulkAssign',{Role_ID:role, End:end, Start:start, Contact_ID: User, Entity_ID:{{request('code')}} }).done(function(){
			$('#PleaseWait').modal({
	backdrop: 'static',
	
	});
			$('#TheData').load(window.location.href + ' #TheData');
			$('#UnplannedData').load(window.location.href + ' #UnplannedData', function(){
				$('#PleaseWait').modal('hide');
			});
			
		})
		}
    }
});
		}
    }
});
			
		}
    }
});
		
	}
    
	
	$('#addRole').on('click', function(){
		
	var Role = 	prompt('Enter a Role Name');
		
		$.post('ACQAddRole',{ACQ_ID: {{request('code')}}, Role:Role}).done(function(){
			console.log('Added '+Role)
			pleasewait();
location.reload();
		})
		
		
	})
	

	function deleteUserFromWeek(Contact_ID,Week,Role_ID){
		
		$.post('deleteUserFromWeek',{Entity_ID: {{request('code')}}, Contact_ID:Contact_ID, Week:Week, Role_ID:Role_ID}).done(function(){
		    pleasewait()
			location.reload()
		})
		
		
	}
    
	
		
	$('.updateField').keyup(function(){
		
		var val = $(this).text(); 
		var ID = $(this).data('id');
		var Field = $(this).data('field');
		$.post('UpdateACQTimeRole',{ID:ID, Field:Field, Val:val}).done(
		function(){
			console.log("Updated Field with: "+val)
			//$('#RefreshField'+ID).load(window.location.href + ' #RefreshField'+ID );
			// $('#RefreshTotals').load(window.location.href + ' #RefreshTotals');
		})
	})		
	
	$('.editEst').keyup(function(){
		
		var val = $(this).text(); 
		var ID = $(this).data('id');
		var Week = $(this).data('week');
		var Code = $(this).data('code');
		$.post('editWeeklyEst',{ID:ID, Week:Week, Val:val, Code:Code}).done(
		function(){
			console.log("Updated Field with: "+val)
		})
	})	
	
	
	$('#EstExtraTotal').keyup(function(){
		
		var val = $(this).val(); 
		var Code = $(this).data('code');
		$.post('editExtraEst',{Val:val, Code:Code}).done(
		function(){
			console.log("Updated Field with: "+val)
		})
	})
	
	$('.editExtraEst').keyup(function(){
		
		var val = $(this).val(); 
		var ID = $(this).data('id');
		var Week = $(this).data('week');
		var Code = $(this).data('code');
		$.post('editWeeklyExtraEst',{ID:ID, Week:Week, Val:val, Code:Code}).done(
		function(){
			console.log("Updated Field with: "+val)
		})
	})
	$('.editExtraAct').keyup(function(){
		
		var val = $(this).val(); 
		var ID = $(this).data('id');
		var Week = $(this).data('week');
		var Code = $(this).data('code');
		$.post('editWeeklyExtraActual',{ID:ID, Week:Week, Val:val, Code:Code}).done(
		function(){
			console.log("Updated Field with: "+val)
		})
	})

		
	function pleasewait(){
		$('#PleaseWait').modal({
	backdrop: 'static',
	
	});
		
		location.reload();
		
	}


</script>


@stop
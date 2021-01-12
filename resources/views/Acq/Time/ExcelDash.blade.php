
<?php 
use Carbon\Carbon; 
$col3 = 100/3;
$col4 = 100/4;
$FullWeek = 37.5;
setlocale(LC_MONETARY,"en_GB");
       
          
          $Roles = DB::table('UKHT_Acquisition_Time_Roles')->where('ACQ_ID',$_GET['code'])->get();
          
          ?>

  
		  <?php 
		  
		  $Variance = DB::table('UKHT_Acquisition_Time_Weekly_Results')->where([['Date_From','<=', Carbon::now()->startOfWeek(Carbon::MONDAY)],'Entity' => request('code')])->select(DB::raw('SUM(Varience) as Varience'))->first()->Varience; 
		  
		 
		  DB::Table('UKHT_Acquisition_Time_Extra')->updateOrInsert(['Entity' => request('code')],['Entity' => request('code')]);
		  
		  $Extra=DB::Table('UKHT_Acquisition_Time_Extra')->where(['Entity' => request('code')])->first()->Est_Cost;
		  
		  
		   $TVariance =  ($Roles->sum('Est_Cost')+$Extra) - DB::table('UKHT_Acquisition_Time_Weekly_Results')->where(['Entity' => request('code')])->select(DB::raw('SUM(Actual_Costs) as Actual_Costs'))->first()->Actual_Costs;
		  
		  
		  ?>
		  
	
        
        <table>
			<tbody>
			<tr>
				<th colspan="6" rowspan="2" style="font-weight: bolder; font-size: 18px; text-align: center; background-color: #024a94; color: #ffffff">{{DB::table('Enquiry')->where('Enquiry_ID',request('code'))->first()->Name}}</th>
				<th colspan="20" rowspan="2" style="background-color: #E8585A; color: aliceblue" align="center" valign="middle"><strong> Please Note:</strong> This is an estimation tool and should not be used for Actual Cost reporting. Speak to Finance for Actual Costs.</th>
			</tr>
			<tr>
				<th colspan="6" style="background-color: #BECBD9 "><strong>Total Costs</strong></th>
			</tr>
			
			
		
			
			<tr>
				<td style="white-space: nowrap">Estimated</td><td style=" text-align: right"> £{{number_format($Roles->sum('Est_Cost')+$Extra)}}</td>
				<td>Actual</td><td style=" text-align: right">  £<?php echo number_format(DB::table('UKHT_Acquisition_Time_Weekly_Results')->where(['Entity' => request('code')])->select(DB::raw('SUM(Actual_Costs) as ACT'))->first()->ACT) ?></td>
				<td>Variance</td>
				@if($TVariance >= 0)
									<td style="color: #39D033; font-weight: bold; text-align: right">£{{number_format($TVariance)}}</td>
								 @else
								  
				<td  style="color: #C32729; font-weight: bold; text-align: right">-£{{number_format($TVariance*-1)}}	   </td>
								 @endif
					
				</tr>
				<tr>
				<th colspan="6" style="background-color: #BECBD9 "><strong>Accumulated Totals for {{Carbon::now()->startOfWeek(Carbon::MONDAY)->toFormattedDateString()}}</strong></th>
			</tr>
			
			<tr>
			
				<td>Estimated</td><td style=" text-align: right"> £<?php echo number_format(DB::table('UKHT_Acquisition_Time_Weekly_Results')->where([['Date_From','<=', Carbon::now()->startOfWeek(Carbon::MONDAY)],'Entity' => request('code')])->select(DB::raw('SUM(Estimated_Costs) as EST'))->first()->EST) ?></td>
				<td>Actual</td><td style=" text-align: right">  £<?php echo number_format(DB::table('UKHT_Acquisition_Time_Weekly_Results')->where([['Date_From','<=', Carbon::now()->startOfWeek(Carbon::MONDAY)],'Entity' => request('code')])->select(DB::raw('SUM(Actual_Costs) as ACT'))->first()->ACT) ?></td>
				<td>Variance</td>@if($Variance < 0)
									<td  style="color: #C32729; font-weight: bold;  text-align: right">-£{{number_format($Variance*-1)}}	   </td>
								 @else
								  <td style="color: #39D033; font-weight: bold;  text-align: right">£{{number_format($Variance)}}</td>
								 @endif
							
				
				</tr>

</tbody>
			
			</table>
     
                <table class="table text-nowrap table-striped table-hover Content">
      <thead>
		  
		  
   
        <tr>
          <th colspan="6" style="color: #ffffff; font-weight: bold; background-color: #024a94; border-right: 2px double #000000">Planned Time </th>
          
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
            
           
            
            
            
            <th scope="col" colspan="4"  style="color: #ffffff; font-weight: bold; background-color: #024a94; border-right: 4px solid #000000"><strong>Week {{$i++}} ({{Carbon::create($StartWeek)->startOfWeek(Carbon::MONDAY)->toFormattedDateString()}})</strong></th>
      
            
            <?php 
             $StartWeek  = Carbon::create($StartWeek)->addWeek()->format('Y-m-d');
             
             } 
			
			  
			  DB::table('UKHT_Acquisition_Time_Extra_Results')->whereNotIn('Date_From',$fromArray)->delete();
			  DB::table('UKHT_Acquisition_Time_Weekly_Results')->whereNotIn('Date_From',$fromArray)->delete();
			
			
			
			?>
     
 
        </tr>
          
          <tr>
          <th colspan="2" style="color: #000000; font-weight: bold; background-color: #87C1FD">Role</th>
          <th style="color: #000000; font-weight: bold; background-color: #87C1FD">Weeks</th>
          <th style="color: #000000; font-weight: bold; background-color: #87C1FD">%</th>
          <th style="color: #000000; font-weight: bold; background-color: #87C1FD">Rate</th>
          <th style="color: #000000; font-weight: bold; background-color: #87C1FD; border-right: 2px double black">Est. Cost</th>
          
              
              <?php
             while(strtotime($HeadStartWeek) <= strtotime($TenderEnd)){
              
				 
				 
            ?>
             
           
            
            
            <th style="color: #000000; font-weight: bold; background-color: #87C1FD;"><strong>Est Qty</strong></th>
            <th style="color: #000000; font-weight: bold; background-color: #87C1FD;"><strong>Act Qty</strong></th>
            <th style="color: #000000; font-weight: bold; background-color: #87C1FD;"><strong>Act Cost</strong></th>
            <th style="color: #000000; font-weight: bold; background-color: #87C1FD; border-right: 4px solid black"><strong>Varience</strong></th>
      
            
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
          <th colspan="2">{{$Role->Role}}</th>
          <th>{{$Role->Week}}</th>
          <th>{{$Role->Percentage}}%</th>
          <th >{{$Role->Rate}}</th>
          <th style="border-right: 2px double black; text-align: right">£{{number_format($Role->Est_Cost,2)}}</th>
            
           <?php
             while(strtotime($BodyStartWeek) <= strtotime($TenderEnd)){
                
                $Contacts = DB::table('UKHT_Acquisition_Time_Contacts')->where('Role_ID',$Role->ID)->whereRaw('\''.carbon::parse($BodyStartWeek)->format('Y-m-d').'\' between Date_From and Date_To')->pluck('Contact_ID');
                
                $TimeBasic = DB::table('Timesheet_Item_Time')->join('Timesheet_Item','Timesheet_Item_Time.Timesheet_Item_ID', 'Timesheet_Item.Timesheet_Item_ID')->join('Timesheet','Timesheet_Item.Timesheet_ID', 'Timesheet.Timesheet_ID')->join('Timesheet_Period','Timesheet_Period.Timesheet_Period_ID', 'Timesheet.Timesheet_Period_ID')->where(['Entity_Identifier' => $_GET['code']])->whereIn('Contact_ID',$Contacts)->whereRaw("'".carbon::create($BodyStartWeek)."' between Date_From and Date_To")->sum('Time_Basic'); 
                 
                 $Est = floatval(number_format(DB::table('UKHT_Acquisition_Time_Weekly_Est')->where(['Entity_ID' => request('code'), 'Role_ID' => $Role->ID])->whereRaw('\''.carbon::parse($BodyStartWeek)->format('Y-m-d').'\' between Date_From and Date_To')->first()->EST_QTY ?? '0',2)) ;
            ?>
            
           
       
			<td>{{$Est}}</td>
			<td> {{round($TimeBasic/$FullWeek,1)}}</td>
			<td style="text-align: right">
			
			£{{number_format(round($TimeBasic/$FullWeek,1) * $Role->Rate,2)}}
			
			</td>
			
	
			@if($Est * $Role->Rate >= (round($TimeBasic/$FullWeek,1) * $Role->Rate))
				<td style="color: #39D033; font-weight: bold; border-right: 4px solid #000000;  text-align: right">£{{number_format(($Est * $Role->Rate) - (round($TimeBasic/$FullWeek,1) * $Role->Rate),2)}}</td>
					@else
				<td style="color: #C32729; font-weight: bold; border-right: 4px solid #000000; text-align: right">-£{{number_format(($Est * $Role->Rate) - (round($TimeBasic/$FullWeek,1) * $Role->Rate *-1),2)}}</td>
					@endif
				
				
		
            
         
              <?php 
             $BodyStartWeek  = Carbon::create($BodyStartWeek)->addWeek()->format('Y-m-d');
             
             } ?>
            
        </tr>
       
          @endforeach
          
		    <tr>
          <th  colspan="5">Extra Costs</th> 
			
          <th  style="border-right: 2px double black; text-align: right">£{{number_format(DB::table('UKHT_Acquisition_Time_Extra')->where('Entity',request('code'))->first()->Est_Cost ?? '0.00',2)}}</th>
            
  
            @foreach(DB::table('UKHT_Acquisition_Time_Extra_Results')->where('Entity',request('code'))->orderby('Date_From','asc')->get() as $ExtraRow)
                
    
			<td>Estimated Cost</td>
			<td style=" text-align: right">£ {{number_Format($ExtraRow->Estimated_Cost,2)}}</td>
			<td style=" text-align: right">
			
			£{{number_Format($ExtraRow->Actual_Cost,2)}}
			
			</td>
			
		
			
				@if($ExtraRow->Estimated_Cost >= $ExtraRow->Actual_Cost)
				<td style="color: #39D033; font-weight: bold; border-right: 4px solid #000000; text-align: right">£{{number_format(($ExtraRow->Variance),2)}}	</td>
					@else
				<td style="color: #C32729; font-weight: bold; border-right: 4px solid #000000; text-align: right">-£{{number_format(number_format(($ExtraRow->Variance),2) *-1,2)}}	</td>
					@endif
				
		
            
				@endforeach
         
            
        </tr>
		  
		  
		  
          
      </tbody>
  
    </table>
            
            






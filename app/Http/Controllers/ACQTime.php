<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ACQTime extends Controller
{
    //
	
	public function UpdateACQTimeRole(Request $request){
		$Field = $request->Field ;
		$Query = DB::table('UKHT_Acquisition_Time_Roles')->where('ID',$request->ID)->update([ $Field => $request->Val]);
		if($Query)
			return response('Success', 200);
			else
			return response('Error', 404);
		
	}
	
	public function ACQAddRole(Request $request){
		$Query = DB::table('UKHT_Acquisition_Time_Roles')->Insert([ 'ACQ_ID' => $request->ACQ_ID, 'Role' => $request->Role]);
		if($Query)
			return response('Success', 200);
			else
			return response('Error', 404);
	}
	
	public function OneOffAssign(Request $request){
		
		
		$Date_From =  Carbon::parse($request->Week)->startOfWeek(); 
		$Date_To =  Carbon::parse($request->Week)->endOfWeek(); 
		
		DB::table('UKHT_Acquisition_Time_Contacts')->insert([
			'Role_ID' => $request->Role_ID,
			'Contact_ID' => $request->Contact_ID,
			'Date_From' => $Date_From,
			'Date_To' => $Date_To,
			'Entity_ID' => $request->Entity_ID
		]) ;
		
	}	
	
	public function BulkAssign(Request $request){
		
		
		$Date_From =  Carbon::parse($request->Start)->startOfWeek(); 
		$Date_To =  Carbon::parse($request->End)->endOfWeek(); 
		
		DB::table('UKHT_Acquisition_Time_Contacts')->insert([
			'Role_ID' => $request->Role_ID,
			'Contact_ID' => $request->Contact_ID,
			'Date_From' => $Date_From,
			'Date_To' => $Date_To,
			'Entity_ID' => $request->Entity_ID
		]) ;
		
	}	
	public function editWeeklyEst(Request $request){
		
		
		$Date_From =  Carbon::parse($request->Week)->startOfWeek(); 
		$Date_To =  Carbon::parse($request->Week)->endOfWeek(); 
		
		DB::table('UKHT_Acquisition_Time_Weekly_Est')->updateOrInsert([
			'Role_ID' => $request->ID,
			'Date_From' => $Date_From,
			'Date_To' => $Date_To,
			'Entity_ID' => $request->Code
		],['EST_QTY' => $request->Val]) ;
		
	}	
	
	public function editWeeklyExtraEst(Request $request){
		
		
		$Date_From =  Carbon::parse($request->Week)->startOfWeek(); 
		$Date_To =  Carbon::parse($request->Week)->endOfWeek(); 
		
		DB::table('UKHT_Acquisition_Time_Extra_Results')->updateOrInsert([
			'Date_From' => $Date_From,
			'Date_To' => $Date_To,
			'Entity' => $request->Code
		],['Estimated_Cost' => $request->Val]) ;
		
	}
	public function editExtraEst(Request $request){
		
	
		DB::table('UKHT_Acquisition_Time_Extra')->updateOrInsert([
			'Entity' => $request->Code
		],['Est_Cost' => $request->Val]) ;
		
	}
	
	public function editWeeklyExtraActual(Request $request){
		
		
		$Date_From =  Carbon::parse($request->Week)->startOfWeek(); 
		$Date_To =  Carbon::parse($request->Week)->endOfWeek(); 
		
		DB::table('UKHT_Acquisition_Time_Extra_Results')->updateOrInsert([
			'Date_From' => $Date_From,
			'Date_To' => $Date_To,
			'Entity' => $request->Code
		],['Actual_Cost' => $request->Val]) ;
		
	}
	

public function deleteUserFromWeek(Request $request){
		
		
		$Date_From =  Carbon::parse($request->Week)->startOfWeek(); 
		$Date_To =  Carbon::parse($request->Week)->endOfWeek(); 
		
		DB::table('UKHT_Acquisition_Time_Contacts')->where([
			'Role_ID' => $request->Role_ID,
			//'Date_From' => $Date_From,
			//'Date_To' => $Date_To,
			'Entity_ID' => $request->Entity_ID,
			'Contact_ID' => $request->Contact_ID
			
		])->delete() ;
		
	}
}

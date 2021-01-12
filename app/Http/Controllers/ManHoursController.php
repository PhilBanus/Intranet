<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use Storage;
use File;
use Maatwebsite\Excel\Facades\Excel;


class ManHoursController extends Controller
{
    //
	
	public function GETmanhours(Request $request){
		$array = array();
		
		$ManHours = DB::table('UKHT_ManHours_Record')->where(['Location' => $request->ID])->whereBetween('Date',[$request->start,$request->end])->get();
	
		foreach($ManHours as $ManHour){
		array_push($array, 
				   [
					   'id' => 1, 
					   'title' => $ManHour->Sum,
					   'start' => $ManHour->Date,
					   'defaultAllDay' => true,
					   'display' => 'auto',
					   'editable' => false,
					   'editor' => 'Phil',
					   'color' => '#'.$request->color
					   ,'HTUK_Male' => $ManHour->HTUK_Male
      ,'HTUK_Female' => $ManHour->HTUK_Female
      ,'Agency_Male' => $ManHour->Agency_Male
      ,'Agency_Female' => $ManHour->Agency_Female
      ,'Sub_Male' => $ManHour->Sub_Male
      ,'Sub_Female' => $ManHour->Sub_Female
      ,'Visitors' => $ManHour->Visitors
      ,'Delivery' => $ManHour->Delivery
      ,'Input_By' => $ManHour->Input_By
      ,'Input_Date' => $ManHour->Input_Date
      ,'Sum' => $ManHour->Sum
					  ,'HTUK_Male_No' => $ManHour->HTUK_Male_No
					  ,'HTUK_Female_No' => $ManHour->HTUK_Female_No
					  ,'Agency_Male_No' => $ManHour->Agency_Male_No
					  ,'Agency_Female_No' => $ManHour->Agency_Female_No
					  ,'Sub_Male_No' => $ManHour->Sub_Male_No
					  ,'Sub_Female_No' => $ManHour->Sub_Female_No
					  ,'Visitors_No' => $ManHour->Visitors_No
					  ,'Delivery_No' => $ManHour->Delivery_No
					  
						   ]);
		
		}
		
		
		return json_encode($array);
	}
	
	
	public function GetCardData(Request $request){

		
		$ManHour = DB::table('UKHT_ManHours_Record')->where(['Location' => $request->ID])->whereBetween('Date',[$request->Start,$request->End])->get();
		
		$array = array('HTUK_Male' => $ManHour->sum('HTUK_Male')
					  ,'HTUK_Female' => $ManHour->sum('HTUK_Female')
					  ,'Agency_Male' => $ManHour->sum('Agency_Male')
					  ,'Agency_Female' => $ManHour->sum('Agency_Female')
					  ,'Sub_Male' => $ManHour->sum('Sub_Male')
					  ,'Sub_Female' => $ManHour->sum('Sub_Female')
					  ,'Visitors' => $ManHour->sum('Visitors')
					  ,'Delivery' => $ManHour->sum('Delivery')
					  ,'Sum' => $ManHour->sum('Sum')
					  ,'HTUK_Male_No' => $ManHour->sum('HTUK_Male_No')
					  ,'HTUK_Female_No' => $ManHour->sum('HTUK_Female_No')
					  ,'Agency_Male_No' => $ManHour->sum('Agency_Male_No')
					  ,'Agency_Female_No' => $ManHour->sum('Agency_Female_No')
					  ,'Sub_Male_No' => $ManHour->sum('Sub_Male_No')
					  ,'Sub_Female_No' => $ManHour->sum('Sub_Female_No')
					  ,'Visitors_No' => $ManHour->sum('Visitors_No')
					  ,'Delivery_No' => $ManHour->sum('Delivery_No')
					
						   );
		
		
		return $array;
		
	}
	
	public function GlobalGetCardData(Request $request){

		
		$ManHour = DB::table('UKHT_ManHours_Record')->whereBetween('Date',[$request->Start,$request->End])
			->whereIn('Location', (DB::table('UKHT_Locations')->where('Type','Project')->where('Removed',0)->pluck('Linked_Entity')))
			
	->get();
		
		$array = array('HTUK_Male' => $ManHour->sum('HTUK_Male')
					  ,'HTUK_Female' => $ManHour->sum('HTUK_Female')
					  ,'Agency_Male' => $ManHour->sum('Agency_Male')
					  ,'Agency_Female' => $ManHour->sum('Agency_Female')
					  ,'Sub_Male' => $ManHour->sum('Sub_Male')
					  ,'Sub_Female' => $ManHour->sum('Sub_Female')
					  ,'Visitors' => $ManHour->sum('Visitors')
					  ,'Delivery' => $ManHour->sum('Delivery')
					  ,'Sum' => $ManHour->sum('Sum')
					  ,'HTUK_Male_No' => $ManHour->sum('HTUK_Male_No')
					  ,'HTUK_Female_No' => $ManHour->sum('HTUK_Female_No')
					  ,'Agency_Male_No' => $ManHour->sum('Agency_Male_No')
					  ,'Agency_Female_No' => $ManHour->sum('Agency_Female_No')
					  ,'Sub_Male_No' => $ManHour->sum('Sub_Male_No')
					  ,'Sub_Female_No' => $ManHour->sum('Sub_Female_No')
					  ,'Visitors_No' => $ManHour->sum('Visitors_No')
					  ,'Delivery_No' => $ManHour->sum('Delivery_No')
					
						   );
		
		
		return $array;
		
	}
		
	public function GetManHoursDay(Request $request){
		
		
		$ManHour = DB::table('UKHT_ManHours_Record')->where(['Location' => $request->ID, 'Date' => $request->Day])->first();
		
		if($ManHour){
		$array = array('HTUK_Male' => floatval($ManHour->HTUK_Male)
					  ,'HTUK_Female' => floatval($ManHour->HTUK_Female)
					  ,'Agency_Male' => floatval($ManHour->Agency_Male)
					  ,'Agency_Female' => floatval($ManHour->Agency_Female)
					  ,'Sub_Male' => floatval($ManHour->Sub_Male)
					  ,'Sub_Female' => floatval($ManHour->Sub_Female)
					  ,'Visitors' => floatval($ManHour->Visitors)
					  ,'Delivery' => floatval($ManHour->Delivery)
					  ,'Sum' => floatval($ManHour->Sum)
					  ,'HTUK_Male_No' => floatval($ManHour->HTUK_Male_No)
					  ,'HTUK_Female_No' => floatval($ManHour->HTUK_Female_No)
					  ,'Agency_Male_No' => floatval($ManHour->Agency_Male_No)
					  ,'Agency_Female_No' => floatval($ManHour->Agency_Female_No)
					  ,'Sub_Male_No' => floatval($ManHour->Sub_Male_No)
					  ,'Sub_Female_No' => floatval($ManHour->Sub_Female_No)
					  ,'Visitors_No' => floatval($ManHour->Visitors_No)
					  ,'Delivery_No' => floatval($ManHour->Delivery_No)
					
						   );
		}else{
			$array = array('HTUK_Male' => 0
					  ,'HTUK_Female' => 0
					  ,'Agency_Male' => 0
					  ,'Agency_Female' => 0
					  ,'Sub_Male' => 0
					  ,'Sub_Female' => 0
					  ,'Visitors' => 0
					  ,'Delivery' => 0
					  ,'Sum' => 0
					  ,'HTUK_Male_No' => 0
					  ,'HTUK_Female_No' => 0
					  ,'Agency_Male_No' => 0
					  ,'Agency_Female_No' => 0
					  ,'Sub_Male_No' => 0
					  ,'Sub_Female_No' => 0
					  ,'Visitors_No' => 0
					  ,'Delivery_No' => 0
					
						   );
		}
		
		
		return $array;
		
		
	}
	
	public function SaveManHours(Request $request){
		
		DB::table('UKHT_ManHours_Record')->updateOrInsert(
		[ 'Location' => $request->Input_ID, 'Date' => $request->Input_Date_Field ],
		[
			'Agency_Female' => $request->Input_Agency_Female,
			'Agency_Female_No' => $request->Input_Agency_Female_No,
			'Agency_Male' => $request->Input_Agency_Male,
			'Agency_Male_No' => $request->Input_Agency_Male_No,
			'Delivery' => $request->Input_Delivery,
			'Delivery_No' => $request->Input_Delivery_No,
			'HTUK_Female' => $request->Input_HTUK_Female,
			'HTUK_Female_No' => $request->Input_HTUK_Female_No,
			'HTUK_Male' => $request->Input_HTUK_Male,
			'HTUK_Male_No' => $request->Input_HTUK_Male_No,
			'Sub_Female' => $request->Input_Sub_Female,
			'Sub_Female_No' => $request->Input_Sub_Female_No,
			'Sub_Male' => $request->Input_Sub_Male,
			'Sub_Male_No' => $request->Input_Sub_Male_No,
			'Visitors' => $request->Input_Visitors,
			'Visitors_No' => $request->Input_Visitors_No
		]
		); 
		
		return redirect()->back();
		
	}
}

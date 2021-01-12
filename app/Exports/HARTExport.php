<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
 use Carbon\Carbon; 
 use Carbon\CarbonInterface; 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class HARTExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	 use Exportable;
	
	public function filters($request){
		
		if(isset($request->code)){

$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$OccurancesFilt = [];
array_push($OccurancesFilt,array('Site','=',$request->code));

if($request->CloseCalls === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',1));
}
if($request->GoodPractice === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',2));
}
if($request->Incidents === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',3));
}
if($request->Accident === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',4));
}
if($request->Innovation === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',5));
}
if($request->Open === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',1));
}
if($request->Closed === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',0));
}
if($request->Time === 'Week'){
	array_push($OccurancesFilt,array('Date','>=',$lastweekStartDate));
}
if($request->Time === 'Month'){
	array_push($OccurancesFilt,array('Date','>=',$now->subMonth()));
}
if($request->Time === 'Year'){
	array_push($OccurancesFilt,array('Date','>=',$now->subYear()));
}
$DateDiff = 32;
if($request->Time === 'Range'){
		if(isset($request->fromRange)) {
  array_push($OccurancesFilt,array('Date','>',Carbon::createFromFormat('d-m-Y',($request->fromRange))));
		$DateDiff = Carbon::createFromFormat('d-m-Y',($request->fromRange))->diffInDays($now);
}
	
	if(isset($request->toRange)) {
  array_push($OccurancesFilt,array('Date','<',Carbon::createFromFormat('d-m-Y',($request->toRange))));
		$DateDiff = Carbon::createFromFormat('d-m-Y',($request->toRange))->diffInDays($now);
}
	
	if( isset($request->fromRange) && isset($request->toRange) ){
		$DateDiff = Carbon::create($request->fromRange)->diffInDays($request->toRange);
	}
	
}

$Locations = DB::table('UKHT_Occurance_Location')->where([['Site',$request->code],['Removed',0]])->get(); 
	  
  foreach($Locations as $Location){
	  
	  if($request->Location.'_'.$Location->ID === 'false'){
	array_push($OccurancesFilt,array('Location','!=',$Location->Name));
}
	  
  }

}else{
	$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$OccurancesFilt = [];

if($request->CloseCalls === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',1));
}
if($request->GoodPractice === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',2));
}
if($request->Incidents === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',3));
}
if($request->Accident === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',4));
}
if($request->Innovation === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',5));
}
if($request->Open === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',1));
}
if($request->Closed === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',0));
}
if($request->Time === 'Week'){
	array_push($OccurancesFilt,array('Date','>=',$lastweekStartDate));
}
if($request->Time === 'Month'){
	array_push($OccurancesFilt,array('Date','>=',$now->subMonth()));
}
if($request->Time === 'Year'){
	array_push($OccurancesFilt,array('Date','>=',$now->subYear()));
}
$DateDiff = 32;
if($request->Time === 'Range'){
		if(isset($request->fromRange)) {
  array_push($OccurancesFilt,array('Date','>',Carbon::createFromFormat('d-m-Y',$request->fromRange)));
		$DateDiff = Carbon::createFromFormat('d-m-Y',$request->fromRange)->diffInDays($now);
}
	
	if(isset($request->toRange)) {
  array_push($OccurancesFilt,array('Date','<',Carbon::createFromFormat('d-m-Y',$request->toRange)));
		$DateDiff = Carbon::createFromFormat('d-m-Y',$request->toRange)->diffInDays($now);
}
	
	if( isset($request->fromRange) && isset($request->toRange) ){
		$DateDiff = Carbon::create($request->fromRange)->diffInDays($request->toRange);
	}
	
}

if($request->Project_0 === 'false'){
	array_push($OccurancesFilt,array('Site','!=',0));
}



if($request->Project_History === 'false'){
	foreach(DB::table('Project')->whereNotIn('Project_ID',DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->pluck('Linked_entity'))->pluck('Project_ID') as $hisory){
		array_push($OccurancesFilt,array('Site','!=',$hisory));
	}
	
	
}


foreach(DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->get() as $Project){
	
	if($request->Project.'_'.$Project->Linked_Entity === 'false'){
	array_push($OccurancesFilt,array('Site','!=',$Project->Linked_Entity));
}
	
}
}
		
		
		$this->OccurancesFilt = $OccurancesFilt;
		
		 return $this;
	}
	
	
    public function  view() : View
    {
		
		return view('obs.ExcelExportGlobal', [
            'data' => DB::table('UKHT_Occurance_Close_Call')->where($this->OccurancesFilt)->orderby('Reported_Date','desc')->get()
        ]);
         

    }
}

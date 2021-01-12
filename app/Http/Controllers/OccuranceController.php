<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use DB;
use App\Mail\AllocateOccurance;
use App\Mail\ActionOccurance;
use App\Mail\UpdateOccuranceLogger;
use App\Mail\CloseOccurance;
use Carbon\Carbon;
use Storage;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HARTExport;

class OccuranceController extends Controller
{
    //
	
	public function Close(Request $request){
		
	$ID = $request->ID;
	$ROOT = $request->ROOT;
	$SUBROOT = $request->SUBROOT;
		$RIDDOR = $request->RIDDOR;

	
	DB::table('UKHT_Occurance_Close_Call')
		->where('ID',$ID)->update([
		'Root_Cause' => $ROOT,
		'Sub_Root' => $SUBROOT,
		'RIDDOR' => $RIDDOR,
		'Sign_Off' => 1,
		'Closed_Date' => Carbon::now(),
	]);
		
		if($request->Thanks){
		DB::table('UKHT_Occurance_Close_Call')
		->where('ID',$ID)->update(['Thanks' => $request->Thanks]);	
			
			
	}
		
	
	
	
	$Occurance = DB::table('UKHT_Occurance_Close_Call')->where('ID', $ID)->first(); 
	$OccuranceName = DB::table('UKHT_Occurance')->where('ID',$Occurance->Occurance)->first();	
	$Members = DB::table('UKHT_Occurance_Teams')->join('Contact_Email','Contact_ID','Member_ID')->where('Removed',0)->where('Site',$Occurance->Site)->pluck('Email');
	
		Mail::to($Members)->send(new CloseOccurance($request));
		
		if($Occurance->Email)
		{
			Mail::to($Occurance->Email)->send(new UpdateOccuranceLogger($request));
		}
		
		
		$SeniorMembers =  DB::table('Role_Membership')
			->join('Contact','Contact.Contact_ID','Role_Membership.Contact_ID')
			->join('UKHT_Emails','UKHT_Emails.ID','Role_Membership.Contact_ID')
			->where('Role_Membership.User_Role_ID',808)->whereNull('Superceded_By_Date')->pluck('Email');
		
		if($request->Occurance == 3){
			Mail::to($SeniorMembers)->send(new CloseOccurance($request));
		}
		
		if($request->Occurance == 4){
			Mail::to($SeniorMembers)->send(new CloseOccurance($request));
		}
	


	
	
	
	
	
	}
	
	public function Action(Request $request){
	
	$ID = $request->ID;
	$SubYesNo = $request->SubYesNo;
	$Actions = $request->Actions;
	$Subby = $request->Subby;


	
	DB::table('UKHT_Occurance_Close_Call')
		->where('ID',$ID)->update([
		'Contractor_Involved' => $SubYesNo,
		'Contractor_Name' => $Subby,
		'Actions_Taken_HSQE' => base64_encode($Actions),
		'ReAllocated' => 0
	]);
	
	
	$Occurance = DB::table('UKHT_Occurance_Close_Call')->where('ID', $ID)->first(); 
	$OccuranceName = DB::table('UKHT_Occurance')->where('ID',$Occurance->Occurance)->first();	
	
	if($Occurance->Site == 0){
		$SiteName = "Head Office";
		$CCGroup = DB::table('UKHT_Occurance_Teams')->join('Contact_Email','Contact_ID','Member_ID')->where('Removed',0)->where('Site',0)->get();
	
	}else{
		$site = DB::table('Project')->where('Project_ID',$Occurance->Site)->first();
		$SiteName = $site->Name;
	
	}
	
	if(is_numeric($Occurance->Location)){
	$loc = DB::table('UKHT_Occurance_Location')->where('ID',$Occurance->Location)->first();
	$locName =$loc->Name; 
			}else{
				$locName = $Occurance->Location; 
			}
	
	$Members = DB::table('UKHT_Occurance_Teams')->join('Contact_Email','Contact_ID','Member_ID')->where('Removed',0)->where('Site',$Occurance->Site)->get();
	
  
   
	
		foreach($Members as $Member){
		Mail::to($Member->Email)->send(new ActionOccurance($request, $Member->Contact_ID));
		}
	
	return redirect('OccuranceView?id='.$request->ID);
	
	
	}
	
	public function Allocate(Request $request){
		
		
	$ID = $request->ID;
	$INS = $request->INS;
	$ALL = $request->ALL;
	$REM = $request->REM;
	$DEAD = $request->DEAD;

	
	DB::table('UKHT_Occurance_Close_Call')
		->where('ID',$ID)->update([
		'HSQE_Instruction' => $INS,
		'HSQE_Actioner' => $ALL,
		'Reminder_Rate' => $REM,
		'DeadLine' => $DEAD,
		'ReAllocated' => 1
	]);
	
	$Members = DB::table('Contact_Email')->where('Contact_ID',$ALL)->first();
		
		
		
		Mail::to($Members->Email)->send(new AllocateOccurance($request));
			
		
		
	}
	
	public function UploadDocument(Request $request){
		
	//dd($request->all());
	
		if($request->has('documents')){
		if(count($request->file('documents'))>0){
			
			Storage::disk('occurance')->makeDirectory("O".$request->ID.'/');
			
			foreach($request->file('documents') as $document){
			
				move_uploaded_file($document->getPathName(),Storage::disk('occurance')->getDriver()->getAdapter()->applyPathPrefix("O".$request->ID.'/'.$document->getClientOriginalName()));
			
		
			
			}	
			
		}}
		
		if($request->has('photos')){
		if(count($request->file('photos'))>0){
			
			foreach($request->file('photos') as $photo){
				$contents = filerequest_contents($photo->getPathName());
				$base = base64_encode($contents);
				
				
				$FILE = urlencode($base);
				$NAME = urlencode($photo->getClientOriginalName());
				$ID = $request->ID;
	
	DB::table('UKHT_Occurance_Photos')->insert(
	['Occurance_ID' => $ID, 'Photo' => $FILE, 'Name' => $NAME, 'Post' => 1]
	); 
				
			}
		
		}
			
	
			
			
		}
		
		return $this->Action($request);
		
		
		
			
	
		}
		
	
	public function DocDownload(Request $request){
		return Storage::disk('occurance')->download($request->file);
	}
	
	
	public function ReadHistoryPhotos(Request $request){
		$url = urldecode($request->photo);
		$filename = substr($url, strrpos($url, '/') + 1);
		Storage::disk('occurance')->makeDirectory("Old".$request->id.'/');
		File::copy(urldecode($request->photo),Storage::disk('occurance')->getDriver()->getAdapter()->applyPathPrefix("Old".$request->id.'/oldfile.jpg'));
		$contents = readfile(Storage::disk('occurance')->getDriver()->getAdapter()->applyPathPrefix("Old".$request->id.'/oldfile.jpg'));
		$photo = ($contents);
		
			$this->convertPhotos(Storage::disk('occurance')->getDriver()->getAdapter()->applyPathPrefix("Old".$request->id.'/oldfile.jpg'), $request->id);
		
		return $photo;
		
	
	
	}
		
		
	public function convertPhotos($path,$id){
		

		
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = filerequest_contents($path);
$base = 'data:image/' . $type . ';base64,' . base64_encode($data);
				
				$FILE = urlencode($base);
				$NAME = 'Historic Photo';
				$ID = $id;
	
	DB::table('UKHT_Occurance_Photos')->updateORInsert(
	['Occurance_ID' => $ID, 'Photo' => $FILE, 'Name' => $NAME, 'Post' => 0],
	['Occurance_ID' => $ID, 'Photo' => $FILE, 'Name' => $NAME, 'Post' => 0]
	); 
		

		
		
	}
		
	
	public function AddRoot(Request $request){
		$CATEGORY = $request->Name;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Root')->updateOrInsert([
		'Root' => $CATEGORY],['Removed' => $REMOVED]);
		
		
	}
			public function RemoveRoot(Request $request){
		$CATEGORY = $request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Root')->updateOrInsert([
		'ID' => $CATEGORY],['Removed' => $REMOVED]);
		
		
	}	
	
	public function AddCategory(Request $request){
		$CATEGORY = $request->Name;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Categories')->updateOrInsert([
		'Category_Name' => $CATEGORY],['Removed' => $REMOVED]);
		
		
	}
	public function RemoveCategory(Request $request){
		$CATEGORY = $request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Categories')->updateOrInsert([
		'ID' => $CATEGORY],['Removed' => $REMOVED]);
		
		
	}
	
	public function AddSubRoot(Request $request){
		$CATEGORY =$request->Name;
		$ID =$request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Root_Sub')->updateOrInsert([
		'Sub_Name' => $CATEGORY, 'Root_ID' => $ID],['Removed' => $REMOVED]);
	
	
	}
	
	public function RemoveSubRoot(Request $request){
		$CATEGORY = $request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Root_Sub')->updateOrInsert([
		'ID' => $CATEGORY],['Removed' => $REMOVED]);
	
	
	}
	
	public function AddRIDDOR(Request $request){
		$CATEGORY =$request->Name;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_RIDDOR')->updateOrInsert(
		['name' => $CATEGORY],['Removed' => $REMOVED]);
	
	
	}
	
	public function RemoveRIDDOR(Request $request){
		$CATEGORY = $request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_RIDDOR')->updateOrInsert([
		'ID' => $CATEGORY],['Removed' => $REMOVED]);
	
	
	}
	
	public function AddSubCategory(Request $request){
		$CATEGORY =$request->Name;
		$ID =$request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Sub')->updateOrInsert([
		'Sub_Name' => $CATEGORY, 'Category_ID' => $ID],['Removed' => $REMOVED]);
	
	
	}
	
	public function RemoveSubCategory(Request $request){
		$CATEGORY = $request->ID;
		$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Sub')->updateOrInsert([
		'ID' => $CATEGORY],['Removed' => $REMOVED]);
	
	
	}
		
	public function OccuranceUploadPhotos(Request $request){
		$FILE = urlencode($request->file);
	$NAME = urlencode($request->name);
	$ID = $request->LogID;
	
	DB::table('UKHT_Occurance_Photos')->insert(
	['Occurance_ID' => $ID, 'Photo' => $FILE, 'Name' => $NAME, 'Post' => 1]
	); 
	}
	
	
	public function SaveCategory(Request $request){
		$ID = $request->ID;
	$CAT = $request->CAT;
	$SUB = $request->SUB;

	
	DB::table('UKHT_Occurance_Close_Call')
		->where('ID',$ID)->update([
		'Category' => $CAT,
		'Sub' => $SUB,
	]);
		
	}
	
	public function ChangeOCC(Request $request){
		$ID = $request->ID;
	$OCC = $request->OCC;
	
	DB::table('UKHT_Occurance_Close_Call')
		->where('ID',$ID)->update([
		'Occurance' => $OCC
	]);
	
	}
	
	public function Member(Request $request){
		$ID = $request->id; 
$MEMBER = $request->Member;
$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Teams')->updateOrInsert([
		'Member_ID' => $MEMBER, 'Site' => $ID],['Removed' => $REMOVED]);
	
	}
	
	public function Location(Request $request){
		$ID = $request->id; 
$LOCATION = $request->Location;
$REMOVED = $request->Removed;
	
	DB::table('UKHT_Occurance_Location')->updateOrInsert([
		'Name' => $LOCATION, 'Site' => $ID],['Removed' => $REMOVED]);
	
		
	}
	
	public function SecretCategory(Request $request){
		
		$ID = $request->ID;
		$Val = $request->Val;
		if(DB::table('UKHT_Occurance_Close_Call')->where('ID',$ID)->first()->$Val){
					DB::table('UKHT_Occurance_Close_Call')->where('ID',$ID)->update([$Val => False]);
		}else{
				DB::table('UKHT_Occurance_Close_Call')->where('ID',$ID)->update([$Val => True]);	
		}

		
	}
	
	public function SaveSettings(Request $request){
		
		$Contact_ID = session('MY_ID');
		$Entity_ID = $request->Entity;
		$String = $request->String;
		
		DB::Table('UKHT_Occurance_User_Settings')->updateOrInsert(
		['Contact_ID' => $Contact_ID, 'Entity_ID' => $Entity_ID],
		['String' => $String]
		);
		
	}
	
	public function export(Request $request) 
    {
        return (new HARTExport)->filters($request)->download("Occurance_Export" . date('dMYhms') . ".xlsx");
    }
	
	
	public function EditName(Request $request){
	   
		if($request->Table == 'RIDDOR'){
			$Table = 'UKHT_Occurance_RIDDOR';
			$Field = 'name';
			$Col = 'RIDDOR';
			$OldName =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->$Field;
			DB::table('UKHT_Occurance_Close_Call')->where($Col, $OldName)->update([ $Col => $request->Name ]);
			DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->update([ $Field => $request->Name ]);
		
		}
		
		if($request->Table == 'Root_Cause'){
			$Table = 'UKHT_Occurance_Root';
			$Field = 'Root';
			$Col = 'Root_Cause';
			$OldName =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->$Field;
			DB::table('UKHT_Occurance_Close_Call')->where($Col, $OldName)->update([ $Col => $request->Name ]);
			DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->update([ $Field => $request->Name ]);
		
		}
		
		if($request->Table == 'Category'){
			$Table = 'UKHT_Occurance_Categories';
			$Field = 'Category_Name';
			$Col = 'Category';
			$OldName =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->$Field;
			DB::table('UKHT_Occurance_Close_Call')->where($Col, $OldName)->update([ $Col => $request->Name ]);
			DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->update([ $Field => $request->Name ]);
		
		}
		
		if($request->Table == 'Root_Sub'){
			$Table = 'UKHT_Occurance_Root_Sub';
			$Field = 'Sub_Name';
			$Col = 'Sub_Root';
			$OldName =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->$Field;
			$ParentID =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->Root_ID;
			$Parent = DB::table('UKHT_Occurance_Root')->orWhere('ID',$ParentID)->first()->Root;
			
			DB::table('UKHT_Occurance_Close_Call')->where([$Col => $OldName, 'Root_Cause' => $Parent])->update([ $Col => $request->Name ]);
			DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->update([ $Field => $request->Name ]);
		
		}
		
		if($request->Table == 'Sub_Cat'){
			$Table = 'UKHT_Occurance_Sub';
			$Field = 'Sub_Name';
			$Col = 'Sub';
			$OldName =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->$Field;
			$ParentID =  DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->first()->Category_ID;
			$Parent = DB::table('UKHT_Occurance_Categories')->orWhere('ID',$ParentID)->first()->Category_Name;
			
			DB::table('UKHT_Occurance_Close_Call')->where([$Col => $OldName, 'Category' => $Parent])->update([ $Col => $request->Name ]);
			DB::table($Table)->where('id',$request->ID)->orWhere('ID',$request->ID)->update([ $Field => $request->Name ]);
		
		}
		
		
	
		
		
	}
	
		public function DuplicateCheck(Request $request){
			
			$HART = DB::table('UKHT_Occurance_Close_Call')->where('ID', $request->ID )->first();
			$Site = DB::table('Project')->where('Project_ID',$HART->Site)->first();
			$Occurance = DB::table('UKHT_Occurance')->where('ID',$HART->Occurance)->first();
			$Div = "<div class='card mb-2' id='HARTDup_$request->ID' > 
			<div class='card-header text-white'>$Occurance->Name - $Site->Name - $HART->Location </div>
			<div class='card-body'>
			<p><strong>Reported Date Time:</strong> $HART->Reported_Date </p>
			<p><strong>HART Date Time:</strong> $HART->Date </p>
			<p><strong>Details:</strong></p>
			<p>$HART->Details</p>
			</div>
			<div class='card-footer'>
			<div class='btn btn-info btn-small rounded' onClick='viewHART($HART->ID)'>VIEW</div>
			<div class='btn btn-danger btn-small rounded' onClick='deleteHART($HART->ID)'>DELETE</div>
			</div>
			</div>";
			return $Div;
			
		}
	
	
	public function DeleteHART(Request $request){
		
		DB::table('UKHT_Occurance_Close_Call')->where('ID', $request->ID )->delete();
		
		return "you have deleted $request->ID";
	}
		
	
	public function HARTChartData(Request $request){
		
	if(isset($request->code)){
		
		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$OccurancesFilt = [];
array_push($OccurancesFilt,array('Site','=',$_GET['code']));

if($_GET['CloseCalls'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',1));
}
if($_GET['GoodPractice'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',2));
}
if($_GET['Incidents'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',3));
}
if($_GET['Accident'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',4));
}
if($_GET['Innovation'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',5));
}
if($_GET['Open'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',1));
}
if($_GET['Closed'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',0));
}
if($_GET['Time'] === 'Week'){
	array_push($OccurancesFilt,array('Date','>=',$lastweekStartDate));
}
if($_GET['Time'] === 'Month'){
	array_push($OccurancesFilt,array('Date','>=',$now->subMonth()));
}
if($_GET['Time'] === 'Year'){
	array_push($OccurancesFilt,array('Date','>=',$now->subYear()->startOfYear()));
	array_push($OccurancesFilt,array('Date','<',Carbon::now()->startOfYear()));
}
if($_GET['Time'] === 'ThisYear'){
	array_push($OccurancesFilt,array('Date','>=',$now->startOfYear()));
}
$DateDiff = 32;
if($_GET['Time'] === 'Range'){
		if(isset($_GET['fromRange'])) {
  array_push($OccurancesFilt,array('Date','>',Carbon::createFromFormat('d-m-Y',($_GET['fromRange']))));
		$DateDiff = Carbon::createFromFormat('d-m-Y',($_GET['fromRange']))->diffInDays($now);
}
	
	if(isset($_GET['toRange'])) {
  array_push($OccurancesFilt,array('Date','<',Carbon::createFromFormat('d-m-Y',($_GET['toRange']))));
		$DateDiff = Carbon::createFromFormat('d-m-Y',($_GET['toRange']))->diffInDays($now);
}
	
	if( isset($_GET['fromRange']) && isset($_GET['toRange']) ){
		$DateDiff = Carbon::create($_GET['fromRange'])->diffInDays($_GET['toRange']);
	}
	
}

$Locations = DB::table('UKHT_Occurance_Location')->where([['Site',$_GET['code']],['Removed',0]])->get(); 
	  
  foreach($Locations as $Location){
	  
	  if($_GET['Location_'.$Location->ID] === 'false'){
	array_push($OccurancesFilt,array('Location','!=',$Location->Name));
}
	  
  }
	}else{
		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

$now = Carbon::now();
$weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
$weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');

$last = Carbon::now()->subWeek();
$lastweekStartDate = $last->startOfWeek()->format('Y-m-d H:i');
$lastweekEndDate = $last->endOfWeek()->format('Y-m-d H:i');
$OccurancesFilt = [];

if($request['CloseCalls'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',1));
}
if($request['GoodPractice'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',2));
}
if($request['Incidents'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',3));
}
if($request['Accident'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',4));
}
if($request['Innovation'] === 'false'){
	array_push($OccurancesFilt,array('Occurance','!=',5));
}
if($request['Open'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',1));
}
if($request['Closed'] === 'false'){
	array_push($OccurancesFilt,array('Sign_Off','=',0));
}
if($request['Time'] === 'Week'){
	array_push($OccurancesFilt,array('Date','>=',$lastweekStartDate));
}
if($request['Time'] === 'Month'){
	array_push($OccurancesFilt,array('Date','>=',$now->subMonth()));
}
if($request['Time'] === 'Year'){
	array_push($OccurancesFilt,array('Date','>=',$now->subYear()->startOfYear()));
	array_push($OccurancesFilt,array('Date','<',Carbon::now()->startOfYear()));
}
if($request['Time'] === 'ThisYear'){
	array_push($OccurancesFilt,array('Date','>=',$now->startOfYear()));
}
$DateDiff = 32;
if($request['Time'] === 'Range'){
		if(isset($request['fromRange'])) {
  array_push($OccurancesFilt,array('Date','>',Carbon::createFromFormat('d-m-Y',$request['fromRange'])));
		$DateDiff = Carbon::createFromFormat('d-m-Y',$request['fromRange'])->diffInDays($now);
}
	
	if(isset($request['toRange'])) {
  array_push($OccurancesFilt,array('Date','<',Carbon::createFromFormat('d-m-Y',$request['toRange'])));
		$DateDiff = Carbon::createFromFormat('d-m-Y',$request['toRange'])->diffInDays($now);
}
	
	if( isset($request['fromRange']) && isset($request['toRange']) ){
		$DateDiff = Carbon::create($request['fromRange'])->diffInDays($request['toRange']);
	}
	
}

if($request['Project_0'] === 'false'){
	array_push($OccurancesFilt,array('Site','!=',0));
}



if($request['Project_History'] === 'false'){
	foreach(DB::table('Project')->whereNotIn('Project_ID',DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->pluck('Linked_entity'))->pluck('Project_ID') as $hisory){
		array_push($OccurancesFilt,array('Site','!=',$hisory));
	}
	
	
}


foreach(DB::table('UKHT_Locations')->where(['Removed' => 0, 'Type' => 'Project'])->get() as $Project){
	
	if($request['Project_'.$Project->Linked_Entity] === 'false'){
	array_push($OccurancesFilt,array('Site','!=',$Project->Linked_Entity));
}
	
}

	}
		
		
		$subCategories = DB::table('UKHT_Occurance_Close_Call')->where($OccurancesFilt)->where('Occurance' ,1)->where('Category',$request->name)->select('Sub', DB::raw('count(*) as count'))->groupBy('Sub')->orderby('count','desc')->get();
		
		$result = "<table class='table'>";
		foreach($subCategories as $sub){
			
			$result .= "<tr><td><strong>$sub->Sub</strong></td><td> $sub->count </td> </tr>";
			
		}
		
		$result .= "</table>";
		
		return $result; 
		
	}
	
	
	public function updateandgetLocations(Request $request){
		
		if($request->type){ 
		
			DB::table('UKHT_Occurance_Close_Call')->where('ID',$request->id)->update([
				'Site' => $request->site,
				'Location' => $request->location
			]);
			
			
		}
		else{ 	
			
			
		return DB::table('UKHT_Occurance_Location')->where(['Removed' => 0, 'Site' => $request->id])->select('Name as text','Name as value')->get()->toArray();
		}
	}
		
}

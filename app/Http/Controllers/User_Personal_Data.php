<?php

namespace App\Http\Controllers;
use App\Temp_User_Personal_Data;
use Illuminate\Http\Request;
use DB;
use App\Contacts;
use App\Mail\User_PD_Updated;
use Illuminate\Support\Facades\Mail;




class User_Personal_Data extends Controller
{
    //
	public function save(Request $request){
		
		DB::table('UKHT_HR_PD_Stage')->where(['User_ID' => session('MY_ID'),'Approved' => NULL])->update(['Approved' => 0]);
		
		$Title = $request->Title ? $request->Title : NULL; 
		$Forename = $request->Forename ? $request->Forename : NULL;
		$Surname = $request->Surname ? $request->Surname : NULL;
		$Telephone = $request->Telephone ? $request->Telephone : NULL;
		$Mobile = $request->Mobile ? $request->Mobile : NULL;
		$Email = $request->Email ? $request->Email : NULL;
		$Firstline = $request->Firstline ? $request->Firstline : NULL;
		$secondline = $request->secondline ? $request->secondline : NULL;
		$Town = $request->Town ? $request->Town : NULL;
		$Postcode = $request->Postcode ? $request->Postcode : NULL;
		$Emergency_Title = $request->Emergency_Title ? $request->Emergency_Title : NULL;
		$Emergency_Forename = $request->Emergency_Forename ? $request->Emergency_Forename : NULL;
		$Emergency_Surname = $request->Emergency_Surname ? $request->Emergency_Surname : NULL;
		$Emergency_Telephone = $request->Emergency_Telephone ? $request->Emergency_Telephone : NULL;
		$Emergency_Mobile = $request->Emergency_Mobile ? $request->Emergency_Mobile : NULL;
		
		$RequestID = DB::table('UKHT_HR_PD_Stage')
		->insertGetId(
		['Title' => $Title, 'Forename' => $Forename, 'Surname' => $Surname, 'Home_Telephone' => $Telephone, 'Mobile' => $Mobile, 'Email' => $Email, 'Address_Firstline' => $Firstline, 'Address_Secondline' => $secondline, 'Address_Town' => $Town, 'Address_Postcode' => $Postcode, 'Emergency_Title' => $Emergency_Title, 'Emergency_Forename' => $Emergency_Forename, 'Emergency_Surname' => $Emergency_Surname, 'Emergency_Telephone' => $Emergency_Telephone, 'Emergency_Mobile' => $Emergency_Mobile, 'User_ID' => session('MY_ID')]
	);
		
		return $this->Notify($RequestID); 
		
	}
	
	public function Notify($RequestID){
		
		$user = Contacts::where('Contact_ID',session('MY_ID'))->first()->getName();
		$id = $RequestID;
		Mail::to(['HRAdmin@hochtief.co.uk'])->send(new User_PD_Updated($user,$id));
		
		return 'Message Sent';
		return response('success',200)->header('Content-Type', 'text/plain');
		
	}
	
	public function commit(Request $request){
		$approve = $request->approve;
		$ID = $request->encrypted_ID;
		$details = Temp_User_Personal_Data::where('ID', '=', $ID)
					->first();
		
		
		DB::table('Contact')->where('Contact_ID',$details->User_ID)->update(['Title' => $details->Title, 'Forename' => $details->Forename, 'Surname' => $details->Surname ]);
		
		
			\App\User_Personal_Data::updateOrInsert(['Contact_ID'=> $details->User_ID],['H_Telephone' => $details->Home_Telephone, 'H_Telephone' => $details->Mobile, 'Email' => $details->Email, 'Line_1' => $details->Address_Firstline, 'Line_2' => $details->Address_secondline, 'Town' => $details->Address_Town, 'Post_code' => $details->Address_Postcode, 'EC_Title' => $details->Emergency_Title, 'EC_Fname' => $details->Emergency_Forename, 'EC_Sname' => $details->Emergency_Surname, 'EC_H_Telephone' => $details->Emergency_Telephone, 'EC_M_Telephone' => $details->Emergency_Mobile,'Contact_ID'=> $details->User_ID ]);
		
		Temp_User_Personal_Data::where('ID', $ID)
					->update(['Approved' => true]);
	
		
	}
	
	public function deny(Request $request){
		$approve = $request->approve;
		$ID = $request->encrypted_ID;
		
		
		
		Temp_User_Personal_Data::
			where('ID',$ID)
			->update(['Approved' => false]);
		
	}
	
}

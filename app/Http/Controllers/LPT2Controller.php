<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Contacts;
use View;
use Carbon\Carbon;

class LPT2Controller extends Controller
{
  
	 public function createContact(Request $request) 
    {
		 
		 $checkContact = $this->checkContact($request);
		
		 ob_end_clean(); // this
		 ob_start(); // and this
		 if($checkContact == false){
			return $this->createTheContact($request);
		 }else{
			 return view('LPTtwo.contactChecker',['origin' => $request, 'other' => $checkContact]);
		 }
		 
		 
		 

	 } 
	
	public function continueCreateContact(Request $request) 
    {
		 
		return $this->createTheContact($request);
		 

	 }
	
	public function checkContact($user){
		
		$contact = Contacts::where('Forename', 'like', '%'.$user->Forename.'%')
			->where('Surname', 'like', '%'.$user->Surname.'%');
		
		if($contact->exists()){
			return $contact;
			
		}else{
			return false;
		}
		
	}
	
	
	public function createTheContact($request){
		
		
		$ID = DB::table('Contact')->Select('Contact_ID')->orderby('Contact_ID', 'desc')->first()->Contact_ID;
		
		$contact = DB::table('Contact')->insert(
		[
			'Contact_ID' => $ID+1,
			'Organisation_ID' => -45,
			'Title' => $request->Title,
			'Forename' => $request->Forename,
			'Surname' => $request->Surname,
			'Job_Category_ID' => 20,
			'Department_ID' => 8,
			'Last_Update_Time' => carbon::now(),
			'Last_Update_User' => session('MY_ID'),
			'Created_Date' => carbon::now()
			
		]); 
		
		if($contact){
			
			$contactMethodID =  DB::table('Contacts_Contact_Methods')->Select('Contacts_Contact_Methods_ID')->orderby('Contacts_Contact_Methods_ID', 'desc')->first()->Contacts_Contact_Methods_ID;
			
			$email = DB::table('Contacts_Contact_Methods')->insert(
			[
				'Contacts_Contact_Methods_ID' => $contactMethodID+1,
				'Contact_ID' => $ID+1,
				'Contact_Method_ID' => 6,
				'Address_Or_Number' => $request->Email,
				'Last_Update_Time' => carbon::now(),
				'Last_Update_User' => session('MY_ID')
			]);
			
				$phone = DB::table('Contacts_Contact_Methods')->insert(
			[
				'Contacts_Contact_Methods_ID' => $contactMethodID+2,
				'Contact_ID' => $ID+1,
				'Contact_Method_ID' => 4,
				'Address_Or_Number' => $request->Phone,
				'Last_Update_Time' => carbon::now(),
				'Last_Update_User' => session('MY_ID')
			]);
			
			if($email && $phone){
				
				$entityid =  DB::table('Entity_Contacts')->Select('Entity_Contacts_ID')->orderby('Entity_Contacts_ID', 'desc')->first()->Entity_Contacts_ID;
				
				$project = DB::table('Entity_Contacts')->insert([
					'Entity_Contacts_ID' => $entityid+1,
					'Entity_Class_ID' => 3,
					'Contact_ID' => $ID+1,
					'Entity_Identifier' => $request->ID,
					'Active' => 1, 
					'Last_Update_User' => session('MY_ID')
				]);
				
				if($project){
					
					DB::table('Table_ID')->where('Table_Name', '=', 'Contact')->update(['LastNumber' => $ID+1]);
					DB::table('Table_ID')->where('Table_Name', '=', 'Entity_Contacts')->update(['LastNumber' => $entityid+1]);
					DB::table('Table_ID')->where('Table_Name', '=', 'Contacts_Contact_Methods')->update(['LastNumber' => $contactMethodID+2]);
					
					 return view('LPTtwo.contactCreated',['origin' => $request, 'id' => $ID+1]);
					
				}
				
			}
			
		}
		
		
		
	}
	
	public function removeFromLPT2(Request $request){
		
		DB::table('Entity_Contacts')
			->where([
				'Entity_Class_ID' => 3,
				'Contact_ID' => $request->contact,
				'Entity_Identifier' => $request->ID])
			->update([
			'Active' => 0, 
			'Last_Update_User' => session('MY_ID')
			]);
		
		return redirect()->back();
		
	}
	
	public function addtoLPT2(Request $request){
		
		$entityid =  DB::table('Entity_Contacts')->Select('Entity_Contacts_ID')->orderby('Entity_Contacts_ID', 'desc')->first()->Entity_Contacts_ID;
		
		DB::table('Entity_Contacts')
			->updateOrInsert([
				'Entity_Class_ID' => 3,
				'Contact_ID' => $request->contact,
				'Entity_Contacts_ID' => $entityid+1,
				'Entity_Identifier' => $request->ID],[
			'Active' => 1, 
			'Last_Update_User' => session('MY_ID')
			]);
		
		//return "<script type='text/javascript'>
    // self.close();
//</script>";
		
	}
	
	
}
?>
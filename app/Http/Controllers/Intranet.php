<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 

class Intranet extends Controller
{
    //
	
	public function add(Request $request){
		
		if(DB::table('Document')->where('Document_ID',$request->document_id)->exists()){
		
		DB::table('UKHT_Useful_Documents')->updateOrInsert(
		[ 'document_id' => $request->document_id ], 
		['disabled' => 0] 
		);
		
		return \Redirect::route('Intranet Settings',['status' => 'success','Header' => 'Document Added', 'Icon' => 'fa-tick', 'Text' => ''])->setStatusCode(200);
		}
		else{
			return \Redirect::route('Intranet Settings',['status' => 'error','Header' => 'Document does not exist', 'Icon' => 'fa-tick', 'Text' => ''])->setStatusCode(200);
		}
	}
	
	public function delete(Request $request){
		
		DB::table('UKHT_Useful_Documents')->where('id', $request->id)->update(['disabled' => 1]);
			
			
			return \Redirect::route('Intranet Settings',['status' => 'success','Header' => 'Document Removed', 'Icon' => 'fa-tick', 'Text' => ''])->setStatusCode(200);
		
	}
	
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ApiController extends Controller
{
    //
	
		public function getID(){
		
		    
				$GlobalID = $_COOKIE['uniAuthSess'];


$MYDetails = DB::table('Authenticated_Session')
	->join('Contact','Contact.Contact_ID','=','Authenticated_Session.User_ID')
	->join('User','User.Contact_ID','=','Authenticated_Session.User_ID')
	->orderby('Authenticated_Session.Created_Date','desc')
	->where('Authenticated_Session_ID', '=', $GlobalID)
	->first();
		
		return $MYDetails->Contact_ID;
    
		
		
	}
	
	public function getName(){
		
		    
				$GlobalID = $_COOKIE['uniAuthSess'];


$MYDetails = DB::table('Authenticated_Session')
	->join('Contact','Contact.Contact_ID','=','Authenticated_Session.User_ID')
	->join('User','User.Contact_ID','=','Authenticated_Session.User_ID')
	->orderby('Authenticated_Session.Created_Date','desc')
	->where('Authenticated_Session_ID', '=', $GlobalID)
	->first();
		
		return $MYDetails->Forename.' '.$MYDetails->Surname;
    
		
		
	}
}

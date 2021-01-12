<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Contacts extends Model
{
    //
	protected $table = 'Contact';
	
	public function getName(){
		return $this->Forename.' '.$this->Surname;
	}
	
	public function getLine($id){
		$line = DB::table('Entity_Contacts')->where(['Entity_Identifier' => $id, 'Contact_Role_ID' => 4])->select('Contact_ID')->first();
		$line = $this->where('Contact_ID', $line->Contact_ID)->first();
		return $line->Forename.' '.$line->Surname;
	}
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class User_Personal_Data extends Model
{
    //
	protected $table = 'UKHT_User_Personal_Data';
	
	
	
	  public function ETitleExist() {
return $this->where('Contact_ID', session('MY_ID'))->whereNotNull('EC_Title');
}
	
	public function hasAccess(){
		$Users = DB::table('User')->select('Contact_ID')->get();
		return $this->whereIn('Contact_ID',$Users)->exists();
	}
	
	
	
}

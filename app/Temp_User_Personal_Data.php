<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_User_Personal_Data extends Model
{
    //
	protected $table = 'UKHT_HR_PD_Stage';
	protected $fillable = ['Approved'];
	
	  public function ETitleExist() {
return $this->where('Contact_ID', session('MY_ID'))->whereNotNull('EC_Title');
}
	
public function GetLatest($id) {
		$user_id = $this->where('ID',$id)->first();
		return $this->where('User_ID',$user_id->User_ID)->where('Approved', NULL)->orderby('ID','Desc')->first();
	}
	
	
}

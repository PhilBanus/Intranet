<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IMSDocuments extends Model
{
    
	//
	
	 protected $table = 'UKHT_IMS_Documents';

	public $timestamps = false;
	
	
	
	 public function document()
    {
        return $this->hasOne('App\Documents','Global_ID','Global_ID');
    }
	
	
}

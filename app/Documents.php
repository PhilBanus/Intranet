<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Documents extends Model
{
//
	
	
   protected $table = 'Document';
	protected $primaryKey = 'Document_ID';
	public $timestamps = false;
	
	
	public function imsdoc()
    {
        return $this->belongsTo('App\IMSDocuments','Global_ID','Global_ID');
    }
	
	
	
	public static  function getLatest($id){
		
		$document_series = Documents::where('Document_ID',$id)->select('Document_Series_ID')->first();
		
		return Documents::where('Document_Series_ID',$document_series->Document_Series_ID)->orderby('Document_ID','desc')->first();
		
		
	}
	
}

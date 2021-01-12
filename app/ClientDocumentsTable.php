<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDocumentsTable extends Model
{
    //
	protected $table = 'UKHT_CD_Document';
	
	public function folder(){
		return $this->belongsTo('App\ClientFolders');
	
	}

}

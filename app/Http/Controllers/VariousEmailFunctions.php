<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Mail\opexIdea;
use Mail; 
use Illuminate\Http\Request;

class VariousEmailFunctions extends BaseController
{
 
	public function opexIdea(Request $request){
		 $document = $request->file('document');
		
		 $data = [
        'document' => $document
    ];
		
		
		//
		Mail::to('jason.johnston@hochtief.co.uk')->bcc('philip.banus@hochtief.co.uk')
			->send(new opexIdea($request->Subject, $request->Body,$request->Name,$request->Email,$data));
		
	return redirect()->route('home')->with('opexSuccess', 'Operational Excellence Idea Submitted!');;
	}
	
	
	
}

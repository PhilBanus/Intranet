<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 

class WorkWinningDash extends Controller
{
    //
	
	public function update(Request $request){
		
		if(empty($request->type)|| empty($request->state) || empty($request->title) || empty($request->client) || empty($request->owner) || empty($request->partners) || empty($request->eta) || empty($request->next) ){
			ob_clean();
	return response("required",200);
}else{
			
			$type = $request->type;
		$state = $request->state;
		$title = $request->title;
		$client = $request->client;
		$owner = $request->owner;
		$partners = $request->partners;
		$eta = $request->eta." 12:00";
		$next = $request->next;
		if($request->UPDATE === 'ADD'){
			DB::table('UKHT_WorkWinning_Dash')->insert(
    [
		'Type' => $type,
		'State' => $state,
		'Title' => $title,
		'Client' => $client,
		'Owner' => $owner,
		'Partners' => $partners,
		'ETA' => $eta,
		'Next' => $next,
		
	]
);
	}
		if($request->UPDATE === 'UPDATE'){
			$datas = DB::table('UKHT_WorkWinning_Dash')->where('ID',$request->id)->get();
			foreach($datas as $data){
    DB::table('UKHT_WorkWinning_Dash_History')->insert( [
		'Dash_ID' => $data->ID,
		'Type' => $data->Type,
		'State' => $data->State,
		'Title' => $data->Title,
		'Client' => $data->Client,
		'Owner' => $data->Owner,
		'Partners' => $data->Partners,
		'ETA' => $data->ETA,
		'Next' => $data->Next,
	]);}
			DB::table('UKHT_WorkWinning_Dash')->where('ID',$request->id)->update(
    [
		'Type' => $type,
		'State' => $state,
		'Title' => $title,
		'Client' => $client,
		'Owner' => $owner,
		'Partners' => $partners,
		'ETA' => $eta,
		'Next' => $next,
	]
);
		}
			
			
			ob_clean();
		return response("complete",200);
	}
		
	}
	
	public function ticker(Request $request){
		
			DB::table('UKHT_WorkWinning_Dash_Scroller')
		->where('Type',2)
		->delete();
		foreach($request->text as $text){
			DB::table('UKHT_WorkWinning_Dash_Scroller')
			->insert([
				'Text' => $text, 'Type' => 2
			]);		
	}
	ob_clean();
		return response("complete",200);
		
	}
	
	public function deletepost(Request $request){
				$datas = DB::table('UKHT_WorkWinning_Dash')->where('ID',$request->id)->get();	
		
			foreach($datas as $data){
    DB::table('UKHT_WorkWinning_Dash_History')->insert( [
		'Dash_ID' => $data->ID,
		'Type' => $data->Type,
		'State' => $data->State,
		'Title' => $data->Title,
		'Client' => $data->Client,
		'Owner' => $data->Owner,
		'Partners' => $data->Partners,
		'ETA' => $data->ETA,
		'Next' => $data->Next,
	]);
};			
	DB::table('UKHT_WorkWinning_Dash')->where('ID',$request->id)->update(
    [
		'Removed' => 1
	]
);
ob_clean();
		return response("complete",200);
	}
	
	public function slogan(Request $request){
			
		DB::table('UKHT_WorkWinning_Dash_Scroller')
			->where('id',1)
			->update(['Text' => $request->text]);		
		ob_clean();
			return response("complete",200);
	}
	
}

<?php 
ob_start();
if($_POST['UPDATE'] === 'DELETE'){	
		$datas = DB::table('UKHT_WorkWinning_Dash')->where('ID',$_POST['id'])->get();	
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
	DB::table('UKHT_WorkWinning_Dash')->where('ID',$_POST['id'])->update(
    [
		'Removed' => 1
	]
);
echo "complete" ;
	}else{
if($_POST['UPDATE'] === 'EDITSlogan'){
		
		DB::table('UKHT_WorkWinning_Dash_Scroller')
			->where('id',1)
			->update(['Text' => $_POST['text']]);		
	echo "complete";
	}
if($_POST['UPDATE'] === 'EDITTicker'){
		DB::table('UKHT_WorkWinning_Dash_Scroller')
		->where('Type',2)
		->delete();
		foreach($_POST['text'] as $text){
			DB::table('UKHT_WorkWinning_Dash_Scroller')
			->insert([
				'Text' => $text, 'Type' => 2
			]);		
	}
	echo "complete";
	}
if(empty($_POST['type'])|| empty($_POST['state']) || empty($_POST['title']) || empty($_POST['client']) || empty($_POST['owner']) || empty($_POST['partners']) || empty($_POST['eta']) || empty($_POST['next']) ){
	echo "required";
}else{
		$type = $_POST['type'];
		$state = $_POST['state'];
		$title = $_POST['title'];
		$client = $_POST['client'];
		$owner = $_POST['owner'];
		$partners = $_POST['partners'];
		$eta = $_POST['eta']." 12:00";
		$next = $_POST['next'];
		if($_POST['UPDATE'] === 'ADD'){
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
		if($_POST['UPDATE'] === 'UPDATE'){
			$datas = DB::table('UKHT_WorkWinning_Dash')->where('ID',$_POST['id'])->get();
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
			DB::table('UKHT_WorkWinning_Dash')->where('ID',$_POST['id'])->update(
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
	echo "complete";
    exit;
}


}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchTheOrganisations extends Controller
{
    //
    
    public function SearchTheOrganisations(Request $request) {

    $Search = $request->get('term','');

    $queries=DB::table('Organisation')
    ->where('Name','LIKE','%'.$Search.'%')
		->orwhere('Branch_Name','LIKE', '%'.$Search.'%')
		->orwhere(DB::RAW("Name +' - '+ Branch_Name"),'LIKE', '%'.$Search.'%')
    ->select('Organisation_ID','Name','Branch_Name')
    ->get()->take(15);

    $results=array();

    foreach ($queries as  $query)
    {
        $results[] = ['id' => $query->Organisation_ID, 'value' => $query->Name.' - '.$query->Branch_Name];
    }
    if(count($results))
        return response()->json($results);
    else
        return ['id'=>'','value'=>'No Result Found'];
}
    
    
}

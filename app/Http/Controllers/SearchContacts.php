<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SearchOrganisations extends Controller
{
    //
    
    Public function SearchOrganisations(Request $request) {

    $Search = $request->get('term','');

    $queries=DB::table('Contact')
    ->where('Name','LIKE','%'.$Search.'%')
    ->select('Contact_ID','Forename', 'Surname','Organisation_ID')
    ->get()->take(10);

    $results=array();

    foreach ($queries as  $query)
    {
        $results[] = ['id' => $query->Organisation_ID, 'value' => $query->Forename.' '.$query->Surname ];
    }
    if(count($results))
        return response()->json($results);
    else
        return ['id'=>'','value'=>'No Result Found'];
}
    
    
}

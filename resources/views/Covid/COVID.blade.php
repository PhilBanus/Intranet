<?php

use Carbon\Carbon;
?>
@extends('project')

@section('content')

@php 

$users = DB::table('COVID_Clockin')->wheredate('check_in', carbon::now('europe/london')->todatestring())->get(); 

@endphp
<div class="card m-2">
	<h2 class="card-header bg-primary text-white">Sign in Sheet</h2>
	<div class="card-body table-responsive">
		
<table id="dtMaterialDesignExample" class="table table-striped data-table" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm">Name
      </th>
      <th class="th-sm" width="20px">In
      </th>
      <th class="th-sm d-none d-md-table-cell">Checked In
      </th>
      <th class="th-sm d-none d-md-table-cell">Checked Out
      </th>
      <th class="th-sm d-none d-md-table-cell">Organisation
      </th>
		<th class="th-sm d-none d-md-table-cell">Location
      </th>
     
    </tr>
  </thead>
  <tbody>
	  
	  @foreach($users as $user)
	  
	  @if( $user->contact_id > 0 )
	  @php 
	  $contact = DB::table('Contact')->where('Contact_ID', $user->contact_id)->first();
	  $organisation = DB::table('Organisation')->where('Organisation_ID',$contact->Organisation_ID)->first()->Name
	  
	  @endphp
	  @endif
    <tr>
      <td>{{$user->name}}</td>
      @if($user->is_in) 
		<td class="bg-success" width="20px"></td>
		@else
		<td class="bg-danger" width="20px"></td>
		@endif
      <td class=" d-none d-md-table-cell">{{carbon::create($user->check_in)->totimestring()}}</td>
      <td class=" d-none d-md-table-cell">{{carbon::create($user->check_out)->totimestring()}}</td>
      <td class=" d-none d-md-table-cell">{{$user->organisation ?? $organisation}}</td>
      <td class=" d-none d-md-table-cell">{{$user->locale}}</td>
      
    </tr>
	  @endforeach
    
  </tbody>
  
</table>
		</div>
</div>
@endsection
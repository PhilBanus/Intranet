<?php 

 use Carbon\Carbon; 
 use Carbon\CarbonInterface; 

?>
<table>
    <thead>
    <tr>
        <th>Occurance Type</th>
        <th>Unique ID</th>
        <th>Event Date</th>
        <th>Event Time</th>
        <th>Involved Project</th>
        <th>Location</th>
        <th>Logged By</th>
        <th>Describe the Event and What Could have Happened</th>
        <th>What were you able to do about it</th>
        <th>Last Action</th>
		<th>Weather</th>
		<th>Lighting</th>
        <th>Health and Safety</th>
        <th>Environmental</th>
        <th>Quality</th>
        <th>Category</th>
        <th>Sub Category</th>
        <th>Closed</th>
        <th>Closed Timestamp</th>
        <th>Last Updated</th>
        <th>Root Cause</th>
        <th>Root Sub</th>
		<th>Accident Category</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{DB::table('UKHT_Occurance')->where('ID', $item->Occurance)->first()->Name}}</td>
            <td>HART{{ $item->ID }}</td>
            <td>{{ Carbon::parse($item->Date)->toDateString() }}</td>
            <td>{{ Carbon::parse($item->Date)->toTimeString() }}</td>
			<td>@if($item->Site == 0) HEAD OFFICE @else {{strtoupper(DB::table('Project')->where('Project_ID', $item->Site)->first()->Name)}} @endif</td>
			<td>{{$item->Location}}</td>
			<td>{{$item->Member_Of_Public}}</td>
			<td>{{urldecode($item->Details)}}</td>
			<td>{{urldecode($item->Actions_Taken_Site)}}</td>
			<td>@if ( base64_encode(base64_decode($item->Actions_Taken_HSQE, true)) === $item->Actions_Taken_HSQE)
    {{ base64_decode($item->Actions_Taken_HSQE, true)}}
@else
				{{$item->Actions_Taken_HSQE}}	 
	 @endif
				
				</td>
			<td>{{$item->Weather}}</td>
			<td>{{$item->Lighting_Conditions}}</td>
			<td>@if($item->HS) TRUE @else FALSE @endif</td>
			<td>@if($item->ENV) TRUE @else FALSE @endif</td>
			<td>@if($item->Q) TRUE @else FALSE @endif</td>
			<td>{{$item->Category}}</td>
			<td>{{$item->Sub}}</td>
			<td>@if($item->Sign_Off) Closed @else Open @endif</td>
			<td>{{$item->Closed_Date}}</td>
			<td>{{$item->Last_Updated}}</td>
			<td>{{$item->Root_Cause}}</td>
			<td>{{$item->Sub_Root}}</td>
			<td>{{$item->RIDDOR}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
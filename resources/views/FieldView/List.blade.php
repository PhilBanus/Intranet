@extends('project')

@section('content')

<div id="Loader" class="bootbox modal fade show" tabindex="-1" role="dialog" aria-modal="true" style="padding-right: 15px; display: block;"><div class="modal-dialog"><div class="modal-content"><div class="modal-body"><div class="bootbox-body"><p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Please wait while we grab the forms...</p></div></div></div></div></div>
<div id="backdrop" class="modal-backdrop fade show"></div>


<div class="card h-100">
	<div class="card-body">
<table id="forms"  class="table table-dark table-striped table-bordered table-sm" >
<thead>
	<tr>
		<th>Form Download</th>
		<th>Status</th>
		<th>Project</th>
		<th>Location</th>
		<th>Name</th>
		<th>Created</th>
		<th>Type</th>
		<th>By User</th>
		<th>By Organisation</th>
	</tr>
    </thead>
    <tbody>

	<?php 
	
	$forms = DB::table('UKHT_FieldView_Project_Forms')
		->join('UKHT_FieldView_Projects','UKHT_FieldView_Projects.ID','UKHT_FieldView_Project_Forms.Project_ID')
		->select(
		'FormID'
      ,'FormTemplateLinkID'
      ,'Deleted'
      ,'FormType'
      ,'FormName'
      ,'FormTitle'
      ,'CreatedDate'
      ,'OwnedBy'
      ,'OwnedByOrganisation'
      ,'IssuedToOrganisation'
      ,'Status'
      ,'StatusColour'
      ,'StatusDate'
      ,'Location'
      ,'OpenTasks'
      ,'ClosedTasks'
      ,'FormExpiryDate'
      ,'OverDue'
      ,'Complete'
      ,'Closed'
      ,'ParentFormID'
      ,'LastModified'
      ,'LastModifiedOnServer'
      ,'ClosedBy'
      ,'FormTemplateID'
      ,'ParentProcessTaskID'
      ,'Name'
	)
		->orderBy('CreatedDate','desc')->get();
	
	
	
	?>
	
	
@foreach($forms as $Form)

<tr>
	<td><a class="text-white" href="https://themis.ukht.org/intranet/api/FieldViewFormPDF?ID={{$Form->FormID}}" download="{{$Form->FormID}}.pdf">{{$Form->FormID}}</a></td>
	<td><div class="p-2 badge mx-2" style="background-color: {{$Form->StatusColour}}"> </div>{{$Form->Status}}</td>
	<td>{{$Form->Name}}</td>
	<td>{{$Form->Location}}</td>
	<td>{{$Form->FormName}}</td>
	<td>{{Carbon\Carbon::parse($Form->CreatedDate)->toDateString()}}</td>
	<td>{{$Form->FormType}}</td>
	<td>{{$Form->OwnedBy}}</td>
	<td>{{$Form->OwnedByOrganisation}}</td>

</tr>

@endforeach

</tbody>
</table>
</div>
</div>
<script>
	

$(document).ready(function() {

	
    $('#forms').DataTable();
	$('#Loader, #backdrop').hide();
	

} );

</script>


@endsection
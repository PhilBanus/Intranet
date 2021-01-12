<?php
use App\Documents;

?>
@extends('intranet')

@section('content')

<div class="col-md-3">

<div class="card">
	<div class="card-header bg-primary text-white">Useful Documents</div>
<div class="card-body"> 
	<form action="addUsefulLinks" method="post">
	<label for="DocumentID">Add document (Document ID):</label>
		<div class="input-group">
 	<input type="number" name="document_id" class="form-control">
		<div class="input-group-append">
    <button class="btn btn-md btn-outline-success m-0 px-3 py-2 z-depth-0 waves-effect" type="submit" id="button-addon2">Add</button>
  </div>
	</div>
		
		
	</form>
	</div>
	<ul class="list-group list-group-flush mt-2 border-top">
	@php 
		$Documents = DB::table('UKHT_Useful_Documents')->where('disabled',0)->get()
		
		@endphp
		
		@foreach($Documents as $document)
		@php $Latest = Documents::getLatest($document->document_id);
		@endphp
		
		<li class="list-group-item list-group-item-action d-flex"> {{$Latest->Title}} <a href="delUsefulLinks?id={{$document->id}}" class="text-danger ml-auto"><i class="fad fa-trash"></i></a></li>
		
		
		@endforeach
	
	</ul>
	
	
</div>

</div>



<script>

$('document').ready(function(){

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "md-toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": 300,
  "hideDuration": 1000,
  "timeOut": 5000,
  "extendedTimeOut": 1000,
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

	
	
Command: toastr["{{request('status') ?? ''}}"]("{{request('Header') ?? ''}}")

	})
</script>

@endsection
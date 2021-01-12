@php use App\User_Personal_Data;
	use App\Contacts; 
@endphp

@extends('table')


@section('headers')
<tr>
      <th>Employee
      </th>
      <th>Linemanager
      </th>
	<th>Emergency Contact Details
      </th>


    
    </tr>


@overwrite
@section('rows')

@php $Users = User_Personal_Data::all(); @endphp
@foreach($Users as $User)

<tr>
<td>{{Contacts::where('Contact_ID',$User->Contact_ID)->first()->getName()}}</td>
<td>{{Contacts::where('Contact_ID',$User->Contact_ID)->first()->getLine($User->Contact_ID)}}</td>

<td> <button data-id="{{$User->Contact_ID}}" type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalPreview">
  Click to View
</button>
</td>
</tr>



@endforeach

<!-- Modal -->
<div class="modal fade right" id="exampleModalPreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-full-height modal-right" role="document">
    <div class="modal-content elegant-color-dark text-warning">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body " id="AjaxBody">
		  
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<script>
			  $(document).ready(function(){
			  $('.btn-primary').on('click', function(){
				  $('#AjaxBody').load('HRUserAjax?id=' + $(this).data('id'))
			  })
			});
		  	
		  </script>
@overwrite
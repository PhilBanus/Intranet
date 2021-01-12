@extends('LPTtwo.default')
@section('content')
<?php 
use Carbon\Carbon;
	
$ProjectID = request('ID') ? request('ID') : 91;
	
	
	?>



	
	<div class="card rounded-0 z-depth-0">
<div class="card-header bg-light d-flex justify-content-between">
	<div class="text-primary">

Add a New Worker
		</div>

		</div>
	<div class="card-body fhl-card" id="Users" style="overflow: auto">

		<form action="createContact" method="post" class="border border-light p-5">

			@csrf

			<input type="number" value="{{$ProjectID}}" hidden="true" name="ID">
    <select class="browser-default custom-select mb-1" id="Title" name="Title" required>
        <option value="" disabled="" selected="">Title</option>
        <option value="Mr">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Miss">Miss</option>
        <option value="Ms">Ms</option>
        <option value="Dr">Dr</option>
        <option value="Sir">Sir</option>
    </select>
			
    <input type="text" id="Forename" name="Forename" autocomplete="off" class="form-control  mb-1" placeholder="First name" required>

    <input type="text" id="Surname" name="Surname" autocomplete="off" class="form-control  mb-1" placeholder="Last name" required>

    <input type="email" id="Email" name="Email" autocomplete="off" class="form-control mb-1" placeholder="E-mail" required>

    <input type="number" id="Phone" name="Phone" autocomplete="off" class="form-control" placeholder="Phone number" aria-describedby="defaultRegisterFormPhoneHelpBlock" required>

 

    <button class="btn btn-info my-4 btn-block" type="submit">Create</button>

</form>
		
		
	</div>
	</div>

<script>



</script>

@stop







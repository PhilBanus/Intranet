@extends('LPTtwo.default')
@section('content')
<?php 
use Carbon\Carbon;
	
	
$Users = $other->get();
$ProjectID = request('ID') ? request('ID') : 91;

	
	?>



	
	<div class="card rounded-0 z-depth-0">
<div class="card-header bg-light d-flex justify-content-between">
	<div class="text-primary">

Possible Duplicates Found
		</div>

		</div>
	<div class="card-body fhl-card" id="Users" style="overflow: auto">
		
				<table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead class="black white-text">
    <tr>
      <th class="th-sm">Name
      </th>
        <th class="th-sm">Skills
      </th>
      <th class="th-sm">Role
      </th>
      <th class="th-sm">Organisation
      </th>
		<th>Add to Project</th>

    </tr>
  </thead>
  <tbody>
	  
<?php 
	
	foreach($Users as $User){
		$Contact = db::table('Contact')->where('Contact_ID',$User->Contact_ID)->first();
		$Name = $Contact->Forename." ".$Contact->Surname;
		$Org = DB::table('Organisation')->where('Organisation_ID',$Contact->Organisation_ID)->first();
		
			$Role = DB::table('LPT2_Links')->join('LPT2_WBS','LPT2_Links.LPT2_Group','LPT2_WBS.ID')->where('Contact',$Contact->Contact_ID)->first();
			
      $internal = DB::table('Role_Membership')->where(['User_Role_ID' => 199, 'Contact_ID' => $Contact->Contact_ID])->exists();
		
		?>
	    <tr>
      <td>{{$Name}}</td>
            <td> 
          
          <a href="https://themis.ukht.org/XWeb/Skills/Journal.aspx?ec=1&code={{$Contact->Contact_ID}}" target="new"><i class="fad fa-user-cog"></i></a>
          </td>
      <td class="Role" data-role="{{$Role->ID ?? ''}}" data-id="{{$Contact->Contact_ID}}" data-name="{{$Name}}">{{$Role->Role ?? ''}}</td>
      <td>{{$Org->Name}}</td>
    	<td><a href="addtoLPT2?contact={{$Contact->Contact_ID}}&ID={{$ProjectID}}" class="text-success"><i class="fad fa-user-plus"></i></a></td>
    </tr>
	  
	   
	  <?php
	}
  
    ?>
  </tbody>
</table>
		
		    <button class="btn btn-danger my-4 btn-block" onclick="close_window();return false;" type="submit">Cancel</button>

		<form action="continueCreateContact" method="post">

			@csrf

			
    <input type="text" id="Title" name="Title" autocomplete="off" class="form-control  mb-1" value="{{$origin->Title}}" hidden="" placeholder="First name" required>
			
    <input type="text" id="Forename" name="Forename" autocomplete="off" class="form-control  mb-1"  value="{{$origin->Forename}}" hidden="" placeholder="First name" required>

    <input type="text" id="Surname" name="Surname" autocomplete="off" class="form-control  mb-1"  value="{{$origin->Surname}}" hidden="" placeholder="Last name" required>

    <input type="email" id="Email" name="Email" autocomplete="off" class="form-control mb-1"  value="{{$origin->Email}}" hidden="" placeholder="E-mail" required>

    <input type="number" id="Phone" name="Phone" autocomplete="off" class="form-control"  value="{{$origin->Phone}}" hidden="" placeholder="Phone number" aria-describedby="defaultRegisterFormPhoneHelpBlock" required>

 

    <button class="btn btn-info my-4 btn-block" type="submit">Create {{$origin->Forename}} {{$origin->Surname}} </button>

</form>
		
		
	</div>
	</div>

<script>

$(document).ready(function () {
$('#dtBasicExample').DataTable();
})
	
function close_window() {
  if (confirm("Close Window?")) {
    close();
  }
}

</script>

@stop







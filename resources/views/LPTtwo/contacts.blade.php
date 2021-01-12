@extends('LPTtwo.default')
@section('content')
<?php 
use Carbon\Carbon;

$ProjectID = request('ID') ? request('ID') : 91;
	
	?>

<?php 

$Users = DB::table('Entity_Contacts')->where(['Entity_Identifier'=> $ProjectID, 'Entity_Class_ID' => 3, 'Active' => 1, 'Superceded_By_Date' => null])->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->orderby('Forename', 'asc')->orderby('Surname','asc')->get()




?>


	
	<div class="card rounded-0 z-depth-0">
<div class="card-header bg-light d-flex justify-content-between">
	<div>

	<a href="https://themis.ukht.org/XWeb/Skills/ExpiringQualificationsLPT2.aspx" target="New" class="btn btn-info">Expiring Qualifications</a>
	<a href="https://themis.ukht.org/Xweb/Search/Search.aspx?def=LPT2SkillSearch" target="New" class="btn btn-info">Search Qualifications</a>
	<a href="LPT2/addContact?ID={{$ProjectID}}" target="New" class="btn btn-success">New Worker</a>
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
		<th></th>

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
      <td>
         
          
          
          <a href="" class="text-primary" data-id="{{$User->Contact_ID}}" data-name="{{$Name}}" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-search">
          
          
          </i> {{$Name}}</a></td>
            <td> 
          
          <a href="https://themis.ukht.org/XWeb/Skills/Journal.aspx?ec=1&code={{$Contact->Contact_ID}}" target="new"><i class="fad fa-user-cog"></i></a>
          </td>
      <td class="Role" data-role="{{$Role->ID ?? ''}}" data-id="{{$Contact->Contact_ID}}" data-name="{{$Name}}">{{$Role->Role ?? ''}}</td>
      <td>{{$Org->Name}}</td>
    	<td class="text-danger"><a href="#" onClick="removeUser({{$User->Contact_ID}})" class="text-danger"><i class="fad fa-trash"></i></a></td>
    </tr>
	  
	  
	  <?php
	}
  
    ?>
  </tbody>
</table>
	</div>
	</div>

<!-- Modal -->
<div class="modal fade green darken-4" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-dialog-centered modal-fluid h-100 modal-dialog-scrollable pr-4 pl-4" role="document">


    <div class="modal-content h-100">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
  
    </div>
  </div>
</div>
	

<div class="modal fade darken-4" id="ChangeRole" tabindex="-1" role="dialog" aria-labelledby="ChangeRoleTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">


    <div class="modal-content h-100">
      <div class="modal-header">
        <h5 class="modal-title" id="ChangeRoleTitle">Please Assign/Change Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="user" data-id=''></div>
		  <select class="mdb-select md-form selectRole" id="Role" searchable="Search here..">
			   <option value="" disabled selected>Choose Role</option>
	<?php $Roles = db::table('LPT2_WBS')->get(); 
			  foreach($Roles as $option){
				  ?>
			   <option value="{{$option->ID}}" data-id="{{$option->ID}}">{{$option->Role}}</option>
			  <?php
			  }
			  
			  ?>	
</select>
		  
      </div>
  <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="SaveRole" class="btn btn-primary">Save changes</button>
		</div>
    </div>
  </div>
</div>
<div class="modal fade darken-4" id="ChangeRate" tabindex="-1" role="dialog" aria-labelledby="ChangeRoleTitle"
  aria-hidden="true">

  <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">


    <div class="modal-content h-100">
      <div class="modal-header">
        <h5 class="modal-title" id="ChangeRoleTitle">Please Assign/Change Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="rateuser" data-id=''></div>
		  <input type="text" id="Rate" class="form-control">
		  
      </div>
  <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="SaveRate" class="btn btn-primary">Save changes</button>
		</div>
    </div>
  </div>
</div>
	
	
<script>


$(document).ready(function () {
$('#dtBasicExample').DataTable();
$('.dataTables_length').addClass('bs-select');
	
	

		$('.adatepicker').pickadate({
disable: [

2,3,4,5,6,7
],
			max: new Date(),
			min: new Date('12/15/2019'),
			onSet: function(context){
				console.log(context)
				if(context.select){
					$('#bulkExport').attr('href','https://themis.ukht.org/intranet/LPT2/User/exportBulk?Date='+moment(context.select).format('YYYY-MM-DD'));
				$('#bulkExport').removeClass('disabled');
				}else{
				$('#bulkExport').attr('href','');
				$('#bulkExport').addClass('disabled');
			}
}
	
	
});
});
	
	
	$('#exampleModalCenter').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var id = button.data('id') // Extract info from data-* attributes
var recipient = button.data('name') // Extract info from data-* attributes

var modal = $(this)
modal.find('.modal-title').text('Timesheets for ' + recipient)
modal.find('.modal-body').load('LPT2/User?id='+id)
})
	
	$('.Role').on('dblclick',function()
				 {
		var Name = $(this).data("name");
		var ID = $(this).data("id");
		var Role = $(this).data("role");
		$('#ChangeRole').find('.modal-title').text('Please Assign/Change Role for '+Name)
		$('#ChangeRole').find('.user').data('id',ID)
		$('#ChangeRole').modal('show');
	
	})
	$('.Rate').on('dblclick',function()
				 {
		var Name = $(this).data("name");
		var ID = $(this).data("id");
		var Rate = $(this).data("role");
		$('#ChangeRate').find('.modal-title').text('Please modify Weekly Rate for '+Name)
		$('#ChangeRate').find('.rateuser').data('id',ID)
		$('#ChangeRate').find('input').val($(this).data('val'))
		$('#ChangeRate').modal('show');
	
	})
	
	$('#SaveRole').on('click',function(){
			console.log($('#Role').val())
		
		var ID = $('.user').data('id')
			$.post('LPT2Update',{Type: "ROLE",ID:ID, Role:$('#Role').val()}).done(function(){
				$('#ChangeRole').modal('hide');
				location.reload()
			})
		})
	
	$('#SaveRate').on('click',function(){
		
		var ID = $('.rateuser').data('id')
			$.post('LPT2Update',{Type: "RATE",ID:ID, Role:$('#Rate').val()}).done(function(){
				$('#ChangeRate').modal('hide');
				location.reload()
			})
		})

	
	function removeUser(id){
		var ask=confirm("Are you sure?");
		if(ask){
			window.location="LPT2/removeContact?contact="+id+"&ID={{$ProjectID}}";
		}
	}


</script>

@stop







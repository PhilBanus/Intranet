@extends('intranet')

@section('content')



<?php 
   
	$othercontacts = new App\Temp_User_Personal_Data;
	$othercontacts = $othercontacts->GetLatest($_GET['ID']);
	
if($othercontacts === NULL){ 
	
	header('Location: '.url('/').'/HREmployees'); }
	else{
		$contacts = db::table('Contact')
					->where('Contact_ID', '=', ($othercontacts->User_ID))
					->first();


?>


<h1 class="justify-content-center">{{$contacts->Title}} {{$contacts->Forename}} {{$contacts->Surname}}</h1>
<div class="d-flex justify-content-center">
<div class="col-md-10">
    <div class="card ">
        <div class="card-header text-white">Current Information</div>
    <div class="row">
        <div class="col-md-6">
              <div class="card-body">
        
     <fieldset>
                  <legend>Your Contact Details</legend>

                  
        <fieldset>
           <div class="mdb-form  col-md-10">
              <label for="First_Line">Title</label>
			<h5>{{$othercontacts->Title}} </h5>
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Forename">First name</label>
          <h5>{{$othercontacts->Forename}}</h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Surname">Last name</label>
          <h5>{{$othercontacts->Surname}}</h5>
               
          </div>  
            
            
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Home_Telephone}}')) </script></h5>
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Mobile}}')) </script></h5>
               
          </div> 
            
          <div class="mdb-form col-md-10">
              <label for="Email">Email (Personal)</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Email}}')) </script></h5>
               
          </div>
          
        
          
</fieldset>
          

        <fieldset class="mt-2">
            <legend>Address</legend>
           <div class="mdb-form col-md-10">
          <h5><script> document.write(window.atob('{{$othercontacts->Address_Firstline}}')) </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
          <h5><script> document.write(window.atob('{{$othercontacts->Address_Secondline}}')) </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
          <h5><script> document.write(window.atob('{{$othercontacts->Address_Town}}')) </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
          <h5><script> document.write(window.atob('{{$othercontacts->Address_Postcode}}')) </script></h5>
               
          </div>
          
</fieldset>
          
                  </fieldset>
          
      </div>
            </div>
         <div class="col-md-6">
              <div class="card-body pr-0 mr-0 blue lighten-5 rounded mb-4">
        <fieldset>
                  <legend>Emergancy Contact Details</legend>

                  
        <fieldset>
           <div class="mdb-form col-md-10">
              <label for="First_Line">Title</label>
			  <h5><script> document.write(window.atob('{{$othercontacts->Emergency_Title}}')) </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Forename">First Name</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Emergency_Forename}}')) </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Surname">Surname</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Emergency_Surname}}')) </script></h5>
               
          </div>  
            
            
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Emergency_Telephone}}')) </script></h5>
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <h5><script> document.write(window.atob('{{$othercontacts->Emergency_Mobile}}')) </script></h5>
               
          </div> 
            
      
          
        
          
</fieldset>
          

          
</fieldset>
          
      </div>
			 <fieldset>
				 <div class="row justify-content-center col-md-offset-1 col-md-12 mb-2">
					 <button id="Sendbtn" type="button" class="btn btn-success col-md-10">Approve <i class="far fa-thumbs-up"></i> </button>
				 </div>
			 
				 <div  class="row justify-content-center col-md-offset-1 col-md-12">
				 	<button id="Closebtn" type="button" class="btn btn-danger col-md-10">Deny <i class="far fa-thumbs-down fa-1x"></i></button>
				 </div>
			
			 </fieldset>
			
        </div>
		
</div>
        
    </div>
    
    </div>

      
    </div>

<script>
$(document).ready(function(){
	console.log('{{$othercontacts->ID}}')
	
	$('#Sendbtn').on('click', function(){
		if(confirm("Are you sure you want to authorise?") == true){
			$.post('UserAmmend/Confirm', {
				approve: true,
				encrypted_ID: {{$othercontacts->ID}}
				
			}).done(function(){
				location.reload()
			})
		}
		
	});
	
	$('#Closebtn').on('click', function(){
		if(confirm("Are you sure you want to deny?") == true){
			$.post('UserAmmend/Deny', {
				approve: false,
				encrypted_ID: {{$othercontacts->ID}}
				
			}).done(function(){
				location.reload()
			})
		}
		
	});
	
});
</script>
<?php } ?>

@stop

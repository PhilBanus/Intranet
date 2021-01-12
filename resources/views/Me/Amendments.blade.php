@extends('intranet')

@section('content')



<?php 
   	

	$Photo = session('MY_PHOTO');
	$Name = session('MY_USERNAME');
	$Title = session('MY_JOBTITLE');

	$contacts = db::table('Contact')
				->where('Contact_ID', '=', session('MY_ID'))
				->first();

	$othercontacts = db::table('UKHT_HR_PD_Stage')
					->where('User_ID', '=', session('MY_ID'))
					->first();

	$contact_exist = db::table('UKHT_HR_PD_Stage')
					->where('User_ID', '=', session('MY_ID'))
					->exists();

?>

<script>console.log("{{session('MY_ID')}}") </script>

<div hidden class="container my-2 col-12">


  <!-- Section: Block Content -->
  <section class="dark-grey-text">

 

    <!-- Grid row -->
    <div class="row">
		
  <div class="col-lg-2 text-center">

        <img src="{{$Photo}}" class="img-fluid rounded z-depth-1" alt="Sample project image">
<div class="btn btn-white btn-sm col-12 waves-effect z-depth-0">Change Photo</div>
      </div>
      <!-- Grid column -->
    <div class="col-md-5">
		
		   <h3 class="text-left font-weight-bold pb-2">Hi, {{$Name}}</h3>
    <p class="text-left text-muted mx-auto">This is your personal profile, It contains some sensitive information which is only available to you and HR. </p>
    <p class="text-left text-muted mx-auto">This information is found in the dropdown section below. It is collapsed for your privacy. </p>
		
		</div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-lg-4">

        <ul class="list-unstyled fa-ul mb-0">
          <li class="d-flex justify-content-left pl-4">
            <span class="fa-li"><i class="fas fa-phone fa-2x cyan-text"></i></span>
            <div>
              <h5 class="font-weight-bold mb-3">Phone</h5>
              <p class="text-muted">{{session('MY_MOBILE')}}</p>
            </div>
          </li>
          <li class="d-flex justify-content-left pl-4">
            <span class="fa-li"><i class="fas fa-envelope fa-2x red-text"></i></span>
            <div>
              <h5 class="font-weight-bold mb-3">Email</h5>
              <p class="text-muted">{{session('MY_EMAIL')}}</p>
            </div>
          </li>
          <li class="d-flex justify-content-left pl-4">
            <span class="fa-li"><i class="far fa-user fa-2x deep-purple-text"></i></span>
            <div>
              <h5 class="font-weight-bold mb-3">Linemanager</h5>
              <a href="https://themis.ukht.org/XWeb/entity/entity.aspx?ec=1&code={{DB::table('Entity_Contacts')->where('Entity_Identifier',session('MY_ID'))->where('Entity_Class_ID',1)->first()->Contact_ID}}" target="new" class="mb-0">{{DB::table('Entity_Contacts')->where('Entity_Identifier',session('MY_ID'))->where('Entity_Class_ID',1)->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->first()->Forename}} {{DB::table('Entity_Contacts')->where('Entity_Identifier',session('MY_ID'))->where('Entity_Class_ID',1)->join('Contact','Contact.Contact_ID','Entity_Contacts.Contact_ID')->first()->Surname}}</a>
            </div>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

    <hr class="my-5">

  </section>
  <!-- Section: Block Content -->


</div>

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
          <select id="Title" placeholder="Title" class="browser-default custom-select">
			  <option selected> {{$contacts->Title}} </option>
			  <option value="1">Mr</option>
			  <option value="2">Mrs</option>
			  <option value="3">Miss</option>
			</select>
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Forename">First name</label>
          <input type="text" id="Forename" placeholder="Forename" value="{{$contacts->Forename}}" class="form-control" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Surname">Last name</label>
          <input type="text" id="Surname" placeholder="Surname" value="{{$contacts->Surname}}" class="form-control" autocomplete="off">
               
          </div>  
            
            
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <input type="text" id="Telephone" placeholder="i.e. 01234 567 890" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Home_Telephone;} ?>"
				 class="form-control" autocomplete="off">
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <input type="text" id="Mobile" placeholder="i.e. 01234 567 890" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Mobile;} ?>" class="form-control" autocomplete="off">
               
          </div> 
            
          <div class="mdb-form col-md-10">
              <label for="Email">Email (Personal)</label>
          <input type="text" id="Email" placeholder="i.e.joe@bloggs.com" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Email;} ?>" class="form-control" autocomplete="off">
               
          </div>
          
        
          
</fieldset>
          

        <fieldset class="mt-2">
            <legend>Address</legend>
           <div class="mdb-form col-md-10">
          <input type="text" id="First_Line" placeholder="First Line" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Address_Firstline;} ?>" class="form-control m-1" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
          <input type="text" id="Second_Line" placeholder="Second Line" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Address_Secondline;} ?>" class="form-control m-1" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
          <input type="text" id="Town" placeholder="Town" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Address_Town;} ?>" class="form-control m-1" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
          <input type="text" id="Postcode" placeholder="Post Code" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Address_Postcode;} ?>" class="form-control m-1" autocomplete="off">
               
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
			  <select id="Emergency_Title" placeholder="Title" class="browser-default custom-select">
				  <option <?php if($contact_exist == false){echo "disabled ";} ?>selected> 
					  <?php if($contact_exist == false){echo 'Please select an option';} else{echo $othercontacts->Emergency_Title;} ?> </option>
				  <option value="1">Mr</option>
				  <option value="2">Mrs</option>
				  <option value="3">Miss</option>
		 	  </select>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Forename">First Name</label>
          <input type="text" id="Emergency_Forename" placeholder="Forename" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Emergency_Forename;} ?>" class="form-control" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Surname">Surname</label>
          <input type="text" id="Emergency_Surname" placeholder="Surname" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Emergency_Surname;} ?>" class="form-control" autocomplete="off">
               
          </div>  
            
            
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <input type="text" id="Emergency_Telephone" placeholder="i.e. 01234 567 890" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Emergency_Telephone;} ?>" class="form-control" autocomplete="off">
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <input type="text" id="Emergency_Mobile" placeholder="i.e. 01234 567 890" value="<?php 
			if($contact_exist == false){echo null;} else{echo $othercontacts->Emergency_Mobile;} ?>" class="form-control" autocomplete="off">
               
          </div> 
            
      
          
        
          
</fieldset>
          

          
</fieldset>
          
      </div>
			 <fieldset>
				 <div class="row justify-content-center col-md-offset-1 col-md-12 mb-2">
					 <button id="Sendbtn" type="button" class="btn btn-success col-md-10">Save</button>
				 </div>
			 
				 <div  class="row justify-content-center col-md-offset-1 col-md-12">
				 	<button id="Closebtn" type="button" class="btn btn-danger col-md-10">Close</button>
				 </div>
			
			 </fieldset>
			
        </div>
		
</div>
        
    </div>
    
    </div>

      
    </div>

<script>
$(document).ready(function(){
	$('#Sendbtn').on('click', function(){
		if(confirm("Are you sure?") == true){
			
			var title = window.btoa($('#Title').val());
			var telephone = window.btoa($('Telephone').val())
			console.log = telephone
			
			
			
			$.post('SendRequest', {
				Title: title,
				Forename: window.btoa($('#Forename').val()),
				Surname: window.btoa($('#Surname').val()),
				Telephone: window.btoa($('Telephone').val()),
				Mobile: window.btoa($('Mobile').val()),
				Email: window.btoa($('Email').val()),
				Firstline: window.btoa($('First_Line').val()),
				secondline: window.btoa($('Second_Line').val()),
				Town: window.btoa($('Town').val()),
				Postcode: window.btoa($('Postcode').val()),
				Emergency_Title: window.btoa($('Emergency_Title').val()),
				Emergency_Forename: window.btoa($('Emergency_Forename').val()),
				Emergency_Surname: window.btoa($('Emergency_Surname').val()),
				Emergency_Telephone: window.btoa($('Emergency_Telephone').val()),
				Emergency_Mobile: window.btoa($('Emergency_Mobile').val()),
				encrypted_ID: {{session('MY_ID')}}
			});
		}
		
	})
});
</script>


@stop

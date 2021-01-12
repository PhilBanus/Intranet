
@extends('intranet')

@section('content')



<?php 
   	

	$Photo = session('MY_PHOTO');
	$Name = session('MY_USERNAME');
	$Title = session('MY_JOBTITLE');

	

	$contacts = App\Contacts::where('Contact_ID', '=', session('MY_ID'))
				->first();

	$othercontacts = App\User_Personal_Data::where('Contact_ID', '=', session('MY_ID'))
					->first();


	
	$H_Telephone = $othercontacts && $othercontacts->H_Telephone ? base64_decode($othercontacts->H_Telephone) : NULL;
	$M_Telephone = $othercontacts && $othercontacts->M_Telephone ? base64_decode($othercontacts->M_Telephone) : NULL;
	$Email = $othercontacts && $othercontacts->Email ? base64_decode($othercontacts->Email) : NULL;
	$Line_1 = $othercontacts && $othercontacts->Line_1 ? base64_decode($othercontacts->Line_1) : NULL;
	$Line_2 = $othercontacts && $othercontacts->Line_2 ? base64_decode($othercontacts->Line_2) : NULL;
	$Town = $othercontacts && $othercontacts->Town ? base64_decode($othercontacts->Town) : NULL;
	$Postcode = $othercontacts && $othercontacts->Postcode ? base64_decode($othercontacts->Postcode) : NULL;
	$EC_Title = $othercontacts && $othercontacts->EC_Title ? base64_decode($othercontacts->EC_Title) : 'Please select an option';
	$EC_Fname = $othercontacts && $othercontacts->EC_Fname ? base64_decode($othercontacts->EC_Fname) : NULL;
	$EC_Sname = $othercontacts && $othercontacts->EC_Sname ? base64_decode($othercontacts->EC_Sname) : NULL;
	$EC_H_Telephone = $othercontacts && $othercontacts->EC_H_Telephone ? base64_decode($othercontacts->EC_H_Telephone) : NULL;
	$EC_M_Telephone = $othercontacts && $othercontacts->EC_M_Telephone ? base64_decode($othercontacts->EC_M_Telephone) : NULL;




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
			  <option value="{{$contacts->Title}}" selected> {{$contacts->Title}} </option>
			  <option value="Mr" >Mr</option>
			  <option value="Mrs">Mrs</option>
			  <option value="Miss">Miss</option>
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
          <input type="text" id="Telephone" placeholder="i.e. 01234 567 890" value="{{$H_Telephone}}" class="form-control" autocomplete="off">
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <input type="text" id="Mobile" placeholder="i.e. 01234 567 890" value="{{$M_Telephone}}" class="form-control" autocomplete="off">
               
          </div> 
            
          <div class="mdb-form col-md-10">
              <label for="Email">Email (Personal)</label>
          <input type="text" id="Email" placeholder="i.e.joe@bloggs.com" value="{{$Email}}" class="form-control" autocomplete="off">
               
          </div>
          
        
          
</fieldset>
          

        <fieldset class="mt-2">
            <legend>Address</legend>
           <div class="mdb-form col-md-10">
          <input type="text" id="First_Line" placeholder="First Line" value="{{$Line_1}}" class="form-control m-1" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
          <input type="text" id="Second_Line" placeholder="Second Line" value="{{$Line_2}}" class="form-control m-1" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
          <input type="text" id="Town" placeholder="Town" value="{{$Town}}" class="form-control m-1" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
          <input type="text" id="Postcode" placeholder="Post Code" value="{{$Postcode}}" class="form-control m-1" autocomplete="off">
               
          </div>
          
</fieldset>
          
                  </fieldset>
          
      </div>
            </div>
         <div class="col-md-6">
              <div class="card-body pr-0 mr-0 blue lighten-5 rounded mb-4">
        <fieldset>
                  <legend>Emergency Contact Details</legend>

                  
        <fieldset>
			@php $ETitle = App\User_Personal_Data::where('Contact_ID', session('MY_ID'))->whereNotNull('EC_Title')->exists() @endphp
           <div class="mdb-form col-md-10">
              <label for="First_Line">Title</label>
			  <select id="EC_Title" placeholder="Title" class="browser-default custom-select">
				  <option value="{{$EC_Title}}" <?php if(!$ETitle){echo "disabled ";} ?>selected> 
					  {{$EC_Title}} </option>
				  <option value="Mr">Mr</option>
				  <option value="Mrs">Mrs</option>
				  <option value="Miss">Miss</option>
		 	  </select>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Forename">First Name</label>
          <input type="text" id="Emergency_Forename" placeholder="Forename" value="{{$EC_Fname}}" class="form-control" autocomplete="off">
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Surname">Surname</label>
          <input type="text" id="Emergency_Surname" placeholder="Surname" value="{{$EC_Sname}}" class="form-control" autocomplete="off">
               
          </div>  
            
            
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <input type="text" id="Emergency_Telephone" placeholder="i.e. 01234 567 890" value="{{$EC_H_Telephone}}" class="form-control" autocomplete="off">
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <input type="text" id="Emergency_Mobile" placeholder="i.e. 01234 567 890" value="{{$EC_M_Telephone}}" class="form-control" autocomplete="off">
               
          </div> 
            
      
          
        
          
</fieldset>
          

          
</fieldset>
          
      </div>
			 <fieldset>
				 <div class="row justify-content-center col-md-offset-1 col-md-12 mb-2">
					 <button id="Sendbtn" type="button" class="btn btn-success col-md-10">Save</button>
				 </div>
			 
				 <div  class="row justify-content-center col-md-offset-1 col-md-12">
				 	<a class="btn btn-danger col-md-10" href="https://themis.ukht.org/intranet/MyProfile">Close</a>
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
			
			var title = ($('#Title').val());
			
			var emergency_Title = ($('#Emergency_Title').val());
			if (emergency_Title == 'Please select an option'){
				emergency_Title = null;
			}
			
			$.post('SendRequest', {
				Title: title,
				Forename: ($('#Forename').val()),
				Surname: ($('#Surname').val()),
				Telephone: window.btoa($('#Telephone').val()),
				Mobile: window.btoa($('#Mobile').val()),
				Email: window.btoa($('#Email').val()),
				Firstline: window.btoa($('#First_Line').val()),
				secondline: window.btoa($('#Second_Line').val()),
				Town: window.btoa($('#Town').val()),
				Postcode: window.btoa($('#Postcode').val()),
				Emergency_Title: window.btoa(emergency_Title),
				Emergency_Forename: window.btoa($('#Emergency_Forename').val()),
				Emergency_Surname: window.btoa($('#Emergency_Surname').val()),
				Emergency_Telephone: window.btoa($('#Emergency_Telephone').val()),
				Emergency_Mobile: window.btoa($('#Emergency_Mobile').val()),
				encrypted_ID: {{session('MY_ID')}}
			}).done(function(){
				
				window.location.href = "{{url('/')}}/MyProfile";
				
			});
		}
		
	})
});
</script>


@stop

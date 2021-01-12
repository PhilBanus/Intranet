@extends('intranet')

@section('content')



<?php 


	$Photo = session('MY_PHOTO');
	$Name = session('MY_USERNAME');
	$Title = session('MY_JOBTITLE');

	$othercontacts = App\User_Personal_Data::where('Contact_ID', '=', session('MY_ID'))
					->first();

$H_Telephone = $othercontacts && $othercontacts->H_Telephone ? base64_decode($othercontacts->H_Telephone) : 'No Record';
	$M_Telephone = $othercontacts && $othercontacts->M_Telephone ? base64_decode($othercontacts->M_Telephone) : 'No Record';
	$Email = $othercontacts && $othercontacts->Email ? base64_decode($othercontacts->Email) : 'No Record';
	$Line_1 = $othercontacts && $othercontacts->Line_1 ? base64_decode($othercontacts->Line_1) : 'No Record';
	$Line_2 = $othercontacts && $othercontacts->Line_2 ? base64_decode($othercontacts->Line_2) : 'No Record';
	$Town = $othercontacts && $othercontacts->Town ? base64_decode($othercontacts->Town) : 'No Record';
	$Postcode = $othercontacts && $othercontacts->Postcode ? base64_decode($othercontacts->Postcode) : 'No Record';
	$EC_Title = $othercontacts && $othercontacts->EC_Title ? base64_decode($othercontacts->EC_Title) : 'No Record';
	$EC_Fname = $othercontacts && $othercontacts->EC_Fname ? base64_decode($othercontacts->EC_Fname) : 'No Record';
	$EC_Sname = $othercontacts && $othercontacts->EC_Sname ? base64_decode($othercontacts->EC_Sname) : 'No Record';
	$EC_H_Telephone = $othercontacts && $othercontacts->EC_H_Telephone ? base64_decode($othercontacts->EC_H_Telephone) : 'No Record';
	$EC_M_Telephone = $othercontacts && $othercontacts->EC_M_Telephone ? base64_decode($othercontacts->EC_M_Telephone) : 'No Record';
?>

<div class="container my-2 col-12">


  <!-- Section: Block Content -->
  <section class="dark-grey-text">

 

    <!-- Grid row -->
    <div class="row">
		
  <div class="col-lg-2 text-center">

        <img src="{{$Photo}}" class="img-fluid rounded z-depth-1" alt="Sample project image">
<div class="btn btn-white btn-sm col-12 waves-effect z-depth-0"></div>
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

  <a href="MyProfile/Amend" class="btn btn-primary btn-sm">Amend Personal Information</a>

          

<div class="accordion" id="accordionExample275">
  <div class="card z-depth-0 bordered">
    <div class="card-header red darken-3 p-1" id="headingOne2">
      <h5 class="mb-0">
        <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne2"
          aria-expanded="true" aria-controls="collapseOne2">
         <i class="fad fa-3x fa-person-sign"></i> Personal Data (Address, Contact Details and Emergency Contacts) - click to expand
        </button>
      </h5>
    </div>
    <div id="collapseOne2" class="collapse" aria-labelledby="headingOne2"
      data-parent="#accordionExample275">
      <div class="card-body row">
		  <div class="col">
        <fieldset>
                  <legend>Your Contact Details</legend>

                  
        <fieldset>
           
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <h5><script> document.write('{{$H_Telephone}}') </script></h5>
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <h5><script> document.write('{{$M_Telephone}}') </script></h5>
               
          </div> 
            
          <div class="mdb-form col-md-10">
              <label for="Email">Email (Personal)</label>
          <h5><script> document.write('{{$Email}}') </script></h5>
               
          </div>
          
        
          
</fieldset>
          

        <fieldset class="mt-2">
            <legend>Address</legend>
           <div class="mdb-form col-md-10">
          <h5><script> document.write(('{{$Line_1}}')) </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
          <h5><script> document.write('{{$Line_2}}') </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
          <h5><script> document.write('{{$Town}}') </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
          <h5><script> document.write('{{$Postcode}}') </script></h5>
               
          </div>
          
</fieldset>
          
                  </fieldset>
          </div>
		  
		  <div class="col">
              <div class="card-body pr-0 mr-0 blue lighten-5 rounded mb-4">
        <fieldset>
                  <legend>Emergency Contact Details</legend>

                  
        <fieldset>
           <div class="mdb-form col-md-10">
              <label for="First_Line">Title</label>
			  <h5><script> document.write('{{$EC_Title}}') </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Forename">First Name</label>
          <h5><script> document.write('{{$EC_Fname}}') </script></h5>
               
          </div>
          
          <div class="mdb-form col-md-10">
              <label for="Surname">Surname</label>
          <h5><script> document.write('{{$EC_Sname}}') </script></h5>
               
          </div>  
            
            
          <div class="mdb-form col-md-10">
              <label for="Telephone">Home Telephone (Personal)</label>
          <h5><script> document.write('{{$EC_H_Telephone}}') </script></h5>
               
          </div>   
          <div class="mdb-form col-md-10">
              <label for="Mobile">Mobile (Personal)</label>
          <h5><script> document.write('{{$EC_M_Telephone}}') </script></h5>
			  </div> 
             </fieldset>
          

          
</fieldset>  
          
		  
      </div>
		
		
            </div>
         
            
      
          
        
          

      
      </div>
    </div>
  </div>

</div>
       

@stop

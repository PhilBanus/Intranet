@extends('intranet')
@section('bg')
style="background-color: #f9f9f9!important"
@stop
@section('content')



<?php use Carbon\Carbon ?>
<style type="text/css">
<!--
/* @group Blink */
.blink {
	-webkit-animation: blink 1s linear infinite;
	-moz-animation: blink 1s linear infinite;
	-ms-animation: blink 1s linear infinite;
	-o-animation: blink 1s linear infinite;
	 animation: blink 1s linear infinite;
}
@-webkit-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@-moz-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@-ms-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@-o-keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
@keyframes blink {
	0% { opacity: 0.2; }
	50% { opacity: 1; }
	50.01% { opacity: 1; }
	100% { opacity: 0.2; }
}
/* @end */
-->
	

</style>

@include('HelpDesk.AdminNav')
	

<div class="card bg-transparent mt-5 border-0 h-100">

<div class="card-header bg-transparent font-weight-bold border-primary">Your Tickets <div data-toggle="modal" data-target="#LogTicket" class="btn btn-sm btn-primary rounded-0 z-depth-1 float-right mb-0 point">Submit a Call</div></div>

	
	<div class="card-body ">
	<?php 
		
		$Calls = db::table('HELPDESK_Calls')->where('Contact',session('MY_ID'))->get()->take(50);
		
		foreach($Calls as $Call){
			?>
		
			<a data-toggle="modal" data-target="#Ticket" data-id="{{$Call->ID}}"><div class="card rounded-0 border-0 z-depth-1-half mb-2">
  <div class="card-body row" style="white-space: nowrap;">
	  <div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 col-4 ">
		  <div style="position: relative">
		  <div style="position: absolute; top: 0; left: auto; right: auto;" class=" w-100 mx-auto my-auto text-white font-weight-bolder small text-center black"><?php if($Call->Technician){ echo "Assigned To";}else{ echo "Awaiting";} ?></div>
	  	  <img src="<?php if(DB::table('HELPDESK_TechnicianImage')->where('Technician',$Call->Technician)->exists()){ echo DB::table('HELPDESK_TechnicianImage')->where('Technician',$Call->Technician)->first()->Image; }else{ echo "data:image/png;base64,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Hct/5c7tnKuyhsowRjl6RUqF93djp/7O95/x29/4a8bT/OYHWwAng8lCjyeWmK4rfREhsTkeh5Ae63K8sSgtoYXDCxov1DBTt8uP66mg1uY4P6vUKpMQpNR4b1nmNNvxJOP//E9/eSd25zqLdspNs+W9rMJwB48QHq0l3luMyREymF++jSGtZZ/ATamSCGrZQmXMuh6HDL2eFa42r9p7u9Sh4//+G399J8fc9Bacrz1ZYrfRMOwhOE7X1rukaYqUILwnz3O0vBvm1yLRjR8iJxxKShwWBEg9E2SHJQXIc8I7WeKlD6q3nYa39RLfa97fzaSYRYegjk7HS7tOKSX4nFTCp959TDdRTLMxadLFqrthfi38mpd9AreNtbaaW53n08qppmSy1F36LnN/e7FCvXc0WOr1lNpclmV4bNUTvomN+l+G1gt12tHcu79TOcy0kHegkOPuopXkS59+a6HHrGfBvWlK4U3TFOdmpldpprWRdl5VjV7aYXd7i7STIIuaWmx739I35auffZteJ7n5gQqOB2NeLHGnllKSJAk7Ozv0er0z4c+lndbtXvOyT+C2sTY4aZxzGFPke5ddI6NczyGl4B9+9VMLPeb3fri35GsCrSVb2xt0u52ZY1X6atduG60Xao/FeUNac4porYtp9K2//FfiF77+GR4teLDAt7738VKvqexbBxQ1ABZwVX5DG2l8SOs621hK6HRS7t27xzg/wBqLTpNz8exV571H2/zigiu0fvD0kL3j4VLvsfe+GppojJmzo9v67Bvfzui6etjwUFN2722zfzygPxmF0ksLSSrbmFD0ynQSzb/4R19b+CL/w299f9mXRq/XY3t7i263i5SWRCUYE0wypQTCN339n0cjGq6CeAnirONrdk0+B5168mmGdzkoi1CgpSo6hay2VGul+B//6dfZ3VxsJdW3/+4JP3z2ZhsjXOT8TN2Qx7uPWO8o8txhTMgiFMKji9BW22i8UVnvZCGlLLLJZvFnrXVoTog9E5uUbbj8G6Gk5F/+8tf5kbd2F3rc8TTnP/zJ95Z9eQAkSVI4SU1VI1Cq4G0UaGjpqvaVEywIc1XsoSQCVVRphY4iq4oQgl//pR/ns+89WPix/90ffpvh+PabOlx0TWdNiPv371ehrHrX2TbTeEdZnaq22s12becNXgpAIoUq3tICKcuKruXlJS+TX/35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"; } ?>" class="rounded z-depth-1 w-100 mx-auto my-auto techimg"  alt="...">
		  <div style="position: absolute; bottom: 0; left: auto; right: auto;" class=" w-100 mx-auto my-auto text-white  text-white font-weight-bolder small text-center black"><?php if($Call->Technician){ echo DB::table('Contact')->where('Contact_ID',$Call->Technician)->first()->Forename." ".DB::table('Contact')->where('Contact_ID',$Call->Technician)->first()->Surname ;}else{ echo "Assignment"; } ?></div>
			  </div>
</div>
	  <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7 col-7">
    <h5 class="card-title" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; ">{{base64_decode($Call->Subject)}}</h5>
    <p class="card-text text-truncate" style="max-width: 100%;
  white-space: nowrap;
  overflow: hidden; 
  text-overflow: ellipsis; " >{{base64_decode($Call->Description)}}</p>
    
		  
		  <div class="float-left small text-muted mr-4">Update: {{Carbon::create($Call->Last_Updated)->toDayDateTimeString()}}</div>
		  <div class="float-left small {{DB::table('HELPDESK_Category')->where('ID',$Call->Category)->first()->Color}} text-primary mr-4">{{DB::table('HELPDESK_Category')->where('ID',$Call->Category)->first()->Name}}</div>
		  <div class="float-left small text-muted mr-4">Comments: 5</div>
		  <div class="float-left small text-success mr-4 small blink">unread comments</div>
		 
		  
  </div>
	  
	  <div class="col-1 {{DB::table('HELPDESK_Status')->where('ID',$Call->Status)->first()->Color}} my-auto mx-auto"> <small>{{DB::table('HELPDESK_Status')->where('ID',$Call->Status)->first()->Name}}</small>  </div>
	    
			
			</div>
</div></a>
		
		
		<?php
		}
		
		?>
	
	
	
	
	</div>


</div>


  <div class="modal fade bg-dark" id="LogTicket" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Call Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
				<form action="HelpPosts" method="post" novalidate enctype="multipart/form-data">
              <div id="Form" class="modal-body needs-validation">
                 {{ csrf_field() }}
				   <div class="md-form mb-5">
          <input type="text" name="Contact" id="Contact" class="form-control validate" required value="{{session('MY_MOBILE')}}">
          <label data-error="wrong" data-success="right" for="Contact">Contact Number</label>
        </div>
				  
				     <span>Category</span>
				  <div class="mb-3 md-form">
      <select class="mdb-select" name="Category" required id="Category">
		  <option value="" disabled selected>Please Select</option>
              <option value="1">Themis</option>
                <option value="2">Network</option>
                <option value="3">Hardware</option>
                <option value="4">Telephony</option>
      </select>

    </div>
         
				  
				  <div class="md-form mb-5">
          <input type="text" name="Subject" id="Subject" class="form-control validate" required>
          <label data-error="wrong" data-success="right" for="Subject">Subject</label>
        </div>
				  
		<div class="md-form">
          
          <textarea type="text" id="Details" name="Details" class="md-textarea form-control" required rows="4"></textarea>
          <label data-error="wrong" data-success="right" for="Details">Extended Details</label>
        </div> 
				  
			<div class="md-form"> 
				  <div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Attachments</span>
      <input type="file" name="documents[]" id="Documents" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more files">
    </div>
  </div>
				</div>	   
				  
				  <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" id="SubmitTicket" name="submit" type="submit">Submit</button>
              </div>   
              </div>
           </form>
            </div>
          </div>
        </div>


<script>

 

(function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();




</script>



@stop



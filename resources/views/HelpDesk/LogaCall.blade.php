	<style>

		.logacall{
			position: fixed; 
			top: 100%;
			right: 2%; 
		    
			
		}
		
		

</style>			

<div class="card col-md-3 logacall">







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
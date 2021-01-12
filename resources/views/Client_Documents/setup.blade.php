@extends('project')

@section('content')

<style>

.progress .progress-bar {
  -webkit-transition: none;
       -o-transition: none;
          transition: none;
}

</style>

<div class="row h-100 p-0">

	<div class="col-md-4 bg-white h-md-100 m-0 p-0">
	<div class="card bg-white h-100 z-depth-2 m-0">
		<div class="card-body">
			
			<div class="btn d-flex justify-content-left btn-transparent waves-effect btn-lg border-0 z-depth-0 "><span class="fa-2x"><i class="fad fa-file-archive mr-3 text-warning"></i></span> <span class="fa-2x text-primary text-capitalize"  data-toggle="modal" data-target="#ZipUploadModal">Upload Client Docs</span></div>
			<div class="btn d-flex justify-content-left btn-transparent waves-effect btn-lg border-0 z-depth-0 "><span class="fa-2x"><i class="fad fa-folder mr-3 text-warning"></i></span> <span class="fa-2x text-primary text-capitalize">Create Folder Structure</span></div>
			
		</div></div>
	</div>
	
	<div class="col-md-8 bg-light h-md-100 m-0 p-0">
	
		<div class="card  bg-transparent z-depth-0">
		<div class="card-body">
			<large>
			<h4 class="text-primary">
			There are Currently no files/folders uploaded
			<br><br>
				Please initialise the folder structure by selecting one of the two options on the left.
			</h4>
				</large>
			</div>
		
		</div>
	
	</div>
	
	
	
<div class="modal fade" id="ZipUploadModal" tabindex="-1" role="dialog" aria-labelledby="ZipUploadModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fad fa-file-archive mr-3 text-warning"></i> Client Document Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="" method="post" enctype="multipart/form-data">
		   
		@csrf
		   <input type="number" value="{{Request()->code}}" hidden name="code">
		   <input type="number" value="{{Request()->ec}}" hidden name="ec">
		  <div class="custom-file">
  <input type="file" class="custom-file-input" name="cdDoc" accept=".zip,.rar,.7zip" id="ClientFile">
  <label class="custom-file-label" for="ClientFile">Choose file</label>
			  
	
</div>
		   
		  <div class="text-center">
		  <button type="submit" class="btn btn-transparent waves-effect text-capitalize text-primary text-center z-depth-0 btn-lg disabled" id="uploadFile"><i class="fad fa-upload text-primary"></i> Upload</button>
			  </div>
		  </form>
		  
		  <div class="card mb-2" id="upload" >
			 <div class="card-title">Uploading Zip</div>
		  <div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressbar" style="width:100%">
   
  </div>
</div>
			  </div>

		  
			    <div id="results" class="">
			  <div class="card z-depth-0 bg-dark text-warning">
				  <div class="card-body text-center" >
				  	<div id="resultsText"></div>
					  <div id="foldUp"></div>
					  <div id="docsUp"></div>
					  <div id="status">Storing . . . </div>
					  
					  
					  
				  </div>
					
					</div>
			  </div>
		  
		  

		  
		  
      </div>
      <div class="modal-footer">

		  <button type="button" class="btn btn-lg btn-transparent border-0 z-depth-0 text-primary waves-effect disabled"><i class="fad fa-arrow-square-right"></i> <span class="">Continue</span></button>
		  
      </div>
    </div>
  </div>
</div>
	
	
</div>


<script>
$('#upload').hide();
$('#results').hide();
	
	
	$('#ClientFile').on('change',function(){
		var FileName = $(this).val(); 
		
		if(FileName){
			$('#uploadFile').removeClass('disabled');
			
		}else{
			alert("no File")
		}
	})
	
	
	
	
	$('form').submit(function(event){
  event.preventDefault();
		
	var formData = new FormData($(this)[0]);
		var xhr2 = new XMLHttpRequest();
		var xhr = new XMLHttpRequest();
			xhr.open('POST', 'CDupload', true);
			xhr2.open('POST', 'CDextract', true);
			xhr.upload.onprogress = updateProgress;
			// Set up a handler for when the request finishes.
xhr.onload = function () {
  console.log('DONE: ', xhr.status);
	$('#results').show();
	var data = JSON.parse(xhr.responseText);
	$('#resultsText').append(data[1]['foldercount'] + ' Folders Found </br>');
	$('#resultsText').append(data[0]['count'] + ' Files Found </br>');
	
	findFiles(data[0]['count'],data[1]['foldercount']);
	
	
	
};
			
	// Send the Data.
xhr.send(formData);
xhr2.send(formData);
		
	})
	
	
	function updateProgress(evt) 
{
	$('#upload').show();
	console.log('event called')
   if (evt.lengthComputable) 
   {  // evt.loaded the bytes the browser received
      // evt.total the total bytes set by the header
      // jQuery UI progress bar to show the progress on screen
     var percentComplete = Math.floor((evt.loaded / evt.total) * 100);  
     $('#progressbar').css( "width", percentComplete+'%' );
     $('#progressbar').attr( "aria-valuenow", percentComplete );
     $('#progressbar').text( percentComplete+'%' );
   } 
}   
	
	
 function findFiles(file,folder){
	 
	 $.post('CDcheckDB',{code:{{Request()->code}},ec:{{Request()->ec}}}).done(
	 function(result){
		 console.log(result);
		 console.log(result[0]);
		 console.log(result[1]);
		 console.log(file);
		 console.log(folder);
		 if(result[0] <= folder || result[1] <= file){
			 
			 $('#foldUp').text(result[0] + ' Folders Stored');
			 $('#docsUp').text(result[1] + ' Files Stored');
			 findFiles(file,folder);
		 }
		 if(result[0] == folder & result[1] == file){
			  $('#foldUp').text(result[0] + ' Folders Stored');
			  $('#docsUp').text(result[1] + ' Files Stored');
			  $('#status').html('Complete');
		 }
		 
		 
		 
	 });
	 
	 
 }
	
	

</script>



@endsection

<div class="card bg-primary p-0 " >
	<div class="card-body p-1">
		<div class="d-flex">
			<div class=" col-sm-6 col-md-8">
	<div class="card-title text-white m-0">Operational Excellence Ideas Hopper</div>
		<p class="card-text text-info">Find out more about Operational Excellence</p>
		</div>
			<div class="col-sm-6 col-md-4">
			<div class="btn btn-default waves-effect p-2 text-capitalize py-2"  data-toggle="modal" data-target="#modalContactForm">Submit ideas here</div>
			</div>
			</div>
	</div>
	</div>


<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form id="opexForm" method="post" action="opexIdea"   enctype="multipart/form-data">
			@csrf
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Operational Excellence Ideas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-user prefix grey-text"></i>
          <input type="text" value="{{session('MY_USERNAME')}}" id="opexName" name="Name" class="form-control validate">
          <label data-error="wrong" data-success="right" for="opexName">Your name</label>
        </div>

        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <input type="email" id="opexEmail" value="{{session('MY_EMAIL')}}"  name="Email" class="form-control validate">
          <label data-error="wrong" data-success="right" for="opexEmail">Your email</label>
        </div>

        <div class="md-form mb-5">
          <i class="fas fa-tag prefix grey-text"></i>
          <input type="text" id="opexSubject" readonly value="Operational Excellence Idea" name="Subject" class="form-control validate">
          <label data-error="wrong" data-success="right" for="opexSubject">Subject</label>
        </div>

        <div class="md-form">
          <i class="fas fa-pencil prefix grey-text"></i>
          <textarea type="text" id="opexBody" class="md-textarea form-control" name="Body" rows="4"></textarea>
          <label data-error="wrong" data-success="right" for="opexBody">Your idea</label>
        </div>
		  
		<div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Choose file</span>
      <input type="file" name="document" id="file">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload your file">
    </div>
  </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="submit" onclick="form_submit()" id="asendOpex" class="btn btn-unique" data-dismiss="modal">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
      </div>
			</form>
    </div>
  </div>
</div>

<script>

	$('#sendOpex').on('click',function(){
		
		var Name = $('#opexName').val();
		var Email =$('#opexEmail').val();
		var Subject = $('#opexSubject').val();
		var Body = $('#opexBody').val();
		var File = $('#file').prop('files');
		
		
		var dialog = bootbox.dialog({
    message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Please wait while submit your idea...</p>',
    closeButton: false
});
            
		
		$.post('opexIdea',{ Name:Name,Email:Email,Subject:Subject,Body:Body,File:File }).done(function(){
			location.reload();
		})
// do something in the background

		
		dialog.modal('hide');
		
		
	})
	
	
  function form_submit() {
    document.getElementById("opexForm").submit();
   }    

</script>

@if (session('opexSuccess'))

<script>
	
	$(document).ready(function(){
		toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "md-toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": 300,
  "hideDuration": 1000,
  "timeOut": 5000,
  "extendedTimeOut": 1000,
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
	
Command: toastr["success"]("{{ session('opexSuccess') }}")


	})
</script>
  
@endif




<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height">
    <head>
       
		@include('Head_Scripts')
        <title>LPT2</title>

	
    </head>
   <body class="fixed-sn white-skin w-100 lighten-5 bg-light m-0 p-0 h-100" >
	

	<nav class="navbar navbar-light ">
  <a class="navbar-brand" href="#">
    <img src="data:image/png;base64,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" height="30" alt="mdb logo">
  </a>
		
		<select name="ProjectChanger" id="ProjectChanger" class="form-control w-auto">
		
			<option value="{{DB::table('Project')->where('Project_ID', '=', $ProjectID)->first()->Project_ID}}">{{DB::table('Project')->where('Project_ID', '=', $ProjectID)->first()->Name}}</option>
			
			@foreach( DB::table('Project')->where('Name','Like','%London Power Tunnels%')->where('Project_ID', '!=', $ProjectID)->get() as $Project)
			
			<option value="{{$Project->Project_ID}}">{{$Project->Name}}</option>
			
			@endforeach
			
		</select>
		
</nav>
				

<div class="container-fluid bg-light m-0 p-0 h-100">
	
		   
			
				@yield('content')

</div>
	   
	   <div id="footer"></div>
		
		
<script type="text/javascript" src="{{asset('/js/app.js')}}"></script>

<script type="text/javascript" src="{{asset('mdbootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/mdb.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons-pro/cards-extended.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons-pro/chat.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons-pro/multi-range.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons-pro/simple-charts.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons-pro/steppers.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons-pro/timeline.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons/datatables-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons/directives.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons/flag.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/js/addons/rating.min.js')}}"></script>
<script type="text/javascript" src="{{asset('mdbootstrap/wysiwyg/js/wysiwyg.js')}}"></script>
<script type="text/javascript" src="{{asset('countdown/jquery.countdown.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.2.1/build/ol.js"></script>
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList"></script>


<script type="text/javascript" src="{{asset('tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript" src="{{asset('tinymce/js/tinymce/jquery.tinymce.min.js')}}"></script>


<script>


	
$(document).ready(function() {
	

   
	
	$("#mdb-lightbox-ui").load("mdbootstrap/mdb-addons/mdb-lightbox-ui.html");
	
	
	$('.mdb-select').materialSelect({
    validate: true,
    labels: {
      validFeedback: 'Valid',
      invalidFeedback: 'Nothing Selected'
    }
  });
	


$('.datepicker').pickadate();
	
	

  // SideNav Button Initialization
	$(".button-collapse").sideNav({
    slim: true,
	breakpoint: 999,
	 edge: 'left', // Choose the horizontal origin
    
  });
		
// SideNav Scrollbar Initialization
var sideNavScrollbar = document.querySelector('.custom-scrollbar');
	if(sideNavScrollbar){
var ps = new PerfectScrollbar(sideNavScrollbar);
	}
	

		$('.data-table').DataTable();
  $('#dtMaterialDesignExample_wrapper').find('label').each(function () {
    $(this).parent().append($(this).children());
  });
  $('#dtMaterialDesignExample_wrapper .dataTables_filter').find('input').each(function () {
    const $this = $(this);
    $this.attr("placeholder", "Search");
    $this.removeClass('form-control-sm');
  });
  $('#dtMaterialDesignExample_wrapper .dataTables_length').addClass('d-flex flex-row');
  $('#dtMaterialDesignExample_wrapper .dataTables_filter').addClass('md-form');
  $('#dtMaterialDesignExample_wrapper select').removeClass(
  'custom-select custom-select-sm form-control form-control-sm');
  $('#dtMaterialDesignExample_wrapper select').addClass('mdb-select');
  $('#dtMaterialDesignExample_wrapper .mdb-select').materialSelect();
  $('#dtMaterialDesignExample_wrapper .dataTables_filter').find('label').remove();

	
		$(function () {
  $(".sticky").sticky({
    topSpacing: 90,
    zIndex: 2,
    stopper: "#footer"
});
});

	
	$(function() {
		if($(".fh-card").length > 0){
		var height = $(window).height();
		console.log(height)
		var offset = $(".fh-card").offset();
		height = height-offset.top-10;
		
		
		$(".fh-card").css("max-height", height)
		}
	})
	
	
	$(function() {
		if($(".fix-at-5").length > 0){
			$('.fix-at-5').each(function(){
				if($(this).children('.fixed-at-5-item').length >= 5){
			
			var height = $(this).find('.fixed-at-5-item:first-child').outerHeight()*5.2;
		 	$(this).css("height", height);
				
		}
				
			})
	
			
		}
	})
	
	
	
	var csrf_token = $('meta[name="csrf-token"]').attr('content');
$.ajaxPrefilter(function(options, originalOptions, jqXHR){
    if (options.type.toLowerCase() === "post") {
        // initialize `data` to empty string if it does not exist
        options.data = options.data || "";

        // add leading ampersand if `data` is non-empty
        options.data += options.data?"&":"";

        // add _token entry
        options.data += "_token=" + encodeURIComponent(csrf_token);
    }
});
	
	
	<?php if(isset($_GET['HelpThanks'])){
	?>
	
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "md-toast-top-center",
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
	
	Command: toastr["success"]("Your call has been logged with ID: <?php echo $_GET['HelpThanks'] ?> ", "Thank you.")

	
	<?php
}
	?>

	
});
	
	
	
		function validateSelect(e) {
    e.preventDefault();
    
    if ($('.needs-validation select').val() === null) {
      $('.needs-validation').find('.valid-feedback').hide();
      $('.needs-validation').find('.invalid-feedback').show();
    } else {
      $('.needs-validation').find('.valid-feedback').show();
      $('.needs-validation').find('.invalid-feedback').hide();
    }
			$('.needs-validation').addClass('was-validated');
  }
  $('.needs-validation select').on('change', function(e){validateSelect(e)})
  $('.needs-validation').on('submit', function(e){validateSelect(e)})


		

	


</script>

<div class="modal fade top w-100 h-100 primary-color rounded-0" id="Ticket" tabindex="-1" role="dialog" aria-labelledby="TicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-fluid modal-full-height modal-top w-100 h-100 p-4" role="document">
    <div class="modal-content w-100 h-100">
      <div class="modal-header bg-dark border-0 rounded-0 text-white">
        <h5 class="modal-title " id="TicketLabel">Modal title</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0 m-0 custom-scrollbar border-0" id="TicketDetails">
        ...
      </div>
    
    </div>
  </div>
</div>

<script>
$('#Ticket').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var id = button.data('id') // Extract info from data-* attributes
var modal = $(this)
$('#TicketDetails').load("TicketDetails?ID="+id)
var Subject = modal.find('.Subject').text()

modal.find('.modal-title').text('#' + id );

	
	
	
})
	
	$('#Ticket').on('hidden.bs.modal', function (event) {

$('#TicketDetails').html("Hi");

	
	
})
</script>

			<script>
				
				$(document).ready(function(){
					
		if($(".fhl-card").length > 0){
		var height = $(window).height();
		console.log(height)
			
		$(".fhl-card").each(function(){
			
			var offset = $(this).offset();
		var theight = height-offset.top;
		
		
		$(this).css("max-height", theight)
		$(this).css("height", theight)
		}
		
		)
		
		}
					
					$('#ProjectChanger').on('change',function(){
						location.href = window.location.pathname+'?ID='+$(this).val();
					})

					
				})
				
			

</script> 
	   
	   
	   
    </body>
</html>

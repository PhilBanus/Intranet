
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/modules/sidenav.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/mdb.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons-pro/cards-extended.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons-pro/chat.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons-pro/multi-range.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons-pro/simple-charts.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons-pro/steppers.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons-pro/timeline.min.js') }}"></script>


<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons/datatables2.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons/datatables-select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons/directives.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons/flag.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/js/addons/rating.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('mdbootstrap/wysiwyg/js/wysiwyg.js') }}"></script>
<script type="text/javascript" src="{{ asset('countdown/jquery.countdown.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.js"></script>
<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.2.1/build/ol.js"></script>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList"></script>


<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>

<script>


	
$(document).ready(function() {
	

   	if (window.document.documentMode) {
        $('.mdb-select').addClass('browser-default');
        $('.mdb-select').removeClass('mdb-select');
    }
	
	$("#mdb-lightbox-ui").load("mdbootstrap/mdb-addons/mdb-lightbox-ui.html");
	
	if($('.mdb-select').length > 0 ){
	$('.mdb-select').materialSelect({
    validate: true,
    labels: {
      validFeedback: 'Valid',
      invalidFeedback: 'Nothing Selected'
    }
  });
	}
	
	if($('.mdb-selectOv').length > 0 ){
		$('.mdb-selectOv').materialSelect({
    validate: true,
    labels: {
      validFeedback: 'Valid',
      invalidFeedback: 'Nothing Selected'
    }
  });
	
	}
	if($('.ignoredefault').length > 0 ){ } else{ 
if($('.datepicker').length > 0 ){
  
if($('.Newdatepicker').length > 0 ){
}else{
$('.datepicker').pickadate();
}

}	
if($('.Newdatepicker').length > 0 ){

$('.datepicker').datepicker({
    today: 'Today',
    buttonClear: 'picker__button--clear',
buttonClose: 'picker__button--close',
buttonToday: 'picker__button--today',
    formatSubmit: 'dd/mm/yyyy',
    format: 'dd mmmm yyyy',
hiddenPrefix: 'prefix__',
hiddenSuffix: '__suffix'
});
	
}
}
if($('.button-collapse').length > 0){
	if($('.button-collapse.wider').length > 0){ }else{
  // SideNav Button Initialization
	$(".button-collapse").sideNav({
    slim: true,
	breakpoint: 999,
	 edge: 'left', // Choose the horizontal origin
    
  });
		
	}
		
// SideNav Scrollbar Initialization
var sideNavScrollbar = document.querySelector('.custom-scrollbar');
	if(sideNavScrollbar){
var ps = new PerfectScrollbar(sideNavScrollbar);
	}
	
}
	
if($('.data-table').length > 0){
		$('.data-table').DataTable();
}
	
	if($('#dtMaterialDesignExample_wrapper').length > 0){
	
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

	}
	
	if($('.sticky').length > 0){
		$(function () {
  $(".sticky").sticky({
    topSpacing: 90,
    zIndex: 2,
    stopper: "#footer"
});
});
		
	}

	
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

	
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
	
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

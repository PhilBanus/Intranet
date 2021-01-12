
<script type="text/javascript" src="./js/app.js"></script>
<script type="text/javascript" src="mdbootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/mdb.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/mdb.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons-pro/cards-extended.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons-pro/chat.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons-pro/multi-range.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons-pro/simple-charts.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons-pro/steppers.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons-pro/timeline.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons/datatables.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons/datatables-select.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons/directives.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons/flag.min.js"></script>
<script type="text/javascript" src="mdbootstrap/js/addons/rating.min.js"></script>
<script type="text/javascript" src="countdown/jquery.countdown.js"></script>

<script>
$(document).ready(function() {
	

	
	$("#mdb-lightbox-ui").load("mdbootstrap/mdb-addons/mdb-lightbox-ui.html");
	
	
	$('.mdb-select').materialSelect({
    validate: true,
    labels: {
      validFeedback: 'Correct choice',
      invalidFeedback: 'Wrong choice'
    }
  });
	


$('.datepicker').pickadate();
	
$(".button-collapse").sideNav({
    slim: true,
  });
			

  // SideNav Button Initialization
$(".button-collapse").sideNav();
// SideNav Scrollbar Initialization
var sideNavScrollbar = document.querySelector('.custom-scrollbar');
var ps = new PerfectScrollbar(sideNavScrollbar);
	
	

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
	
	

	
});
	
	

		

	


</script>




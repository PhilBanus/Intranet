@extends('project')

@section('content')

<style>
	
		   header, main, footer, nav {
  padding-left: 300px !important;
}
		.button-collapse{
				display: none !important;
			}   

		   
		@media only screen and (max-width : 1200px) {
  header, main, footer, nav {
    padding-left: 0 !important;
	 
  }
			.button-collapse{
				display: block !important;
			}
}
	
	
#folders a.active{
	border-right: 10px #aab62a solid !important;
	}
	
	#folders a.active > .rotated-icon{
		transform: rotate(180deg)
		
	}
	
	.btn_hvr:hover{
		filter: brightness(125%);
		cursor: pointer;
	}
	
	#folders .TableOption:hover{
		filter: brightness(75%);
		cursor: pointer;
	}
	
	#folders .tab-btn:hover{
		background: #FFFFFF;
		color:#024A94 !important;
		border-radius: 10px;
		cursor: pointer;
	}
	
	#folders .tab-btn.active{
		background: #FFFFFF;
		color:#024A94 !important;
		border-radius: 10px;
		cursor: pointer;
	}
	
	#folders .rotate {
		transform: rotate(180deg);
		cursor: pointer;
	}
	
	#folders .rotate2 {
		transform: rotate(180deg);
	}
	
	.rotate{
    -moz-transition: all 0.2s linear;
    -webkit-transition: all 0.2s linear;
    transition: all 0.2s linear;
		    position: absolute;
    top: 0.8rem;
    right: 0;
    margin-right: 1.25rem;
}

.rotate.down{
    -ms-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
}

	
</style>


<body class="fixed-sn hochtief-skin w-100 lighten-5 ">

  <!--Double navigation-->
  <header>
    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav sn-bg-4 fixed">
      <ul class="custom-scrollbar">
        <!-- Logo -->
  

			<ul class='collapsible collapsible-accordion bg-primary  list-group list-group-flush m-0'>
				
				<li class="list-group-item bg-primary text-white active p-0 w-100"><a data-id="home" class="collapsible-header w-100 waves-effect active"><i class=" fas fa-folder mr-2"></i> All Folders</a> </li>
           
			        <?php echo $top ?>
			  
         
    
        <!--/. Side navigation links -->
      </ul>
      </ul>
      <div class="sidenav-bg mask-strong"></div>
    </div>
    <!--/. Sidebar navigation -->
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg double-nav navbar-dark primary-color" id="topbar">
      <!-- SideNav slide-out button -->
      <div class="float-left text-dark">
        <a href="#" data-activates="slide-out" class="button-collapse wider"><i class="fal fa-bars"></i></a>
      </div>
      <!-- Breadcrumb-->
      <div class="breadcrumb-dn mr-auto">
        <p>Client Documents</p>
      </div>
		
	
		
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item" id="mod_Docs">
          <div class="nav-link waves-effect" id="Documentcheck"><i class="fas fa-envelope"></i> <span class="clearfix d-none d-sm-inline-block">My documents</span></div>
        </li>
       
      </ul>
    </nav>
    <nav class="navbar fixed-bottom navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav navbar-dark row mb-0 pb-0 pt-0" id="detailsArea" >
      
	

		
    </nav>
    <!-- /.Navbar -->
	  
	
  </header>
  <!--/.Double navigation-->

  <!--Main Layout-->
  <main class="mx-0" style="padding-top: 50px"  style="overflow: hidden">
 
	
				<div id="results" class="bg-white card-body h-100 m-0"  >

				</div>
		
		
		




	  
  </main>
  <!--Main Layout-->

</body>


	<!-- Central Modal Small -->
<div class="modal fade " id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

  <!-- Change class .modal-sm to change the size of the modal -->
  <div class="w-100 modal-dialog px-5 modal-dialog-scrollable pt-3 m-0" style="max-width: 100% !important" role="document">


    <div class="modal-content bg-dark w-100 h-100 mx-auto">
      <div class="modal-header border-0 bg-primary text-light">
        <h4 class="modal-title w-100" id="myModalLabel">My Checked Out Documents</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-2 bg-dark border-0" style="overflow-y: auto " id="CheckOutBody">
		
		
      </div>
      <div class="modal-footer border-0 bg-dark">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Central Modal Small -->

<div class="modal fade " id="propertiesModel" tabindex="-1" role="dialog" aria-labelledby="propertiesModel"
  aria-hidden="true">

  <!-- Change class .modal-sm to change the size of the modal -->
  <div class="w-100 modal-dialog modal-lg modal-dialog-scrollable text-center"  role="document">


    <div class="modal-content bg-dark w-100 h-100 mx-auto">
      <div class="modal-header border-0 bg-primary text-light">
        <h4 class="modal-title w-100" id="myModalLabel">Edit Document Properties / replace</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div  id="Property-modal-body">
      
			</div>
    </div>
  </div>
</div>



<script type="text/javascript" src="{{ asset('mdbootstrap/js/modules/sidenav.min.js') }}"></script>
<script>
	$(document).ready(function() {

  // SideNav Button Initialization
  $(".button-collapse.wider").sideNav({
	  menuWidth: 300, // Width for sidenav
	  
breakpoint: 1200,
  });
  // SideNav Scrollbar Initialization
  var sideNavScrollbar = document.querySelector('.custom-scrollbar');
  var ps = new PerfectScrollbar(sideNavScrollbar);
})
	
	function changeHeight(){
		var totalheight = $(window).height()
		var headheight = $('.dataTables_scrollHead').height();
		var detailsArea = $('#detailsArea').height();
	
		var searchbar = $('.dataTables_length').parent().parent().height();
		var topbar = $('#topbar').height();
		var bottombar = $('.navbar.fixed-bottom').height();
		var documentsmainbody = $('main').height();
		var scrollheader = $('.dataTables_scrollHead').height();
		var papginate = $('.dataTables_paginate').parent().parent().height();
		
		var FinalHeight = totalheight-topbar-searchbar-detailsArea-scrollheader-papginate-15;
		console.log(totalheight+" Total")
		console.log(topbar+" topbar")
		console.log(searchbar+" searchbar")
		console.log(detailsArea+" details")
		console.log(scrollheader+" tableheader")
		console.log(totalheight-topbar-searchbar-detailsArea-scrollheader+10)
		
		$('.dataTables_scrollBody').css("height",FinalHeight+"px")
	
	
	}
	
$(document).ready(function(){
	 var doc_ID = null;
	
	$("#Documentcheck").on("click", function(){
		$('#CheckOutBody').load('CDAjaxCheckout?code={{request('code')}}&ec={{request('ec')}}');
	})
	
	$("#results").load("CDAjaxTable?id=home&code={{request('code')}}&ec={{request('ec')}}");
	$('a').on('click', function(){
		var table_ID = $(this).data('id');
		$("#results").load("CDAjaxTable?id=" + table_ID + "&code={{request('code')}}&ec={{request('ec')}}");
	});	
	$('#mod_Docs').on('click', function(){
		$('#centralModalSm').modal('show');
	});
	$('#zip_Docs').on('click', function(){
		alert('test');
	});
	$('#summaryBtn').on('click', function(){
		$( ".tab-btn" ).removeClass( "active" )
		$( "#summaryBtn" ).addClass( "active" )
		$("#detailsArea").show("slow");
	  	$('#dropbtn').removeClass('rotate')
		$('#detailsArea').load('CDAjaxDetails?id=1&Data=' + doc_ID)
	});
	$('#readByBtn').on('click', function(){
		$( ".tab-btn" ).removeClass( "active" )
		$( "#readByBtn" ).addClass( "active" )
		$("#detailsArea").show("slow");
	  	$('#dropbtn').removeClass('rotate')
		$('#detailsArea').load('CDAjaxDetails?id=2&Data=' + doc_ID)
	});
	$('#versionsBtn').on('click', function(){
		$( ".tab-btn" ).removeClass( "active" )
		$( "#versionsBtn" ).addClass( "active" )
		$("#detailsArea").show("slow");
	  	$('#dropbtn').removeClass('rotate')
		$('#detailsArea').load('CDAjaxDetails?id=3&Data=' + doc_ID)
	});
	
	$('#dropbtn').on('click', function(){
		$("#detailsArea").toggle("slow");
			$(this).toggleClass('rotate');
	});
	
	
	$('[tag=parent]').on('click',function(){
		$(this).find('.rotate').toggleClass("down"); 
	});
	
	

	
});
	
	$(window).on('resize',function(){
			changeHeight()
	})
	
	
	function reloadMyDocs(id){
		$.post('CDcancel',{id:id})
		$('#CheckOutBody').load('CDAjaxCheckout?code={{request('code')}}&ec={{request('ec')}}');
	}
	
	
</script>

@endsection
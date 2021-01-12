

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="full-height">
    <head>
       
		@include('Head_Scripts')
        <title>LPT2</title>

		
	
   <style>
	   .side-nav{
		   width: 300px
	   }
		   header, main, footer, nav {
  padding-left: 300px !important;
}
		.button-collapse{
				display: none !important;
			}   
	body{
				overflow-x: hidden !important
			}  
		   
		@media only screen and (max-width : 1200px) {
  header, main, footer, nav {
    padding-left: 0 !important;
	 
  }
			.button-collapse{
				display: block !important;
			}
			
			body{
				overflow-x: hidden !important
			}
}
	
	
#folders a.active{
	border-right: 10px #aab62a solid !important;
	}
	
	#folders a.active > .rotated-icon{
		transform: rotate(180deg)
		
	}
	
	#folders .btn_hvr:hover{
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
 </head>

<body class="fixed-sn hochtief-skin w-100 lighten-5 " style="background-color: #EDEAEB; overflow-x: hidden !important">

  <!--Double navigation-->
  <header>
    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav bg-primary fixed">
      <ul class="custom-scrollbar">
        <!-- Logo -->
		   <li>
      <div class="logo-wrapper waves-light bg-white h-auto p-1">
        <a href="#" class="w-100 h-100"><img src="{{asset('LPT/HMJV 2017.png')}}"
            class="img-fluid flex-center p-0"></a>
      </div>
    </li>
		  
		   <li>
      <ul class="social">
		  <li><cite>"One Team, One Spirit"</cite></li>
			   </ul>
		  </li>
  

			<ul class='collapsible collapsible-accordion bg-primary  list-group list-group-flush m-0'>
				
			  <li class="active"><a class="collapsible-header waves-effect arrow-r active"><i class="fas fa-globe"></i> Useful Links <i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
            
					<li><a href='http://londonpowertunnels.co.uk' class='waves-effect' target='_blank'>London Power Tunnels</a>
					<li><a href='https://www.nationalgrid.com' class='waves-effect' target='_blank'>National Grid</a>
					<li><a href='https://www.mykindafuture.com/success-story/national-grid/' class='waves-effect' target='_blank'>My Kinda Future</a>
					<li><a href='https://www.thecalmzone.net' class='waves-effect' target='_blank'>The Calm Zone</a>
						
				
                </ul>
              </div>
            </li>
           
			    
			  
         
    
        <!--/. Side navigation links -->
      </ul>
      </ul>
      
    </div>
    <!--/. Sidebar navigation -->
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg double-nav navbar-light text-primary" style="background-color: #fff" id="topbar">
      <!-- SideNav slide-out button -->
      <div class="float-left  text-primary">
        <a href="#" data-activates="slide-out" class="button-collapse wider"><i class="fal fa-bars  text-primary"></i></a>
      </div>
      <!-- Breadcrumb-->
     <ul class="nav navbar-nav nav-flex-icons mr-auto">
        <li class="breadcrumb-dn pl-2">
			<p>Welcome to London Power Tunnels 2 Tunnels & Shafts</p>
       </li>
       
      </ul>
		
	
		
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item ml-auto">
          <div class="navbar-brand"><img src="{{asset('LPT/National_Grid.png')}}" alt="" height="20"></div>
        </li>
       
      </ul>
    </nav>
    <nav class="navbar fixed-bottom navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav navbar-dark row mb-0 pb-0 pt-0" id="detailsArea" >
      
	

		
    </nav>
    <!-- /.Navbar -->
	  
	
  </header>
  <!--/.Double navigation-->

  <!--Main Layout-->
  <main class="mx-auto ">
 
	  <div class="container-fluid row p-1 m-0 " style="column-gap: 0;">
	  
	 <div class="col-md-6">
	<div class="card bg-transparent text-white rounded-0 m-1 z-depth-0">
  <img class="card-img p-0 m-0 w-100 rounded-0" src="{{asset('LPT/Tunnel-routes_1530x487.jpg')}}" alt="Card image">
 
</div>
</div>
		  
		
		  <div class="col-md-6 p-1">
		  <div class="card z-depth-0 h-100 rounded-0 border-0">
			  <div class="card-header text-light border-0 rounded-0 position-relative" style="background-color: #25475f !important"> <div class="btn-floating z-depth-0 btn-sm m-0 p-0" style="background-color: #8591a5"><i class="fad fa-tasks-alt"></i></div> HMJV Management Systems  </div>
		  <div class="card-body row">
			  
			    <div class="col-md p-1">
		  <div class="card z-depth-0 h-100 border-0">
			  <div class="card-header text-white border-0 rounded-0 position-relative" style="background-color:  #8591a5
 !important">Useful Templates</div>
		  <div class="card-body p-0 m-0">
			  
			  <ul class="list-group list-group-flush">
			   <li class="list-group-item  list-group-item-action">
      <a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
</span> Example Document</a> 
    </li>
			 
			  </ul>
			  
			  </div></div>
</div>
			  
			    <div class="col-md p-1">
		  <div class="card z-depth-0 h-100 border-0">
			  <div class="card-header text-white border-0 rounded-0 position-relative" style="background-color:  #8591a5
 !important">What's Changed</div>
		   <div class="card-body p-0 m-0">
			  
			  <ul class="list-group list-group-flush">
			   <li class="list-group-item  list-group-item-action">
      <a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
</span> Example Document</a> 
    </li>
			 
			  </ul>
			  
			  </div></div>
</div>
			  
			  </div></div>
</div> 
		
		  <div class="col-md-8 p-1">
		  <div class="card z-depth-0 h-100 rounded-0 border-0">
			  <div class="card-header text-light border-0 rounded-0 position-relative" style="background-color: #25475f !important"> <div class="btn-floating z-depth-0 btn-sm m-0 p-0" style="background-color: #8591a5"><i class="fad fa-heartbeat"></i></div> Health, Safety and Wellbeing</div>
		  <div class="card-body row">
			  
			    <div class="col-md p-1">
		 <div class="card z-depth-0 h-100 border-0">
			  <div class="card-header text-white border-0 rounded-0 position-relative" style="background-color:  #8591a5
 !important">Useful Forms</div>
		  <div class="card-body p-0 m-0">
			  
			  <ul class="list-group list-group-flush">
			   <li class="list-group-item  list-group-item-action">
      <a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
</span> Example Document</a> 
    </li>
			 
			  </ul>
			  
			  </div></div>
</div>
			    <div class="col-md p-1">
		  <div class="card z-depth-0 h-100 border-0">
			  <div class="card-header text-white border-0 rounded-0 position-relative" style="background-color:  #8591a5
 !important">Occupational Health</div>
		   <div class="card-body p-0 m-0">
			  
			  <ul class="list-group list-group-flush">
			   <li class="list-group-item  list-group-item-action">
      <a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
</span> Example Document</a> 
    </li>
			 
			  </ul>
			  
			  </div></div>
</div>
			  
			    <div class="col-md p-1">
		 <div class="card z-depth-0 h-100 border-0">
			  <div class="card-header text-white border-0 rounded-0 position-relative" style="background-color:  #8591a5
 !important">Posters</div>
		  <div class="card-body p-0 m-0">
			  
			  <ul class="list-group list-group-flush">
			   <li class="list-group-item  list-group-item-action">
      <a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
</span> Example Document</a> 
    </li>
			 
			  </ul>
			  
			  </div></div>
</div>
			  
			  </div></div>
</div> 
		  
		   <div class="col-md-4 p-1">
		 <div class="card z-depth-0 h-100 rounded-0 border-0">
			  <div class="card-header text-light border-0 rounded-0 position-relative" style="background-color: #25475f !important"> <div class="btn-floating z-depth-0 btn-sm m-0 p-0" style="background-color: #8591a5"><i class="fad fa-walkie-talkie"></i></div> Project Communications</div>
		   <div class="card-body p-0 m-0">
			  
			  <ul class="list-group list-group-flush">
			   <li class="list-group-item  list-group-item-action">
      <a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
</span> Example Document</a> 
    </li>
			 
			  </ul>
			  
			  </div></div>
</div> 
		
	  
	  </div>


	  
  </main>
  <!--Main Layout-->

	@include('Footer_Scripts')
	
		<!-- Central Modal Small -->

<!-- Central Modal Small -->

<script type="text/javascript" src="{{ asset('mdbootstrap/js/modules/sidenav.min.js') }}"></script>
<script>
	
	
	$(document).ready(function() {
$(".button-collapse.wider").sideNav({
	  menuWidth: 300, // Width for sidenav
	  
breakpoint: 1200,
  });
  // SideNav Button Initialization
  
  // SideNav Scrollbar Initialization
  var sideNavScrollbar = document.querySelector('.custom-scrollbar');
  var ps = new PerfectScrollbar(sideNavScrollbar);
})
	


</script>
	
	
	
</body>







</html>


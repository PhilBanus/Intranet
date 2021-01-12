<!--Double navigation-->
  <header>
    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav fixed wide custom-scrollbar" style="background: #404040">
   
        <!--/. Logo -->
        <!--Social-->
    
        <!--/Social-->
        <!--Search Form-->
        
		<div class="card testimonial-card bg-transparent">

        <!--Background color-->
      

        <!--Avatar-->
        <div class=" mx-auto bg-transparent border-0 p-2 m-0 d-flex"><img src="{{session('MY_PHOTO')}}"
            alt="{{session('MY_USERNAME')}}" class="rounded-circle img-fluid mx-auto" style="max-width: 80px; width: 30% height=auto" >
        </div>
		
			
		 <div class="card-body p-0 m-0">
          <!--Name-->
          <h5 class="card-title mt-1 ">{{session('MY_USERNAME')}}</h5>
         
          <p class="small no-wrap">{{session('MY_JOBTITLE')}}</p>
        </div>
		
		</div>
				
          <ul class="collapsible collapsible-accordion">
			  
			
			  
			  <li><a class="collapsible-header waves-effect arrow-r"><i class="fas fa-globe"></i> Useful Links <i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
                <?php 
					$Links = DB::table("UKHT_Useful_Links")->get();
					
					foreach($Links as $Link){
						
						echo "<li><a href='".$Link->Link."' class='waves-effect' target='_blank'>".$Link->Name."</a>";
						
					}
					
					
					?>
				
                </ul>
              </div>
            </li>
			  
			  
			   <?php 
					$Headers = DB::table("UKHT_User_Role")
						->join('UKHT_Roles','UKHT_Roles.ID','UKHT_User_Role.Role_ID')
						->join('UKHT_Nav_Access','UKHT_Nav_Access.Role_ID','UKHT_Roles.ID')
						->join('UKHT_Nav','UKHT_Nav_Access.Nav_ID','UKHT_Nav.ID')
						->join('UKHT_Nav_Headers','UKHT_Nav_Headers.ID','UKHT_Nav.Header')
						->select('UKHT_Nav_Headers.ID','UKHT_Nav_Headers.Name','UKHT_Nav_Headers.ShortName','UKHT_Nav_Headers.Icon','UKHT_Nav_Headers.Order')->distinct()
						->where('UKHT_User_Role.User_ID', '=', session('MY_ID'))
						->orderby('UKHT_Nav_Headers.Order','asc')
						->get();
					
		
					foreach($Headers as $Header){ ?>
			  
			  <li><a class="collapsible-header waves-effect arrow-r"><i class="{{$Header->Icon}}"></i> 
				  <span class="sv-slim"> {{$Header->ShortName}} </span>
                  <span class="sv-normal">{{$Header->Name}}</span>
				   <i class="fas fa-angle-down rotate-icon"></i></a>
              <div class="collapsible-body">
                <ul>
                <?php 
					$Navs = DB::table("UKHT_User_Role")
						->join('UKHT_Roles','UKHT_Roles.ID','UKHT_User_Role.Role_ID')
						->join('UKHT_Nav_Access','UKHT_Nav_Access.Role_ID','UKHT_Roles.ID')
						->join('UKHT_Nav','UKHT_Nav_Access.Nav_ID','UKHT_Nav.ID')
						->select('UKHT_Nav.ID','UKHT_Nav.Name','UKHT_Nav.ShortName','UKHT_Nav.Link')->distinct()
						->where('UKHT_User_Role.User_ID',session('MY_ID'))
						->where("Header","=",$Header->ID)->get();
					
					foreach($Navs as $Nav){
						
						echo "<li><a href='".$Nav->Link."' class='waves-effect'><span class='sv-slim'> {$Nav->ShortName} </span>
                  <span class='sv-normal'>{$Nav->Name}</span></a>";
						
					}
					
					
					?>
				
                </ul>
              </div>
            </li>
			  
			  <?php 
						}
					
					
					?>
		
			  
			  
        
   
			 
            
          </ul>
		<ul class="collapsible collapsible-accordion fixed-bottom" hidden>
       <li><a id="toggle" class="waves-effect"><i class="sv-slim-icon fas fa-angle-double-left"></i>Minimize
            menu</a>
        </li></ul>
    </div>
    <!--/. Sidebar navigation -->
    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
      <!-- SideNav slide-out button -->
      <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse text-dark"><i class="fas fa-bars"></i></a>
      </div>
      <!-- Breadcrumb-->
      
		  <a class="navbar-brand pl-4" href="intranet">
     <img src="{{ asset('public/images/intranet.png') }}" height="40" class="d-inline-block align-top">
		
			 
			  </a>
  
      <ul class="nav navbar-nav nav-flex-icons ml-auto waves-effect waves-dark align-top">
        
		  
		  <form class="search-form pl-2 text-dark" role="search">
            <div class="form-inline ">
				
              <input type="text" class="form-control text-dark border-0"  id="IMSSearcher" placeholder="IMS Portal Search . . .">
				
	
            </div>
          </form>
        	
      </ul>
    </nav>
    <!-- /.Navbar -->
  </header>

  <!--/.Double navigation-->

<script>

	$(document).ready(function() {
		
		 var instance = new Mark("a.IMSDoc");
	
function imsSearch(str) {

	
	
  if (str.length==0) {
	  $('#imsSearch').hide();
	  $('#imsSearch').siblings('.container-fluid').show()
    document.getElementById("imsSearch").innerHTML="";
    document.getElementById("imsSearch").style.border="0px";
    return;
	  
  }else{
	  
	  $('#imsSearch').show();
	  $('#imsSearch').siblings('.container-fluid').hide()
	  
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("imsSearch").innerHTML= this.responseText;
	
      document.getElementById("imsSearch").style.border="1px solid #A5ACB2";
			
	$('a.IMSDoc').mark(str);

		
    }
	  
	  
	 
  }
  xmlhttp.open("GET","imssearch?q="+str,true);
  xmlhttp.send();
  }
			

}
	
		
	$('#IMSSearcher').keyup(delay(function (e) {
		imsSearch(this.value)
		console.log(this.value)
}, 500));
	
	$('#IMSSearcher').focusout(delay(function (e) {
		$('#imsSearch').hide();
		$('#imsSearch').siblings('.container-fluid').show()
		
	}, 500));
	
	function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}

	
		
	})

</script>

<?php 
	
	$Projects = DB::table("UKHT_Alerts")->join("UKHT_Alert_Recipients","UKHT_Alert_Recipients.Alert_ID","=","UKHT_Alerts.ID")->where("UKHT_Alert_Recipients.Contact_ID","=",session('MY_ID'))->where("Active","=","1")->where('Read',0)->where('Type','fas fa-exclamation-triangle')->orderby('Read','asc')->orderby('Alert_ID','desc');
	
	if($Projects->exists()){
	
	foreach($Projects->get() as $Project)
	{ ?>

<div class="modal fade right alertModal" id="alert{{$Project->ID}}" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header {{$Project->Color}}">
        <h5 class="modal-title " id="exampleModalPreviewLabel"><i class="{{$Project->Type}}"></i> {{urldecode($Project->Subject)}}</h5>
       
         
        </button>
      </div>
      <div class="modal-body">
       <?php echo urldecode($Project->Body) ?>
      </div>
      <div class="footer pt-3 mdb-color lighten-3">



      <div class="row mt-2 mb-3 d-flex justify-content-center">
    
		  <button data-dismiss="modal" class="btn btn-lg primary-color-dark text-white" onClick="markAsReadAlert({{$Project->Alert_ID}},{{session('MY_ID')}},$('#andiv{{$Project->ID}}'))" >I have read this Alert</button>
		  
      </div>

    </div>
    </div>
  </div>
</div>

<?php }} ?>


<script>

function markAsReadAlert(id,user,item){
		
		item.find('.badge').addClass('badge-success');
		item.find('.badge').removeClass('badge-danger');
		item.find('.badge').text('Read');
	
		
		$.post("readAlert",{ID: id, USER: user}).done(function(result){
						console.log(result);
						console.log(item);
			
			
						//location.reload();
					});
	}

</script>

<script>
	
	$(document).ready(function() {
$('.alertModal').first().modal('show')

$('.alertModal').on('hidden.bs.modal', function () {
  $(this).next('.alertModal').modal('show');
})		
		
		
	})
	
	
</script>
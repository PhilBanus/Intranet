

<div class="card border-0 p-2 mt-0" style="background-color: #151e53; overflow: hidden">
<!--Grid row-->
<div class="card-header text-center bg-transparent text-white"><span>Alerts and Notifications</span> <a href="MyNotifications" class="btn btn-sm btn-outline-light m-0 waves-effect" style="position: absolute; right: 1%">View all</a></div>

  <!--Grid column-->
			<div class="list-group-flush " style="overflow-y: auto">
<?php 
	
	$Projects = DB::table("UKHT_Alerts")->join("UKHT_Alert_Recipients","UKHT_Alert_Recipients.Alert_ID","=","UKHT_Alerts.ID")->where("UKHT_Alert_Recipients.Contact_ID","=",session('MY_ID'))->where("Active","=","1")->orderby('Read','asc')->orderby('Alert_ID','desc')->take(5);
	
	if($Projects->exists()){
	
	foreach($Projects->get() as $Project)
	{
	
	
	?>
    <!-- Card -->
    <div class="list-group-item list-group-item-action border-0 fixed-at-5-item {{$Project->Color}} point" id="andiv{{$Project->ID}}" onClick="markAsRead({{$Project->Alert_ID}},{{session('MY_ID')}},$(this))" data-toggle="modal" data-target="#alert{{$Project->ID}}">


          <!-- Content -->
   <p class="mb-0 text-truncate ">
	   
	   <i class="{{$Project->Type}}"></i> 
	  
	   
	   
	   <span class="">{{urldecode($Project->Subject)}} <?php if(!$Project->Read){ echo "<span class='badge badge-danger ml-auto float-right'>Not Read</span>"; }else{ echo "<span class='badge badge-success ml-auto float-right'>Read</span>"; }?></span>
</p>
            
    



    </div>   
	
		
	
<?php }
	
	}else{
	
		?>
	 <div class="list-group-item list-group-item-action border-0 fixed-at-5-item">


          <!-- Content -->
   <p class="mb-0"><i class="h-100"> </i> <span class="">You have no Alerts or Notifications</span></p>
            
    




    </div>   
	
	<?php
	
	
	}?>

	</div>
	</div>
 

<script>

	function markAsRead(id,user,item){
		
		item.find('.badge').addClass('badge-success');
		item.find('.badge').removeClass('badge-danger');
		item.find('.badge').text('Read');
	
		
		$.post("readAlert",{ID: id, USER: user}).done(function(result){
						console.log(result);
			
			
						//location.reload();
					});
	}
	
</script>
	
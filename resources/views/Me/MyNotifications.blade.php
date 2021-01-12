@extends('intranet')
@section('content')

<style>
.dataTables_wrapper{
color: white !important; 
	}

</style>
<div class="card border-0 p-2 mt-0" style="background-color: #151e53; overflow: hidden">
<!--Grid row-->
<div class="card-header text-center bg-transparent text-white"><span>Alerts and Notifications</span> <a href="home" class="btn btn-sm btn-outline-light m-0 waves-effect" style="position: absolute; left: 1%">Back</a></div>

  <!--Grid column-->
		
	<div class="card-body m-0">
<?php 
	
	$Projects = DB::table("UKHT_Alerts")->join("UKHT_Alert_Recipients","UKHT_Alert_Recipients.Alert_ID","=","UKHT_Alerts.ID")->where("UKHT_Alert_Recipients.Contact_ID","=",session('MY_ID'))->where("Active","=","1")->orderby('Read','asc')->orderby('Alert_ID','desc')->take(100);
	
	?>
	@if($Projects->exists())

	
		<table class="table table-hover data-table text-white">
			<thead>
			<th>Type</th>
			<th>Subject</th>
			<th>Read</th>
			
			</thead>
				<tbody>
		
	@foreach($Projects->get() as $Project)
	
    <tr class="{{$Project->Color}} point" id="andiv{{$Project->ID}}" onClick="markAsRead({{$Project->Alert_ID}},{{session('MY_ID')}},$(this))" data-toggle="modal" data-target="#alert{{$Project->ID}}">


          <!-- Content -->
   <td class="mb-0 text-truncate ">
	   
	   <i class="{{$Project->Type}}"></i> 
	  
	   
	   
	
</td>
		<td>
		{{urldecode($Project->Subject)}}
		</td>
            
    
   <td class=""> @if(!$Project->Read)
	   <span class='badge badge-danger ml-auto float-right'>Not Read</span>
	   @else
	   <span class='badge badge-success ml-auto float-right'>Read</span>
		@endif</td>


    </tr>   
	
	@endforeach	
	
					
					</tbody>

	</table>
	
	@else
	
	 <div class="list-group-item list-group-item-action border-0 fixed-at-5-item">


          <!-- Content -->
   <p class="mb-0"><i class="h-100"> </i> <span class="">You have no Alerts or Notifications</span></p>
            
    




    </div>   
	
@endif
					
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


<?php

$Projects = DB::table("UKHT_Alerts")->join("UKHT_Alert_Recipients","UKHT_Alert_Recipients.Alert_ID","=","UKHT_Alerts.ID")->where("UKHT_Alert_Recipients.Contact_ID","=",session('MY_ID'))->where("Active","=","1")->orderby('Read','asc')->orderby('Alert_ID','desc')->take(100);
	
	if($Projects->exists()){
	
	foreach($Projects->get() as $Project)
	{
	
	
	?>
    
	
				
				<div class="modal fade right" id="alert{{$Project->ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header {{$Project->Color}}">
        <h5 class="modal-title " id="exampleModalPreviewLabel"><i class="{{$Project->Type}}"></i> {{urldecode($Project->Subject)}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-2">
		<p>
       <?php echo urldecode($Project->Body) ?>
			</p>
      </div>
     
    </div>
  </div>
</div>
	
<?php } } ?>

@endsection
	
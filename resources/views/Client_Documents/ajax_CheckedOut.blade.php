		
 
<?php
$exists = $documents = DB::table('UKHT_CD_Document')->where(['editor' => session('MY_ID'), 'checked_out' => 1])->exists()

?>


@if ($exists == true)
		  @php   $documents = DB::table('UKHT_CD_Document')->where(['editor' => session('MY_ID'), 'checked_out' => 1])->get()    @endphp
        @foreach ($documents as $item)
		  <?php $ver = (double)$item->version + 0.1 ?>
		  
		  <div class="col-12 mx-auto card mb-2 p-0">
			  <div class="card-header text-light border-0 rounded-0 p-1 d-flex" style="background-color: #c8c8c8 !important"> 
			   <div class="mr-auto my-auto"><a class="text-dark"><span class="fa-stack text-primary ">
  <i class="fas fa-circle fa-stack-2x"></i>
  <i class="fas fa-file-word fa-stack-1x fa-inverse"></i>
				   </span>
				   {{$item->title}}
				   </div>
				   <div class="ml-auto my-auto p-0 d-flex">
				      
				  <a href="CDdownload?id={{$item->id}}" class="bg-primary m-0 p-2 text-white text-center waves-effect my-auto mr-2">
		 <i class="fas fa-download mx-auto "></i> 
					  Download
			</a>
			 <div  onClick="reloadMyDocs({{$item->id}})" class="bg-primary m-0 p-2 text-white text-center waves-effect ">
				 <i class="fas fa-ban"></i> 
				 Undo Check Out
			</div>
				   </div>
				   
			  </div>
				  
				 <form action="CDcheckIn" method="post" class="" enctype="multipart/form-data">  
			  <div class="col-md-12 card-body row p-2">
				
				<div class="col-md-7 row m-0">
			  <div class="col-md-4">
				  <label for="version" class="active"><small>Version</small></label>
    					<input type="text" class="form-control" value="{{$ver}}" name="version" placeholder="Text input">
			</div>
				  <div class="col-md-8">
				  <label for="version" class="active"><small>Description</small></label>
    					<textarea type="text" class="form-control"  name="description" rows="2" cols="6" >{{$item->description}}</textarea>
				  </div>
			</div>
					
				  <div class="col-md-5 m-0 ">
				  
			
				  <input type="number" value="{{$item->id}}" name="id" hidden="">
				  <input type="number" value="{{request('ec')}}" name="ec" hidden="">
				  <input type="number" value="{{request('code')}}" name="code" hidden="">
			   
					  <div class="custom-file">
						  <label class="custom-file-label" for="customFileLang">Click to upload document</label>
  <input type="file" class="custom-file-input" required name="document">
  
</div>
					    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="name{{$item->id}}" name="name">
    <label class="form-check-label" for="name{{$item->id}}">Change Document Title?</label>
  </div>
				  <button type="submit" class="py-2 btn btn-success float-right"><i class="fas fa-file-upload "></i> Check In</button>
			   
				  
				 </div>
					
			   
			  </div>
					 </form>
				  
			  </div>
		  @endforeach
@else
<div class="text-center text-white">
No Documents checked out.
</div>

@endif
		
			  
			  <script> 
			  
			  	$('.custom-file-input').on('change', function(){
		var val = $(this).val()
		$(this).siblings('label').text(val.replace(/.*[\/\\]/, ''))
	})
				  
				  	

	
	
			  </script>


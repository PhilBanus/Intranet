@extends("Intranet")
@section('content')

<div class="col-12 mb-2 ">
<div class="card">
	<div class="card-body">
	<div class="card-title">Images <small>- click to copy link</small> </div>
		
		<div class="w-100 row flex-row flex-nowrap" style="overflow: auto">
		
			<?php 
			
	
			
			 $images = \File::allFiles('alertImages');
			
			foreach($images as $image){
				
				 $data = getimagesize($image);
 $width = $data[0];
 $height = $data[1];
	 $imageData = base64_encode(file_get_contents(asset('alertImages/'.$image->getFilename())));

				?>
			<div class="border p-2 m-2" style="height: 100px; width: auto"><img   class="h-100" onClick="copyImageval('{{ asset('public/alertImages/' . $image->getFilename()) }}')" style="width: auto" data-value="{{$imageData}}" src="{{ asset('public/alertImages/' . $image->getFilename()) }}"></div>
			 
			
			<?php 
				
			}
			
			?>
		
		</div>
		
		
	</div>
	
	<div class="card-footer p-0 m-0">
		
		 @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
		{{Session::forget('success')}}
        @endif
		
		@if ($message = Session::get('errors'))
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
        </div>
		{{Session::forget('errors')}}
        @endif
  
        
		
	 <form action="{{ url('public/alertImageUploads') }}" method="post" enctype="multipart/form-data" class="md-form p-0 m-0 row col-md-6 ">
		 @csrf
  <div class="file-field col-md-10">
    <div class="btn btn-primary btn-sm float-left">
      <span>Choose file</span>
      <input type="file" name="fileToUpload" required id="file">
    </div>
    <div class="file-path-wrapper ">
      <input class="file-path validate" name="otherFile" type="text" autocomplete="off" placeholder="Upload your file">
    </div>
	   
  </div>
		 
	<button type="submit" class="btn btn-success col-md">Upload</button>
                   
           
</form>
	</div>
	
	</div></div>

<div class="row">

	
	<div class="mr-auto col-6">
	<div class="card">
	<!--Section: Live preview-->
<section class="form-light">

  <!--Form without header-->
  <div class="card">

    <div class="card-body mx-4">

      <!--Header-->
      <div class="text-center">
        <h3 class="pink-text mb-5"><strong>Create Alert</strong></h3>
      </div>

	 
	
		  
		
      <!--Body-->
      <div class="md-form">
        <input type="text" id="Subject" class="form-control" autocomplete="off">
        <label for="Subject">Subject</label>
		 
		  
		  <select class="mdb-select md-form" id="Color">
  <option disabled selected>Please Select...</option>
  <option value="blue text-white" class="blue">blue</option>
  <option value="red text-white" class="red">red</option>
  <option value="amber" class="amber">amber</option>
  <option value="yellow" class="yellow">yellow</option>
  <option value="success-color" class="yellow">green</option>

</select> 
		  <label for="Color">Banner Color</label>
		  
		  <select class="mdb-select md-form" id="Type">
  <option disabled selected>Please Select...</option>
  <option value="fas fa-exclamation-triangle" class="bg-blue">Alert</option>
  <option value="fas fa-info-circle" class="red">Notification</option>
 

</select>
		    <label for="Type">Type</label>
		  
		  
		  
		  <select class="mdb-select md-form" multiple  id="NotificationGroup">
  <option disabled selected>Please Select...</option>
  <?php
			$Groups = DB::table('UKHT_Alert_Groups')->get();  
			  
			  foreach($Groups as $Group){
				  
				  echo "<option value='$Group->ID'>$Group->Name</option>"; 
				  
				  
			  }
	
			  
			  ?>
 

</select>
		    <label for="NotificationGroup">Who to Notify</label>
		  
		  <div class="form-check md-form">
    <input type="checkbox" class="form-check-input" checked id="Email">
    <label class="form-check-label" for="Email">Do you want to Email Alert/Notification?</label>
</div>
		  
		    <textarea id="summernote" name="Body" runat="server" rows="15" cols="80" clientidmode="Static" style="width: 100%">
		  
				
				
		  
		  </textarea>  

		 
		  <button id="ImgResize" class="btn btn-lg">Resize Images</button>
		  <button id="ImgStop" style="display: none" class="btn btn-lg">Stop Resize</button>
		  
      </div>

      

      <!--Grid row-->
      <div class="row d-flex align-items-center mb-4">

        <!--Grid column-->
        <div class="col-md-6 col-md-12 text-center">
          <button type="button" class="btn btn-pink btn-block btn-rounded z-depth-1" id="Submit">Send Alert/Notification</button>
        </div>
     
      </div>
      <!--Grid row-->


    <!--Footer-->
   

    </div>

  </div>
  <!--/Form without header-->

</section>
<!--Section: Live preview-->
	
	</div>
	
	
	</div>

	
	<div class="ml-auto col-6">
		<div class="card border-0 bg-transparent" style="resize: ">
		<section class="form-light">
 <div class="text-center">
        <h3 class="pink-text "><strong>POP UP PREVIEW</strong></h3>
      </div>
  <!--Form without header-->
  <div class="card">
	  
	  <h5 class="card-header" id="alertHeader"><i class=""></i> <span></span></h5>

    <div class="card-body mx-4" id="alertBody">

      <!--Header-->
     

      <!--Body-->


      <!--Grid row-->
 
      <!--Grid row-->
    </div>

    <!--Footer-->
    <div class="footer pt-3 mdb-color lighten-3">



      <div class="row mt-2 mb-3 d-flex justify-content-center">
    
		  <button class="btn btn-lg primary-color-dark text-white">I have read this Alert</button>
		  
      </div>

    </div>

  </div>
  <!--/Form without header-->

</section>

		</div>
		<div class="text-center mt-5">
        <h3 class="pink-text "><strong>DASH PREVIEW</strong></h3>
      </div>
		<div class="card border-0 p-0 mb-0 mt-3" style="background-color: #aab62a; overflow: hidden">
<!--Grid row--> 
<div class="card-header text-center bg-transparent mb-0 text-white ">Alerts and Notifications</div>
		<div class="card-body border bg-white m-0 p-1">
			<div class="list-group-flush fix-at-5" style="overflow-y: auto;">
			
			 <div id="CardSubject" class="list-group-item list-group-item-action border-0 point Subject red">


          <!-- Content -->
   <p class="mb-0 text-truncate">
	   
	   <i class=""></i> 
	  
	   
	   
	   <span class="Subject-Text"></span></p>
            
    




    </div>  
			
			</div>
			
			
			</div>
			
		</div>
		
	</div>

</div>

 <input type="text" style="display: none" id="Clipper">

<script>

	$(document).ready(function(){
		 $('#summernote').mdbWYSIWYG();

		
		
		
		
		
		$('#Subject').keyup(function(){
			$('#alertHeader span').text($(this).val())
			$('.Subject-Text').text($(this).val())
		})
		

	
		
		$('.mdb-wysiwyg-textarea').on('keyup', function(we, e) {
			
			$(this).find('img').addClass('resizebleImage');
			$(this).find('img').removeClass('img-fluid');
			$(this).find('img').each(function(){
				$(this).attr('width',$(this).css('width').replace("px",""))
				$(this).attr('height',$(this).css('height').replace("px",""))
			});
			
			
			
  $('#alertBody').html($(this).html())
});
		
		$('.mdb-wysiwyg-textarea').on("DOMSubtreeModified", function(we, e) {
			$(this).find('img').addClass('resizebleImage');
			$(this).find('img').removeClass('img-fluid');
			$(this).find('img').each(function(){
				$(this).attr('width',$(this).css('width').replace("px",""))
				$(this).attr('height',$(this).css('height').replace("px",""))
			});
			
	$('#summernote').val($(this).html())		
  $('#alertBody').html($(this).html())
});
		
		$('#Color').on("change",function(){
			$('#alertHeader').removeClass();
			$('#CardSubject').removeClass();
			$('#alertHeader').addClass($(this).val());
			$('#CardSubject').addClass($(this).val());
			$('#alertHeader').addClass('card-header');
			$('#CardSubject').addClass('list-group-item list-group-item-action border-0 point Subject');
		})
		
		$('#Type').on("change",function(){
			$('#alertHeader i').removeClass();
			$('#CardSubject i').removeClass();
			$('#alertHeader i').addClass($(this).val());
			$('#CardSubject i').addClass($(this).val());
			
		})
		
		
		
		$('#Submit').on('click',function(){

		
				
			
				
	
			
			
			
			if ($('#Email').is(":checked"))
{
  var Email = true;
}else{
	var Email = false;
}
			
			bootbox.confirm("Are you sure you would like to send this Alert/Notification?", function(result){ 
    console.log('This was logged in the callback: ' + result); 
				
				if(result){
					var Subject = encodeURIComponent($('#Subject').val());
			var Body = encodeURIComponent($('#alertBody').html());
			var Color = encodeURIComponent($('#Color').val());
			var Type = encodeURIComponent($('#Type').val());
			var NotificationGroup = encodeURIComponent($('#NotificationGroup').val());
					$.post("sendAlert",{Subject: Subject, Body: Body, Color: Color, Type: Type, NotificationGroup: NotificationGroup, Email: Email}).done(function(result){
						console.log(result);
						//location.reload();
					})
					
					
				}
});
			
			
			
			
		})
		
		
		
		
		
	})

	
	function copyImageval(val) {
		$('#Clipper').show();
		$('#Clipper').val(val)
  var copyText = document.getElementById("Clipper");
  
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
		$('#Clipper').hide();
}
	
	
	function getBase64Image(img) {
  var canvas = document.createElement("canvas");
  canvas.width = img.width;
  canvas.height = img.height;
  var ctx = canvas.getContext("2d");
  ctx.drawImage(img, 0, 0);
  var dataURL = canvas.toDataURL("image/png");
  return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}
	
	
	
	function toDataURL(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}
	
	$('#ImgResize').on('click', function() {
   $(".resizebleImage").resizable({  
               ghost: true  
            });
		$('#ImgStop').show();
		$('#ImgResize').hide();
		$(".resizebleImage").css('display','inline-block')
	
}); 	
	
	$('#ImgStop').on('click', function() {
		$('#ImgResize').show();
		$('#ImgStop').hide();
   $(".resizebleImage").resizable('destroy');
		
		$(".resizebleImage").css('display','inline-block')
}); 

</script>


@stop
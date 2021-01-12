@extends("Intranet")
@section('content')


<?php



$Location = DB::table('UKHT_Locations')->where('ID',$_GET['id'])->first();

$id = $_GET['id'];


?>

<a href="Laptops" class="btn-floating  btn-default"><i class="fas fa-angle-double-left "></i></a>

<div class="card card-cascade narrower primary-color darker-5">

 <div class="view view-cascade  gradient-card-header blue-gradient">
	 <h4 class="card-header-title"> {{$Location->Name}} </h4>
  </div>

  <div class="card-body card-body-cascade text-center row">
	  
	  <div class="col-md-6">
		  <div class="card">
		 <div class="card-body px-lg-5 pt-0">  
<form class="needs-validation" novalidate>
      <!-- Email -->
      <div class="md-form">
        <input type="text" id="serialNum" class="form-control text-uppercase" required>
        <label for="serialNum">Serial Number</label>
		  <div class="invalid-feedback">
        Either empty or Already Exists
      </div>
      </div>

      <!-- Password -->
      <div class="md-form">
        <input type="text" id="Make" class="form-control" required>
        <label for="Make">Make</label>
      </div>
      <!-- Password -->
      <div class="md-form">
        <input type="text" id="Model" class="form-control" required>
        <label for="Model">Model</label>
      </div>
		  
	 

      <!-- Sign in button -->
      <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" id="submit" type="submit">Submit</button>

			 </form>   

			  </div>
			  </div>
	  </div>
	  
	  <div class="col-md-6">
	  <ul class="list-group" id="list">
	 
	  <?php 
		  
		  $Monitors = DB::table('UKHT_Monitors')->where('Location',$id)->get();
			  
			  foreach($Monitors as $Monitor){
				  
				  echo "<li class='list-group-item serial-item d-flex' data-id='$Monitor->Serial_Number' data-make='$Monitor->Make' data-model='$Monitor->Model'> <i class='fas fa-pen-alt mr-4 blue p-3 white-text rounded waves-effect mon-edit'></i> <span>$Monitor->Make: $Monitor->Serial_Number</span>  <i class='fas fa-dumpster-fire red p-3 white-text rounded ml-auto waves-effect mon-delete'></i> </li>";
				  
			  }
		  
		  
		  ?>
	  
	  </ul>
	   </div>
	  
	</div>
</div>


<script>

 
		
	
	(function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');

	
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
	event.preventDefault();
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}else{
		
		var Serial = $('#serialNum').val();
		var Make = $('#Make').val();
		var Model = $('#Model').val();
		var li = "<li class='list-group-item serial-item d-flex' data-id='"+Serial+"' data-make='"+Make+"' data-model='"+Model+"'><i class='fas fa-pen-alt mr-4 blue p-3 white-text rounded waves-effect mon-edit'></i> <span>"+Make+": "+Serial+"</span>  <i class='fas fa-dumpster-fire red p-3 white-text rounded ml-auto waves-effect mon-delete'></i> </li>";
		$('#list').prepend(li)
		
	$.post('monitorPost',{'_token': $('meta[name=csrf-token]').attr('content'),'L' : <?php echo $id ?>, 'Type' : "add",'MAKE': Make, 'MODEL': Model, 'SN': Serial}).done(function( data ) { console.log(data) });
	
	
		
		$('#serialNum').val('')
		$('#Make').val('')
		$('#Model').val('')

	
}
form.classList.add('was-validated');
	
	
	
	
	
	
}, false);
});
}, false);
})();


	
$('#serialNum').on('keyup',function(){
	var ser = $(this).val(); 
	var serarray = [];
	console.log(ser)
	$('.serial-item').each(function(){
	
		serarray.push($(this).data('id'))
	
	   })
	console.log($.inArray(ser, serarray))
	if($.inArray(ser, serarray) >= 0){
		console.log("exists")
		$('#serialNum').addClass('is-invalid');
		$('#serialNum').removeClass('is-valid');
		$('.serial-item').each(function(){
	
		if($(this).data('id') === ser){
			$(this).addClass('bg-light');
		}
	
	   })
		
	}else{
		console.log("nah")
		$('#serialNum').addClass('is-valid');
		$('#serialNum').removeClass('is-invalid');
		$('.serial-item').removeClass('bg-light');
	}
})
	
	
    $("#list").on('click', '.serial-item > .mon-delete', function() {
		var Serial = $(this).parent().data('id');
		var item = $(this).parent()
		bootbox.confirm({
    title: "Destroy Monitor?",centerVertical: 1,
    message: "Do you want to activate the Deathray now? This cannot be undone.",
    buttons: {
        cancel: {
            label: '<i class="fa fa-times"></i> Cancel'
        },
        confirm: {
            label: '<i class="fa fa-check"></i> Confirm'
        }
    },
    callback: function (result) {
        console.log('This was logged in the callback: ' + result);
		if(result){
				$.post('monitorPost',{'_token': $('meta[name=csrf-token]').attr('content'), 'Type' : "del",'SN': Serial}).done(function( data ) { console.log(data) });
			 item.remove()
		}
    }
});
		
		
	});
	
	
	
	  $("#list").on('click', '.serial-item > .mon-edit', function() {
		var Serial = $(this).parent().data('id');
		var olSerial = $(this).parent().data('id');
		var Make = $(this).parent().data('make');
		var Model = $(this).parent().data('model');
		var item = $(this).parent()
		bootbox.prompt({
    title: "Modify Serial", value: Serial,
    centerVertical: true,
    callback: function(result){ 
		if(result){
        Serial = result;
			
    }
		bootbox.prompt({
    title: "Modify Make", value: Make,
    centerVertical: true,
    callback: function(result){ 
       if(result){
        Make = result;
			
    }
  
		bootbox.prompt({
    title: "Modify Model", value: Model,
    centerVertical: true,
    callback: function(result){ 
        if(result){
        Model = result;
			
    }
		
		
		
		console.log(Serial+','+Make+','+Model)
		
		item.find('span').text(Make+": "+Serial);
		
	$.post('monitorPost',{'_token': $('meta[name=csrf-token]').attr('content'), 'Type' : "edit",'MAKE': Make, 'MODEL': Model, 'SN': Serial, 'olSerial': olSerial}).done(function( data ) { console.log(data) });

		
    }
		
	});	
		
	  }		
		
	});
		
		
		
	}
});
		
		
	});
		
		
	

</script>



@stop
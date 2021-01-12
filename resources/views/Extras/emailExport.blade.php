@extends("Intranet")
@section('content')





<div class="card card-cascade narrower ">

 <div class="view view-cascade  gradient-card-header blue-gradient">
	 <h4 class="card-header-title"> Please Select a Project Below </h4>
  </div>

  <div class="card-body card-body-cascade">
	  
	  
<select id="contact" class="mdb-select md-form" searchable="Search here..">
  <option value="" disabled selected>Choose Contact</option>
	
<?php 

$Users = DB::table('Contact')
    ->where("Organisation_ID","<",0)
	->orderby("Contact.Surname", 'asc')
	->orderby("Contact.Forename", 'asc')
	->get();


foreach($Users as $User){
	
	?>
<option value="{{$User->Contact_ID}}" data-value="{{$User->Contact_ID}}-{{$User->Forename}}{{$User->Surname}}">
{{$User->Forename}} {{$User->Surname}} 

</option>

<?php
	
	
}


?>


</select>

	  <div class="md-form">
  <input readonly value="//ukhts055/data/emails/" type="text" id="Location" class="form-control">
  <label  for="Location">File Location</label>
</div>
	
	  <div class="md-form">
  <input placeholder="Selected date" type="text" id="From_Date" class="form-control datepicker">
  <label for="date-picker-example">From</label>
</div>
	  <div class="md-form">
  <input placeholder="Selected date" type="text" id="To_Date" class="form-control datepicker">
  <label for="date-picker-example">To</label>
</div>
	  
   <!--Export button -->
    <button class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit" id="export">Export</button>
	  
	  
	</div>
</div>


<div id="result"></div>

<script>

var id = "";
	
	$('#contact').on('change select',function(){
		id = $(this).val();
		var location = '//ukhts055/data/emails/' + $(this).find('option:selected').data('value') 
		$('#Location').val(location)
	})
	

	$('#export').on('click', function(){
		$("#result").html('searching...');
		
		var location = $('#Location').val()
		var from = formatDate($('#From_Date').val())
		var to = formatDate($('#To_Date').val())
		var tonew = newDate(to)
		console.log(id)
		console.log(location)
		console.log(from)
		console.log(tonew)
		
		
		 $.post("getEmailExport", {'_token': $('meta[name=csrf-token]').attr('content'), ID: id, LOCATION: location, FROM: from, TO: tonew}, function(result){
    $("#result").html(result);
  });
		
		
	})
	
	
	
	
	function formatDate(date) {
     var d = new Date(date),
         month = '' + (d.getMonth() + 1),
         day = '' + d.getDate(),
         year = d.getFullYear();

     if (month.length < 2) month = '0' + month;
     if (day.length < 2) day = '0' + day;

     return [year, month, day].join('-');
 }
	
	
	function newDate(tt) {
 
    var date = new Date(tt);
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate() + 1);
    
    var dd = newdate.getDate();
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();

    var someFormattedDate = y + '-' +  ( '0' + (mm) ).slice( -2 ) + '-' + dd;
   return someFormattedDate;
}

</script>


@stop



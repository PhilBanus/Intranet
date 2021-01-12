@extends('intranet')
@section('content')
<!--Main Layout-->


<?php 

use Carbon\Carbon;

?>


      <div class="col-12 card-columns">
		  
		  <div class="card bg-transparent border-0">
		 
<div class="card-columns border-0 bg-transparent" style="columns: 2" >
	@include("cards.profile",["Name" => "Andy Hyde", "Title" => "Network and Infrastructure Manager", "ID" => "12", "LunchStart" => "12:00", "LunchEnd" => "13:00"])
	 @include("cards.profile",["Name" => "Nigel Pratt", "Title" => "ICT and Helpdesk Technician", "ID" => "55", "LunchStart" => "12:00", "LunchEnd" => "13:00"])
		  @include("cards.profile",["Name" => "Philip Banus", "Title" => "Business Systems Technican", "ID" => "7006", "LunchStart" => "12:30", "LunchEnd" => "13:00"])
		 
	     
		 
	 @include("cards.profile",["Name" => "Callum Porter", "Title" => "Business Systems Apprentice", "ID" => "11853", "LunchStart" => "13:00", "LunchEnd" => "14:00"])
		  
		
		</div>  
</div>
		  @include("cards.count",["Title" => "Documents Published", "Table" => "Document", "Col" => "Published_Date", "icon" => "archive"])  
		  @include("cards.count",["Title" => "Emails Sent/Received", "Table" => "UKHT_Mail", "Col" => "Date", "icon" => "envelope"])  
		  
		  
  @include("charts.piePercent", ['title' => 'Windows Version', 'ID' => 'Windows_Version', 'Table' => 'UKHT_Asset', 'Column' => 'Windows_Version'])
		  
		  
		  <div class="card">
		  
		  <div class="card-body fa-4x text-center" id="date"> </div>
		  <div class="card-body fa-4x text-center" id="time"> </div>
		  
		  
		  </div>
		  
		  
 
	  @include("charts.timeChart", ['title' => 'Logins Over Time', 'ID' => 'Logins_OverTime', 'Table' => 'UKHT_Laptop_Login', 'Column' => 'Inital_Login'])
	 
		 	
		  
		  <div class="card wider border-0 m-0 bg-transparent">
		  
  @include("cards.smallCard", ['Title' => "Todays Logins", 'Table' => "UKHT_Laptop_Login", 'Where' => "Inital_Login", 'Date' => 'Today', 'Distinct' => 'Login_ID', 'Css' => 'blue-gradient'  ])
  @include("cards.smallCard", ['Title' => "Yesterday Logins", 'Table' => "UKHT_Laptop_Login", 'Where' => "Inital_Login", 'Date' => 'Yesterday', 'Distinct' => 'Login_ID', 'Css' => 'purple-gradient'  ])
		  </div >
		  
		    <div class="card wider border-0 m-0  bg-transparent">
  @include("cards.smallCard", ['Title' => "Themis Logins (Today)", 'Table' => "Session_Logons", 'Where' => "Created_Date", 'Date' => 'Today', 'Distinct' => 'User_ID' , 'Css' => 'peach-gradient' ])
  @include("cards.smallCard", ['Title' => "Themis Logins (Yesterday)", 'Table' => "Session_Logons", 'Where' => "Created_Date", 'Date' => 'Yesterday', 'Distinct' => 'User_ID', 'Css' => 'purple-gradient' ])


		  </div>
		
	
	 
		  </div>




  

<script type="text/javascript">
  function showTime() {
    var date = new Date(),
        utc = new Date(Date.UTC(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('date').innerHTML = utc.toLocaleDateString();
    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
  }

	showTime();
  setInterval(showTime, 1000);
</script>


  <!--Main Layout-->
<!--/.Card-->

@stop
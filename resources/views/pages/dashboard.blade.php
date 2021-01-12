@extends('dashboard')
@section('content')
<!--Main Layout-->
 <meta http-equiv="refresh" content="60" />

<?php 
date_default_timezone_set("Europe/London");

use Carbon\Carbon;

?>
<style>
	.clockcontianer{
		display: flex;
		justify-content: center;
		align-items: center;
		background: transparent; 
		border: none; 
		text-align: center
	}
	.clock{
		width: 250px;
		height: 250px; 
		display: flex; 
		justify-content: center;
		align-items: center; 
		background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZAAAAGQCAYAAACAvzbMAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjQwMkM2NkE1RjNDRjExRTlCQzhGRkZGNzZFRDE0RTFDIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjQwMkM2NkE2RjNDRjExRTlCQzhGRkZGNzZFRDE0RTFDIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NDAyQzY2QTNGM0NGMTFFOUJDOEZGRkY3NkVEMTRFMUMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NDAyQzY2QTRGM0NGMTFFOUJDOEZGRkY3NkVEMTRFMUMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6dNzTWAAAT+UlEQVR42uzd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')
;
		background-size: cover;
		border: 4px solid transparent; 
		border-radius: 50%;
		box-shadow: 0 -15px 15px rgba(255,255,255,0.05),
					inset 0 -15px 15px rgba(255,255,255,0.05),
					0 15px 15px rgba(0,0,0,0.3),
					inset 0 15px 15px rgba(0,0,0,0.3);
	}
	.clock::before {
		content: '';
		position:absolute; 
		width: 10px; 
		height: 10px; 
		background: #fff; 
		border-radius: 50%; 
		z-index: 10000 !important; 
	}
	
	.clock .hour, 
	.clock .min, 
	.clock .sec{
		position: absolute
	}
	
	.clock .hour, .hr{
		width: 130px; 
		height: 130px; 
		
	}
	.clock .min, .mn{
		width: 160px; 
		height: 160px; 
		
	}
	.clock .sec, .sc{
		width: 180px; 
		height: 180px; 
		
	}
	
	.hr, .mn, .sc{
display: flex; 
		justify-content: center; 
		/*align-items: center; */
		position: absolute; 
		border-radius: 50%; 
	}
	
	.hr::before{
		content: ''; 
		position: absolute; 
		width: 6.5px; 
		height: 65px; 
		background: #ff105e; 
		z-index: 10; 
		border-radius: 6px 6px 0 0 
	}
	.mn::before{
		content: ''; 
		position: absolute; 
		width: 4px; 
		height: 80px; 
		background: #fff; 
		z-index: 10; 
		border-radius: 6px 6px 0 0 
	}
	.sc::before{
		content: ''; 
		position: absolute; 
		width: 1px; 
		height: 110px; 
		background: yellow; 
		z-index: 11; 
		border-radius: 6px 6px 0 0 
	}
	

</style>

      <div class="col-12 card-columns">
		  
		  <div class="card bg-transparent border-0">
		 
<div class="card-columns" style="columns: 2" >
	 @include("cards.profile",["Name" => "Andy Hyde", "Title" => "Network and Infrastructure Manager", "ID" => "12", "LunchStart" => "12:00", "LunchEnd" => "13:00"])
	 @include("cards.profile",["Name" => "Nigel Pratt", "Title" => "ICT and Helpdesk Technician", "ID" => "55", "LunchStart" => "12:00", "LunchEnd" => "13:00"])
		  @include("cards.profile",["Name" => "Philip Banus", "Title" => "Business Systems Technican", "ID" => "7006", "LunchStart" => "12:30", "LunchEnd" => "13:00"])
		 
	     
		 
	 @include("cards.profile",["Name" => "Callum Porter", "Title" => "Business Systems Apprentice", "ID" => "11853", "LunchStart" => "13:00", "LunchEnd" => "14:00"])
		  
		
		</div>  
</div>
		  @include("cards.count",["Title" => "Documents Published", "Table" => "Document", "Col" => "Published_Date", "icon" => "archive"])  
		  @include("cards.count",["Title" => "Emails Sent/Recieved", "Table" => "UKHT_Mail", "Col" => "Date", "icon" => "envelope"])  
		  
		  
  @include("charts.piePercent", ['title' => 'Windows Version', 'ID' => 'Windows_Version', 'Table' => 'UKHT_Asset', 'Column' => 'Windows_Version'])
		  
		  
		  <div class="card clockcontianer text-center d-flex border-0 pt-3">
		  
			  <div class="clock mx-auto">
			  <div class="hour">
				  <div class="hr" id="hr"></div>
				  </div>
			  <div class="min">
				  <div class="mn" id="mn"></div>
				  </div>
			  <div class="sec">
				  <div class="sc" id="sc"></div>
				  </div>
			  </div>
			  
			  <script type="text/javascript">
			  	  const deg = 6;
				  const hr = document.querySelector('#hr');
				  const mn = document.querySelector('#mn');
				  const sc = document.querySelector('#sc');
				  setInterval(() => {
					let day = new Date(); 
				  let hh = (day.getHours()) * 30;
				  let mm = day.getMinutes() * deg; 
				  let ss = day.getSeconds() * deg;
				  let hrs = hh+(mm/12)
				  hr.style.transform = 'rotateZ('+hrs+'deg)'
				  mn.style.transform = 'rotateZ('+mm+'deg)'
				  sc.style.transform = 'rotateZ('+ss+'deg)'  
					  
				  })
				  
			  </script>
			  
		<!--  <div class="card-body fa-4x text-center" id="date"> </div>
		  <div class="card-body fa-4x text-center" id="time"> </div> -->
		  
		  
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


<div class="alert alert-warning alert-dismissible fade show text-center mr-3 ml-3" role="alert">
 This is better than the Work Winning dashboard....
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>


	<a href="home" class="position-absolute" style="bottom: 35px; right: 20px; z-index: 200">
  <div class="btn-floating btn-lg blue">
    <i class="fas fa-home"></i>
  </div>
  </a>  
  

<script type="text/javascript">
 /* function showTime() {
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
  setInterval(showTime, 1000); */
</script>


  <!--Main Layout-->
<!--/.Card-->

@stop
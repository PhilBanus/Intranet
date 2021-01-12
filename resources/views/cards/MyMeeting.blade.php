

<?php
use Carbon\Carbon;
date_default_timezone_set('Europe/London');
$savings = date('I');
if($savings){
	$extraHour = 3600;
}else{
	$extraHour = 0;
}
if(!isset($_COOKIE['uniAuthSess'])){
	$url = base64_encode(URL::full());
	header("location: https://themis.ukht.org/XWeb/Security/Logon.aspx?url=$url");
}else{
$auth = $_COOKIE['uniAuthSess'];


$User = DB::table('Authenticated_Session')->join("Contact","Contact.Contact_ID","=","Authenticated_Session.User_ID")->where("Authenticated_Session_ID","=",$auth)->first();

$user_email = $User->User_Logon."@ukht.org";

$InsertCount = 0;
$UpdateCount = 0; 
$Counter = 0;
$Counter2 = 0;
$MovedCount = 0; 
$DeletedCount = 0;

$OfficeIDs = [];


$now = date("Y-m-d\T00:00:00.000\Z");
$nextweek = date("Y-m-d\T23:59:59.000\Z", strtotime("+1 week"));

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://login.microsoftonline.com/4d3084cb-cd31-43d4-bea5-9f0e7f34aae3/oauth2/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
		CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "client_id=1b619156-ea88-41a0-b7dd-f55878f27bb8&scope=offline_access%20https%253A%252F%252Fgraph.microsoft.com%252F.default&client_secret=rM6AfXia1Z%3AAHbv3wP0tIkDoJ%2Fjf%40-r0&grant_type=client_credentials&resource=https%3A%2F%2Fgraph.microsoft.com",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Content-Length: 248",
    "Content-Type: application/x-www-form-urlencoded",
    "Cookie: x-ms-gateway-slice=prod; stsservicecookie=ests; fpc=AsmXj5npUohLhEqnjwcQCxhUIgulAQAAAEAoU9UOAAAA8jbx4gEAAACCKFPVDgAAAA",
    "Host: login.microsoftonline.com",
    "Postman-Token: 160b118a-d784-4973-b16c-183a0201cf8b,9bb686bf-d511-44f4-a58f-d776a06b2fc8",
    "User-Agent: PostmanRuntime/7.18.0",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 
	$DATA = json_decode($response);
	
	foreach ($DATA as $Key1 => $Level1){
		
		if ($Key1 === "access_token"){ $access_key = $Level1; }
		
	}
	
	session_start();
	$_SESSION["accesskey"]=$access_key;
	

	
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graph.microsoft.com/v1.0/users/$user_email/calendar/calendarView?startdatetime=$now&enddatetime=$nextweek",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
		CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Authorization: Bearer $access_key",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Host: graph.microsoft.com",
    "Postman-Token: 3206ef3c-a88d-4bc1-b1a6-a7df23d479cb,3d83f066-649d-45de-8225-048bb0612699",
    "User-Agent: PostmanRuntime/7.20.1",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  
	$DATA = json_decode($response, true);
	

	foreach ($DATA as $Check => $Value){
		
		 if(isset($Value['code'])){
		$error = $Value['code'];
			 
		 }else{ $error = "no Error" ; }
		
	}
		
	if($error === 'MailboxNotEnabledForRESTAPI'){ } else {
	
	?> 

<div class="fixed-action-btn" style="right: 20px">
<div id="MeetingsModal" type="button" class="btn-lg btn-floating btn-dark" data-toggle="modal" data-target="#MyMeetings">
 <i class="fas fa-calendar-alt"></i>
</div>
	</div>
<!-- Modal -->
<div class="modal fade right" id="MyMeetings" tabindex="-1" role="dialog" aria-labelledby="MyMeetingsLabel" aria-hidden="true">
  <div class="modal-dialog modal-full-height modal-right" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="MyMeetingsLabel">My Meetings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-0 p-0 bg-dark">
		  <ul class="list-group-flush m-0 p-0">
     	<?php
	

	

		foreach ($DATA as $Key1){
		
		if(is_array($Key1)){
		
			?> 


		
					

						<li class="list-group-item text-light" style="background-color: #702957" id="Day1" hidden>Today</li>
				<ul class="list-group bg-dark">

		
		

						<?php
			if(isset($Key1['code']) && $Key1['code'] == 'ErrorInvalidUser'){
				
			}
			else{
				
				
			
		
	
			
foreach($Key1 as $Key2){
	
	
				
				if( date("d m Y") === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> 
						
	<li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>
		
							<script>
								
								$("#Day1").removeAttr('hidden') 
							
							
							</script>
						
						<?php
				
				}
				
			
}
				
					?></ul>
			
	
					<li class="list-group-item text-light" style="background-color: #702957" id="Day2" hidden>Tomorow - <?php echo date("l, jS F",strtotime("+1 days")) ?></li>
					<ul class="list-group bg-dark">
						
						
						
						<?php
			
	
			
			foreach($Key1 as $Key2){
	
				
				if( date("d m Y",strtotime("+1 day")) === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> 
					
							<li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>
							
							<script>
								
								$("#Day2").removeAttr('hidden') 
							
							
							</script>
						
						<?php
				
				}
				
			}	
			
			
			
			// 2 dasy from now
			
						?></ul>
							
						
					<li class="list-group-item text-light" style="background-color: #702957" id="Day3" hidden><?php echo date("l, jS F",strtotime("+2 days")) ?></li>
					<ul class="list-group bg-dark">
					
						<?php
			
	
			
			foreach($Key1 as $Key2){
	
				
				if( date("d m Y",strtotime("+2 days")) === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> 
					
						<li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>
							
								
							<script>
								
								$("#Day3").removeAttr('hidden') 
							
							
							</script>
						
						<?php
				
				}
				
			}	
			
			
			// 2 dasy from now
			
			?></ul>
		
					<li class="list-group-item text-light" style="background-color: #702957" id="Day4" hidden><?php echo date("l, jS F",strtotime("+3 days")) ?></li>
					<ul class="list-group bg-dark">
						
						<?php
			
	
			
			foreach($Key1 as $Key2){
	
				
				if( date("d m Y",strtotime("+3 days")) === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> 
					
						<li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>
							
								
							<script>
								
								$("#Day4").removeAttr('hidden') 
							
							
							</script>
						
						<?php
				
				}
				
			}	
			
			
				// 4 dasy from now
			
						?></ul>
					
					<li class="list-group-item text-light" style="background-color: #702957" id="Day5" hidden><?php echo date("l, jS F",strtotime("+4 days")) ?></li>
				<ul class="list-group bg-dark">
						
						<?php
			
	
			
			foreach($Key1 as $Key2){
	
				
				if( date("d m Y",strtotime("+4 days")) === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> 
					<li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>
						
							<script>
								
								$("#Day5").removeAttr('hidden') 
							
							
							</script>	
						<?php
				
				}
				
			}
			
			
				// 5 dasy from now
			
					?></ul>
				
					<li class="list-group-item text-light" style="background-color: #702957" id="Day6" hidden><?php echo date("l, jS F",strtotime("+5 days")) ?></li>
					<ul class="list-group bg-dark">
						<?php
			
	
			
			foreach($Key1 as $Key2){
	
				
				if( date("d m Y",strtotime("+5 days")) === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> 
					
						<li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>			
								
							<script>
								
								$("#Day6").removeAttr('hidden') 
							
							
							</script>
						
						<?php
				
				}
				
			}
			
			
				// 5 dasy from now
			
						?></ul>
					
					<li class="list-group-item text-light" style="background-color: #702957" id="Day7" hidden><?php echo date("l, jS F",strtotime("+6 days")) ?></li>
					<ul class="list-group bg-dark">
						<?php
			
	
			
			foreach($Key1 as $Key2){
	
				
				if( date("d m Y",strtotime("+6 days")) === date("d m Y", strtotime($Key2['start']['dateTime'])+$extraHour) ){
					
			
				
			?> <li class="list-group-item list-group-item-action w-100 bg-dark">
		<a href="<?php echo $Key2['webLink'] ?>" target="new" class="text-light w-100 p-0 m-0">
		<small class="bg-dark text-warning w-100 "><?php echo date("H:i",strtotime($Key2['start']['dateTime'])+$extraHour) ?> - <?php echo date("H:i",strtotime($Key2['end']['dateTime'])+$extraHour) ?></small>
		<div class=""><span><?php echo $Key2['subject'] ?></span></div>
		<small class="ml-auto"><?php echo  $Key2['location']['displayName'] ?></small>
		
			
		</a>
					</li>			
							<script>
								
								$("#Day7").removeAttr('hidden') 
							
							
							</script>
						<?php
				
				}
				
			}
			
						?></ul>
	 
	 <?php
		}
			
		}
		
	}

	
	
		
		?> 
			  
			  </ul>
      </div>
   
    </div>
  </div>
</div>
<!-- Modal -->







<?php 
	
}
	
	
}


	
	
		
	};
	
}

?>







<?php
$id = $_GET['id'];


$contacts = App\Contacts::where('Contact_ID', '=', $id)->first();
$othercontacts = App\User_Personal_Data::where('Contact_ID', '=', $id)->first();
$H_Telephone = $othercontacts && $othercontacts->H_Telephone ? base64_decode($othercontacts->H_Telephone) : 'No Record';
	$M_Telephone = $othercontacts && $othercontacts->M_Telephone ? base64_decode($othercontacts->M_Telephone) : 'No Record';
	$Email = $othercontacts && $othercontacts->Email ? base64_decode($othercontacts->Email) : 'No Record';
	$Line_1 = $othercontacts && $othercontacts->Line_1 ? base64_decode($othercontacts->Line_1) : 'No Record';
	$Line_2 = $othercontacts && $othercontacts->Line_2 ? base64_decode($othercontacts->Line_2) : 'No Record';
	$Town = $othercontacts && $othercontacts->Town ? base64_decode($othercontacts->Town) : 'No Record';
	$Postcode = $othercontacts && $othercontacts->Postcode ? base64_decode($othercontacts->Postcode) : 'No Record';
	$EC_Title = $othercontacts && $othercontacts->EC_Title ? base64_decode($othercontacts->EC_Title) : 'No Record';
	$EC_Fname = $othercontacts && $othercontacts->EC_Fname ? base64_decode($othercontacts->EC_Fname) : 'No Record';
	$EC_Sname = $othercontacts && $othercontacts->EC_Sname ? base64_decode($othercontacts->EC_Sname) : 'No Record';
	$EC_H_Telephone = $othercontacts && $othercontacts->EC_H_Telephone ? base64_decode($othercontacts->EC_H_Telephone) : 'No Record';
	$EC_M_Telephone = $othercontacts && $othercontacts->EC_M_Telephone ? base64_decode($othercontacts->EC_M_Telephone) : 'No Record';
?>
<H4 class="text-white">Contact Details</H4>
<div class="mt-3">
<h5>Title</h5>
<h5><strong>{{$contacts->Title}}</strong></h5>
<h5>Forename</h5>
<h5><strong>{{$contacts->Forename}}</strong></h5>
<h5>Surname</h5>
<h5><strong>{{$contacts->Surname}}</strong></h5>
<h5>Telephone</h5>
<h5><strong>{{$H_Telephone}}</strong></h5>
<h5>Mobile</h5>
<h5><strong>{{$M_Telephone}}</strong></h5>
<h5>Email</h5>
<h5><strong><a href="mailto:{{$Email}}" class="text-warning">{{$Email}}</a></strong></h5>
</div>

<div class="mt-4">
<H4><a class="text-white" href="https://www.google.com/maps/place/{{$Postcode}}" target="new">Address</a></H4>
<h5><strong>{{$Line_1}}</strong></h5>
<h5><strong>{{$Line_2}}</strong></h5>
<h5><strong>{{$Town}}</strong></h5>
<h5><strong>{{$Postcode}}</strong></h5>
</div>

<div class="mt-4">
<H4 class="text-white">Emergency Contacts</H4>
<h5>Title</h5>
<h5><strong>{{$EC_Title}}</strong></h5>
<h5>Forename</h5>
<h5><strong>{{$EC_Fname}}</strong></h5>
<h5>Surname</h5>
<h5><strong>{{$EC_Sname}}</strong></h5>
<h5>Telephone</h5>
<h5><strong>{{$EC_H_Telephone}}</strong></h5>
<h5>Mobile</h5>
<h5><strong>{{$EC_M_Telephone}}</strong></h5>
</div>


        
            

          
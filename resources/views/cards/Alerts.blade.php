
<div class="card border-0 p-2 mt-0" style="background-color: #aab62a; overflow: hidden">
<?php 


$GlobalID = $_COOKIE['uniAuthSess'];


$MYDetails = DB::table('Authenticated_Session')
	->join('Contact','Contact.Contact_ID','=','Authenticated_Session.User_ID')
	->join('User','User.Contact_ID','=','Authenticated_Session.User_ID')
	->orderby('Authenticated_Session.Created_Date','desc')
	->where('Authenticated_Session_ID', '=', $GlobalID)
	->first();

$MYMobile = DB::table('contact_mobile')
	->where('contact_id',$MYDetails->User_ID)
	->first();

$MYPhoto = DB::table('Document_Categories')
	->join('Document_Entities','Document_Entities.Document_ID','=','Document_Categories.Document_ID')
	->join('Document','Document.Document_ID','=','Document_Categories.Document_ID')
    ->where('Document_Categories.Category_ID',444)
	->where('Document_Entities.Entity_Class_ID',1)
	->where('Document_Entities.Entity_Identifier', $MYDetails->User_ID)
	->orderby('Document_Categories.Document_ID','desc')
	->first();


if($MYPhoto){
	
	session(['MY_PHOTO' => 'https://themis.ukht.org/__files/rendition/'.$MYPhoto->Document_ID . '/-9/photo.jpg']);
	
}else{
	session(['MY_PHOTO' => "data:image/png;base64,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"]);
}

if($MYMobile){
	
	session(['MY_MOBILE' => $MYMobile->Mobile_phone]);
} else {
	session(['MY_MOBILE' => '01793 755 555']);
}


		
		

        session(['MY_ID' => $MYDetails->Contact_ID]);
        session(['MY_EMAIL' => $MYDetails->Identity_Email]);
        session(['MY_JOBTITLE' => $MYDetails->Job_Title]);
        session(['MY_USERNAME' => $MYDetails->Forename." ".$MYDetails->Surname]);
	


/* $CurrentPage = str_replace('https://themis.ukht.org/XWeb/ICT_Portal/','',URL::current());
echo $CurrentPage;
if($CurrentPage === "https://themis.ukht.org/XWeb/ICT_Portal" || $CurrentPage === "intranet"){}else{

	
	
	
$Navs = DB::table("UKHT_User_Role")
						->join('UKHT_Roles','UKHT_Roles.ID','UKHT_User_Role.Role_ID')
						->join('UKHT_Nav_Access','UKHT_Nav_Access.Role_ID','UKHT_Roles.ID')
						->join('UKHT_Nav','UKHT_Nav_Access.Nav_ID','UKHT_Nav.ID')
						
						->where('UKHT_User_Role.User_ID',$_SESSION['MY_ID'])
						->where('UKHT_Nav.Link','=',$CurrentPage)
						->exists();

if(!$Navs){
	
	return redirect('intranet');
}

} */




$CheckAccess = DB::table('UKHT_User_Role')->where('User_ID',session('MY_ID'))->exists();
$InternalList = DB::table('UKHT_Alert_Group_Contacts')->where('Contact_ID',session('MY_ID'))->where('Group_ID',3)->exists();
	
	
if(!$CheckAccess){ 

DB::table('UKHT_User_Role')->insert(
['User_ID' => session('MY_ID'), 'Role_ID' => 6 ]
);
	

}	
if(!$InternalList){ 

DB::table('UKHT_Alert_Group_Contacts')->insert(
['Contact_ID' => session('MY_ID'), 'Group_ID' => 3 ]
);
	

}

?>

<!--Grid row-->
<div class="card-header text-center bg-transparent text-white ">Alerts and Notifications </div>

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
	
				
				<div class="modal fade right" id="alert{{$Project->ID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header {{$Project->Color}}">
        <h5 class="modal-title " id="exampleModalPreviewLabel"><i class="{{$Project->Type}}"></i> {{urldecode($Project->Subject)}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <?php echo urldecode($Project->Body) ?>
      </div>
      <div class="footer pt-3 mdb-color lighten-3">



      <div class="row mt-2 mb-3 d-flex justify-content-center">
    
		  <button class="btn btn-lg primary-color-dark text-white">I have read this Alert</button>
		  
      </div>

    </div>
    </div>
  </div>
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
	
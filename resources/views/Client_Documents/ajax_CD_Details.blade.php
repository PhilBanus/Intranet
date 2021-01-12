
<?php 
$id = $_GET['id'];
$data_ID = $_GET['Data'];
$data = null;
if($data_ID != null){
	$data = DB::table('UKHT_CD_Document')->where('id', $data_ID)->first();
	
	if($data->checked_out){
		$Editor = DB::table('Contact')->where('Contact_ID',$data->editor)->first();
	}
} 



?>

<style>
	.nav-link.active{
		background-color: #024a94 !important; 
		color: white !important
	}
</style>
<div class="col-12 pr-0 m-0 bg-dark">
	<div class="row d-flex col-12 p-0 m-0 ">
<div class="mr-auto d-flex">
	
			<ul class="nav nav-pills bg-dark p-1" style="font-size: 70%" id="myTab" role="tablist">
  <li class="nav-item mr-1">
    <a class="nav-link active  bg-light text-dark" id="home-pills" data-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">Summary</a>
  </li>
  <li class="nav-item mr-1">
    <a class="nav-link  bg-light text-dark" id="profile-pills" data-toggle="pill" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Read</a>
  </li>
  <li class="nav-item mr-1">
    <a class="nav-link  bg-light text-dark" id="contact-pills" data-toggle="pill" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Versions</a>
  </li>
</ul>
	</div>

<div class=" ml-auto " >
			<ul class="nav nav-pills  bg-dark p-1" style="font-size: 70%" id="myTab" role="tablist">
				<li class="nav-item  mr-1">
				<a  class="nav-link  bg-light text-dark"  href="#" data-toggle="tooltip" title="Email Document"><i class="fas fa-envelope"></i></a>
				</li>
				<li class="nav-item  mr-1">
				<a class="nav-link  bg-light text-dark editPropertiesBtn"  data-id="" data-toggle="tooltip" title="Edit Properties"><i class="fas fa-list"></i></a>
					</li>
				
				@if($data->checked_out)
				<li class="nav-item  mr-1"  data-toggle="tooltip" title="Checked Out to: {{$Editor->Forename}} {{$Editor->Surname}} " >
				<a class="nav-link  disabled bg-light text-dark py-1 px-2"  href="#"><span class="fa-stack p-0">
  <i class="fas fa-pencil-alt fa-stack-1x"></i>
  <i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i>
</span></a>
				</li>
				@else
				<li class="nav-item  mr-1">
				<a class="nav-link  bg-light text-dark"  href="CDedit?id={{$data_ID}}" data-toggle="tooltip" title="Edit document" onClick=""><i class="fas fa-pencil-alt"></i></a>
				</li>
				@endif
				<li class="nav-item  mr-1">
				<a class="nav-link  bg-light text-dark"  href="CDdownload?id={{$data_ID}}" data-toggle="tooltip"  title="Download Document"><i class="fas fa-file-download"></i></a>
				</li>
				<li class="nav-item  mr-1">
				<a class="nav-link  bg-light text-dark"  href="#" data-toggle="tooltip" title="Delete document"><i class="fas fa-trash-alt"></i></a>
				</li>
				<li class="nav-item  mr-1">
				<a class="nav-link p-1  bg-transparent text-danger" onClick="closeDetails($(this))"  href="#" data-toggle="tooltip" title="Close"><i class="fal fa-2x fa-times-square"></i></a>
				</li>
			</ul>
			
		</div>	
	
</div>



<div class="tab-content bg-white p-2" id="myTabContent" >
  <div class="tab-pane fade show active p-5 m-2" id="home" role="tabpanel" aria-labelledby="home-pills" >					<div class="row text-primary" >
					<div class="col-md-12 d-flex">
						<h4 class="col-md-6 justify-content-center">{{$data->title ?? ""}}</h4>
					</div>
					<div class="col-md-12 d-flex text-center">
						<div class="col-md-3 ">Uploaded By:</div>
						<div class="col-md-3 text-left font-weight-bold">{{db::table('Contact')->where('Contact_ID',$data->uploaded_by)->first()->Forename}} {{db::table('Contact')->where('Contact_ID',$data->uploaded_by)->first()->Surname}}</div>
						<div class="col-md-3">Document ID:</div>
						<div class="col-md-3 text-left font-weight-bold">{{$data->id ?? ""}}</div>
					</div>
					<div class="col-md-12 d-flex text-center">
						<div class="col-md-3 ">Uploaded Date:</div>
						<div class="col-md-3 text-left font-weight-bold">{{$data->upload_date ?? ""}}</div>
						<div class="col-md-3">Document Type:</div>
						<div class="col-md-3 text-left font-weight-bold">{{$data->extension ?? ""}}</div>
					</div>
					<div class="col-md-12 d-flex text-center">
						<div class="col-md-3 ">File Location:</div>
						<div class="col-md-3 text-left font-weight-bold">{{$data->file_location ?? ""}}</div>
						<div class="col-md-3">File Size:</div>
						<div class="col-md-3 text-left font-weight-bold">{{$data->size ?? ""}}</div>
					</div>
					
			</div></div>
  <div class="tab-pane fade" id="profile" role="tabpanel" style="overflow-y: scroll" aria-labelledby="profile-pills">
					<!-- place foreach code here -->
	  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Contact</th>
		<th scope="col">Version</th>
      <th scope="col">Date</th>
      
    </tr>
  </thead>
		  <tbody>
	  <?php
	  	$readDocs = DB::table('UKHT_CD_Document_Read')->where('document_id', $data_ID)->orderby('read_date','desc')->get();
	  ?>
	  @foreach ($readDocs as $readDoc)
	  <?php $contact = DB::table('contact')->where('Contact_ID', $readDoc->contact_id)->first();
			  $new_date = $readDoc->read_date;
			  $date = substr($new_date,0, 10); 
			  $time = substr($new_date,11, 22); 
			  
			  ?>
			 
					<tr>
						<td>{{$contact->Forename}} {{$contact->Surname}}</td>
						<td>{{$readDoc->version}}</td>
						<td>{{$date}} {{$time}}</td>
						
					</tr>
	  @endforeach
			  </tbody>
</table>
			
</div>
  <div class="tab-pane fade h-100 " id="contact" role="tabpanel" style="overflow-y: scroll" aria-labelledby="contact-pills">
					<!-- place foreach code here -->
	  <?php
	  $versions = DB::table("UKHT_CD_Document_History")->where('document_id', $data_ID)->orderby('upload_date','desc')->get();
	  
	  ?>
	  
	    <table class="table">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">Version</th>
      <th scope="col">Name at time</th>
      <th scope="col">uploaded date</th>
    </tr>
  </thead>
  <tbody>
	  
	   <tr>
		   <td><a class="link-primary text-primary"  href="Readhistory?id={{$data_ID}}&ver={{$data->version}}" data-toggle="tooltip" title="Download document" onClick=""><i class="fas fa-file-download"></i></a></td>
	  <td>{{$data->version}}</td>
	  <td>{{$data->title}}</td>
	  <td>{{$data->upload_date}}</td>
	</tr>
	  
	  @foreach($versions as $version)
	
    <tr>
		<td><a class="link-primary text-primary"  href="Readhistory?id={{$data_ID}}&ver={{$version->version}}" data-toggle="tooltip" title="Download document" onClick=""><i class="fas fa-file-download"></i></a></td>
	  <td>{{$version->version}}</td>
	  <td>{{$version->title}}</td>
	  <td>{{$version->upload_date}}</td>
	</tr>
 
	  @endforeach
		 </tbody>
</table>			
			
</div>
</div>
	</div>

<script>
	$(document).ready(function(){
		
		var height = ""; 
		var container = $('#myTabContent').height();
		var nav = $('#myTab').height();
		height = container;
		$('#myTabContent').height(height);
		changeHeight();
		
			$(function () {
  $('[data-toggle="tooltip"]').tooltip()});
		
		$('.editPropertiesBtn').on('click', function(){
		$('#propertiesModel').modal('show');
		$('#Property-modal-body').load('CD_EditProp?id={{$data_ID}}');
	});
		
		
		
	});
	$("#download_doc").on('click', function(){
		var temp = "CDdownload?id=" + {{$data_ID}};
		$("#download_doc").attr("href", temp );
	});
	
	$("#edit_doc").on('click', function(){
		var temp1 = "CDedit?id=" + {{$data_ID}};
		$("#edit_doc").attr("href", temp1 );
	});
			changeHeight();
	
	function closeDetails(item){
		item.tooltip('hide')
		$('#detailsArea').html('');
		
				changeHeight();
	}
	
</script>




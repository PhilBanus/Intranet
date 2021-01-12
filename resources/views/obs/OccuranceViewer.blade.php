@extends('obs.OccuranceMainPage')
@section('content')

<div id='ahaha'>
<div class="body"  style="display: none;">
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>

	
	
	 <style>
      .map {
        height: 400px;
        width: 100%;
      }
		 
		 .ol-popup{
			 margin-left: -17.5px;
			 margin-top: -300%;
		 }
		 
		 .popover-header{
			 background-color: #024a94;
			 color: white;
		 }
		 .popover{
			 background-color: lightgrey;
			 font-size: 80%
		 }
		 .bs-popover-right > .arrow::after, .bs-popover-auto[x-placement^=right] > .arrow::after, .bs-popover-right > .arrow::before, .bs-popover-auto[x-placement^=right] > .arrow::before{
			 border-right-color: darkred
		 }
    </style>
<?php use Carbon\Carbon; 
$now = Carbon::now();

$AdminOnly = DB::table('UKHT_Occurance_Teams')
	->where('Member_ID', session('MY_ID') )
	->where('Removed',0)
	->exists();
	
	
$ViewOnly = DB::table('UKHT_Occurance_Close_Call')
	->where('ID', $_GET['id'] )
	->where( 'Sign_Off', 1 )
	->exists();

$Actioner = DB::table('UKHT_Occurance_Close_Call')
	->where('ID', $_GET['id'] )
	->select('HSQE_Actioner as ID')
	->where('HSQE_Actioner', session('MY_ID') );

$ActionOnly = DB::table('UKHT_Occurance_Teams')
	->select('Member_ID as ID')
	->where('Member_ID', session('MY_ID') )
	->where('Removed',0)
	->union($Actioner)
	->exists();



?>
<script>

	$(document).ready(function(){
			
toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "md-toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": 300,
  "hideDuration": 1000,
  "timeOut": 0,
  "extendedTimeOut": 0,
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut",
	"tapToDismiss": false
}
	})

</script>
<?php 

$Occurance = DB::table('UKHT_Occurance_Close_Call')->where('ID',$_GET['id'])->first(); 

$OccuranceName = DB::table('UKHT_Occurance')->where('ID',$Occurance->Occurance)->first();
	
	?>
		@if(($Occurance->Occurance == 4 && !$AdminOnly) || ($Occurance->Occurance == 4 && !$Actioner)){
		
		<div class="text-white">You are not permitted to view accident data.
			</div>
	
	<script>
	
	$('.body').show();
		
	</script>
		
	
@else
	<?php

$Photos = DB::table('UKHT_Occurance_Photos')->where('Occurance_ID','=',$Occurance->ID)->where('Post','!=',1);
$PostPhotos = DB::table('UKHT_Occurance_Photos')->where('Occurance_ID',$Occurance->ID)->where('Post','=',1);
$HistPhotos = DB::table('UKHT_Occurance_Historic_Photo')->where('Occurance_ID',$Occurance->Global_ID);

if($Occurance->Site == 0){
		$SiteName = "Head Office";
	}else{
		$site = DB::table('Project')->where('Project_ID',$Occurance->Site)->first();
		$SiteName = $site->Name;
	}

if(is_int($Occurance->Location)){
$loc = DB::table('UKHT_Occurance_Location')->where('ID',$Occurance->Location)->first();
	$locName =$loc->Name; 
}else{
	$locName =$Occurance->Location;
}

if($Occurance->Email){
	
	?>
<script> 
	$(document).ready(function(){
		
	
		
Command: toastr["warning"]("Please note, The submitter will recieve an email of all actions taken.", "Email Added")

	}); 
</script>


<?php
	
	
}


if($Occurance->Risk_Prevented){
	
	?>
<script> 
	$(document).ready(function(){
		
	
		
Command: toastr["success"]("", "Risk Prevented")

	}); 
</script>


<?php
	
	
}else{
		?>
<script> 
	$(document).ready(function(){
		
	
		
Command: toastr["error"]("", "Risk NOT Prevented")

	}); 
</script>


<?php
	
}

	
	if(!$Occurance->Sign_Off && $Occurance->Actions_Taken_HSQE && !$Occurance->ReAllocated || $Occurance->Occurance == 2 && !$Occurance->Sign_Off || $AdminOnly){
		
		
	


?>
	
	
	<div class="col-12 adminonly Nvoc  m-0 p-3">
	<div class="card  ">
	
		<h3 class="card-header bg-success">Closure</h3>
	
		<div class="card-body">
			
			@if($Occurance->Occurance == 2 || $Occurance->Occurance == 1)
			<input type="text" id="Roots" value="N/A" hidden="">
			<input type="text" id="SubRoots" value="N/A" hidden="">
			
					@if($Occurance->Email)
			<div class="form-group">
			<label for="thanks">Message to submitter (optional)</label>
			<textarea name="thanks" class="form-control" id="thanks" cols="10" rows="2"></textarea>
			</div>
			@endif
			
			<div class="btn btn-lg btn-primary adminonly" id="CloseOut">Close</div>
			@else
				<div id="RootUpdate" class="adminonly ">
		
			
			<select class="mdb-select md-form colorful-select" searchable="Search here.." id="Roots">
  <option value="" disabled selected>Choose Root</option>
  <?php 
			$Roots = DB::table('UKHT_Occurance_Root')->where("Removed",0)->get();
				
			foreach($Roots as $Root){
			?>
				<option value="{{$Root->Root}}" data-id="{{$Root->ID}}">{{$Root->Root}}</option>
  
				
				<?php
			}
				?>
  
</select>
					
					
<label class="mdb-main-label">Root Cause</label>
			
			<div>
			<select class="mdb-select md-form subRoots" searchable="Search here.." id="SubRoots" disabled>
  <option value="" disabled selected>Choose Root first</option>
			</select>
			<label class="mdb-main-label subRootLabel">Sub Root</label>
		</div>
		<?php
			$Roots = DB::table('UKHT_Occurance_Root')->where("Removed",0)->get();
				
			foreach($Roots as $Root){
			?>
			<div style="display: none">		
		<select class="mdb-select md-form subRoots" style="display: none" searchable="Search here.." id="SubRoots{{$Root->ID}}">
  <option value="" disabled selected>Choose Sub Root</option>
  <?php 
			
			$Roots = DB::table('UKHT_Occurance_Root_Sub')->where('Root_ID',$Root->ID)->where("Removed",0)->get();
				
			foreach($Roots as $Root){
			?>
				<option value="{{$Root->Sub_Name}}" data-id="{{$Root->Root_ID}}" data-value="{{$Root->ID}}">{{$Root->Sub_Name}}</option>
  
				
				<?php
			}
				?>
</select>
<label class="mdb-main-label">Sub Category</label>
  </div>
				
				<?php
			}
		?> 
			
					@if($Occurance->Occurance == 4 || $Occurance->Occurance == 3)
					<div>
					<select class="mdb-select md-form" searchable="Search here.." id="RIDDOR">
  <option value="" disabled selected>Choose Accident status</option>
						@foreach(DB::table('UKHT_Occurance_RIDDOR')->orderby('order','asc')->get() as $Riddor)
						<option>{{$Riddor->name}}</option>
@endforeach

			</select>
					</div>
					@endif
	
		</div>
			
			@if($Occurance->Email)
			<div class="form-group">
			<label for="thanks">Message to submitter (optional)</label>
			<textarea name="thanks" class="form-control" id="thanks" cols="10" rows="2"></textarea>			</div>
			@endif
			

			<div class="btn btn-lg btn-primary adminonly disabled" id="CloseOut">Close</div>
			@endif
		</div>
	
	</div>
	
</div>	
	
	<?php
	
}
?>
	<div class="col-12 viewOnly m-0 p-3" style="display: none">
	<div class="card">
		<h3 class="card-header bg-success">CLOSED</h3>
		<div class="card-body">
		Root Cause: <strong>{{$Occurance->Root_Cause}} / {{$Occurance->Sub_Root}}</strong><br>
		RIDDOR Status: <strong>{{$Occurance->RIDDOR}}</strong> <br>
			<br>
			@if($Occurance->Thanks)
			<strong>Feedback to Submitter :</strong> {{$Occurance->Thanks}}
			@endif
		</div></div></div>

<div class="col-md-6 float-right  m-0 p-3">

	<div class="card">
<h4 class="card-header primary-color-dark text-white">HSQE Information</h4>
	<div class="card-body p-0">
		
		
		
		<div class="btn btn-lg bg-info adminonly" id="ChangeOccurance">Not a {{$OccuranceName->Name}}?</div>
		<div class="btn btn-lg bg-info adminonly" id="ChangeLocation">Not {{$SiteName}}?</div>
		
		
			<div class="card-title p-2 mt-2 ml-0 mr-0 {{$OccuranceName->Class}}">Category </div>
			<div class="card-body" style="position: relative">
			
					<?php 
					
					
				 $CatCount = 0;
		$CatText = "";
		 if($Occurance->HS == true){
		 $HealthCheck = 'checked="true"';
		 $CatCount++;
		$CatText .= " Health and Safety /";
			 $hscss = "text-danger";
			 $hscss2 = " opacity: 100 !important";
		 };
		 if($Occurance->ENV == true){
		 $EnvironmentCheck = 'checked="true"';
				 $CatCount++;
		$CatText .= " Environment /";
			 	 $envcss = "text-success";
			 $envcss2 = " opacity: 100 !important";
		 };
		 if($Occurance->Q == true){
		 $QualityCheck = 'checked="true"';
				 $CatCount++;
		$CatText .= " Quality /";
			 $qcss = " text-info";
			 $qcss2 = " opacity: 0.8 !important";
		 };
		 
					
					?>
				
				<div class="d-flex justify-content-between w-75 h-100" style="position: absolute; z-index: 0; opacity: 0.3; left: 12.5%; overflow: hidden; top: 1%">
				
				<i class="fas fa-heartbeat fa-5x {{$hscss ?? ''}}" style="{{$hscss2 ?? 'opacity: 0.5'}}"></i>
				<i class="fas fa-leaf fa-5x {{$envcss ?? ''}}"  style="{{$envcss2 ?? 'opacity: 0.5'}}"></i>
				<i class="fas fa-check-circle fa-5x {{$qcss ?? ''}}"  style="{{$qcss2 ?? 'opacity: 0.5'}}" ></i>
				
				</div>
					
						<div class="pl-3 mb-2 font-weight-bold">{{substr($CatText,0,-1)}}
		</div>
			 <div class="d-flex justify-content-center adminonly pl-3 mb-3">
	

	
		 
		 
<!-- Default inline 1-->
<div class="custom-control custom-checkbox custom-control-inline">
  <input type="checkbox" class="custom-control-input secretCat" id="HS" data-id="" {{$HealthCheck ?? ''}} value="1" name="SecretCat_">
  <label class="custom-control-label" for="HS"><i class="fad fa-heartbeat text-danger"></i> Health and Safety</label>
</div>

<!-- Default inline 2-->
<div class="custom-control custom-checkbox custom-control-inline">
  <input type="checkbox" class="custom-control-input secretCat" id="ENV"  data-id="" {{$EnvironmentCheck ?? ''}} value="2" name="SecretCat_">
  <label class="custom-control-label" for="ENV"><i class="fad fa-leaf text-success"></i> Environment</label>
</div>

<!-- Default inline 3-->
<div class="custom-control custom-checkbox custom-control-inline">
  <input type="checkbox" class="custom-control-input secretCat" id="Q"  data-id="" {{$QualityCheck ?? ''}} value="3" name="SecretCat_">
  <label class="custom-control-label" for="Q"><i class="fad fa-check-circle text-info"></i> Quality</label>
</div>
	 
	 </div>
				
		<?php 
		
		if($Occurance->Category){
			?>
		

		
		<div class="pl-3">{{$Occurance->Category}} \ {{$Occurance->Sub}}</div>
			
		<div class="btn btn-sm bg-secondary adminonly" id="ChangeCategory">change</div>
		
		<div id="categoriesUpdate" class="adminonly p-2" style="display: none">
		
			
			<select class="mdb-select md-form colorful-select " searchable="Search here.." id="Cats">
  <option value="" disabled selected>Choose Category</option>
  <?php 
			$Categories = DB::table('UKHT_Occurance_Categories')->where("Removed",0)->get();
				
			foreach($Categories as $Cat){
			?>
				<option value="{{$Cat->Category_Name}}" data-id="{{$Cat->ID}}">{{$Cat->Category_Name}}</option>
  
				
				<?php
			}
				?>
  
</select>
<label class="mdb-main-label">Categories</label>
			
			<div>
			<select class="mdb-select md-form subCats" searchable="Search here.." id="SubCats" disabled>
  <option value="" disabled selected>Choose Category first</option>
			</select>
			<label class="mdb-main-label"Sub Category</label>
		</div>
		<?php
			$Categories = DB::table('UKHT_Occurance_Categories')->where("Removed",0)->get();
				
			foreach($Categories as $Cat){
			?>
			<div style="display: none">		
		<select class="mdb-select md-form subCats" style="display: none" searchable="Search here.." id="SubCats{{$Cat->ID}}">
  <option value="" disabled selected>Choose Sub Category</option>
  <?php 
			
			$Categories = DB::table('UKHT_Occurance_Sub')->where('Category_ID',$Cat->ID)->where("Removed",0)->get();
				
			foreach($Categories as $Cat){
			?>
				<option value="{{$Cat->Sub_Name}}" data-id="{{$Cat->Category_ID}}" data-value="{{$Cat->ID}}">{{$Cat->Sub_Name}}</option>
  
				
				<?php
			}
				?>
</select>
<label class="mdb-main-label">Sub Category</label>
  </div>
				
				<?php
			}
		?> 
			
		<div class="btn btn-primary disabled" id="SaveCategory" >Save</div>
			
		
		</div>
		

			
			<?php
		}else{
			?>
			
			<select class="mdb-select md-form colorful-select adminonly ml-2" searchable="Search here.." id="Cats">
  <option value="" disabled selected>Choose Category</option>
  <?php 
			$Categories = DB::table('UKHT_Occurance_Categories')->where("Removed",0)->get();
				
			foreach($Categories as $Cat){
			?>
				<option value="{{$Cat->Category_Name}}" data-id="{{$Cat->ID}}">{{$Cat->Category_Name}}</option>
  
				
				<?php
			}
				?>
  
</select>
<label class="mdb-main-label adminonly">Categories</label>
			
			<div class="adminonly ml-2">
			<select class="mdb-select md-form subCats" searchable="Search here.." id="SubCats" disabled>
  <option value="" disabled selected>Choose Category first</option>
			</select>
			<label class="mdb-main-label"Sub Category</label>
		</div>
		<?php
			$Categories = DB::table('UKHT_Occurance_Categories')->where("Removed",0)->get();
				
			foreach($Categories as $Cat){
			?>
			<div class="adminonly" style="display: none">		
		<select class="mdb-select md-form subCats" style="display: none" searchable="Search here.." id="SubCats{{$Cat->ID}}">
  <option value="" disabled selected>Choose Sub Category</option>
  <?php 
			
			$Categories = DB::table('UKHT_Occurance_Sub')->where('Category_ID',$Cat->ID)->where("Removed",0)->get();
				
			foreach($Categories as $Cat){
			?>
				<option value="{{$Cat->Sub_Name}}" data-id="{{$Cat->Category_ID}}" data-value="{{$Cat->ID}}">{{$Cat->Sub_Name}}</option>
  
				
				<?php
			}
				?>
</select>
				
			
				
<label class="mdb-main-label">Sub Category</label>
  </div>
				
				<?php
			}
		?> 
			
		<div class="btn btn-primary disabled adminonly" id="SaveCategory" >Save</div>
			
			
			
			<?php
		
		}
		
		
	
		
		
		
		
							  
		
		?>
	
		
		
		
				</div>
		
		
		<div class="card-title p-2 mt-2 ml-0 mr-0 {{$OccuranceName->Class}}">Allocation and Actions:</div>
		
	
		<?php 
		
			if($Occurance->HSQE_Actioner){ 
				
				$ActionHide = "style=display:none"; 
				?>
				<div class="card-body Nvoc">
		
		<p class="card-text font-weight-bold">{{DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first()->Surname}}</p>
		
			<div class="btn btn-sm bg-secondary actionOnly  Nvoc" id="ChangeAllocation">New Allocation</div>
	
						@if($Occurance->Passed_To)
		<p class="pl-4">Suggested Actioner: {{$Occurance->Passed_To}}</p>
		@endif
					
		</div>
				<?php
			}
		else{
			$ActionHide = ""; 
		}
		
		?> 
		
	<div class="card-body adminonly Nvoc" {{$ActionHide}}>
		
		<div class="md-form amber-textarea active-amber-textarea">
  <textarea id="Instructions" class="md-textarea form-control " rows="3"></textarea>
  <label for="Instructions">Instructions for Allocated User:</label>
</div>
		
		<select class="mdb-select md-form" id="AllocatedTo" searchable="Search user..">
  <option value="" disabled selected>Choose your user</option>
			<?php
			$External =  DB::table('Entity_Contacts')->where(['Entity_Class_ID' => 3, 'Entity_Identifier' => $Occurance->Site])->select('Contact_ID');
			
			$Internal = DB::table('UKHT_Emails')->where('Organisation_ID', '<',0)->select('ID as Contact_ID')->union($External);
			
			$USERS = DB::table('UKHT_Emails')
				->whereIn('ID',$Internal->pluck('Contact_ID'))->orderby('Organisation_ID','asc')->orderby('Name')->get(); 
			
			
			
			foreach($USERS as $User){
			?>
			  <option value="{{$User->ID}}">{{$User->Name}} - {{DB::table('Organisation')->where('Organisation_ID',$User->Organisation_ID)->first()->Name}}</option>
			<?php	
			}
			
			
			?>
	
</select>
		
		<div class="md-form">
  <input placeholder="Selected date" type="text" id="deadline" class="form-control datepicker">
  <label for="deadline">Deadline</label>
</div>
		
		<label for="Urgancy">Reminder Schedule</label>
		
		<select class="mdb-select md-form" id="Urgancy" name="urgancy">
			  <option value="1" selected>Daily</option>
			  <option value="2">Weekly</option>
		
</select>
		
		<div class="btn btn-primary disabled waves-effect waves-light" id="Allocate">Confirm and Allocate</div>
		
		</div>
		
	</div>
	</div>	
	
<?php if($Occurance->HSQE_Actioner && !$Occurance->Sign_Off && !$Occurance->Actions_Taken_HSQE || $Occurance->ReAllocated == 1){
	?>
<div class="card mt-2 actionOnly">
<h3 class="card-header bg-danger text-white">Actions</h3>
	<div  class="card-body" >
		<div>
<form action="OccuranceUploadDocument" method="post"  enctype="multipart/form-data">
	
	<input type="number" hidden="" value="{{request('id')}}" name="ID">
		<div class="md-form amber-textarea active-amber-textarea">
  <textarea id="ActionsTaken" class="md-textarea form-control " name="Actions" rows="3"></textarea>
  <label for="ActionsTaken">What actions have you taken?</label>
</div>
	
	<div class="form-check">
    <input type="checkbox" class="form-check-input" name="SubbyYesNo" id="SubbyYesNo">
    <label class="form-check-label" for="SubbyYesNo">Subcontractor involved?</label>
</div>
	
	<div class="md-form" style="display: none">
  <input type="text" id="Subby" name="Subby" class="form-control">
  <label for="Subby">Subcontractor(s) Name:</label>
</div>
	
	
	<div class="md-form">			
	<div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Upload Photos</span>
      <input type="file" multiple name="photos[]" id="photos" accept="image/png, image/jpeg">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more photos (optional)">
    </div>
  </div>
			</div>	
	
	<div class="md-form">			
	<div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Upload Supporting Documents</span>
      <input type="file" multiple id="documents" name="documents[]">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more documents (optional)">
    </div>
  </div>
			</div>	
	
	<button type="submit" class="btn btn-primary disabled" id="SubmitActions">Submit</div>
	</form>
			</div>
</div>

<?php
}
	
	if($Occurance->HSQE_Actioner){
	?>
	<div class="card mt-2">
<h3 class="card-header bg-danger text-white">Actions taken</h3>
<div class="card-body">
	<?php
		
		if($Occurance->ReAllocated == 1 ){ ?>
			<div class="card-title badge badge-danger">Awaiting Action</div>
		<div class="row">
		<div class="col-3 text-right">Allocated To: </div>
		<div class="col">{{DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first()->Surname}}</div>
		</div>
	
		<div class="row">
		<div class="col-3 text-right">HSQE Instruction: </div>
		<div class="col">{{urldecode($Occurance->HSQE_Instruction)}}</div>
		</div>
	<?php 
		}else{
		
		?>
	
	<div class="card-title badge badge-secondary">{{$Occurance->Last_Updated}}</div>
		<div class="row">
		<div class="col-3 text-right">Allocated To: </div>
		<div class="col">{{DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$Occurance->HSQE_Actioner)->first()->Surname}}</div>
		</div>
	
		<div class="row">
		<div class="col-3 text-right">HSQE Instruction: </div>
		<div class="col">{{urldecode($Occurance->HSQE_Instruction)}}</div>
		</div>
	
		<div class="row">
		<div class="col-3 text-right">Deadline: </div>
		<div class="col">{{$Occurance->DeadLine}}</div>
		</div>
	
	<div class="row">
		<div class="col-3 text-right">Actions Taken: </div>
		<div class="col">@if(base64_encode(base64_decode($Occurance->Actions_Taken_HSQE, true)) === $Occurance->Actions_Taken_HSQE)
			{{base64_decode($Occurance->Actions_Taken_HSQE)}}
			@else
			{{$Occurance->Actions_Taken_HSQE}}
			@endif</div>
		</div>
	<?php 
	
	if($Occurance->Contractor_Involved){
		?>
	
	<div class="row">
		<div class="col-3 text-right">Subcontractor Involved: </div>
		<div class="col">
			{{$Occurance->Contractor_Name}}
		
			
			</div>
		</div>
	
	<?php
	}else{
		?>
	<div class="row">
		<div class="col-3 text-right">Subcontractor Involved: </div>
		<div class="col">No Subcontractor involved</div>
		</div>
	<?php
	}
		
		}
	
	
	
	$History = DB::table('UKHT_Occurance_History')
		->where([['HSQE_Instruction','!=',$Occurance->HSQE_Instruction],['Occurance_ID',$Occurance->ID],['ReAllocated',0]])
		->orWhere([['Actions_Taken_HSQE','!=',$Occurance->Actions_Taken_HSQE],['Occurance_ID',$Occurance->ID],['ReAllocated',0]])
		->orderby("Last_Updated","desc")
				 ->get(); 
		
		foreach($History as $item){
		
		?>
	
	<div class="card-title badge badge-primary">{{$item->Last_Updated}}</div>
		<div class="row">
		<div class="col-3 text-right">Allocated To: </div>
		<div class="col">{{DB::table('Contact')->where('Contact_ID',$item->HSQE_Actioner)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$item->HSQE_Actioner)->first()->Surname}}</div>
		</div>
	
		<div class="row">
		<div class="col-3 text-right">HSQE Instruction: </div>
		<div class="col">{{urldecode($item->HSQE_Instruction)}}</div>
		</div>
	
		<div class="row">
		<div class="col-3 text-right">Deadline: </div>
		<div class="col">{{$item->DeadLine}}</div>
		</div>
	
	<div class="row">
		<div class="col-3 text-right">Actions Taken: </div>
		<div class="col">
			@if(base64_encode(base64_decode($item->Actions_Taken_HSQE, true)) === $item->Actions_Taken_HSQE)
			{{base64_decode($item->Actions_Taken_HSQE)}}
			@else
			{{$item->Actions_Taken_HSQE}}
			@endif
			
			</div>
		</div>
	<?php 
	
	if($Occurance->Contractor_Involved){
		?>
	
	<div class="row">
		<div class="col-3 text-right">Subcontractor Involved: </div>
		<div class="col">
			@if(base64_encode(base64_decode($item->Contractor_Name, true)) === $item->Contractor_Name)
			{{base64_decode($item->Contractor_Name)}}
			@else
			{{$item->Contractor_Name}}
			@endif</div>
		</div>
	
	<?php
	}else{
		?>
	<div class="row">
		<div class="col-3 text-right">Actions Taken: </div>
		<div class="col">No Subcontractor involved</div>
		</div>
	<?php
	}
		
		}
	
	
	
	
	
	
	
	?>
		</div>
	<div class="card-title p-2 mt-2 ml-0 mr-0 text-white primary-color">Documents </div>
	<div class="card-body">
		@if(Storage::disk('occurance')->exists("O".request('id').'/'))
		@foreach(Storage::disk('occurance')->files("O".request('id').'/') as $FileName)
	
		<a href="OccuranceDocDownload?file={{$FileName}}">{{str_replace("O".request('id').'/','',$FileName)}}</a>
		<br>
		@endforeach
		@else
		No Documents
		@endif
	</div>
	
	

		




		

	
	<div class="card-title p-2 mt-2 ml-0 mr-0 text-white primary-color">Photos </div>
	<div class="card-body">
		
		<?php 
	
	if(!$PostPhotos->exists()){
		?>
No images.
			<?php 
	}
	
	
	
	?>
		


   <div class="no-margin card-columns p-0 m-0"  style="column-gap: 2; column-count: 6">
	<?php if($PostPhotos->exists()){
			
	
			foreach($PostPhotos->get() as $image){
			 
				?>
			
        <a href="{{urldecode($image->Photo)}}" data-toggle="lightbox" data-gallery="Photos" class="w-100">
          <img src="{{urldecode($image->Photo)}}" style="height: 100px;" class="img-fluid w-100">
			 </a>
   
			
			<?php 
				
			
			}
			

	
}else{
	
	
	
} ?>
			
		</div>

	
	</div>
		

</div>
</div>
	<?php
}

?>

</div>


<div class="col-md-6 float-left m-0 p-3">

<div class="card">
<h4 class="card-header {{$OccuranceName->Class}}">{{$OccuranceName->Name}} Details</h4>
	
	<div class="card-body">
	
		<div class="row">
		<div class="col-3 text-right">Reported: </div>
		<div class="col">{{Carbon::createFromFormat('Y-m-d H:i:s.u',$Occurance->Reported_Date)->toRfc7231String()}}</div>
		</div>
		<div class="row">
		<div class="col-3 text-right">Occurred: </div>
		<div class="col">{{Carbon::createFromFormat('Y-m-d H:i:s.u',$Occurance->Date)->toRfc7231String()}}</div>
		</div>
		<div class="row">
		<div class="col-3 text-right">Site: </div>
		<div class="col">{{$SiteName}}</div>
		</div>
		<div class="row">
		<div class="col-3 text-right">Location: </div>
		<div class="col">{{$locName}}</div>
		</div>
		
		<div class="row">
		<div class="col-3 text-right">Weather: </div>
		<div class="col">{{$Occurance->Weather}}</div>
		</div>
		
		<div class="row">
		<div class="col-3 text-right">Lighting Conditions: </div>
		<div class="col">{{$Occurance->Lighting_Conditions}}</div>
		</div>
		
	
		
<?php if($Occurance->Name){ ?>
	<div class="row">
		<div class="col-3 text-right">Name: </div>
		<div class="col">{{$Occurance->Name}}</div>
		</div>
<?php } ?>
<?php if($Occurance->Employer){ ?>
	<div class="row">
		<div class="col-3 text-right">Employer: </div>
		<div class="col">{{$Occurance->Employer}}</div>
		</div>
<?php } ?>
		
		
		
		<div class="row">
		<div class="col-3 text-right">Reporter is: </div>
		<div class="col">{{$Occurance->Member_Of_Public}}</div>
		</div>

		@if($Occurance->Occurance == 3 || $Occurance->Occurance == 4 )
		<div class="row">
		<div class="col-3 text-right">Occupation: </div>
		<div class="col">{{$Occurance->Occupation}}</div>
		</div>
		
		<div class="row">
		<div class="col-3 text-right">Phone Number: </div>
		<div class="col">{{$Occurance->Phone}}</div>
		</div>
		
		
		@endif
	
	</div>
	
	<div class="card-title p-2 mt-2 ml-0 mr-0 {{$OccuranceName->Class}}">Describe the Event and What Could have happened: </div>
	<div class="card-body">
		
		<div class=""><?php echo urldecode($Occurance->Details) ?></div>
	
	</div>	
	
	@if($Occurance->Occurance == 4)
	@include('obs\InjuryChart')
	@endif
	
	<div class="card-title p-2 mt-2 ml-0 mr-0 {{$OccuranceName->Class}}">What were you able to do about it? </div>
	<div class="card-body">
		
		<div class=""><?php echo urldecode($Occurance->Actions_Taken_Site) ?></div>
	
	</div>
	<div class="card-title p-2 mt-2 ml-0 mr-0 {{$OccuranceName->Class}}">Photos </div>
	<div class="card-body">
		
		<?php 
	
	if(!$Photos->exists() && !$HistPhotos->exists()){
		?>
No images.
			<?php 
	}
	
	
	
	?>
		
		


   <div class="no-margin card-columns p-0 m-0" style="column-gap: 2; column-count: 6">
	<?php if($Photos->exists()){
			
	
			foreach($Photos->get() as $image){
			 
				?>
		
        <a href="{{($image->Photo)}}"  data-toggle="lightbox" data-gallery="Photos"  data-size="100%x50%" class="w-100" title="oldimage.jpg">
          <img src="{{($image->Photo)}}" style="height: 100px;" class="img-fluid w-100" title="oldimage.jpg">
			 </a>
        
			
			<?php 
				
			
			}
			

	
}else{
	
	if($HistPhotos->exists()){
			
	
			foreach($HistPhotos->get() as $image){
			 
				$content = urlencode($image->File_Location);
				$file = str_replace('\\\\UKHTS097\\PersistentStore$','',$content); 
				$final = str_replace('\\','/',$file);
				
	
				?>
			 
        <a href="OccuranceOldPhotos?photo={{$content}}&id={{request('id')}}"  data-toggle="lightbox" data-gallery="Photos" data-max-width="600">
          <img src="OccuranceOldPhotos?photo={{$content}}&id={{request('id')}}" class="img-fluid w-100">
			 </a>
        
			
			<?php 
				
			
			}
			

	
}
	
	
	
} ?>
	   
	 	
		</div>
 
	   
	</div>
	<div class="card-title p-2 mt-2 ml-0 mr-0 {{$OccuranceName->Class}} mb-0">Location Map (remember GPS is not entirely accurate) </div>
		  <div id="map" class="map m-0"></div>
	 <div id="popup" class="ol-popup">
     <a href="#" id="popup-closer" class="ol-popup-closer"></a>
     <div id="popup-content"></div>
 </div>
	</div>

	</div>


<canvas width="200px" height="200px" /></canvas>

<script>
	
	
	$(document).ready(function(){
		var GPS = [<?php echo $Occurance->GPS ?>];
		if(!GPS || GPS.length === 0){
			$('.map').html('Location not provided')
			$('.map').addClass('card-text p-2')
			$('.map').removeClass('map')
			$('#popup').remove()
		}else{
		
			 var attribution = new ol.control.Attribution({
     collapsible: false
 });

 var map = new ol.Map({
     controls: ol.control.defaults({attribution: false}).extend([attribution]),
     layers: [
         new ol.layer.Tile({
            source: new ol.source.OSM()
         })
     ],
     target: 'map',
     view: new ol.View({
         center: ol.proj.fromLonLat(GPS),
         maxZoom: 18,
         zoom: 12
     })
 });
		
		 var layer = new ol.layer.Vector({
     source: new ol.source.Vector({
         features: [
             new ol.Feature({
                 geometry: new ol.geom.Point(ol.proj.fromLonLat(GPS))
             })
         ]
     })
 });
 map.addLayer(layer);

		
		 var container = document.getElementById('popup');
 var content = document.getElementById('popup-content');
 var closer = document.getElementById('popup-closer');

 var overlay = new ol.Overlay({
     element: container,
     autoPan: true,
     autoPanAnimation: {
         duration: 250
     }
 });
		
		
	 content.innerHTML = ' <img src="{{asset("images/Pin/".$OccuranceName->Name.".png")}}" width="35px" alt="">';
 
		overlay.setPosition(ol.proj.fromLonLat(GPS));	

		
		
 map.addOverlay(overlay);

		

			
		}
		
	
		
		if (window.document.documentMode) {
        $('.mdb-select').addClass('browser-default');
        $('.mdb-select').removeClass('mdb-select');
    }

		
		<?php if($AdminOnly){ echo "var AdminOnly = true;"; }else{ echo "var AdminOnly = false;"; } ?>
		
		<?php if($ViewOnly){ echo "var ViewOnly = true;"; }else{ echo "var ViewOnly = false;"; } ?>
		
		<?php if($ActionOnly){ echo "var ActionOnly = true;"; }else{ echo "var ActionOnly = false;"; } ?>
	 
		if(AdminOnly == false){
			$('.adminonly').remove()
		}
		
		if(ViewOnly == true){
			
			$('.Nvoc').remove()
			$('.viewOnly').show();
		}else{
			$('.viewOnly').remove()
		}
		
		if(ActionOnly == false){
			$('.actionOnly').remove()
		}
		
		
		
	
		
		$('.toast').delay(2000).toast('show');
		
		$('#Cats').on('change',function(){
			var ID = $(this).children('option:selected').data('id');
			
	$(".subCats").parents('div').hide()	
$("#SubCats"+ID).parents('div').show()
$("#SubCats"+ID).parents('div').css("display",'block')

			
		})
		
		if(<?php echo $Occurance->Occurance ?> == 2){
			$(".subRoots, .subRootLabel").remove(); 
			$('#Roots').on('change',function(){
				
					$('#CloseOut').removeClass('disabled');
		})
				
		}else{
			
			$('#Roots').on('change',function(){
			var ID = $(this).children('option:selected').data('id');
			
	$(".subRoots").parents('div').hide()	
$("#SubRoots"+ID).parents('div').show()
$("#SubRoots"+ID).parents('div').css("display",'block')

			
		})
			
		}
		
		
		
		
		$(".subCats").on('change',function(){
			$('#SaveCategory').removeClass('disabled');
		})
		$("#AllocatedTo").on('change',function(){
			$('#Allocate').removeClass('disabled');
		})
		
		$(".subRoots").on('change',function(){
			$('#CloseOut').removeClass('disabled');
			
		@if($Occurance->Occurance == 4)
			if($('#RIDDOR').children('option:selected').val().length > 0){
			$('#CloseOut').removeClass('disabled');
		}else{
			$('#CloseOut').addClass('disabled');
		}
			console.log($('#RIDDOR').children('option:selected').val())
			console.log($('#SubRoots'+$('#Roots').children('option:selected').data('id')).find('option:selected').val())
			@endif
			
		})
		
		@if($Occurance->Occurance == 4)
		$('#RIDDOR').on('change',function(){
		if($('#RIDDOR').children('option:selected').val().length > 0 && $('#SubRoots'+$('#Roots').children('option:selected').data('id')).find('option:selected').val().length > 0 ){
			$('#CloseOut').removeClass('disabled');
		}else{
			$('#CloseOut').addClass('disabled');
		}
			})
		@endif
		
		$("#ChangeCategory").on('click',function(){
			$('#categoriesUpdate').show();
			$(this).hide()
		})
		
		$("#ChangeAllocation").on('click',function(){
			$(this).parent().siblings().show();
			$(this).hide()
		})
		
		$('#SaveCategory').on('click',function(){
			var CAT = $('#Cats').val();
			var CATID = $('#Cats').children('option:selected').data('id');
			var SUB = $("#SubCats"+CATID).val();
			 $.post('OccuranceSaveCategory',{ID:<?php echo $_GET['id']; ?>,CAT:CAT,SUB:SUB,Type:"UpdateCat"}).done(function(){
			location.reload();
		})
		})
		
		$('#CloseOut').on('click',function(){
			var ROOT = $('#Roots').val();
			
			@if($Occurance->Occurance == 4)
			var RIDDOR = $('#RIDDOR').children('option:selected').val();
			@else
			var RIDDOR = "N/A";
			@endif
			
			if(<?php echo $Occurance->Occurance ?> == 2){
				var SUBROOT = "Good Practice"
			}else{
				var ROOTID = $('#Roots').children('option:selected').data('id');
			var SUBROOT = $('#SubRoots'+ROOTID).val();
			}
			
			var Thanks = $('#thanks').val();
			
				 $.post('CloseOccurance',{ID:<?php echo $_GET['id']; ?>,ROOT:ROOT, RIDDOR:RIDDOR,SUBROOT:SUBROOT, Thanks:Thanks,Type:"Close"}).done(function(){
			location.reload();
		})
  
		
		})	
		
		$('#Allocate').on('click',function(){
			var INS = $('#Instructions').val();
			var ALL = $('#AllocatedTo').val();
			var REM = $('#Urgancy').val();
			var DEAD = $('#deadline').val();
			
			 $.post('OccuranceAllocate',{ID:<?php echo $_GET['id']; ?>,ALL:ALL,REM:REM,INS:INS,DEAD:DEAD,Type:"Allocate"}).done(function(){
			location.reload();
		})
		})
		
		$('#ChangeLocation').on('click',function(){
			 console.log('Custom cancel clicked');
			var dialog = bootbox.prompt({
    title: 'Please choose the correct Site',
    message: "<p>This can be reverted or changed again at any time before close.</p>",
    size: 'large',
				inputType: 'select',
    inputOptions: [
    {
        text: 'Choose one...',
        value: '',
    },
		@foreach(DB::table('UKHT_Locations')->where('Type','Project')->where('Removed',0)->get() as $Location)
    {
        text: '{{$Location->Name}}' ,
        value: {{$Location->Linked_Entity}},
    },
		@endforeach
   
    ],
				
    callback: function (result) {
		if(result){
			var site = result;
        $.post('updateandgetLocations',{id:result}).done(function(locations){
			
			var dialog = bootbox.prompt({
    title: 'Please choose the correct Location',
    message: "<p>This can be reverted or changed again at any time before close.</p>",
    size: 'large',
				inputType: 'select',
    inputOptions: locations,
				
    callback: function (result) {
		if(result){
        $.post('updateandgetLocations',{site:site, id:{{request('id')}}, location:result, type: 'location'}).done(function(locations){ 
			location.reload();
		})
														 
		}
    }
});
			
		})
			
			
		}
    }
});
		})	
		$('#ChangeOccurance').on('click',function(){
			 console.log('Custom cancel clicked');
			var dialog = bootbox.dialog({
    title: 'Please choose the correct Occurance',
    message: "<p>This can be reverted or changed again at any time before close.</p>",
    size: 'large',
    buttons: {
        cancel: {
            label: "Close",
            className: 'btn-default',
            callback: function(){
               
            }
        },
        cc: {
            label: "Close Call",
            className: 'btn-primary',
            callback: function(){
                 $.post('OccuranceChangeOCC',{ID:<?php echo $_GET['id']; ?>,OCC:1,Type:"ChangeOCC"}).done(function(){
			location.reload();
		})
            }
        },
        gp: {
            label: "Good Practice",
            className: 'btn-success',
            callback: function(){
             $.post('OccuranceChangeOCC',{ID:<?php echo $_GET['id']; ?>,OCC:2,Type:"ChangeOCC"}).done(function(){
			location.reload();
		})
            }
        },
        acc: {
            label: "Accident",
            className: 'btn-danger',
            callback: function(){
                  $.post('OccuranceChangeOCC',{ID:<?php echo $_GET['id']; ?>,OCC:4,Type:"ChangeOCC"}).done(function(){
			location.reload();
		})
			}
            },
        inc: {
            label: "Incident",
            className: 'btn-warning',
            callback: function(){
                $.post('OccuranceChangeOCC',{ID:<?php echo $_GET['id']; ?>,OCC:3,Type:"ChangeOCC"}).done(function(){
			location.reload();
		})
            }
        }
    }
});
		})	
		
	})
	
	$('#SubbyYesNo').on('change',function(){
		console.log($(this).prop('checked'))
		
		if($(this).prop('checked') == true){
			$('#Subby').parent().show()
			$('#SubmitActions').addClass('disabled');
			$('#Subby').val('')
		}else{
			$('#Subby').parent().hide()
		}
	})
	
	
	$('#SubbyYesNo, #Subby, #ActionsTaken').on('change keyup select blur', function(){
		var Actions = $('#ActionsTaken').val();
		var Subby = $('#Subby').val();
		if(!$('#SubbyYesNo').prop('checked')){
			if(!Actions || Actions.trim() === '' ){
		   $('#SubmitActions').addClass('disabled');
		   }else{
			   $('#SubmitActions').removeClass('disabled');
		   }
		}else{
			if(!Subby || Subby.trim() === '' || !Actions || Actions.trim() === '' ){
		   $('#SubmitActions').addClass('disabled');
		   }else{
			   $('#SubmitActions').removeClass('disabled');
		   }
		}
		
	})
	
	
	
	$('#SubmitActions').on('click',function(){
		
		
		var Actions = $('#ActionsTaken').val();
		var SubYesNo = $('#SubbyYesNo').prop('checked');
		var Subby = $('#Subby').val();
		
		
		
		
		  var files = $("#photos").prop("files");
            for (var i = 0; i < files.length; i++) {
                (function (file) {
                    if (file.type.indexOf("image") == 0) {
                        var fileReader = new FileReader();
                        fileReader.onload = function (f) {
                              $.ajax({
                                type: "POST",
                                url: "OccuranceUploadPhotos",
                                data: {
                                    'file': f.target.result,
                                    'name': file.name,
                                    'LogID': <?php echo $_GET['id']; ?>,
									'Type': 'ActionPhotos'
                                },
                                success: function (photoresult) {
                                    console.log(photoresult)
                                }
                            });
                        };

                        fileReader.readAsDataURL(file);
                    }
                })(files[i]);
            }
		
		var form_data = new FormData(); 
	
		  // Read selected files
    var documents = $("#documents").prop("files");
		 for (var i = 0; i < documents.length; i++) {
                (function (document) {
					form_data.append('files[]',document)
					
						 $.ajax({
     url: 'OccuranceUploadDocument', 
     type: 'post',
     data: {'ID':1, 'Doument':document},
     cache: false,
        processData: false,
        contentType : false,
     success: function (response) {

       for(var index = 0; index < response.length; index++) {
         ;
       }

     }
   });
					
					
					console.log(document)
				})(documents[i]);
		 }

	
	
             
	
  
		
		//$.post('OccuranceAction',{ID:<?php echo $_GET['id']; ?>,SubYesNo:SubYesNo,Actions: Actions, Subby: Subby, Type:"AllocatorActions"}).done(function(){
		//	location.reload();
		//})
		
		
	})
	
	
	

		$('.body').show();
	
	$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
					showArrows: 1
				});
            });
	
	
	$('.secretCat').on('click',function(){
		console.log($(this).val())
		console.log($(this).attr('id'))
		
		$.post('OccuranceSecretCategory',{ID:{{request('id')}},Val:$(this).attr('id')})
	})

</script>
</div>
@endif

@stop
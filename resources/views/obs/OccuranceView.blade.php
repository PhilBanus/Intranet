@extends('obs.OccuranceMainPage')
@section('content')
<?php use Carbon\Carbon; 
$now = Carbon::now();

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

$DATA = DB::table('UKHT_Occurance_Close_Call')->where('ID',$_GET['id'])->first(); 

$Occurance = DB::table('UKHT_Occurance')->where('ID',$DATA->Occurance)->first();

$Photos = DB::table('UKHT_Occurance_Photos')->where('Occurance_ID',$_GET['id']);
$HistPhotos = DB::table('UKHT_Occurance_Historic_Photo')->where('Occurance_ID',$DATA->Global_ID);

if($DATA->Site == 0){
		$SiteName = "Head Office";
	}else{
		$site = DB::table('Project')->where('Project_ID',$DATA->Site)->first();
		$SiteName = $site->Name;
	}

if(is_int($DATA->Location)){
$loc = DB::table('UKHT_Occurance_Location')->where('ID',$DATA->Location)->first();
	$locName =$loc->Name; 
}else{
	$locName =$DATA->Location;
}

if($DATA->Email){
	
	?>
<script> 
	$(document).ready(function(){
		
	
		
Command: toastr["warning"]("Please note, The submitter will recieve an email of all actions taken.", "Email Added")

	}); 
</script>


<?php
	
	
}


if($DATA->Risk_Prevented){
	
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



?>

<div class="col-md-6 float-right p-0 m-0">

	<div class="card">
<h4 class="card-header danger-color-dark text-white">Actions</h4>
	<div class="card-body">
		
		<div class="btn btn-lg bg-info" id="ChangeOccurance">Not a {{$Occurance->Name}}?</div>
		
		<p>
		<?php 
		
		if($DATA->Category){
			?>
		
			
			<?php
		}else{
			?>
			
				
			<select class="custom-select md-form" searchable="Search here.." id="Cats">
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
			
			
			
			<?php
		
		}
		
		
		?>
			</p>
	</div>
	</div>	
	
</div>


<div class="col-md-6 float-left">

<div class="card">
<h4 class="card-header {{$Occurance->Class}}">{{$Occurance->Name}} Details</h4>
	
	<div class="card-body">
	
		<div class="row">
		<div class="col-3 text-right">Reported: </div>
		<div class="col">{{Carbon::createFromFormat('Y-m-d H:i:s.u',$DATA->Reported_Date)->toRfc7231String()}}</div>
		</div>
		<div class="row">
		<div class="col-3 text-right">Occurred: </div>
		<div class="col">{{Carbon::createFromFormat('Y-m-d H:i:s.u',$DATA->Date)->toRfc7231String()}}</div>
		</div>
		<div class="row">
		<div class="col-3 text-right">Site: </div>
		<div class="col">{{$SiteName}}</div>
		</div>
		<div class="row">
		<div class="col-3 text-right">Location: </div>
		<div class="col">{{$locName}}</div>
		</div>
		
<?php if($DATA->Name){ ?>
	<div class="row">
		<div class="col-3 text-right">Name: </div>
		<div class="col">{{$DATA->Name}}</div>
		</div>
<?php } ?>
<?php if($DATA->Employer){ ?>
	<div class="row">
		<div class="col-3 text-right">Employer: </div>
		<div class="col">{{$DATA->Employer}}</div>
		</div>
<?php } ?>
	
	</div>
	
	<div class="card-title p-2 mt-2 ml-0 mr-0 text-white primary-color">Describe the Event and What Could have happened: </div>
	<div class="card-body">
		
		<div class=""><?php echo urldecode($DATA->Details) ?></div>
	
	</div>
	
	<div class="card-title p-2 mt-2 ml-0 mr-0 text-white primary-color">What were you able to do about it? </div>
	<div class="card-body">
		
		<div class=""><?php echo urldecode($DATA->Actions_Taken_Site) ?></div>
	
	</div>
	<div class="card-title p-2 mt-2 ml-0 mr-0 text-white primary-color">Photos </div>
	<div class="card-body">
		
		<?php 
	
	if(!$Photos->exists() && !$HistPhotos->exists()){
		?>
No images.
			<?php 
	}
	
	
	
	?>
		
		<div id="mdb-lightbox-ui"></div>


   <div class="mdb-lightbox no-margin card-columns p-0 m-0" style="column-gap: 2; column-count: 6">
	<?php if($Photos->exists()){
			
	
			foreach($Photos->get() as $image){
			 
				?>
			 <figure class="card p-0 m-0 w-100">
        <a href="{{urldecode($image->Photo)}}" data-size="968x1024" class="w-100">
          <img src="{{urldecode($image->Photo)}}" style="height: 100px;" class="img-fluid w-100">
			 </a>
        <figcaption><?php echo urldecode($image->Name); ?></figcaption>
      </figure>
			
			<?php 
				
			
			}
			

	
}else{
	
	if($HistPhotos->exists()){
			
	
			foreach($HistPhotos->get() as $image){
			 
				?>
			 <figure class="card p-0 m-0 w-100">
        <a href="https://themis.ukht.org/workflow/service.ashx/{{$image->This_ID}}/image" data-size="968x1024" class="w-100">
          <img src="https://themis.ukht.org/workflow/service.ashx/{{$image->This_ID}}/image" style="height: 100px;" class="img-fluid w-100">
			 </a>
        <figcaption>{{$image->This_ID}}</figcaption>
      </figure>
			
			<?php 
				
			
			}
			

	
}
	
	
	
} ?>
			
		</div>

	
	</div>
	
	</div>

	</div>

<script>
	$(document).ready(function(){
		$('.toast').delay(2000).toast('show');
		
		$('#Cats').on('change', function(){
			var ID = $(this).children('option:selected').data('id');
			
	$(".subCats").parents('div').hide()	
$("#SubCats"+ID).parents('div').show()

			
		})
		
		
		$('#ChangeOccurance').on('click',function(){
			 console.log('Custom cancel clicked');
			var dialog = bootbox.dialog({
    title: 'Please choose the correct Occurance',
    message: "<p>This can be reverted or changed again at any time before close.</p>",
    size: 'large',
    buttons: {
        cancel: {
            label: "I'm a cancel button!",
            className: 'btn-danger',
            callback: function(){
                console.log('Custom cancel clicked');
            }
        },
        noclose: {
            label: "I don't close the modal!",
            className: 'btn-warning',
            callback: function(){
                console.log('Custom button clicked');
                return false;
            }
        },
        ok: {
            label: "I'm an OK button!",
            className: 'btn-info',
            callback: function(){
                console.log('Custom OK clicked');
            }
        },
        another: {
            label: "I don't close the modal!",
            className: 'btn-warning',
            callback: function(){
                console.log('Custom button clicked');
                return false;
            }
        }
    }
});
		})	
		
	})</script>
@stop
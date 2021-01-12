<div style="position: relative">
<?php 

$Admin = DB::table('HELPDESK_TechnicianImage')->where('Technician',session('MY_ID'))->exists(); 


$Details = DB::table('HELPDESK_Calls')->where('ID',$_GET['ID'])->first();

if($Details->Technician){
	$Technician = DB::table('Contact')->where('Contact_ID',$Details->Technician)->first()->Forename." ".DB::table('Contact')->where('Contact_ID',$Details->Technician)->first()->Surname; 
}else{
	$Technician = "Not Assigned";
}

$User = DB::table('Contact')->where('Contact_ID',$Details->Contact)->first()->Forename." ".DB::table('Contact')->where('Contact_ID',$Details->Contact)->first()->Surname; 

$UserEmail = $Details->Email;



if($Admin){
	
	?>
	
	<div class="bg-dark w-100 p-2 sticky-top m-0 d-flex justify-content-left">
	
		<?php if($Details->Technician){ }else{ ?><a href="AssignHelpdesk?ID={{session('MY_ID')}}" class="btn btn-sm btn-default border-0 rounded-0">Pick Up</a><?php } ?>
		<div class="dropdown">
		<div class="btn btn-sm btn-default border-0 rounded-0 dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
    aria-haspopup="true" aria-expanded="false"><?php if($Details->Technician){ echo "Re-";} ?>Assign</div>
		<div class="dropdown-menu dropdown-primary">
			<?php
			$technicians = DB::table('HELPDESK_TechnicianImage')->join('Contact','Contact_ID','Technician')->get();
	foreach($technicians as $Tech){
		?>
			<a class="dropdown-item" href="AssignHelpdesk?ID={{$Tech->Contact_ID}}">{{$Tech->Forename}} {{$Tech->Surname}}</a>
			
			<?php
			
	}			?>
    
  </div>
  </div>
		<div class="btn btn-sm btn-default border-0 rounded-0">Close</div>
		<div class="btn btn-sm btn-default border-0 rounded-0">Put On-Hold</div> 
		
	</div>
	
	
	
	
	<?php
	
}


?>



<div class="row p-0 m-0 h-100" id="Element">

<div class="col-md-9 bg-light">

	<div class="card bg-transparent border-0 mb-1 p-0 z-depth-0 h-100">
				<div class="card-header bg-transparent border-0 m-0">Comments</div>

	<div class="card-body m-0 pt-0">

		
		<div class="white p-2 border-left border-secondary m-0 mb-2 " id="respond">
	<textarea id="Comment" class="card-text form-control rounded-0 border-0" placeholder="Enter response here"></textarea>
			<div class="small text-muted text-right d-flex justify-content-between">
				
				<div class="md-form w-75"> 
				  <div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Attachments</span>
      <input type="file" id="AttachDocuments" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more files">
    </div>
  </div>
				</div>	 
				
				<div><div class="btn btn-sm border-0 btn-light z-depth-0 float-right" id="AddComment"><i class="fas fa-paper-plane"></i></div> </div></div>
	
</div>
		<hr>
		
		<div id="CommentsList" class="c-scroll custom-scrollbar"  style="overflow: auto">
		
			<?php
			
			$Comments = DB::table('HELPDESK_Comments')->where('Ticket',$_GET['ID'])->where('Removed',false)->orderby('Date','desc')->get();
			
			foreach($Comments as $Comment){
				
				if($Comment->Technician){
		$border = 'border-right border-danger';
	}else{
		$border = 'border-left border-success';
	}
	
	?>

<div class="white p-2 mb-2 {{$border}} " data-id="{{$Comment->Count}}">
	<div class="card-title small text-muted">{{DB::table('Contact')->where('Contact_ID',$Comment->Contact)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$Comment->Contact)->first()->Surname}} - {{$Comment->Date}} </div>
	<div class="card-text"><?php echo base64_decode($Comment->Message) ?></div>
	
	
<?php
 $dir = '\\\\ukhts055\\Data\\HelpDesk\\HELPDESK-'.$_GET['ID'].'\\COMMENT-'.$Comment->Count.'\\';
				
				if(is_dir($dir)){
					
					echo '<div class="card  rounded-0 border-0 m-2 mr-0 ml-0 p-2">';
				
$CfileList = glob('\\\\ukhts055\\Data\\HelpDesk\\HELPDESK-'.$_GET['ID'].'\\COMMENT-'.$Comment->Count.'\\*');
foreach($CfileList as $filename){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($filename)){
		?>
			<a class="btn rounded-0 p-0 border-bottom text-primary text-left z-depth-0" href="Download?filename={{base64_encode($filename)}}&name={{str_replace($dir,'',$filename)}}">{{str_replace($dir,'',$filename)}}  <span class="float-right">{{round(filesize($filename) * 0.001)}} mb</span></a>
			
			
			<?php
	
    }   
}
					echo "</div>";
					}
	?>		
		
	
</div>
			<?php	
				
			}
			
			?>
			<div class="white p-2 border-left border-primary ">
	<div class="card-title small text-muted">{{DB::table('Contact')->where('Contact_ID',$Details->Contact)->first()->Forename}} {{DB::table('Contact')->where('Contact_ID',$Details->Contact)->first()->Surname}} - {{$Details->Submitted}} </div>
	<div class="card-text text-black">{{base64_decode($Details->Description)}}</div>
				
				<div class="card  rounded-0 border-0 m-2 mr-0 ml-0 p-2">
<?php
 $dir = '\\\\ukhts055\\Data\\HelpDesk\\HELPDESK-'.$_GET['ID'].'\\';
$fileList = glob('\\\\ukhts055\\Data\\HelpDesk\\HELPDESK-'.$_GET['ID'].'\\*');
foreach($fileList as $filename){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($filename)){
		?>
			<a class="btn rounded-0 p-0 border-bottom text-primary text-left z-depth-0" href="Download?filename={{base64_encode($filename)}}&name={{str_replace($dir,'',$filename)}}">{{str_replace($dir,'',$filename)}}  <span class="float-right">{{round(filesize($filename) * 0.001)}} mb</span></a>
			
			
			<?php
	
    }   
}
	?>		
		</div>
</div>
		
		</div>
		
		
		
	</div>
	</div>
	
</div>

	
	<div class="col-md-3 ">
<div class="table-responsive">	
<table class="table">
		<tr><td>User</td><td>{{$User}}</td></tr>
		<tr><td>Email</td><td>{{$UserEmail}}</td></tr>
		<tr><td>Phone</td><td>{{$Details->Phone}}</td></tr>
		<tr><td>Status</td><td class="{{DB::table('HELPDESK_Status')->where('ID',$Details->Status)->first()->Color}}"> {{DB::table('HELPDESK_Status')->where('ID',$Details->Status)->first()->Name}} </td></tr>
		<tr><td>Category</td><td class="{{DB::table('HELPDESK_Category')->where('ID',$Details->Category)->first()->Color}}"> {{DB::table('HELPDESK_Category')->where('ID',$Details->Category)->first()->Name}} </td></tr>
		<tr><td>Assigned To</td><td>{{$Technician}}</td></tr>
	
	</table>
		</div>
	
		
			
			
			
			
			
			<div class="card-title">All Attachments</div>
<?php
 $dir = '\\\\ukhts055\\Data\\HelpDesk\\HELPDESK-'.$_GET['ID'].'\\';
$fileList = glob('\\\\ukhts055\\Data\\HelpDesk\\HELPDESK-'.$_GET['ID'].'\\*');
foreach($fileList as $filename){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($filename)){
		?>
			<a class="btn rounded-0 p-0 border-bottom text-primary text-left z-depth-0 w-100" href="Download?filename={{base64_encode($filename)}}&name={{str_replace($dir,'',$filename)}}">{{str_replace($dir,'',$filename)}}  <span class="float-right">{{round(filesize($filename) * 0.001)}} mb</span></a>
			
			
			<?php
	
    }   
	
	if(is_dir($filename)){
		$afileList = glob($filename.'\\*');
foreach($afileList as $afilename){
    //Use the is_file function to make sure that it is not a directory.
    if(is_file($afilename)){
		?>
			<a class="btn rounded-0 p-0 border-bottom text-primary text-left z-depth-0 w-100" href="Download?filename={{base64_encode($afilename)}}&name={{str_replace($dir,'',$afilename)}}">{{str_replace($dir,'',$afilename)}}  <span class="float-right">{{round(filesize($afilename) * 0.001)}} mb</span></a>
			
			
			<?php
	
    }   
}
	}}
	?>		
		</div>
	
	</div>
</div>

<script>
	
	tinymce.EditorManager.execCommand('mceRemoveEditor',true, 'Comment');
	
tinymce.init({
        selector: '#Comment',
			 plugins: "paste",
	branding: false,
  menubar: "",
  toolbar: "",
  paste_data_images: true
      });
	

	
	$('#Element').parents('.modal-content').find('.modal-title').text("#<?php echo $_GET['ID']?> - {{base64_decode($Details->Subject)}}");
	
	$.ajaxSetup({  });
	
	$('#AddComment').on('click',function(){
		 var fileData = new FormData();
	
	
		
		var f1 = $('#AttachDocuments');	

		if(f1.val()) {
			console.log('value')
		var fileList = f1.get(0).files;
		for(var x=0;x<fileList.length;x++) {
			fileData.append('file[]', fileList.item(x));	
			console.log('appended a file');
		}
	}
		
		tinyMCE.triggerSave();
		var comment = $('#Comment').val();

		
		
		if(!comment.trim() && comment.length < 1){}else{
			var user = <?php echo session('MY_ID') ?>;
		var id = <?php echo $_GET['ID'] ?>;
		
	
		fileData.append('comment', comment)

		fileData.append('user', user)
		fileData.append('id', id)
		fileData.append('type', "Comment")
		
			
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'HelpUpdate', true);
			// Set up a handler for when the request finishes.
xhr.onload = function () {
  if (xhr.status === 200) {
    // File(s) uploaded.
  } else {
    alert('An error occurred!');
  }
};
			
	// Send the Data.
xhr.send(fileData);
			
		
		
		$('#AttachDocuments').val('');
		tinyMCE.activeEditor.setContent('');
		}
		
		
	})
	
	
	$(function() {
		if($(".c-scroll").length > 0){
		var height = $('.modal').height();
		console.log(height)
		var offset = $(".c-scroll").position();
		console.log(offset)
		
		$(".modal-body").css("max-height", height);
			
			height = height-(offset.top*1.7);
		console.log(height)
		$(".c-scroll").css("height", height);
		}
	})

	// SideNav Scrollbar Initialization
var sideNavScrollbar = document.querySelector('.c-scroll');
	if(sideNavScrollbar){
var ps = new PerfectScrollbar(sideNavScrollbar);
	}
	
	
	
	
</script>

<div id="footer"></div>

</div>


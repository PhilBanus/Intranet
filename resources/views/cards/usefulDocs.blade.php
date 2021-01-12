
<div class="card border-0" style="background: #8591a5 " >
	<div class="card-header text-center bg-transparent text-white font-weight">Useful Documents</div>
	
	
		<?php 
		
		$Documents = DB::table('UKHT_Useful_Documents')->where('disabled',0)->join('Document','Document.Document_ID','UKHT_Useful_Documents.document_id')->orderby('Published_Date','desc')->take(10)->get(); 
		
		if($Documents->count() > 0){
			
			?>
	<div class="card-body p-1 pr-3 row" > 
		<?php
		
		foreach($Documents as $Doc){
			
			
		?>
		
			<div class="col-md-12">
		<div class="card bg-transparent border-0 m-0 p-0 text-center">
		
				<a href="https://themis.ukht.org/XWeb/DMS/Document_Properties.aspx?ID={{$Doc->Document_Series_ID}}&viewDocument=true&showProperties=True&latest=true" target="new" class="btn btn-outline-primary text-left w-100 pl-2 pr-1" style="background-color: white !important"><i class="fas fa-file-<?php if($Doc->File_Type == "pdf")
								{ echo $Doc->File_Type." text-".$Doc->File_Type; }
								elseif($Doc->File_Type == "pptx")
								{ echo "powerpoint text-danger"; }elseif($Doc->File_Type == "zip")
								{ echo "archive text-warning"; }elseif($Doc->File_Type == "docx" || $Doc->File_Type == "doc" )
								{ echo "word text-word"; } ?> mr-1"></i> {{App\Documents::getLatest($Doc->Document_ID)->Keywords}}</a> 
		
		</div>
			</div>
		
		<?php
			
			
			
		}
		?>
	</div>
	
	<?php
		
		}
		else{
			?>
	
			<div class="alert alert-warning m-2" role="alert">
 This section is being updated.
</div>
		
		<?php
		}
		
		?>
	
		
	
	</div>

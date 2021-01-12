
<div class="card border-0" style="background: #4e8790" >
	<div class="card-header text-center bg-transparent text-white">Stay In Touch</div>
	
	<div class="card-body p-1 pr-3 row" > 
		<?php 
		
		$Documents = DB::table('Stay_In_Touch')->orderby('Published_Date','desc')->take(4)->get(); 
		
		foreach($Documents as $Doc){
			
			
		?>
		
			<div class="col-md-12">
		<div class="card bg-transparent border-0 m-0 p-0 text-center">
		
				<a href="https://themis.ukht.org/XWeb/DMS/Document_Properties.aspx?ID={{$Doc->Document_Series_ID}}&viewDocument=true&showProperties=True" target="new" class="btn btn-outline-primary text-left w-100 pl-2 pr-1" style="background-color: white !important"><i class="fas fa-file-<?php if($Doc->Type == "pdf")
								{ echo $Doc->Type." text-".$Doc->Type; }
								elseif($Doc->Type == "pptx")
								{ echo "powerpoint text-danger"; }elseif($Doc->Type == "zip")
								{ echo "archive text-warning"; }elseif($Doc->Type == "docx" || $Doc->Type == "doc" )
								{ echo "word text-word"; } ?> mr-1"></i> {{$Doc->Title}}</a> 
		
		</div>
			</div>
		
		<?php
			
			
			
		}
		
		?>
	
		
	
	</div>
	</div>
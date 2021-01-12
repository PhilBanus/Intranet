
<?php

$Count = DB::table($Table)->where(DB::raw("CAST(".$Col." as Date)"),"=",DB::raw("CAST(GETDATE() as Date)"))->count();
	
	
	
	?>



<div class="card view view-cascade text-center">
	<div class="card-body row p-4 m-0 mx-auto text-center">

<i class="fas fa-3x fa-{{$icon}} text-white morpheus-den-gradient p-4 text-center rounded-circle mx-auto"></i>
		
<div class="p-4 fa-2x text-nowrap text-center mx-auto">
{{$Count ?? ''}} {{$Title ?? ''}}
	</div>
</div>
</div>
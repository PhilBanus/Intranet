@extends('LPTtwo.default')
@section('content')
<?php 
use Carbon\Carbon;
	


	
	?>



	
	<div class="card rounded-0 z-depth-0">
<div class="card-header bg-light d-flex justify-content-between">
	<div class="text-primary">

Contact Created
		</div>

		</div>
	<div class="card-body fhl-card" id="Users" style="overflow: auto">
		
		
		    <a href="https://themis.ukht.org/XWeb/Skills/Journal.aspx?ec=1&code={{$id}}" class="btn btn-info my-4 btn-block" type="submit">{{$origin->Forename}} {{$origin->Surname}} Skills</a>

		
		    <button class="btn btn-danger my-4 btn-block" onclick="close_window();return false;" type="submit">Exit</button>
 



		
		
	</div>
	</div>

<script>

	
function close_window() {
  if (confirm("Close Window?")) {
    close();
  }
}

</script>

@stop







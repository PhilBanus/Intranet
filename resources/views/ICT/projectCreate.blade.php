@extends('intranet')

@section('content')
<div class="row">
<div class="col-md-12 float left">
	<div class="card card-cascade">

  
  <div class="view view-cascade gradient-card-header blue-gradient">
  
    <h2 class="card-header-title mb-3"> New Project</h2>
  
    

  </div>
		
	<div class="view view-cascade gradient-card-header winter-neva-gradient">
  
    
  
    

  </div>

</div>
</div>
	
	<div class="col-md-6">
		<div class="card card-cascade">
			<div class="card-header bg-dark">
				<div class="text-white text-center">Start dates and end dates</div>
				<div class="row d-flex justify-content-around ">
					<div class="md-form col-md-5">
					<input type="text" id="form1" class="form-control text-warning">
					<label for="form1 " class="text-warning">Start date</label>
					</div>
					<div class="md-form col-md-5">
					<input type="text" id="form1" class="form-control text-warning">
					<label for="form1 " class="text-warning">End date</label>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card card-cascade">
			<div class="card-header white">
				<div class="text-white text-center">Description</div>
				
			</div>
		</div>
	</div>

</div>







@stop


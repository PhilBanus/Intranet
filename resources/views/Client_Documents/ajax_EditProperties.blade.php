<?php
$id = request('id');

$details = db::table('UKHT_CD_Document')->where('id',$id)->first();

?>

<div class="modal-body p-2 bg-dark border-0" style="overflow-y: auto ">
	
	<div class="card">
		
		<div class="card-header row  primary float-right" >
			<div class=""><button type="button" class="btn success text-white">replace</button> </div>
		</div>
		
<div class="card-body row white justify-content-around">
	
	<div class="form-outline col-md-4">
		<label for="version" class="active text-white"><small>Title</small></label>
  <input type="text" id="typeNumber" class="form-control" placeholder="insert title here" value="{{$details->title}}" />
</div>
	
	<div class="form-outline col-md-4">
		<label for="version" class="active text-white"><small>Description</small></label>
  <input type="text" id="typeNumber" class="form-control" placeholder="insert Description here" value="{{$details->description}}"  />
</div>
	
	<div class="form-outline col-md-2">
		<label for="version" class="active text-white"><small>Version</small></label>
  <input type="number" id="typeNumber" class="form-control" step="0.1" placeholder="insert Version here" value="{{$details->version}}"  />
</div>
	
</div></div>
		
      </div>
      <div class="modal-footer border-0 bg-dark">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><i class="fad-fa-save"></i> Save</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>





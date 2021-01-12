@extends('intranet')

@section('content')





<div class="row">
	<div class="col md-8">
		
				<div class="card z-depth-0">
		
			<div class="card-header bg-transparent text-primary font-weight-bold border-primary">RIDDOR <i class="fas fa-plus text-success waves-effect addRIDDOR" onClick="addRIDDOR()" role="tab"></i></div>
			
		<div class="card-body">
			<div id="RIDDORLIST" class="w-100">

	@foreach( DB::table('UKHT_Occurance_RIDDOR')->where(['Removed' => 0])->orderby('order','asc')->get();  as $RIDDOR)
 <div class="d-flex border-dark border-bottom p-2 "><div>{{$RIDDOR->name}}</div>
	 <div class="ml-auto">
	 <i onClick="editName('RIDDOR', {{$RIDDOR->id}} , '#RIDDORLIST')" class="ml-auto fad fa-pencil text-warning lighter waves-effect"></i>
	 <i onClick="removeRIDDOR({{$RIDDOR->id}})" class="ml-auto fad fa-trash text-danger lighter waves-effect"></i>
		 </div>
		 </div>
	@endforeach


				</div>
			
			</div>
		
		
		
		</div>
		
				<div class="card z-depth-0">
		
			<div class="card-header bg-transparent text-primary font-weight-bold border-primary">Root Causes <i class="fas fa-plus text-success waves-effect" id="addRoot" role="tab"></i></div>
			
		<div class="card-body">
			<div id="RootList" class="w-100 row">
<div class="nav flex-column nav-pills col-md-4" id="Root_Causes" role="tablist" aria-orientation="vertical">
	
	@foreach( DB::table('UKHT_Occurance_Root')->where('Removed',0)->get() as $Root)
  <a class="nav-link d-flex" id="Root_{{$Root->ID}}_tab" data-toggle="pill" href="#Root_{{$Root->ID}}" role="tab" aria-controls="Root_{{$Root->ID}}" aria-selected="false">{{$Root->Root}} 
	   <div class="ml-auto">
	 <i onClick="editName('Root_Cause', {{$Root->ID}} , '#RootList')" class="ml-auto fad fa-pencil text-warning lighter waves-effect"></i>
	  <i class="ml-auto fad fa-trash waves-effect text-danger" onClick="removeRoot({{$Root->ID}})"></i>
	  </div>
	</a>

	@endforeach
</div>
<div class="tab-content col-md-8 bg-light text-dark" id="Root_Causes_Content">
	@foreach( DB::table('UKHT_Occurance_Root')->where('Removed',0)->get() as $Root)
	 <div class="tab-pane fade show" id="Root_{{$Root->ID}}" role="tabpanel" aria-labelledby="Root_{{$Root->ID}}_tab">
		 <div class="card-title font-weight-bold">{{$Root->Root}} <i class="fas fa-plus text-success waves-effect addSubRoot" onClick="addSubRoot({{$Root->ID}})"></i></div>
	@foreach( DB::table('UKHT_Occurance_Root_Sub')->where(['Root_ID' => $Root->ID, 'Removed' => 0])->get();  as $Root_Sub)
 <div class="d-flex border-dark border-bottom p-2 "><div>{{$Root_Sub->Sub_Name}}</div>
	  <div class="ml-auto">
	 <i onClick="editName('Root_Sub', {{$Root_Sub->ID}} , '#Root_{{$Root->ID}}')" class="ml-auto fad fa-pencil text-warning lighter waves-effect"></i>
	 <i onClick="removeSubRoot({{$Root_Sub->ID}},{{$Root->ID}})" class="ml-auto fad fa-trash text-danger lighter waves-effect"></i>
		 </div>
		 </div>
	@endforeach
		 </div>
	@endforeach
</div>
				</div>
			
			</div>
		
		
		
		</div>
		
		
		
	<div class="card z-depth-0">
		
			<div class="card-header bg-transparent text-primary font-weight-bold border-primary">Categories <i class="fas fa-plus text-success waves-effect" id="addCategory" role="tab"></i></div>
			
		<div class="card-body">
			<div id="CategoryList" class="w-100 row">
<div class="nav flex-column nav-pills col-md-4" id="Categories" role="tablist" aria-orientation="vertical">
	
	@foreach( DB::table('UKHT_Occurance_Categories')->where('Removed',0)->get() as $Category)
  <a class="nav-link d-flex" id="Category_{{$Category->ID}}_tab" data-toggle="pill" href="#Category_{{$Category->ID}}" role="tab" aria-controls="Category_{{$Category->ID}}" aria-selected="false">{{$Category->Category_Name}} 
	  <div class="ml-auto">
	 <i onClick="editName('Category', {{$Category->ID}} , '#CategoryList')" class="ml-auto fad fa-pencil text-warning lighter waves-effect"></i><i class="ml-auto fad fa-trash waves-effect text-danger" onClick="removeCategory({{$Category->ID}})"></i>
	  </div>
	</a>
	@endforeach
</div>
<div class="tab-content col-md-8 bg-light text-dark" id="Category_Content">
	@foreach( DB::table('UKHT_Occurance_Categories')->where('Removed',0)->get() as $Category)
	 <div class="tab-pane fade show" id="Category_{{$Category->ID}}" role="tabpanel" aria-labelledby="Category_{{$Category->ID}}_tab">
		 <div class="card-title font-weight-bold">{{$Category->Category_Name}} <i class="fas fa-plus text-success waves-effect addSubCategory" onClick="addSubCategory({{$Category->ID}})"></i></div>
	@foreach( DB::table('UKHT_Occurance_Sub')->where(['Category_ID' => $Category->ID, 'Removed' => 0])->get();  as $Category_Sub)
 <div class="border-dark border-bottom p-2 ">
	 <div class="d-flex"><div>{{$Category_Sub->Sub_Name}}</div>
		  <div class="ml-auto">
	 <i onClick="editName('Sub_Cat', {{$Category_Sub->ID}} , '#Category_{{$Category->ID}}')" class="ml-auto fad fa-pencil text-warning lighter waves-effect"></i>
	 <i onClick="removeSubCategory({{$Category_Sub->ID}},{{$Category->ID}})" class="ml-auto fad fa-trash text-danger lighter waves-effect"></i>
	</div>
	</div>
	
	 
	 
		 </div>
	@endforeach
		 </div>
	@endforeach
</div>
				</div>
			
			</div>
		
		
		
		</div>
		
		
	</div>
<div class="col-md-4">
<div class="list-group list-group-flush">
	<div class="list-group-item list-group-item-action border-primary ">
		<div class="text-primary d-flex align-items-center  font-weight-bold">Head Office 
			<div class="btn-sm btn-light text-primary ml-auto waves-effect" data-toggle="modal" data-target="#exampleModal" data-whatever="Head Office" data-id="0"><i class="fas fa-cog"></i></div>
		</div>
		<div class="d-flex align-items-center mt-1">
		<a href="https://themis.ukht.org/XWeb/PublicAssets/external/public/observations?id=0" target="new" class="btn btn-sm btn-secondary m-0">Go to Form</a>
		<div class="ml-auto">
	<img src="https://api.qrserver.com/v1/create-qr-code/?data={{urlencode('https://themis.ukht.org/XWeb/PublicAssets/external/public/observations?id=0')}}&amp;size=300x300" alt="" title="Head Office" class="img-thumbnail downloadable ml-auto border-primary" height="30" width="30" /></div>
		</div>
	</div>
<?php

$Locations = DB::table('UKHT_Locations')->where('Type','Project')->where('Removed',0)->get();

foreach($Locations as $Location){
	
	$Url = urlencode('https://themis.ukht.org/XWeb/PublicAssets/external/public/observations?id='.$Location->Linked_Entity);
	?>
	<div class="list-group-item list-group-item-action border-primary">
		<div class="text-primary d-flex align-items-center  font-weight-bold">{{$Location->Name}} 
			<div class="btn-sm btn-light text-primary ml-auto waves-effect" data-toggle="modal" data-target="#exampleModal" data-whatever="{{$Location->Name}}" data-id="{{$Location->Linked_Entity}}"><i class="fas fa-cog"></i></div>
		</div>
		<div class="d-flex align-items-center mt-1">
		<a href="https://themis.ukht.org/XWeb/PublicAssets/external/public/observations?id={{$Location->Linked_Entity}}" target="new" class="btn btn-sm btn-secondary m-0">Go to Form</a>
			<div class="ml-auto">
	<img src="https://api.qrserver.com/v1/create-qr-code/?data={{$Url}}&amp;size=300x300" alt="" title="{{$Location->Name}}" class="img-thumbnail downloadable ml-auto border-primary" height="30" width="30" />
			</div>
	</div>
	</div>
	<?php
} ?>

</div>
</div>

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="Settings">
        ...
		  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>



<script>
$(document).ready(function() {
$('.downloadable').each(function(){
  var $this = $(this);
  $this.wrap('<a href="' + $this.attr('src') + '" download target="new" />')
});

	
	
$('#exampleModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var recipient = button.data('whatever') // Extract info from data-* attributes
var ID = button.data('id') 
$('#Settings').load('locationSettings?id='+ID)

var modal = $(this);
modal.find('.modal-title').text('Settings for ' + recipient)
	
	
})


	});
	
		$('#addCategory').on('click', function(){
		bootbox.prompt({
    title: "Enter Category Name", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			
			
				$.post('OccuranceAddCategory',{Name:result,Type:"Category",Removed:0}).done(function(){
			$('#CategoryList').load('Observations #CategoryList')
		})
		}
    }
});
	})
		
	
	$('#addRoot').on('click', function(){
		bootbox.prompt({
    title: "Enter Root Name", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			
			
				$.post('OccuranceAddRoot',{Name:result,Removed:0}).done(function(){
			$('#RootList').load('Observations #RootList')
		})
		}
    }
});
	})
	
	function removeRoot(ID){
			$.post('OccuranceRemoveRoot',{ID:ID,Removed:1}).done(function(){
			$('#RootList').load('Observations #RootList')
		})
	}
	
	function removeCategory(ID){
			$.post('OccuranceRemoveCategory',{ID:ID,Removed:1}).done(function(){
			$('#CategoryList').load('Observations #CategoryList')
		})
	}
	
	
	function addSubCategory(id){
		bootbox.prompt({
    title: "Enter Category Name", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			
			
				$.post('OccuranceAddSubCategory',{Name:result, ID: id,Removed:0}).done(function(){
			$('#Category_'+id).load('Observations #Category_'+id)
		})
		}
    }
});
	}
	function removeSubCategory(id,Cat){
	
			
				$.post('OccuranceRemoveSubCategory',{ID: id,Removed:1}).done(function(){
			$('#Category_'+Cat).load('Observations #Category_'+Cat)
		})
	
	}
	function addSubRoot(id){
		bootbox.prompt({
    title: "Enter Root Name", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			
			
				$.post('OccuranceAddSubRoot',{Name:result, ID: id,Removed:0}).done(function(){
			$('#Root_'+id).load('Observations #Root_'+id)
		})
		}
    }
});
	}
	
	function addRIDDOR(){
		bootbox.prompt({
    title: "Enter RIDDOR Name", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			
			
				$.post('OccuranceAddRIDDOR',{Name:result, Removed:0}).done(function(){
			$('#RIDDORLIST').load('Observations #RIDDORLIST')
		})
		}
    }
});
	}
	
	function removeSubRoot(ID,Root){
	$.post('OccuranceRemoveSubRoot',{ID:ID,Removed:1}).done(function(){
			$('#Root_'+Root).load('Observations #Root_'+Root)
		})	
	}
	
	function removeRIDDOR(ID){
	$.post('OccuranceRemoveRIDDOR',{ID:ID,Removed:1}).done(function(){
			$('#RIDDORLIST').load('Observations #RIDDORLIST')
		})	
	}
	
	
	function editName(Table, ID, Refresh,Field){
		bootbox.prompt({
    title: "Enter New Name/Description.", 
    centerVertical: true,
    callback: function(result){ 
        console.log(result); 
		
		if(result){
			
				$.post('OccuranceEditName',{Table:Table, ID:ID, Name: result}).done(function(serve){
			$(Refresh).load('Observations '+Refresh)
			console.log(serve)		
		})
			
			
		}
	}
		});
		
	}
	
	$('#Root_Causes').find('a').first().addClass('active');
	$('#Root_Causes').find('a').first().attr('aria-selected',true);
	$('#Categories').find('a').first().addClass('active');
	$('#Categories').find('a').first().attr('aria-selected',true);	
	$('#Category_Content').find('.tab-pane').first().addClass('active');
	$('#Root_Causes_Content').find('.tab-pane').first().addClass('active');


	
	
</script>
@stop



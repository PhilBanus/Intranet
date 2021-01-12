
@extends('project')
@section('content')

<?php 
use Carbon\Carbon;
use Carbon\CarbonInterface;
$currentCats = DB::table('UKHT_Occurance_Categories')->where('Removed',0)->pluck('Category_Name');
$Recents = DB::table('UKHT_Occurance_Close_Call')->where('Date','>','2019-01-02')->whereNotIn('Category',$currentCats);
$Recents = DB::table('UKHT_Occurance_Close_Call')->where('Date','>','2019-01-02')->whereNull('Category')->union($Recents);
$Recents = DB::table('UKHT_Occurance_Close_Call')->where('Date','>','2019-01-02')->where(['HS' => false, 'Q' => false, 'ENV' => false])->union($Recents);
$Recents = DB::table('UKHT_Occurance_Close_Call')->where('Date','>','2019-01-02')->whereNull(['HS', 'Q', 'ENV'])->union($Recents);
					$Recents = $Recents->orderby('Date','desc')->get(); 
?>


<div class="row HARTS" style="display: none">
	<div class="col-5">
<div class="card bg-transparent border-0 mb-3">
				<div class="card-header bg-transparent border-primary">HART's ({{$Recents->count()}}) - Since 01 Jan 2019 - That are mis-categorised.</div>
				<div class="card-body p-0 m-0 h-100 fh-card custom-scroll"  id="Timeline"  style="overflow: auto">
				<ul class="list-group list-group-flush" id="harts">
			<?php 
				
				
				foreach($Recents as $Recent){
					if($Recent->Sign_Off){
						$Color = 'list-group-item-success';
					}else{
						$Color = 'list-group-item-danger';
					}
					?>
				<a onclick="windowLoad('OccuranceView?id={{$Recent->ID}}',$(this))"  onLoad="check()" data-id='OccuranceView?id={{$Recent->ID}}' target="_blank" class="list-group-item list-group-item-action small p-1 text-truncate {{$Color}} d-flex">
					<?php 
					if($Recent->Occurance == 1){ echo '<i class="fas fa-closed-captioning" style="color: #024a94"></i>'; }
					if($Recent->Occurance == 2){ echo '<i class="fas fa-check text-success"></i>'; }
					if($Recent->Occurance == 3){ echo '<i class="fas fa-exclamation-triangle text-warning"></i>'; }
					if($Recent->Occurance == 4){ echo '<i class="fas fa-user-injured text-danger"></i>'; }
					if($Recent->Occurance == 5){ echo '<i class="far fa-lightbulb text-info"></i>'; }
					
					
					
					
					?>
					
					{{Carbon::parse($Recent->Date)->diffForHumans(Carbon::now(), [
    'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
    'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS,
])}} - {{$Recent->Location}}
					
					 / 
					<span class="text-truncate">
					<?php 
					
					if($Recent->Occurance != 3 && $Recent->Occurance != 4){ echo urldecode($Recent->Details); } else{ echo "Click to view"; }
					?>
					
					</span> 	
					
					
					@if(DB::table('UKHT_Occurance_Close_Call')->where(['Details' => $Recent->Details, 'Site' => $Recent->Site])->where('ID', '!=', $Recent->ID)->exists())
					
					<div class="badge badge-danger ml-auto" onClick="showDuplicates({{DB::table('UKHT_Occurance_Close_Call')->where(['Details' => $Recent->Details, 'Site' => $Recent->Site])->pluck('ID')}})">Possible Duplicate</div>
					
					@endif
					</a>
				<?php
					
				}
				
				
				?>
			
			</ul>
				</div>
				</div>
		</div>
<div class="col-7">
	<iframe src="" class="col-12 w-100 h-100 bg-dark" id="occurance"></iframe>
	
	</div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="Duplicates">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Duplicates</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="DuplicateList">
		  
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
	
	$('document').ready(function(){
		$('.HARTS').show();
	})


function windowLoad(link,item){
	item.siblings().removeClass('bg-secondary');
	item.addClass('bg-secondary');
	$('#occurance').attr('src',link);
	
	$('#harts').load('https://themis.ukht.org/intranet/HARTHistory #harts',function(responseTxt, statusTxt, xhr){
		if(statusTxt == "success")
      $('[data-id="'+link+'"]').addClass('bg-secondary');
		console.log('done')
	})
	

}
	
	function showDuplicates(Array){
		$('#DuplicateList').html('')
		$('#Duplicates').modal('show');
		
		
		$.each(Array,function(Index, Value){
			$.get('HARTDuplicateCheck',{ID:Value}).done(function(result){
				$('#DuplicateList').append(result)
			})
		})
		
		
	}
	
	function viewHART(ID){
		window.open("https://themis.ukht.org/intranet/OccuranceView?id="+ID);
	}	
	function deleteHART(ID){
		
		bootbox.confirm("Are you sure you want to delete this HART (not retrivable)?", function(result){ 
    console.log('This was logged in the callback: ' + result); 
			
			if(result){
				$.post('HARTDeleteHART',{ID:ID}).done(function(delresult){
					bootbox.alert("HART Deleted!", function(){ 
    $('#HARTDup_'+ID).remove();
						console.log(delresult);
						$('#harts').load('https://themis.ukht.org/intranet/HARTHistory #harts');
});
				})
			}
});
		
		
	}
	
	

</script>
@endsection
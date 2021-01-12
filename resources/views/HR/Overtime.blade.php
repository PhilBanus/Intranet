<?php 
use Carbon\Carbon;

$Months = db::table('UKHT_Overtime_Items')->distinct(db::raw("cast(Submitted_Month as datetime) as Submitted_Month"))->orderby(db::raw("cast(Submitted_Month as datetime)"),'desc')->whereNotNull('Submitted_Month')->pluck(db::raw("cast(Submitted_Month as datetime) as Submitted_Month"));

$Max = db::table('UKHT_Overtime_Items')->orderby('Date','desc')->first();
$Min = db::table('UKHT_Overtime_Items')->orderby('Date','asc')->first();

$MaxDate = carbon::create($Max->Date);
$MinDate = carbon::create($Min->Date);

?>
@extends('intranet')

@section('content')

<div class="card bg-light" id="SearchFields">
    <div class="card-body row">
   
        <div class="col-md-3">
        <div class="input-group mb-3 col-md-12">
  <div class="input-group-prepend">
    <span class="input-group-text bg-primary text-white" id="basic-addon1"><i class="fas fa-user-circle"></i></span>
  </div>
  <input type="text" class="form-control" placeholder="Employee" id="Employee" aria-label="Employee" aria-describedby="basic-addon1">
</div>
        
        <div class="input-group mb-3 col-md-12">
  <div class="input-group-prepend">
    <span class="input-group-text bg-primary text-white" id="basic-LineManager"><i class="fas fa-user-tie"></i></span>
  </div>
  <input type="text" class="form-control" placeholder="Line Manager" aria-label="Line Manager" id="Line" aria-describedby="basic-LineManager">
</div>
            
            </div>
        
        <div class="col-md-3">
        <div class="input-group mb-3 col-md-12">
  <div class="input-group-prepend">
    <span class="input-group-text bg-primary text-white" id="basic-ProjectManager"><i class="fas fa-hard-hat"></i></span>
  </div>
  <input type="text" class="form-control" id="PM" placeholder="Project Manager" aria-label="Project Manager" aria-describedby="basic-ProjectManager">
</div>
        
        <div class="input-group mb-3 col-md-12">
  <div class="input-group-prepend">
    <label class="input-group-text bg-primary text-white" for="Status"><i class="fas fa-question-circle"></i></label>
  </div>
  <select class="browser-default custom-select" id="Status">
    <option value="-1" disabled selected>Choose...</option>
    <option value="0" class="bg-primary text-white">Clear</option>
    <option value="1">Approved</option>
    <option value="2">With Linemanager</option>
    <option value="3">With Project Manager</option>
    <option value="4">Rejected</option>
  </select>
</div>
            
            </div>
    
                <div class="col-md-3">
        <div class="input-group mb-3 col-md-12">
  <div class="input-group-prepend">
    <span class="input-group-text bg-primary text-white" id="basic-Project"><i class="fas fa-hard-hat"></i></span>
  </div>
  <input type="text" class="form-control" placeholder="Project" id="Project" aria-label="Project" aria-describedby="basic-ProjectManager">
</div>
        
        <div class="input-group mb-3 col-md-12">
  <div class="input-group-prepend">
    <label class="input-group-text bg-primary text-white" for="ClaimMonth"><i class="fas fa-calendar"></i></label>
  </div>
  <select class="browser-default custom-select" id="ClaimMonth">
    <option value="1" disabled selected>Claim Month</option>
    <option value="2" class="bg-primary text-white">Clear</option>
      @foreach($Months as $month)
    <option value="{{carbon::create($month)->format('F Y')}}">{{carbon::create($month)->format('F Y')}}</option>
      @endforeach
  </select>
</div>
            
            </div>
                <div class="col-md-3">
       <div  id="From" class="md-form md-outline p-0 m-0 mb-3 input-with-post-icon ignoredefault Newdatepicker datepicker">
  <input placeholder="Submitted From Date" type="text" id="FromDate"  class="form-control bg-white ">

  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
                    
                    <div id="To" class="md-form md-outline p-0 m-0 mb-3 input-with-post-icon ignoredefault Newdatepicker datepicker">
  <input placeholder="Submitted To Date" type="text" id="ToDate"  class="form-control bg-white ">
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
            
            </div>
            </div>
     <small class="card-title text-muted m-1">hit 'TAB' or 'ENTER' to search</small>

            </div>

    
<div class="col-12 note note-info p-1 mt-2 d-flex justify-content-between">

<div class="form-check small">
  <input type="checkbox" class="form-check-input text-primary" id="Paid" checked>
  <label class="form-check-label" for="Paid">UnPaid</label>
</div>
    
   <i class="fas fa-2x text-excel fa-file-excel waves-effect"></i> 
    
</div>

<div id="Result" class="card bg-transparent z-depth-0 mt-2"></div>



<script>
    var xhr;
    
var HidePaid = 'true';
    
    $(document).ready(function(){
        
        $('#From').datepicker({
            min: new Date('{{$MinDate}}'),
             max: new Date('{{$MaxDate}}')
        })
        $('#To').datepicker({
            min: new Date('{{$MinDate}}'),
             max: new Date('{{$MaxDate}}')
        })
        
        $('#Result').load('OvertimeDashTable?HidePaid=true');
        
        
        $('#Paid').on('change',function(){
            if($(this).is(':checked')){
               HidePaid = 'true';
            }else{
                HidePaid = 'false'
            }
            
            reLoad()
        })
        
        $('#SearchFields').find('input').on('keydown',function(e) {
   if(e.which == 13 || e.which == 9) {
       reLoad()
    }
        
    
        })
        
        $('#SearchFields').find('select').on('change',function(e) {
   
        reLoad()
   
        })
        $('#SearchFields').find('.datepicker').on('change',function(e) {
   
        reLoad()
   
        })
        
        
        
    });
    
    function reLoad(){
       
       if(xhr && xhr.readyState != 4){
            xhr.abort();
        }
        
        $('#Result').html('<div><div class="preloader-wrapper big active">\
  <div class="spinner-layer spinner-blue-only">\
    <div class="circle-clipper left">\
      <div class="circle"></div>\
    </div>\
    <div class="gap-patch">\
      <div class="circle"></div>\
    </div>\
    <div class="circle-clipper right">\
      <div class="circle"></div>\
    </div>\
  </div>\
</div> Loading Results . . . </div>')
        
        var Project = btoa($('#Project').val())
        var PM = btoa($('#PM').val())
        var Line = btoa($('#Line').val())
        var Employee = btoa($('#Employee').val())
        var ToDate = btoa($('#ToDate').val())
        var FromDate = btoa($('#FromDate').val())
        
        if($('#ClaimMonth').val() == 1 || $('#ClaimMonth').val() == 2 || $('#ClaimMonth').val() == null){
            var ClaimMonth = '';
            $('#ClaimMonth').val(1);
        }else{
            
        
        var ClaimMonth = btoa($('#ClaimMonth').val())
    }
        if($('#Status').val() < 1 || $('#Status').val() == null){
            var Status = '';
            $('#Status').val(-1);
        }else{
            
        
        var Status = $('#Status').val()
    }
        
        xhr = $.ajax({
            url: 'OvertimeDashTable',
            data: {'HidePaid' : HidePaid, 'Project': Project, 'PM': PM, 'Line':Line, 'Employee':Employee,'ClaimMonth':ClaimMonth,'Status':Status, 'ToDate':ToDate, 'FromDate':FromDate},
            success: function(data) {
              $("#Result").html(data);
            }
          });
        
      
        
        
        
    }

    
</script>
@stop

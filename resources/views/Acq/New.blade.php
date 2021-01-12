<?php
use Carbon\Carbon;
use Carbon\CarbonInterface;
?>
@extends('sections')
@section('content')


<?php
$Year = date('y');

$Code = DB::table('UKHT_Acquisition_Code')->where('Year',$Year)->orderBy('Code','Desc')->exists() ? DB::table('UKHT_Acquisition_Code')->where('Year',$Year)->orderBy('Code','Desc')->first()->Code : 000 ;

$Code = str_pad(intval($Code)+1, 3, '0', STR_PAD_LEFT) ;

?>


<div class="loader text-center p-5">
    
    <div class="spinner-border text-primary" role="status">

</div>
    Loading...
</div>

<div id="cont" style="font-size: 90%; display: none" class="row h-100">
    
<div class="col-md-9 float-right">
    
    

    
    <div class="alert alert-info d-flex justify-content-between" role="alert">
  <div> A{{$Year}}-{{$Code}}</div>
  <input type="text" class="form-control col-md-6" placeholder="Acquisiton Name" id="EnquiryName">
  <div>
      <select id="EnquiryStatus" class="browser-default custom-select" searchable="Search here..">
  <option value="" selected disabled>Select Status</option>
  @foreach(DB::table('Enquiry_Status')->where('Enquiry_Status_ID','>',12)->orderby('Display_Order')->get() as $Stat)
       <option value="{{$Stat->Enquiry_Status_ID}}" class="alert-<?php if($Stat->Display_Colour === "red"){ echo "danger"; } elseif($Stat->Display_Colour  === "yellow"){ echo "warning"; } else { echo "success"; }  ?> "          >{{$Stat->Name}}</option>
          @endforeach
          
</select>
        </div>
</div>
    

    
    <div class="row m-0 p-0">
        
   
            
            <div class="col-md-6 pl-4">
            
                <blockquote  class="blockquote bq-primary p-2 mb-1 pb-0 pt-0" >
  <p class="bq-title mb-1 pb-1" style="font-size: 90% !important">Client: 
      

      <input id="Client" type="search"  class="OrgSearch form-control mdb-autocomplete" data-id="">
        
 
                    </p>
  <textarea id="Description" class="form-control rounded m-0" rows="4" style="font-size: 80% !important">
  </textarea>
</blockquote>
                
                
                    
                    <dl >
       
  <dt>Form of Contract:</dt>
  <dd>      
      <select id="FormOfContract" class="browser-default custom-select" searchable="Search here..">
  <option value="" selected disabled>Select Status</option>
  @foreach(DB::table('UKHT_Acquisition_Form_Of_Contract')->orderby('Name')->get() as $Stat)
       <option value="{{$Stat->Form_Of_Contract_ID}}"             >{{$Stat->Name}}</option>
          @endforeach
          
        </select>
      
                        </dd>
                        
  <dt>Contract Category:</dt>
  <dd>
                        <select id="ContractCategory" class="browser-default custom-select" searchable="Search here..">
  <option value="" selected disabled>Select Status</option>
  @foreach(DB::table('UKHT_Acquisition_Contract_Category')->orderby('Name')->get() as $Stat)
       <option value="{{$Stat->Contract_Category_ID}}"     >{{$Stat->Name}}</option>
          @endforeach
          
        </select>
                        </dd>
                                   
  <dt></dt>
  <dd>
      
      <div class="md-form md-outline input-with-pre-icon">
  <i class="fas fa-pound-sign  input-prefix"></i>
  <input type="text" id="ClientValue" class="form-control">
  <label for="ClientValue">Client Value</label>
</div>
                        
                        </dd>
                        
  <dt>Known Competitors (PQQ):</dt>
  <dd><input id="Competitors" type="text"  class="form-control"></dd>
                        
  <dt>Known Competitors (Tender):</dt>
  <dd><input id="TenderCompetitors" type="text"  class="form-control"></dd>
                    </dl>
                
            </div>
        
      
            
                
            <div class="col-md-3">
            
                  <p class="note note-warning"><strong>Joint Venture</strong></p>       
          
                
                <div class="switch">
  <label>
    Not JV
    <input type="checkbox" id="JV">
    <span class="lever"></span> Is JV
  </label>
</div>
                
                
               <dl>
 <dt>JV Partners:</dt>
  <dd>
                    <input id="JVPartner" type="search" class="OrgSearch form-control mdb-autocomplete" data-id="">
                   
                   </dd>
    
                   <dt>HT JV Share:</dt>
  <dd>
                   
                   <div class="d-flex justify-content-center my-4">
  <div class="w-75">
    <input type="range" class="custom-range" id="Share" min="0" max="100">
  </div>
  <span class="font-weight-bold text-primary ml-2 valueSpan2"></span>%
</div>
                   
                   </dd>
                  
                   
                   
                    </dl>
                
                <hr>
              
                
                 <dl >
     
  <dt>Lead Designer:</dt>
  <dd>
                     <input id="Designer" type="search" class="OrgSearch form-control mdb-autocomplete" data-id="">
                     
                     </dd>
      
                   
                     
                     
  <dt>Approval Status:</dt>
  <dd><input type="text" readonly id="Approval"  class="form-control"></dd>
           
                     <hr>   
                   
  <dt>Winning Bidder:</dt>
  <dd><input id="Winner" type="text" class="form-control" ></dd>
      
                     
                     <dt for="Location">Location:</dt>
        <dd><input id="Location" type="text" class="form-control" value="United Kingdom"></dd>
        
                     
                
            </div>
        
      
                
            <div class="col-md-3">
     <p class="note note-primary"><strong>Dates</strong></p>       
               
                
                  <div class="row pl-4">
                     
                      
      <div class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="PQQ_Start" class="form-control">
  <label for="PQQ_Start">PQQ Start Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>     
                      
      <div  class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="PQQ_Submit" class="form-control">
  <label for="PQQ_Submit">PQQ Submission Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>    
                      
      <div  class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="Tender_Start" class="form-control">
  <label for="Tender_Start">Tender Start Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>               
      <div  class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="Tender_Submit" class="form-control">
  <label for="Tender_Submit">Tender Submission Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
                       
      <div  class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="Contract_Award" class="form-control">
  <label for="Contract_Award">Contract Award Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
                       
      <div  class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="Contract_Start" class="form-control">
  <label for="Contract_Start">Contract Start Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
      
                       
      <div  class="md-form md-outline input-with-post-icon Newdatepicker datepicker m-1">
  <input placeholder="Select date" type="text" 
         id="Contract_End" class="form-control">
  <label for="Contract_End">Contract End Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>
                     
            
                     
                     
                    </div>
                 <hr>
                <p class="note note-danger">
                <strong>Reason for bid rejection / no bid:</strong>
  <textarea name="nobid" id="NoBid" cols="30" rows="4" class="form-control"></textarea>
                    </p>
              
                <hr>
                
                  <div class="text-center">
 
                      <div class="btn btn-success disabled" id="save">Save</div>
        
                    </div>
              
                
              
            
                
                 
            
                
            </div>
        
    
        
        
    </div>
    
    
</div>


    
<div class="col-md-3 m-0 h-100 float-left">
    <div class="card p-0 m-0 rounded-0 h-100">
        
<iframe class=""  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed/v1/search?key=AIzaSyBPVHaD75EzmfHiLoQX9moPGtUYLilKGS8&q=United Kingdom&zoom=15"></iframe>
    </div>
</div>

</div>

<script>
   
 
    $(window).on('load', function(){

        $('.loader').hide()
        $('#cont').show()
 $('iframe').height($('#cont').height())

        
        

    })
            
// do something in the background


    
    $(document).ready(function() {
        
        $('#Location').on('keyup change', function(){
            $('iframe').attr('src',"https://www.google.com/maps/embed/v1/search?key=AIzaSyBPVHaD75EzmfHiLoQX9moPGtUYLilKGS8&q="+$(this).val()+"&zoom=15")
        })
        
        
        var src = "{{ route('SearchTheOrganisations') }}";
        $( ".OrgSearch" ).autocomplete({ classes: {
        "ui-autocomplete-item": "dropdown-item",
    "ui-autocomplete": "dropdown-menu dropdown-primary",
    "ui-menu-item-wrapper": "dropdown-menu dropdown-primary",
    },
            source: function( request, response ) {
                $.ajax({
                    url: src,
                    dataType: "json",
                    data: {
                         term : request.term
                    },
                    success: function(data) {
                        response(data);
                        
                    }
                });
            },change: function(event,ui){
  $(this).val((ui.item ? ui.item.value : ""));
  $(this).attr('data-id',(ui.item ? ui.item.id : ""));
},
            minLength: 2,
                    select: function (event, ui){
                        $( this ).val(ui.item.value); 
                        $( this ).attr('data-id',ui.item.id)
                        
                      
                        console.log(ui.item.value)
                        console.log(ui.item.id)
                    },
           
        });
        
        
          const $valueSpan = $('.valueSpan2');
  const $value = $('#Share');
  $valueSpan.html($value.val());
  $value.on('input change', function() {

    $valueSpan.html($value.val());
  });
        
        
     
        
        $('#ClientValue').on('keyup change', function(){
            var value = $(this).val();
            var appr = ''
            if(value < 8800000 ){ appr = 'Country Manager (CM)' }
            if(value > 8800000 && value < 17600000){ appr = 'Business Sector Manager (BSM)' }
            if(value > 17600000 && value < 35200000){ appr = "Tender Commitee (TC)" }
            if(value > 35200000){ appr = "Contract Review Committee (CRC)" }
            
            $('#Approval').val(appr)
        })
        
        
        
        $('#EnquiryName, #EnquiryStatus').on('change',function(){
            if($('#EnquiryName').val()){
                if($('#EnquiryStatus').val()){
                    $('#save').removeClass('disabled')
                }else{
                    $('#save').addClass('disabled')
                }
            }else{
                    $('#save').addClass('disabled')
                }
        })
        
        
        $('#save').on('click',function(){
            
            var Title = $('#EnquiryName').val()
            var Status = $('#EnquiryStatus').val()
            var Client = $('#Client').data('id')
            var Description = $('#Description').val()
            var FormOfContract = $('#FormOfContract').val()
            var ContractCategory = $('#ContractCategory').val()
            var ClientValue = $('#ClientValue').val()
            var PQQCompetitors = $('#Competitors').val()
            var TenderCompetitors = $('#TenderCompetitors').val() 
            
            if($('#JV').is(':checked')){
                var JV = 'Yes'
            }else{
                var JV = 'No'
            }
            
            
            
            var JVPartner = $('#JVPartner').data('id')
            var Share = $('#Share').val()
            var Designer = $('#Designer').data('id')
            var Approval = $('#Approval').val()
            var Winner = $('#Winner').val()
            var Location = $('#Location').val()
            var PQQ_Start = $('#PQQ_Start').val()
            var PQQ_Submit = $('#PQQ_Submit').val()
            var Tender_Start = $('#Tender_Start').val()
            var Tender_Submit = $('#Tender_Submit').val()
            var Contract_Award = $('#Contract_Award').val()
            var Contract_Start = $('#Contract_Start').val()
            var Contract_End = $('#Contract_End').val()
            var NoBid = $('#NoBid').val()
            
            
            
            
            $.post('Posts',{
                   Title:Title,
                   Status:Status,
                   Client:Client,
                   Description:Description,
                   FormOfContract:FormOfContract,
                   ContractCategory:ContractCategory,
                   ClientValue:ClientValue,
                   PQQCompetitors:PQQCompetitors,
                   TenderCompetitors:TenderCompetitors,
                   JV:JV,
                   JVPartner:JVPartner,
                   Share:Share,
                   Designer:Designer,
                   Approval:Approval,
                   Winner:Winner,
                   Location:Location,
                   PQQ_Start:PQQ_Start,
                   PQQ_Submit:PQQ_Submit,
                   Tender_Start:Tender_Start,
                   Tender_Submit:Tender_Submit,
                   Contract_Award:Contract_Award,
                   Contract_Start:Contract_Start,
                   Contract_End:Contract_End,
                   NoBid:NoBid,
                Year:'{{$Year}}',
                   Code:'{{$Code}}',
                   User:{{session('MY_ID')}},
                      Type:'New'
                   }).done(function(result){
            window.open = "https://themis.ukht.org/XWeb/entity/entity.aspx?ec=4&code="+result; 
            $('#cont').remove()   
                
        })
            
        })
        
        
    });

    
    
</script>

    
@stop
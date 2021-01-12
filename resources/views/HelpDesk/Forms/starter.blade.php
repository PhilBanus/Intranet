

@extends('form')

@section('content')

<div class="input-group" style="color: #757575;">


  <div class="md-form input-group">
  <div class="input-group-prepend">
    <input class="form-control" id="Title" type="text" placeholder="Title" autofocus>
  </div>
  <input type="text" aria-label="First name" class="form-control" placeholder="First Name">
  <input type="text" aria-label="Last name" class="form-control" placeholder="Surname">
</div>
    
        
</div>

    <select class="mdb-select md-form" searchable="Search here..">
  <option value="" disabled selected>Choose Department</option>
  <option value="1">USA</option>
  <option value="2">Germany</option>
  <option value="3">France</option>
  <option value="3">Poland</option>
  <option value="3">Japan</option>
</select>
<label class="mdb-main-label">Department</label>
    
    
    <select class="mdb-select md-form" searchable="Search here..">
  <option value="" disabled selected>Choose Organisation</option>
  <option value="1">USA</option>
  <option value="2">Germany</option>
  <option value="3">France</option>
  <option value="3">Poland</option>
  <option value="3">Japan</option>
</select>
<label class="mdb-main-label">Organisation</label>
    
    
    
    <select class="mdb-select md-form" searchable="Search here..">
  <option value="" disabled selected>Choose Line Manager</option>
  <option value="1">USA</option>
  <option value="2">Germany</option>
  <option value="3">France</option>
  <option value="3">Poland</option>
  <option value="3">Japan</option>
</select>
<label class="mdb-main-label">Line Manager</label>
    

<div id="date-picker-example" class="md-form md-outline input-with-post-icon Newdatepicker datepicker">
  <input placeholder="Select date" type="text" id="example" class="form-control">
  <label for="example">Start Date</label>
  <i class="fas fa-calendar input-prefix" tabindex=0></i>
</div>

<div class="mdb-form">

 <input type="text" aria-label="Holiday" id="holiday" class="form-control" placeholder="Holiday">

</div>

<script>

    $(document).ready(function(){
    
    $('.datepicker').on('change',function(){
      var week = moment($(this).find('.picker__input').val()).isoWeek()
      var weeksleft = 52-week;
      var holidays = weeksleft / 2;
        if(holidays >25){
            holidays = 25
        }
        $('#holiday').val(holidays)
    })
    
    
        
    })
</script>

@stop


@section('title')
Internal Employee ICT Setup Request
@stop




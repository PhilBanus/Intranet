@extends('table')

@section('tabletheme')

table-light table-borderless

@stop

@section('tableName')

ICT Projects

@stop

@section('headers')
<tr>
      <th>Project Name
      </th>
      <th>Start Date
      </th>
      <th>Description
      </th>
   
      <th>Contact
	  </th>
    </tr>

@stop

@section('rows')


<?php 

$Projects = DB::table('UKHT_ICT_Projects')->select('UKHT_ICT_Projects.*','Contact.Forename','Contact.Surname','UKHT_ICT_Projects_Status.Name as StatusName','UKHT_ICT_Projects_Status.Color')
				->join('Contact','Contact.Contact_ID','=','UKHT_ICT_Projects.Last_Update_Contact')
				->join('UKHT_ICT_Projects_Status','UKHT_ICT_Projects_Status.ID','=','UKHT_ICT_Projects.Status_ID')
				
				->get();

foreach ($Projects as $Project){
	?>

 <tr class="border-0 text-dark w-100 " id="Project{{$Project->ID}}" >
      <td> <a href="projectExtendedView?id={{$Project->ID}}"><?php echo $Project->Name ?></a> </td>
      <td><?php echo $Project->Start_Date ?></td>
      <td><?php echo $Project->Description ?></td>
      <td><?php echo $Project->Forename.' '.$Project->Surname ?> </td>
     
      
    </tr>

<script>

$('#Project{{$Project->ID}}').css({


background: "{{$Project->Color}}", 
backgroundImage: " -webkit-gradient(linear,right top,left bottom,color-stop(0.1, #ffffff),color-stop(0.8, {{$Project->Color}})",
backgroundImage: " -o-linear-gradient(left bottom, #ffffff 10%, {{$Project->Color}} 80%)",
backgroundImage: "-moz-linear-gradient(left bottom, #ffffff 10%, {{$Project->Color}} 80%)",
backgroundImage: " -webkit-linear-gradient(left bottom, #ffffff 10%, {{$Project->Color}} 80%)",
backgroundImage: "-ms-linear-gradient(left bottom, #ffffff 10%, {{$Project->Color}} 80%)",
backgroundImage: "linear-gradient(to left bottom, #ffffff 10%, {{$Project->Color}} 80%)",
	backgroundRepeat: "no-repeat",
	backgroundAttachment: "fixed"


})


</script>

<?php } ?>


@stop


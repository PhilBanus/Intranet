@extends('table')

@section('headers')
<tr>
      <th>Serial Number
      </th>
      <th>Make and Model
      </th>
      <th>Current User
      </th>
	  <th>Current Location
      </th>
	  <th>Product Code
      </th>
	  <th>Year
      </th>
   
      <th>Last Seen
	  </th>
    </tr>

@stop

@section('rows')

@include('humantimer')

<?php 

$logins = DB::table('UKHT_Monitors')->get();

foreach ($logins as $login){
	?>

 <tr>
      <td><?php echo $login->Serial_Number ?></td>
      <td><?php echo $login->Make_Model ?></td>
      <td><?php echo $login->User ?></td>
      <td><?php echo $login->Location ?></td>
      <td><?php echo $login->Product_Code ?></td>
      <td><?php echo $login->Year ?></td>
      <td><?php echo $login->Last_Seen ?></td>

     
     
    </tr>

<?php } ?>
 



@stop


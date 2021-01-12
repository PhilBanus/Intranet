@extends('table')


@section('headers')
<tr>
      <th>Computer
      </th>
      <th>User
      </th>
      <th>Model
      </th>
   
      <th>Windows Version
	  </th>
    </tr>


@overwrite
@section('rows')



<?php 

$logins = DB::table('UKHT_Asset')->get();

foreach ($logins as $login){
	?>

 <tr>
      <td><?php echo $login->Computer_Name ?></td>
      <td><?php echo $login->User_Name ?></td>
      <td><?php echo $login->Model ?></td>
      <td><?php echo $login->Windows_Version ?></td>
     
      
      
    </tr>

<?php } ?>
 



@overwrite


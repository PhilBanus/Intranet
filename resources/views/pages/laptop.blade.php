@extends('table')

@section('headers')
<tr>
      <th>Computer
      </th>
      <th>User
      </th>
      <th>Login
      </th>
   
      <th>Logged In Time
	  </th>
    </tr>

@stop

@section('rows')

@include('humantimer')

<?php 

$logins = DB::table('UKHT_Laptop_Login')->join('UKHT_Asset','UKHT_Laptop_Login.Serial_Number','=','UKHT_Asset.Serial_Number')->whereDate('UKHT_Laptop_Login.Inital_Login', '=', date('Y-m-d'))->select('UKHT_Laptop_Login.*','UKHT_Asset.Computer_Name')->get();

foreach ($logins as $login){
	?>

 <tr>
      <td><?php echo $login->Computer_Name ?></td>
      <td><?php echo $login->Logged_In_User ?></td>
      <td><?php echo $login->Inital_Login ?></td>
     
      <td><?php if($login->Last_Pooled_Login > $login->Shutdown_Time){ echo humanTiming( $login->Inital_Login,$login->Last_Pooled_Login); }else{ echo humanTiming( $login->Inital_Login,$login->Shutdown_Time) ; } ?></td>
      
    </tr>

<?php } ?>
 



@stop


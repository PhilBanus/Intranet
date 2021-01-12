@extends('table')

<?php 
use GuzzleHttp\Client;

$MobilePhones = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'https://mdm.vodafone.co.uk/api/mdm/devices/',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);


$response = $MobilePhones->request('GET', 'search', [
	'verify' => false,
	'auth' => ['api', 'Pan2er622'],
	'headers' => [
		'aw-tenant-code' => '3wjgMqqfs6ksq8LY3cl1PiotIqh13JPxZjnzYFG7AxQ='
	]
]);




$code = $response->getStatusCode(); // 200
$reason = $response->getReasonPhrase(); // OK


// Check if a header exists.
if ($response->hasHeader('Content-Length')) {

	

	
	$body = (string) $response->getBody();
	$xml = simplexml_load_string($body); 
	$json = json_encode($xml);

$array = json_decode($json,TRUE);
// Implicitly cast the body to a string and echo it

// print_r($array['Devices']);
	
	
}




?>
@section('headers')

<tr>
      <th>Compliance
      </th>
      <th>User
      </th>
      <th>Type
      </th>
	  <th>OS
      </th>
	  <th>OS Version
      </th>
   
      <th>Last Seen
	  </th>
    </tr>

@stop

@section('rows')

@include('humantimer')

<?php 


foreach ($array['Devices'] as $Mobile){
	
	if($Mobile['EnrollmentStatus'] === "Enrolled"){
	?>

 <tr>
      <td><?php echo $Mobile['ComplianceStatus'] ?></td>
      <td><?php echo $Mobile['DeviceFriendlyName'] ?></td>
      <td><?php echo $Mobile['Model'] ?></td>
      <td><?php echo $Mobile['Platform'] ?></td>
      <td><?php echo $Mobile['OperatingSystem'] ?></td>
      <td><?php echo $Mobile['LastSeen'] ?></td>
    
      
    </tr>

<?php }} ?>
 



@stop


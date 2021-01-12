<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use DB;
use Carbon\Carbon;


class FieldViewApi extends Controller
{
    //
	
	
	public function GetBusinessUnits(){
	
		$client = new Client();
$res = $client->request('POST', 'https://www.priority1.uk.net/FieldViewWebServices/WebServices/JSON/API_ConfigurationServices.asmx', [

	'verify' => false,
	'body' => '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><GetBusinessUnits xmlns="https://localhost.priority1.uk.net/Priority1WebServices/JSON"><apiToken>'.config('fieldview.Token').'</apiToken><startRow>1</startRow><pageSize>100</pageSize></GetBusinessUnits></soap:Body></soap:Envelope>',
	'headers' => [
		'Host' => 'www.priority1.uk.net',
  		'Content-Type' => 'text/xml; charset=utf-8',
		'SOAPAction' => 'https://localhost.priority1.uk.net/Priority1WebServices/JSON/GetBusinessUnits'
],
	'allow_redirects' => true,
	
]);

		$xml = simplexml_load_string($res->getBody());
	
print_r($xml->__toString());
		$body = strip_tags(str_replace('<?xml version="1.0" encoding="utf-8"?>','',$res->getBody()));

			echo "<Br><Br>";
$Obj = json_decode($body);
		
		foreach($Obj->BusinessUnitInformation as $BU){
			echo $BU->BusinessUnitID;
		};

		
	}
	
	
	public function GetFormPDF(Request $request){
	
		$ID=$request->ID;
		$client = new Client();
$res = $client->request('POST', 'https://www.priority1.uk.net/FieldViewWebServices/WebServices/JSON/API_FormsServices.asmx', [

	'verify' => false,
	'body' => '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><GetFormPdf xmlns="https://localhost.priority1.uk.net/Priority1WebServices/JSON"><apiToken>'.config('fieldview.Token').'</apiToken><formId>'.$ID.'</formId>
	<showActions>1</showActions>
      <showAnsweredBy>1</showAnsweredBy>
      <showAttachedComments>1</showAttachedComments>
      <showAttachedDocuments>1</showAttachedDocuments>
      <showAttachedImages>1</showAttachedImages>
      <showStatusAuditTrail>1</showStatusAuditTrail>
	  </GetFormPdf></soap:Body></soap:Envelope>',
	'headers' => [
		'Host' => 'www.priority1.uk.net',
  		'Content-Type' => 'text/xml; charset=utf-8',
		'SOAPAction' => 'https://localhost.priority1.uk.net/Priority1WebServices/JSON/GetFormPdf'
],
	'allow_redirects' => true,
	
]);

		$xml = simplexml_load_string($res->getBody());
	

		$body = strip_tags(str_replace('<?xml version="1.0" encoding="utf-8"?>','',$res->getBody()));

	
	
		$Obj = json_decode($body);
		
		
		
		return response()->make(base64_decode($Obj->FilePayload), 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="'.$ID.'.pdf"'
]);
		

		
	}
	
	
	public function GetFormData(Request $request){
	
		$ID=$request->ID;
		$client = new Client();
$res = $client->request('POST', 'https://www.priority1.uk.net/FieldViewWebServices/WebServices/JSON/API_FormsServices.asmx', [

	'verify' => false,
	'body' => '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><GetForm xmlns="https://localhost.priority1.uk.net/Priority1WebServices/JSON"><apiToken>'.config('fieldview.Token').'</apiToken><formId>'.$ID.'</formId></GetForm></soap:Body></soap:Envelope>',
	'headers' => [
		'Host' => 'www.priority1.uk.net',
  		'Content-Type' => 'text/xml; charset=utf-8',
		'SOAPAction' => 'https://localhost.priority1.uk.net/Priority1WebServices/JSON/GetForm'
],
	'allow_redirects' => true,
	
]);

		$xml = simplexml_load_string($res->getBody());
	

		$body = strip_tags(str_replace('<?xml version="1.0" encoding="utf-8"?>','',$res->getBody()));

			echo "<Br><Br>";
$Obj = json_decode($body);

		
		foreach($Obj->FormInformation as $Form){
			foreach($Form as $key => $value){
				echo "$key: $value <br>";
			}
			echo "<br>";
		};

		
	}
	
	public function GetProjectsForms(Request $request){
	
		
		$ID = $request->ID;
		$StartDate = Carbon::parse($request->Date)->toDateString();
		$now = Carbon::now()->toDateString();
		
		echo $StartDate;
		echo "<Br>";
		
			if($StartDate > $now){
				echo "End";
			}else{
		
		if($StartDate > $now){
			
			$endDate = Carbon::now()->addDays(1)->toDateString();
			$StartDate = $StartDate;
		}else{
			
			$endDate = Carbon::create($request->Date)->addMonths(3)->toDateString();
			$StartDate = $StartDate;
		}
		
		

		
		
		$client = new Client();
$res = $client->request('POST', 'https://www.priority1.uk.net/FieldViewWebServices/WebServices/JSON/API_FormsServices.asmx', [

	'verify' => false,
	'body' => '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetProjectFormsList xmlns="https://localhost.priority1.uk.net/Priority1WebServices/JSON"><apiToken>'.config('fieldview.Token').'</apiToken><projectId>'.$ID.'</projectId> 
	<lastmodifiedDateFrom>'.$StartDate.'</lastmodifiedDateFrom>
      <lastmodifiedDateTo>'.$endDate.'</lastmodifiedDateTo>
	  </GetProjectFormsList>
  </soap:Body>
</soap:Envelope>',
	'headers' => [
		'Host' => 'www.priority1.uk.net',
  		'Content-Type' => 'text/xml; charset=utf-8',
		'SOAPAction' => 'https://localhost.priority1.uk.net/Priority1WebServices/JSON/GetProjectFormsList'
],
	'allow_redirects' => true,
	
]);

		$xml = simplexml_load_string($res->getBody());
	
print_r($xml->__toString());
		$body = strip_tags(str_replace('<?xml version="1.0" encoding="utf-8"?>','',$res->getBody()));

			echo "<Br><Br>";
$Obj = json_decode($body);
		
			
		foreach($Obj->ProjectFormsListInformation as $ProjForms){
			$update = ['Project_ID' => $ID, 'FormID' => $ProjForms->FormID];
			$data = [
			'FormTemplateLinkID' => $ProjForms->FormTemplateLinkID ,
      'Deleted' => $ProjForms->Deleted ,
      'FormType' => $ProjForms->FormType ,
      'FormName' => $ProjForms->FormName ,
      'FormTitle' => $ProjForms->FormTitle ,
      'CreatedDate' => $ProjForms->CreatedDate ,
      'OwnedBy' => $ProjForms->OwnedBy ,
      'OwnedByOrganisation' => $ProjForms->OwnedByOrganisation ,
      'IssuedToOrganisation' => $ProjForms->IssuedToOrganisation ,
      'Status' => $ProjForms->Status ,
      'StatusColour' => $ProjForms->StatusColour ,
      'StatusDate' => $ProjForms->StatusDate ,
      'Location' => $ProjForms->Location ,
      'OpenTasks' => $ProjForms->OpenTasks ,
      'ClosedTasks' => $ProjForms->ClosedTasks ,
      'FormExpiryDate' => $ProjForms->FormExpiryDate ,
      'OverDue' => $ProjForms->OverDue ,
      'Complete' => $ProjForms->Complete ,
      'Closed' => $ProjForms->Closed ,
      'ParentFormID' => $ProjForms->ParentFormID ,
      'LastModified' => $ProjForms->LastModified ,
      'LastModifiedOnServer' => $ProjForms->LastModifiedOnServer ,
      'ClosedBy' => $ProjForms->ClosedBy ,
      'FormTemplateID' => $ProjForms->FormTemplateID ,
      'ParentProcessTaskID' => $ProjForms->ParentProcessTaskID
			];
		
			DB::table('UKHT_FieldView_Project_Forms')->updateOrInsert($update,$data);
			
		}

		$newRequest = new Request(); 
		$newRequest->request->add(['ID' => $ID, 'Date' => $endDate]);
	

		 return redirect("/api/FieldViewProjectsForms?ID=$ID&Date=$endDate");
		
	}
		
	}
	
	
	public function GetProjectsFormsProj($ID, $Date){
	
		
		$ID = $ID;
		$StartDate = Carbon::now()->subMonths(3)->toDateString();
		$now = Carbon::now()->toDateString();
		

		
			if($StartDate > $now){
				echo "End -";
				echo $ID;
			}else{
		
		if($StartDate > $now){
			
			$endDate = Carbon::now()->addDays(1)->toDateString();
			$StartDate = $StartDate;
		}else{
			
			$endDate = Carbon::create($Date)->addMonths(3)->toDateString();
			$StartDate = $StartDate;
		}
		
		

		
		
		$client = new Client();
$res = $client->request('POST', 'https://www.priority1.uk.net/FieldViewWebServices/WebServices/JSON/API_FormsServices.asmx', [

	'verify' => false,
	'body' => '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetProjectFormsList xmlns="https://localhost.priority1.uk.net/Priority1WebServices/JSON"><apiToken>'.config('fieldview.Token').'</apiToken><projectId>'.$ID.'</projectId> 
	<lastmodifiedDateFrom>'.$StartDate.'</lastmodifiedDateFrom>
      <lastmodifiedDateTo>'.$endDate.'</lastmodifiedDateTo>
	  </GetProjectFormsList>
  </soap:Body>
</soap:Envelope>',
	'headers' => [
		'Host' => 'www.priority1.uk.net',
  		'Content-Type' => 'text/xml; charset=utf-8',
		'SOAPAction' => 'https://localhost.priority1.uk.net/Priority1WebServices/JSON/GetProjectFormsList'
],
	'allow_redirects' => true,
	
]);

		$xml = simplexml_load_string($res->getBody());
	
print_r($xml->__toString());
		$body = strip_tags(str_replace('<?xml version="1.0" encoding="utf-8"?>','',$res->getBody()));

			echo "<Br><Br>";
$Obj = json_decode($body);
		
			
		foreach($Obj->ProjectFormsListInformation as $ProjForms){
			$update = ['Project_ID' => $ID, 'FormID' => $ProjForms->FormID];
			$data = [
			'FormTemplateLinkID' => $ProjForms->FormTemplateLinkID ,
      'Deleted' => $ProjForms->Deleted ,
      'FormType' => $ProjForms->FormType ,
      'FormName' => $ProjForms->FormName ,
      'FormTitle' => $ProjForms->FormTitle ,
      'CreatedDate' => $ProjForms->CreatedDate ,
      'OwnedBy' => $ProjForms->OwnedBy ,
      'OwnedByOrganisation' => $ProjForms->OwnedByOrganisation ,
      'IssuedToOrganisation' => $ProjForms->IssuedToOrganisation ,
      'Status' => $ProjForms->Status ,
      'StatusColour' => $ProjForms->StatusColour ,
      'StatusDate' => $ProjForms->StatusDate ,
      'Location' => $ProjForms->Location ,
      'OpenTasks' => $ProjForms->OpenTasks ,
      'ClosedTasks' => $ProjForms->ClosedTasks ,
      'FormExpiryDate' => $ProjForms->FormExpiryDate ,
      'OverDue' => $ProjForms->OverDue ,
      'Complete' => $ProjForms->Complete ,
      'Closed' => $ProjForms->Closed ,
      'ParentFormID' => $ProjForms->ParentFormID ,
      'LastModified' => $ProjForms->LastModified ,
      'LastModifiedOnServer' => $ProjForms->LastModifiedOnServer ,
      'ClosedBy' => $ProjForms->ClosedBy ,
      'FormTemplateID' => $ProjForms->FormTemplateID ,
      'ParentProcessTaskID' => $ProjForms->ParentProcessTaskID
			];
		
			DB::table('UKHT_FieldView_Project_Forms')->updateOrInsert($update,$data);
			
		}

		$newRequest = new Request(); 
		$newRequest->request->add(['ID' => $ID, 'Date' => $endDate]);
	

				 $this->GetProjectsFormsProj($ID,$endDate);
			
		
	}
		
	}
	
	
	
	public function GetProjects(){
	
		$client = new Client();
$res = $client->request('POST', 'https://www.priority1.uk.net/FieldViewWebServices/WebServices/JSON/API_ConfigurationServices.asmx', [

	'verify' => false,
	'body' => '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><GetProjects xmlns="https://localhost.priority1.uk.net/Priority1WebServices/JSON"><apiToken>'.config('fieldview.Token').'</apiToken><startRow>1</startRow><pageSize>100</pageSize></GetProjects></soap:Body></soap:Envelope>',
	'headers' => [
		'Host' => 'www.priority1.uk.net',
  		'Content-Type' => 'text/xml; charset=utf-8',
		'SOAPAction' => 'https://localhost.priority1.uk.net/Priority1WebServices/JSON/GetProjects'
],
	'allow_redirects' => true,
	
]);

		$xml = simplexml_load_string($res->getBody());
	
print_r($xml->__toString());
		$body = strip_tags(str_replace('<?xml version="1.0" encoding="utf-8"?>','',$res->getBody()));

			echo "<Br><Br>";
$Obj = json_decode($body);
		
		
		foreach($Obj->ProjectInformation as $Proj){
			$update = ['ID' => $Proj->ID];
			$data = ['Name' => $Proj->Name,
      'Reference' => $Proj->Reference,
      'ProjectOwnerID' => $Proj->ProjectOwnerID,
      'ProjectOwner' => $Proj->ProjectOwner,
      'BusinessUnitTypeID' => $Proj->BusinessUnitTypeID,
      'BusinessUnitType' => $Proj->BusinessUnitType,
      'ProjectTypeID' => $Proj->ProjectTypeID,
      'ProjectType' => $Proj->ProjectType,
      'StartDate' => $Proj->StartDate,
      'FinishDate' => $Proj->FinishDate,
      'TimeZoneOffset' => $Proj->TimeZoneOffset,
      'CultureID' => $Proj->CultureID,
      'Culture' => $Proj->Culture,
      'ResolutionDays' => $Proj->ResolutionDays,
      'Active' => $Proj->Active];
		
			DB::table('UKHT_FieldView_Projects')->updateOrInsert($update,$data);
			
			 $this->GetProjectsFormsProj($Proj->ID,$Proj->StartDate);
			
		};

		
	}
}

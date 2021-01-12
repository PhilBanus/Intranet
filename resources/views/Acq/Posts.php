<?php
use Carbon\Carbon;
if($_POST['Type'] === "Update"){
    
     
    $Code = DB::table('UKHT_Acquisition_Code')->where('Acquisition_ID', $_POST['Enquiry'])->first(); 
    
    if($_POST['Status'] == 13 || $_POST['Status'] == 14 || $_POST['Status'] == 27 ){ $UpdateCode = 1; }else{ };
          if($_POST['Status'] >= 15 && $_POST['Status'] <= 20 ){ $UpdateCode = 2; }else{ };
          if($_POST['Status'] >= 21 && $_POST['Status'] <= 26 ){ $UpdateCode = 3; }else{ };
    
    $NewCodeFinaltemp = "A".$Code->Year."-".$Code->Code."-".$UpdateCode;
    
    DB::table('UKHT_Acquisition')->where('Entity_ID',$_POST['Enquiry'])->update(
    
    [ 
                  
                   'Client_Name' => $_POST['Client'],
                   'Project_Description' => $_POST['Description'],
                   'Form_of_Contract' => $_POST['FormOfContract'],
                   'Contract_Category' => $_POST['ContractCategory'],
                   'Client_Value' => $_POST['ClientValue'],
                   'Competitors' => $_POST['PQQCompetitors'],
                   'Supply_Chain' => $_POST['TenderCompetitors'],
                   'Joint_Venture' => $_POST['JV'],
                   'JV_Partner' => $_POST['JVPartner'],
                   'HT_JV_Share' => $_POST['Share'].'%',
                   'Designer' => $_POST['Designer'],
                   'CRC_Submitted' => $_POST['Approval'],
                   'Win_Bid' => $_POST['Winner'],
                   'Location' => $_POST['Location'],
                   'PQQ_Start' => $_POST['PQQ_Start'],
                   'PQQ_Start_Date' => carbon::create($_POST['PQQ_Start']),
                   'PQQ_Submit' => $_POST['PQQ_Submit'],
                   'PQQ_Submit_Date' => carbon::create($_POST['PQQ_Submit']),
                   'Tender_Start' => $_POST['Tender_Start'],
                   'Tender_Start_Date' => carbon::create($_POST['Tender_Start']),
                   'Tender_Submit' => $_POST['Tender_Submit'],
                   'Tender_Submit_Date' => carbon::create($_POST['Tender_Submit']),
                   'Contract_Award' => $_POST['Contract_Award'],
                   'Contract_Award_Date' => carbon::create($_POST['Contract_Award']),
                   'Contract_Start' => $_POST['Contract_Start'],
                   'Contract_Start_Date' => carbon::create($_POST['Contract_Start']),
                   'Contract_End' => $_POST['Contract_End'],
                   'Contract_Ending_Date' => carbon::create($_POST['Contract_End']),
                    'No_Bid' => $_POST['NoBid'],
                    'PQQ_Deadline_Time' => $_POST['PQQ_Sub_Time'],
                    'Tender_Query_Deadline_Time' => $_POST['Tender_Query_Time'],
                    'Tender_Submission_Deadline_Time' => $_POST['Tender_Sub_Time'],
                    'Last_Update_Contact' => session('MY_ID'),
                    'Last_Update' => carbon::now()
        
        ]
        );
	
	DB::table('UKHT_Acquistion_Procurement_Confidence')->updateOrInsert(
	[ 'Entity' => $_POST['Enquiry'], 'Class' => $_POST['Class']],
	[ 'Confidence' => $_POST['Confidence']]);
    
    DB::table('Enquiry')->where('Enquiry_ID',$_POST['Enquiry'])->update([
        'Enquiry_Status_ID'=>$_POST['Status'],
        'Name'=>$_POST['Title'],
        'Enquiry_Code'=>$NewCodeFinaltemp
    ]);
    
	DB::table('UKHT_Acquisition_Dates_Notes')->updateOrInsert(['id' => $_POST['Enquiry']],['note' => $_POST['DateNote']]);
        
}


if($_POST['Type'] === "New"){
    
     if($_POST['Status'] == 13 || $_POST['Status'] == 14 || $_POST['Status'] == 27 ){ $UpdateCode = 1; }else{ };
          if($_POST['Status'] >= 15 && $_POST['Status'] <= 20 ){ $UpdateCode = 2; }else{ };
          if($_POST['Status'] >= 21 && $_POST['Status'] <= 26 ){ $UpdateCode = 3; }else{ };
    
    $NewCodeFinaltemp = "A".$_POST['Year']."-".$_POST['Code']."-".$UpdateCode;
    
    
       $ID = DB::table('Enquiry')->orderBy('Enquiry_ID','desc')->first()->Enquiry_ID + 1;
           
           DB::table('Enquiry')->insert([
               'Enquiry_ID' => $ID,
        'Enquiry_Status_ID'=>$_POST['Status'],
        'Name'=>$_POST['Title'],
        'Enquiry_Code'=>$NewCodeFinaltemp,
               'Created_Date' => carbon::now(),
               'last_update_user' => session('MY_ID'),
               'Region_ID' => 1,
               'Enquiry_Source_ID' => 1
    ]);
    
    
    
    
    DB::table('UKHT_Acquisition_Code')->insert(
    [
        'Acquisition_ID' => $ID,
        'Code' => $_POST['Code'],
        'Year' => $_POST['Year'],
        'Full_Code' => $NewCodeFinaltemp
    ]);
 
    DB::table('UKHT_Acquisition')->insert(
    
    [ 
                   'Entity_ID' => $ID,
                   'Client_Name' => $_POST['Client'],
                   'Project_Description' => $_POST['Description'],
                   'Form_of_Contract' => $_POST['FormOfContract'],
                   'Contract_Category' => $_POST['ContractCategory'],
                   'Client_Value' => $_POST['ClientValue'],
                   'Competitors' => $_POST['PQQCompetitors'],
                   'Supply_Chain' => $_POST['TenderCompetitors'],
                   'Joint_Venture' => $_POST['JV'],
                   'JV_Partner' => $_POST['JVPartner'],
                   'HT_JV_Share' => $_POST['Share'].'%',
                   'Designer' => $_POST['Designer'],
                   'CRC_Submitted' => $_POST['Approval'],
                   'Win_Bid' => $_POST['Winner'],
                   'Location' => $_POST['Location'],
                   'PQQ_Start' => $_POST['PQQ_Start'],
                   'PQQ_Start_Date' => carbon::create($_POST['PQQ_Start']),
                   'PQQ_Submit' => $_POST['PQQ_Submit'],
                   'PQQ_Submit_Date' => carbon::create($_POST['PQQ_Submit']),
                   'Tender_Start' => $_POST['Tender_Start'],
                   'Tender_Start_Date' => carbon::create($_POST['Tender_Start']),
                   'Tender_Submit' => $_POST['Tender_Submit'],
                   'Tender_Submit_Date' => carbon::create($_POST['Tender_Submit']),
                   'Contract_Award' => $_POST['Contract_Award'],
                   'Contract_Award_Date' => carbon::create($_POST['Contract_Award']),
                   'Contract_Start' => $_POST['Contract_Start'],
                   'Contract_Start_Date' => carbon::create($_POST['Contract_Start']),
                   'Contract_End' => $_POST['Contract_End'],
                   'Contract_Ending_Date' => carbon::create($_POST['Contract_End']),
                    'No_Bid' => $_POST['NoBid'],
                    'Last_Update_Contact' => session('MY_ID'),
                    'Last_Update' => carbon::now()
        
        ]
        );
    

       echo $ID; 
        
}
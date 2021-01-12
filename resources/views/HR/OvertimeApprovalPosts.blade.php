<?php 

use Carbon\Carbon;

$Now = Carbon::now();

if($_POST['Type'] === 'HR_Approval'){
    
    
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['HR_Approved' => true, 'HR_Approver' => $HR, 'HR_Approved_Date' => "$Now"]);
    
}
if($_POST['Type'] === 'LN_Approval'){
    
    
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['Line_Approved' => true, 'LineManager' => $HR, 'Line_Approved_Date' => "$Now"]);
   
    
    if(db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->first()->Contact == $HR){
        
         db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['PM_Approved' => true, 'PM' => $HR, 'PM_Approved_Date' => "$Now"]);
    
    } 
    
    if(db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->first()->PM == $HR){
        
         db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['PM_Approved' => true, 'PM' => $HR, 'PM_Approved_Date' => "$Now"]);
    
    }
    
}
if($_POST['Type'] === 'PM_Approval'){
    
    
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['PM_Approved' => true, 'PM' => $HR, 'PM_Approved_Date' => "$Now"]);
    
}
if($_POST['Type'] === 'HR_Paid'){
    
    
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['HR_Paid' => true]);
    
}
if($_POST['Type'] === 'HR_Reject'){
    
    $Reject = $_POST['Reject'];
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['HR_Approved' => false, 'HR_Approver' => $HR, 'HR_Approved_Date' => "$Now", 'Reject_Reason' => $Reject, 'Removed' => 1]);
    
}

if($_POST['Type'] === 'LN_Reject'){
    
    $Reject = $_POST['Reject'];
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['Line_Approved' => false, 'LineManager' => $HR, 'Line_Approved_Date' => "$Now", 'Reject_Reason' => $Reject, 'Removed' => 1]);
    
}


if($_POST['Type'] === 'PM_Reject'){
    
    $Reject = $_POST['Reject'];
    $ID = $_POST['id']; 
    $HR = $_POST['HR'];
    
    db::table('UKHT_Overtime_Items')->where('Global_ID',$ID)->update(['PM_Approved' => false, 'PM' => $HR, 'PM_Approved_Date' => "$Now", 'Reject_Reason' => $Reject, 'Removed' => 1]);
    
}
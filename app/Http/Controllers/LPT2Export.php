<?php
namespace App\Http\Controllers;
use App\Exports\LPT2TimeUser;
use App\Exports\LPT2Time;
use App\Exports\LPT2Summary;
use Maatwebsite\Excel\Facades\Excel;
use dompdf\dompdf;

class LPT2Export extends Controller
{
  
	 public function export() 
    {
		 ob_end_clean(); // this
		 ob_start(); // and this
		 return Excel::download(new LPT2TimeUser, 'Timesheet_'.$_GET['Name'].'.xlsx');
		 exit();
	 }
	
	 public function exportBulk() 
    {
		 ob_end_clean(); // this
		 ob_start(); // and this
		 return (new LPT2Time)->download('LPT2_Timesheets_'.$_GET['Date'].'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
		 exit();
	 }
	
	public function summary() 
    {
		 ob_end_clean(); // this
		 ob_start(); // and this
		 return (new LPT2Summary)->download('LPT2_Timesheets_Summary.xlsx', \Maatwebsite\Excel\Excel::XLSX);
		 exit();
	 }
}
?>
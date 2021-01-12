<?php
namespace App\Http\Controllers;
use App\Exports\AcquisitionCostTracker;
use Maatwebsite\Excel\Facades\Excel;
use dompdf\dompdf;
use Carbon\Carbon;

class ACQExports extends Controller
{
  

	
	public function export() 
    {
		 ob_end_clean(); // this
		 ob_start(); // and this
		 return (new AcquisitionCostTracker)->download('Cost_Tracker_' . date('d-m-Y') . '_' . time() . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
		 //Excel::download(view("Acq.Time.exceldash"), 'Cost_Tracker_' . date('d-m-Y') . '_' . time() . '.xlsx');
		 exit();
	 }
}
?>
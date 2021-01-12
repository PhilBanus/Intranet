<?php
namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Request;

class LPT2Time implements WithMultipleSheets
{
	
	use Exportable;


	
	/**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
		
		 $Users = DB::table('Timesheet_Item')->select('Timesheet.Contact_ID','Timesheet.Timesheet_ID','Forename','Surname','Organisation.Name as Company')->where(['Entity_Identifier'=> request('ID'), 'Entity_Class_ID' => 3, 'Period_Ending_Date' => $_GET['Date'] ])
			 ->join("Timesheet","Timesheet.Timesheet_ID","Timesheet_Item.Timesheet_ID")
			 ->join('Contact','Contact.Contact_ID','Timesheet.Contact_ID')
			 ->join('Organisation','Contact.Organisation_ID','Organisation.Organisation_ID')
			 ->join('Timesheet_Period','Timesheet.Timesheet_Period_ID', 'Timesheet_Period.Timesheet_Period_ID')
			 ->distinct('Timesheet.Contact_ID')
			 ->orderby('Forename', 'asc')
			 ->orderby('Surname','asc')->get();

        foreach ($Users as $User) {
            $sheets[] = new LPT2TimeUserBulk($User->Timesheet_ID, $User->Contact_ID, $User->Forename.' '.$User->Surname, base64_encode($User->Company),request('ID'));
        }

        return $sheets;
    }
}
?>
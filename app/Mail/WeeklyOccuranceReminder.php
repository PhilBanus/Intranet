<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests;
use DB;

class WeeklyOccuranceReminder extends Mailable
{
    use Queueable, SerializesModels;
public $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
		$this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$ID = $this->request->ID;
	$INS = $this->request->INS;
	$ALL = $this->request->ALL;
	$REM = $this->request->REM;
	$DEAD = $this->request->DEAD;

	$Occurance = DB::table('UKHT_Occurance_Close_Call')->where('ID', $ID)->first(); 
	
    $OccuranceName = DB::table('UKHT_Occurance')->where('ID',$Occurance->Occurance)->first();

	if($Occurance->Site == 0){
		$SiteName = "Head Office";
	}else{
		$site = DB::table('Project')->where('Project_ID',$Occurance->Site)->first();
		$SiteName = $site->Name;
	}
		
		if($Occurance->Risk_Prevented == 1){
				$atRisk = "Risk Prevented";
			}else{
				$atRisk = "At Risk";
			}
	
		
        return $this
			->from('hsqe@hochtief.co.uk')
			->subject($SiteName.' - '.$OccuranceName->Name.' - '.$Occurance->Category.' ('.$atRisk.') ')
			->markdown('emails.occurance.WeeklyOccuranceReminder');
    }
}

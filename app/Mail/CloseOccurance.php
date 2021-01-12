<?php

namespace App\Mail;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests;
use DB;

class CloseOccurance extends Mailable
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

		
	

	$Occurance = DB::table('UKHT_Occurance_Close_Call')->where('ID', $ID)->first(); 
	
    $OccuranceName = DB::table('UKHT_Occurance')->where('ID',$Occurance->Occurance)->first();

	if($Occurance->Site == 0){
		$SiteName = "Head Office";
	}else{
		$site = DB::table('Project')->where('Project_ID',$Occurance->Site)->first();
		$SiteName = $site->Name;
	}
		
	
		
        return $this
			->from('hsqe@hochtief.co.uk')
			->subject($SiteName.' - '.$OccuranceName->Name.' - Closed ')
			->markdown('emails.occurance.close');
    }
}

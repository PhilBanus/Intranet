<?php
namespace App\Console\Commands;
use DB;
use Mail;
use Illuminate\Console\Command;
use App\Mail\WeeklyOccuranceReminder;
use App\Mail\ActionOccurance;
use App\Mail\UpdateOccuranceLogger;
use App\Mail\CloseOccurance;
use Carbon\Carbon;


date_default_timezone_set('Etc/UTC');

class SendWeeklyCloseCalls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Weekly_CloseCall:send';
    protected $name = 'Weekly_CloseCall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Weekly Occurances allocation notifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		
		$Occurances = DB::table('UKHT_Occurance_Close_Call')->where('Sign_Off', 0)->whereNotNull('HSQE_Actioner')->where('ReAllocated', 1)->where('Reminder_Rate',2)->get(); 
		$array = "";
		foreach($Occurances as $Occurance){
	
			
		$ID = $Occurance->ID;
	$INS = $Occurance->HSQE_Instruction;
	$ALL = $Occurance->HSQE_Actioner;
	$REM = $Occurance->Reminder_Rate;
	$DEAD = $Occurance->DeadLine;
		
		$request = new \Illuminate\Http\Request();
	$request->ID = $ID;
	$request->INS = $INS;
	$request->ALL = $ALL;
	$request->REM = $REM;
	$request->DEAD = $DEAD;
			
		$Members = DB::table('Contact_Email')->where('Contact_ID',$ALL)->first();
		
		$array .= $Occurance->ID;
		
		Mail::to($Members->Email)->send(new WeeklyOccuranceReminder($request));
			
		
			
			
		}
		
		$this->info("Weekly Close Call Notification run - ".Carbon::now()->toDayDateTimeString()." /n Calls Run: ".$array);
		
		
        //
    }
}

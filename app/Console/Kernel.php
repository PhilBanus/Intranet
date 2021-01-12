<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
		'App\Console\Commands\SendDailyCloseCalls',
		'App\Console\Commands\SendWeeklyCloseCalls'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('Daily_CloseCall:send')->daily()
			 ->appendOutputTo('E:\DeltekPIM\XWeb\ICT_Portal\test.txt');   
		
		$schedule->command('Weekly_CloseCall:send')->weekly()
			 ->appendOutputTo('E:\DeltekPIM\XWeb\ICT_Portal\test.txt');
                 
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

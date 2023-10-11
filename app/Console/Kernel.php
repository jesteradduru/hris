<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Rats\Zkteco\Lib\ZKTeco;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

    
    protected function schedule(Schedule $schedule): void
    {

        $schedule->call(function() {

            $zk = new ZKTeco('192.168.222.4', 4370);
            
            $zk->connect();
    
            $dtrs = $zk->getAttendance();


            $latestRecord = DB::table('daily_time_record')->max('date_time');
            
            foreach($dtrs as $dtr){
                $dtr_timestamp = Carbon::parse($dtr['timestamp']);

                if($latestRecord){
                    if($dtr_timestamp->greaterThan(Carbon::parse($latestRecord))){
                        DB::table('daily_time_record')->insert([
                            'user_id' => $dtr['id'],
                            'date_time' => $dtr['timestamp'],
                        ]);
                    }
                }else{
                    DB::table('daily_time_record')->insert([
                        'user_id' => $dtr['id'],
                        'date_time' => $dtr['timestamp'],
                    ]);
                }
            }
    
            $zk->disconnect();
        })
        // ->cron('0-59/15 7-10,12-13,17-20 * * 1-5');
        ->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

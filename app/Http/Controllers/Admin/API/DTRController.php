<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use App\Models\DailyTimeRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DTRController extends Controller
{
    public function get_dtr_log(Request $request){
        $dtr_id = $request->dtr_id;
        $dtr = DailyTimeRecord::getDtrToday($dtr_id);
    
        $inAM=  self::formatTime($dtr['inAM']);
        $outAM=  self::formatTime($dtr['outAM']);
        $inPM= self::formatTime($dtr['inPM']);
        $outPM=  self::formatTime($dtr['outPM']); 

        return "\nAM\nTime-in: {$inAM}\nTime-out: {$outAM}\nPM\nTime-in: {$inPM}\nTime-out: {$outPM}\n";
    }

    private static function formatTime($time){
        $timeFormatted = "-";

        if($time){
            $log=Carbon::parse($time);
            $timeFormatted = $log->format('h:i:00 A');
        }

        return $timeFormatted;
        

    }
}

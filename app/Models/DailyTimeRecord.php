<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class DailyTimeRecord extends Model
{
    use HasFactory;

    protected $table = 'daily_time_record';
    protected $fillable = ['user_id', 'date_time'];

    public function scopeLatestDtr(Builder $query){
        return $query->orderBy('date_time', 'DESC');
    }

    public function user() : HasOne {
        return $this->hasOne(User::class, 'dtr_user_id', 'user_id');
    }

    public function scopeFilter(Builder $query, $filters = []) {
        return $query
        
        ->when( // filter by month
            $filters['month'] ?? false, 
            // fn($query, $value) => $query->whereMonth('date_time', $value)
            fn($query, $value) => $query->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m')"), $value),
            fn($query, $value) => $query->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m')"), date('Y-m'))
        )
        
        ->when( // get sched by id
            $filters['user_id'] ?? false, 
            fn($query, $value) => $query->where('user_id', '=', $value)
        )
        
        ->when( // order date_time descending
            $filters['order'] ?? false, 
            fn($query, $value) => $query->orderBy('date_time', $value),
            fn($query, $value) => $query->orderBy('date_time', "DESC"),
        );
    }

    private static function getTotalHours ($inAM, $outAM, $inPM, $outPM) {
        $totalAM = null;
        $totalPM = null;

        if($inAM && $outAM){
            $logTimeInAm = Carbon::parse($inAM->format('H:i'));
            $logTimeOutAm = Carbon::parse($outAM->format('H:i'));

            $time_in_earlier_7 = $logTimeInAm->lessThan(Carbon::parse('7:00:00'));
            $time_in_pass_7 = $logTimeInAm->greaterThan(Carbon::parse('7:00:00'));
            $time_out_earlier_12 = $logTimeOutAm->lessThan(Carbon::parse('12:00:00'));
            $time_out_pass_12 = $logTimeOutAm->greaterThanOrEqualTo(Carbon::parse('12:00:00'));

            $exact12 = Carbon::parse('12:00');

            if($time_in_earlier_7 && $time_out_earlier_12) {
                $totalAM = $logTimeOutAm->diffInSeconds(Carbon::parse('7:00'));
            }else if($time_in_earlier_7 && $time_out_pass_12){
                $totalAM = $exact12->diffInSeconds(Carbon::parse('7:00'));
            }else if($time_in_pass_7 && $time_out_earlier_12){
                $totalAM = $logTimeOutAm->diffInSeconds($logTimeInAm);
            }else if($time_in_pass_7 && $time_out_pass_12){
                $totalAM = $exact12->diffInSeconds($logTimeInAm);
            }
        }

        if($inPM && $outPM){
            $logTimeInPm = Carbon::parse($inPM->format('H:i'));
            $logTimeOutPm = Carbon::parse($outPM->format('H:i'));

            $time_in_earlier_13 = $logTimeInPm->lessThan(Carbon::parse('13:00:00'));
            $time_in_pass_13 = $logTimeInPm->greaterThan(Carbon::parse('13:00:00'));
            $time_out_earlier_19 = $logTimeOutPm->lessThan(Carbon::parse('19:00:00'));
            $time_out_pass_19 = $logTimeOutPm->greaterThan(Carbon::parse('19:00:00'));
            // $time_out_pass_12 = $logTimeOutPm->greaterThan(Carbon::parse('12:00:00'));

            $exact19 = Carbon::parse('19:00');

            // dd($time_in_earlier_13 && $time_out_earlier_19);

            if($time_in_earlier_13 && $time_out_earlier_19) { // time in before 1 and time out before 7 PM
                $totalPM = $logTimeOutPm->diffInSeconds(Carbon::parse('13:00'));  // 1 PM until out before 7 PM
            }else if($time_in_earlier_13 && $time_out_pass_19 ){
                $totalPM = $exact19->diffInSeconds(Carbon::parse('13:00'));  // 1 PM until out pass 7 PM
            }else if($time_in_pass_13 && $time_out_earlier_19){
                $totalPM = $logTimeOutPm->diffInSeconds($logTimeInPm);
            }else if($time_in_pass_13 && $time_out_pass_19){
                $totalPM = $exact19->diffInSeconds($logTimeInPm);
            }
        }

        $total = null;

        if($totalAM || $totalPM){

            if($totalAM) {
                $total = gmdate('H:i:s', $totalAM);
            }

            if($totalPM){
                $total = gmdate('H:i:s', $totalPM);
            }

            if($totalAM && $totalPM){
                $total = gmdate('H:i:s', $totalAM + $totalPM);
            }
        }

        return [
            'totalAM' => $totalAM,
            'totalPM' => $totalPM,
            'total' => $total
        ];
    }

    private static function identifyInOut($dateTimeRecordToday = []) {
        // initialize time in/out in the morning and afternoon
        $inAM = null;
        $outAM = null;
        $inPM = null;
        $outPM = null;
        
        $logTimeBetween7to11 = array();
        $logTimeBetween11to3 = array();
        $logTimeBetween3onwards = array();

        if(count($dateTimeRecordToday)){
            foreach($dateTimeRecordToday as $dtrRecord){
                $time = Carbon::create($dtrRecord->date_time);
                $logTime = Carbon::parse($time->toTimeString());

                if($logTime->lessThan(Carbon::parse('11:00:00'))){
                    array_push($logTimeBetween7to11, $time);
                }

                if($logTime->greaterThan(Carbon::parse('11:00:00')) && $logTime->lessThan(Carbon::parse('15:00:00'))){
                    array_push($logTimeBetween11to3, $time);
                }

                if($logTime->greaterThan(Carbon::parse('15:00:00'))){
                    array_push($logTimeBetween3onwards, $time);
                }
            }
        }

        $inAM = $logTimeBetween7to11[0] ?? null;
        $outAM = $logTimeBetween11to3[0] ?? null;
        $inPM = $logTimeBetween11to3[1] ?? null;
        $outPM = $logTimeBetween3onwards[0] ?? null;

        return [
            'inAM' => $inAM,
            'outAM' => $outAM,
            'inPM' => $inPM,
            'outPM' => $outPM,
        ];
    }

    public static function getRecordByMonth($user_id, $filter = []){
        if(!count($filter)){
            $filter['month'] = date('Y-m'); //set to current month
        }
        
        $yearMonth = date('Y-m', strtotime($filter['month'])); // 2023-09

        // Get the number of days in the given month
        $daysInMonth = date('t', strtotime($yearMonth . "-01")); // day count

        // Initialize the daily time record array
        $dailyTimeRecord = [];

        // initialize the suggestions
        $suggestions = null;

        // Loop through each day of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {

            $date = $day;

            $dateTimeRecordToday = DB::table('daily_time_record')
            ->select(['date_time'])
            ->where('user_id', '=', $user_id)
            ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%e')"), $yearMonth . '-' . $date)
            ->get();


            // // initialize time in/out in the morning and afternoon
            // $inAM = null;
            // $outAM = null;
            // $inPM = null;
            // $outPM = null;
            
            // $logTimeBetween7to11 = array();
            // $logTimeBetween11to3 = array();
            // $logTimeBetween3onwards = array();

            // if(count($dateTimeRecordToday)){
            //     foreach($dateTimeRecordToday as $dtrRecord){
            //         $time = Carbon::create($dtrRecord->date_time);
            //         $logTime = Carbon::parse($time->toTimeString());

            //         if($logTime->lessThan(Carbon::parse('11:00:00'))){
            //             array_push($logTimeBetween7to11, $time);
            //         }
    
            //         if($logTime->greaterThan(Carbon::parse('11:00:00')) && $logTime->lessThan(Carbon::parse('15:00:00'))){
            //             array_push($logTimeBetween11to3, $time);
            //         }

            //         if($logTime->greaterThan(Carbon::parse('15:00:00'))){
            //             array_push($logTimeBetween3onwards, $time);
            //         }
            //     }
            // }
            $inout = self::identifyInOut($dateTimeRecordToday);    

            $inAM = $inout['inAM'];
            $outAM = $inout['outAM'];
            $inPM = $inout['inPM'];
            $outPM = $inout['outPM'];

            $total = self::getTotalHours($inAM, $outAM, $inPM, $outPM, $yearMonth . '-' . $date);
            

            $dayOfWeek = date('D', strtotime($yearMonth . '-' . $date));
            // Create a daily record for the current day
            $record = [
                'date' => $date,
                'day' => $dayOfWeek,
                'inAM' => $inAM ? $inAM->format('h:i:00 A') : null,  
                'outAM' => $outAM ? $outAM->format('h:i:00 A') : null,
                'inPM' => $inPM ? $inPM->format('h:i:00 A') : null,
                'outPM' => $outPM ? $outPM->format('h:i:00 A') : null,
                'totalHours' => $total['total'],
            ];

            // Add the daily record to the array
            $dailyTimeRecord[] = $record;
        }

        return [
            'dtr' => $dailyTimeRecord,
            'suggestion' => $suggestions
        ];

    }


    public static function getInfo($user_id){
        $date = Carbon::now();
        
        $hours_to_render = ($date->dayOfWeek * 8) * 60 * 60;
        $rendered = 0;
        $timeout = null;

        $dtr_now = null;
        
        //  5 > 1
        //
        if($date->format('d') === '01' && $date->dayOfWeek > $date->format('d') || true){
            // $hours_to_render = (5 - ($date->dayOfWeek - 1)) * 8;
            $days_before_count = $date->dayOfWeek;
            // 1; 1 < 1; 0+1

            for($i = 0; $i < $days_before_count; $i ++){

                $days_before = $date;

                if($i != 0){
                    $days_before = $date->subDay();
                }

                $user_dtr = DB::table('daily_time_record')->select('date_time')
                ->where('user_id', $user_id)
                ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%d')"), $days_before->format('Y-m-d'))
                ->get();

                if($i == 0){
                    $dtr_now = self::identifyInOut($user_dtr);
                }

                $parse_dtr = self::identifyInOut($user_dtr);

                $count_hours = self::getTotalHours($parse_dtr['inAM'], $parse_dtr['outAM'], $parse_dtr['inPM'], $parse_dtr['outPM']);

                if($count_hours['totalAM']){
                    $rendered += $count_hours['totalAM'];
                }
                if($count_hours['totalPM']){
                    $rendered += $count_hours['totalPM'];
                }
            }
        }
        if($dtr_now !== null && $dtr_now['inAM'] && $dtr_now['outPM'] == null){
            $dtr_now_am = $dtr_now['inAM'];
            $inAM = Carbon::parse($dtr_now_am->format('H:i:s'));
    
            if($inAM->lessThan(Carbon::parse('7:00:00'))){
                $inAM = Carbon::parse('7:00:00');
            }else{
                $inAM = $dtr_now_am;
            }
    
            $exact12 = Carbon::parse('12:00');
            
            $hours_to_render_today = null;
    
            if($dtr_now['outAM']){
                $hours_to_render_today = $exact12->diffInSeconds($inAM) + ($hours_to_render - $rendered) + 3600;
            }else{
                $hours_to_render_today = $hours_to_render - $rendered + 3600;
            }

            $timeout = $inAM->addSeconds($hours_to_render_today);

            if($timeout->lessThan(Carbon::parse('16:00'))){
                $timeout = Carbon::parse('4:00 PM');
            }else if($timeout->greaterThan(Carbon::parse('19:00'))){
                $timeout = Carbon::parse('7:00 PM');
            }

    
            return([
                'hours_to_render' => ($hours_to_render / 60) / 60,
                'render' => round(($hours_to_render - $rendered) / 60 / 60),
                'rendered' => round($rendered / 60 / 60),
                'timeout' => $timeout->format('h:i A'),
            ]);
        }


        
    }
}
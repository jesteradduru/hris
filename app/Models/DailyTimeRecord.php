<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;
use Rats\Zkteco\Lib\ZKTeco;


class DailyTimeRecord extends Model
{
    use HasFactory;

    protected $table = 'daily_time_record';
    protected $fillable = ['user_id', 'date_time', 'remark'];
    public $timestamps = false;

    public function scopeLatestDtr(Builder $query){
        return $query->orderBy('date_time', 'DESC');
    }

    public function user() : HasOne {
        return $this->hasOne(User::class, 'dtr_user_id', 'user_id');
    }

    // update dtr
    public static function getDtr(){
        set_time_limit(200);
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


    }

    // filter
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
            function ($query, $value) {
                $query->where('user_id', '=', $value)
                      ->orWhereHas('user', function($query) use ($value) {
                          $query->where('first_name', 'like', "%$value%")
                                ->orWhere('surname', 'like', "%$value%")
                                ->orWhere('middle_name', 'like', "%$value%");
                      });
            }
        )

        ->when( // order date_time descending
            $filters['order'] ?? false,
            fn($query, $value) => $query->orderBy('date_time', $value),
            fn($query, $value) => $query->orderBy('date_time', "DESC"),
        );
    }

    private static function getTotalHours ($inAM, $outAM, $inPM, $outPM, $day = '', $offset = '') {
        $totalAM = null;
        $totalPM = null;
        $lateAM = 0;
        $utAM = 0;
        $latePM = 0;
        $utPM = 0;
        $absent = 0;

        $exact12 = Carbon::parse('12:00');
        $exact7 = Carbon::parse('7:00');
        $exact930 = Carbon::parse('9:30');
        $exact19 = Carbon::parse('19:00');
        $exact4pm = Carbon::parse('16:00');
        $exact1pm = Carbon::parse('13:00');

        if($inAM && $outAM){
            $logTimeInAm = Carbon::parse($inAM->format('H:i'));
            $logTimeOutAm = Carbon::parse($outAM->format('H:i'));


            $time_in_earlier_7 = $logTimeInAm->lessThan(Carbon::parse('7:00:00'));
            $time_in_pass_7 = $logTimeInAm->greaterThan(Carbon::parse('7:00:00')) && $logTimeInAm->lte(Carbon::parse('9:30:00'));
            $time_out_gte_12 = $logTimeOutAm->gte(Carbon::parse('12:00:00'));
            $time_in_late = $logTimeInAm->greaterThan(Carbon::parse('09:30:00')) && $logTimeInAm->lte(Carbon::parse('11:00:00'));
            $early_out = $logTimeOutAm->greaterThan(Carbon::parse('11:00:00')) && $logTimeOutAm->lessThan(Carbon::parse('12:00:00'));



            if($time_in_earlier_7 && $time_out_gte_12) { // maaga sa 7 // saktong out

                $totalAM = $exact12->diffInSeconds($exact7);

            }else if($time_in_earlier_7 && $early_out){ // early time in // early out

                $utAM = $exact12->diffInSeconds($logTimeOutAm);
                $totalAM = $exact12->diffInSeconds($exact7);

            }else if($time_in_late && $time_out_gte_12){ // time in late // gte 12

                $lateAM = $logTimeInAm->diffInSeconds($exact930);
                $totalAM = $exact12->diffInSeconds($exact930);

            }else if($time_in_late && $early_out){ // time in late // early out

                $lateAM = $logTimeInAm->diffInSeconds($exact930);
                $utAM = $exact12->diffInSeconds($logTimeOutAm);
                $totalAM = $exact12->diffInSeconds($exact930);

            }else if($time_in_pass_7 && $early_out || $time_in_pass_7 && $time_out_gte_12){ // saktong time in // early out or  saktong time in // saktong out
                if($time_in_pass_7 && $early_out){
                    $utAM = $exact12->diffInSeconds($logTimeOutAm);
                }

                $totalAM = $exact12->diffInSeconds($logTimeInAm);

            }

        }

        if($inPM && $outPM){
            $logTimeInPm = Carbon::parse($inPM->format('H:i'));
            $logTimeOutPm = Carbon::parse($outPM->format('H:i'));

            $time_in_earlier_13 = $logTimeInPm->lte(Carbon::parse('13:00:00'));
            $time_in_pass_13 = $logTimeInPm->greaterThan(Carbon::parse('13:00:00'));
            $early_out_pm = $logTimeOutPm->lte(Carbon::parse('16:00:00'));
            $time_out_earlier_7pm = $logTimeOutPm->lte(Carbon::parse('19:00:00')) && $logTimeOutPm->gte(Carbon::parse('16:00:00')); // 4pm-7pm
            $time_out_pass_19 = $logTimeOutPm->gte(Carbon::parse('19:00:00')); // 7pm onwards
            // $time_out_pass_12 = $logTimeOutPm->greaterThan(Carbon::parse('12:00:00'));

            if($time_in_earlier_13 && $time_out_earlier_7pm) { // saktong in, saktong out
                $totalPM = $logTimeOutPm->diffInSeconds($exact1pm);
            }else if($time_in_earlier_13 && $early_out_pm ){ // saktong in, early out
                $utPM = $exact1pm->diffInSeconds($logTimeOutPm);
                $totalPM = $exact4pm->diffInSeconds($exact1pm);
            }else if($time_in_earlier_13 && $time_out_pass_19 ){ // saktong in, pass 7 out
                $totalPM = $exact19->diffInSeconds($exact1pm);
            }else if($time_in_pass_13 && $time_out_earlier_7pm){ // late in, saktong out
                $latePM = $logTimeInPm->diffInSeconds($exact1pm);
                $totalPM = $logTimeOutPm->diffInSeconds($exact1pm);
            }else if($time_in_pass_13 && $early_out_pm){ // late in, early out
                $latePM = $logTimeInPm->diffInSeconds($exact1pm);
                $utPM = $exact1pm->diffInSeconds($logTimeOutPm);
                $totalPM = $exact4pm->diffInSeconds($exact1pm);
            }else if($time_in_pass_13 && $time_out_earlier_7pm){ // late in, saktong out
                $latePM = $logTimeInPm->diffInSeconds($exact1pm);
                $totalPM = $logTimeOutPm->diffInSeconds($exact1pm);
            }else if($time_in_pass_13 && $time_out_pass_19 ){ // late in, pass 7 out
                $latePM = $logTimeInPm->diffInSeconds($exact1pm);
                $totalPM = $exact19->diffInSeconds($exact1pm);
            }
        }

        if($day !== 'Sat' && $day !== 'Sun'){
            if(!($inAM && $outAM) && ($inPM && $outPM)){
                $absent = $exact12->diffInSeconds($exact930);
            }else if(!($inPM && $outPM) && ($inAM && $outAM)){
                $absent = $exact4pm->diffInSeconds($exact1pm);
            }else if(!($inAM && $outAM) && !($inPM && $outPM)){
                $absent = 28800;
            }
        }



        $totalRaw = null;
        $totalMinutes = 0;
        $offsetSeconds = 0;

        if($offset){
            $offsetSeconds = $offset * 60 * 60;
        }


        if($totalAM || $totalPM){

            if($totalAM) {
                $totalRaw = $totalAM + $offsetSeconds;
                $totalMinutes =  $totalAM - 28800;
            }

            if($totalPM){
                $totalRaw = $totalPM + $offsetSeconds;
                $totalMinutes =  $totalPM - 28800;
            }

            if($totalAM && $totalPM){
                $totalRaw = $totalAM + $totalPM + $offsetSeconds;
                $totalMinutes = ($totalAM + $totalPM ) - 28800;
            }

        }

        if($absent == 28800){
            $totalMinutes = -28800;
        }
        

        return [
            'absent' => $absent,
            'lateAM' => $lateAM,
            'utAM' => $utAM,
            'latePM' => $latePM,
            'utPM' => $utPM,
            'totalAM' => $totalAM,
            'totalPM' => $totalPM,
            'totalMinutes' => $totalMinutes / 60,
            'totalRaw' => $totalRaw,
            'total' => gmdate('H:i:s', $totalRaw)
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

        // if(count($dateTimeRecordToday))
        // dd($dateTimeRecordToday);

        $remarks = null;

        if(count($dateTimeRecordToday)){
            foreach($dateTimeRecordToday as $dtrRecord){

                $time = Carbon::create($dtrRecord->date_time);
                $logTime = Carbon::parse($time->toTimeString());

                if($logTime->lte(Carbon::parse('11:00:00'))){
                    array_push($logTimeBetween7to11, $time);
                }

                if($logTime->greaterThan(Carbon::parse('11:00:00')) && $logTime->lte(Carbon::parse('15:00:00'))){
                    array_push($logTimeBetween11to3, $time);
                }

                if($logTime->gt(Carbon::parse('15:00:00'))){
                    array_push($logTimeBetween3onwards, $time);
                }


                if(!isset($remarks) && isset($dtrRecord->remark)){
                    $remarks = $dtrRecord->remark;
                }
            }
        }

        $inAM = $logTimeBetween7to11[0] ?? null;
        $outAM = count($logTimeBetween11to3) > 1 ? $logTimeBetween11to3[0]: null;
        $inPM =  null;
        $outPM = $logTimeBetween3onwards[0] ?? null;

        // IN PM LOGIC
        if($inAM && count($logTimeBetween11to3) == 1){
            $outAM = $logTimeBetween11to3[0];
        }
        
        if(!$inAM && count($logTimeBetween11to3) == 1 ){
            $inPM = $logTimeBetween11to3[0];
        }
        
        if(count($logTimeBetween11to3) > 1 ){
            $inPM = $logTimeBetween11to3[1];
        }

        return [
            'inAM' => $inAM,
            'outAM' => $outAM,
            'inPM' => $inPM,
            'outPM' => $outPM,
            'remarks' => $remarks
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

            $user = User::select('id')->where('dtr_user_id', $user_id)->first();
            $date = $day;
            $remarks = '';
            $dayOfWeek = date('D', strtotime($yearMonth . '-' . $date));

            $other_dtr = DB::table('timesheet_entries')->select('*')
                // ->where('employee', $user_id)
                ->where(function($query) use ($user) {
                    $query->where('employee', $user->id)
                          ->orWhere('employee', null);
                })
                ->where(DB::raw("DATE_FORMAT(date, '%Y-%m-%e')"), $yearMonth . '-' . $date)
                ->orWhere(function($query) use ($yearMonth, $date) {
                    $query->where('reg_multiday', '1')
                          ->where(DB::raw("reg_start"), '<=', $yearMonth . '-' . $date)
                          ->where(DB::raw("reg_end"), '>=', $yearMonth . '-' . $date);
                })
                ->first();

            
            // OFFICIAL
            if($other_dtr && $other_dtr->purpose !== 'supp' && $other_dtr->purpose !== 'pass' && $other_dtr->remarks !== 'OFFSETTING'){
                $record = self::getTimeSheet($other_dtr, $date, $dayOfWeek, $user_id);
            }
            // SUPP or time in time out
            else{
                $dateTimeRecordToday = DB::table('daily_time_record')
                ->select(['date_time', 'remark'])
                ->where('user_id', '=', $user_id)
                ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%e')"), $yearMonth . '-' . $date)
                ->get();

                $inout = self::identifyInOut($dateTimeRecordToday);
                // if($date === 31){
                //     // dd($date);
                //     dd($dateTimeRecordToday);
                // }
                $remarks = $inout['remarks'];

                if($other_dtr && $other_dtr->purpose === 'supp'){
                    // dd($other_dtr);
                    $supp_am_in = $other_dtr->supp_am_in ? Carbon::parse($other_dtr->supp_am_in) : null;
                    $supp_am_out = $other_dtr->supp_am_out ? Carbon::parse($other_dtr->supp_am_out) : null;
                    $supp_pm_in = $other_dtr->supp_pm_in ? Carbon::parse($other_dtr->supp_pm_in) : null;
                    $supp_pm_out = $other_dtr->supp_pm_out ? Carbon::parse($other_dtr->supp_pm_out) : null;

                    $inAM = $inout['inAM'] ? $inout['inAM'] : $supp_am_in;
                    $outAM = $inout['outAM'] ? $inout['outAM'] : $supp_am_out;
                    $inPM = $inout['inPM'] ? $inout['inPM'] : $supp_pm_in;
                    $outPM = $inout['outPM'] ? $inout['outPM'] : $supp_pm_out;
                }else{
                    $inAM = $inout['inAM'];
                    $outAM = $inout['outAM'];
                    $inPM = $inout['inPM'];
                    $outPM = $inout['outPM'];
                }



                // OFFSETTING
                if($other_dtr && $other_dtr->remarks === 'OFFSETTING'){
                    $total = self::getTotalHours($inAM, $outAM, $inPM, $outPM, $dayOfWeek, $other_dtr->off_hours);
                    $remarks = 'OFFSETTING: ' . $other_dtr->off_hours . 'H';
                }else{
                    $total = self::getTotalHours($inAM, $outAM, $inPM, $outPM, $dayOfWeek);
                }



                // GET PERSONAL PASS SLIP
                $pps = DB::table('timesheet_entries')->select('*')
                ->where(function($query) use ($user) {
                    $query->where('employee', $user->id)
                        ->orWhere('employee', null);
                })
                ->where(DB::raw("DATE_FORMAT(date, '%Y-%m-%e')"), $yearMonth . '-' . $date)
                ->where('pass_type', 'personal')
                ->get();
                $personalPassSlips = collect();

                //PERSONAL PASS SLip
                if(count($pps)){
                    foreach($pps as $entry){
                        $data = self::getTimeSheet($entry, $date, $dayOfWeek, $user_id);
                        $personalPassSlips->add($data);
                    }
                    $remarks = 'PPS: '.  gmdate('H:i', $personalPassSlips->sum('total'));
                }

                //OFFICIAL PASS SLIP

                
                // Create a daily record for the current day
                $record = [
                    'date' => $date,
                    'day' => $dayOfWeek,

                    'inAM' => $inAM ? $inAM->format('h:i:00 A') : '-',  
                    'outAM' => $outAM ? $outAM->format('h:i:00 A') : '-',
                    'inPM' => $inPM && $outAM ? $inPM->format('h:i:00 A') : '-',
                    'outPM' => $outPM ? $outPM->format('h:i:00 A') : '-',
                    'lateAM' =>  ($total['lateAM'] / 60) / 480,
                    'utAM' =>  ($total['utAM'] / 60) / 480,
                    'latePM' =>  ($total['latePM'] / 60) / 480,
                    'utPM' =>  ($total['utPM'] / 60) / 480,
                    'absent' =>  ($total['absent'] / 60) / 480,
                    'totalMinutes'=> $total['totalMinutes'] - ($personalPassSlips->sum('total') / 60),
                    'totalHoursInSeconds' => $total['totalRaw'] - $personalPassSlips->sum('total'),
                    'totalHours' => $total['totalRaw'] ? gmdate('H:i:s',$total['totalRaw'] - $personalPassSlips->sum('total')) : null,
                    'remarks' => $remarks,
                    'personalPassSlips' => $personalPassSlips,
                    // 'totalPersonalPassSlip' => gmdate('H:i', $personalPassSlips->sum('total'))
                    'totalPersonalPassSlip' => $personalPassSlips->sum('total')
                ];

                // if($date == 15)
                // dd($record);
            }

            // Add the daily record to the array
            $dailyTimeRecord[] = $record;
        }

        return [
            'dtr' => $dailyTimeRecord,
            'suggestion' => $suggestions
        ];

    }

    public static function getDtrToday($user_id) {
        $date = Carbon::now();
        $user_dtr = DB::table('daily_time_record')->select('date_time')
            ->where('user_id', $user_id)
            ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%d')"), $date->format('Y-m-d'))
            ->get();

        $user_dtr = self::identifyInOut($user_dtr);
            return $user_dtr;
    }


    public static function getInfo($user_id){
        $date = Carbon::now();
        $startMonth = Carbon::now()->startOfMonth();

        $hours_to_render = ($date->dayOfWeek * 8) * 60 * 60;

        if($date->dayOfWeek > $date->format('d')){
            $hours_to_render = (($date->dayOfWeek + 1 - $startMonth->dayOfWeek) * 8) * 60 * 60;
        }

        $rendered = 0;
        $timeout = null;
        $dtr_now = null;

        //  5 > 1
        //

        // $hours_to_render = (5 - ($date->dayOfWeek - 1)) * 8;
        $days_before_count = $date->dayOfWeek;

        if($date->dayOfWeek > $date->format('d')){
            $days_before_count = ($date->dayOfWeek + 1 - $startMonth->dayOfWeek);
        }
        // 1; 1 < 1; 0+1

        for($i = 0; $i < $days_before_count; $i ++){

            // $days_before = $date;

            if($i != 0){
                $date = $date->subDay();
            }

            $user_dtr = DB::table('daily_time_record')->select('date_time')
            ->where('user_id', $user_id)
            ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%d')"), $date->format('Y-m-d'))
            ->get();

            if($i == 0){
                $dtr_now = self::identifyInOut($user_dtr);
            }

            $parse_dtr = self::identifyInOut($user_dtr);

            $count_hours = self::getTotalHours($parse_dtr['inAM'], $parse_dtr['outAM'], $parse_dtr['inPM'], $parse_dtr['outPM']);

            // if($i == 0){
            //     dd($days_before_count);
            // }

            if($count_hours['totalAM']){
                $rendered += $count_hours['totalAM'];
            }
            if($count_hours['totalPM']){
                $rendered += $count_hours['totalPM'];
            }
        }

        if($dtr_now !== null && $dtr_now['inAM'] ){
            $dtr_now_am = $dtr_now['inAM'];
            $inAM = Carbon::parse($dtr_now_am->format('H:i:s'));
            $hours_remaining = null;

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


            $hours_remaining = $date->diffInSeconds($timeout->format('H:i'));

            return([
                'hours_to_render' => ($hours_to_render / 60) / 60,
                'render' => ($hours_to_render - $rendered) / 60 / 60,
                'rendered' => $rendered / 60 / 60,
                'timeout' => $timeout->format('h:i A'),
                'hours_remaining' =>  $hours_remaining,
            ]);
        }else{
            return([
                'hours_to_render' => ($hours_to_render / 60) / 60,
                'render' => 0,
                'rendered' => 0,
                'timeout' => '-',
                'hours_remaining' =>  0,
            ]);
        }

    }

    public static function getTimeSheet($record, $date, $dayOfWeek, $currentUser) {
        $entry = [];
        $wholeday_remarks = [
            'REG_HOLIDAY',
            'RA_9710',
            'REG_OB',
            'REG_SPL',
            'REG_SL',
            'REG_VL',
            'REG_FL',
            'STUDY_LEAVE',
            'MATERNITY_LEAVE',
            'PATERNITY_LEAVE',
            'ON_SCHOLARSHIP',
        ];

        $weekend = ['Sat', 'Sun'];

        // dd($record);
        if(in_array($record->remarks, $wholeday_remarks)){
            if(in_array($dayOfWeek, $weekend)){
                $entry = [
                    'date' => $date,
                    'day' => $dayOfWeek,
                    'inAM' => null,
                    'outAM' =>  null,
                    'inPM' =>  null,
                    'outPM' =>  null,
                    'totalMinutes'=> 0,
                    'lateAM'=> 0,
                    'latePM'=> 0,
                    'utAM'=> 0,
                    'utPM'=> 0,
                    'absent'=> 0,
                    'totalHours' => null,
                    'remarks' => null,
                    "totalPersonalPassSlip" => 0,
                    "totalHoursInSeconds" => 0,
                ];
            }else{
                $entry = [
                    'date' => $date,
                    'day' => $dayOfWeek,
                    'inAM' => '08:00:00 AM',
                    'outAM' =>  '12:00:00 AM',
                    'inPM' =>  '01:00:00 PM',
                    'outPM' =>  '05:00:00 PM',
                    'totalMinutes'=> 0,
                    'lateAM'=> 0,
                    'latePM'=> 0,
                    'utAM'=> 0,
                    'utPM'=> 0,
                    'absent'=> 0,
                    'totalHours' => '08:00:00',
                    'remarks' => $record->remarks,
                    "totalPersonalPassSlip" => 0,
                    "totalHoursInSeconds" => 0,
                ];
            }
        }

        if($record->remarks === 'EO' && $record->eo_sched_type === 'ALLDAY'){

            $entry = [
                'date' => $date,
                'day' => $dayOfWeek,
                'inAM' => '08:00:00 AM',
                'outAM' =>  '12:00:00 AM',
                'inPM' =>  '01:00:00 PM',
                'outPM' =>  '05:00:00 PM',
                'totalMinutes'=> 0,
                'totalHours' => '08:00:00',
                'lateAM'=> 0,
                'latePM'=> 0,
                'utAM'=> 0,
                'utPM'=> 0,
                'absent'=> 0,
                'remarks' => $record->remarks . ': ' . $record->off_title,
                "totalPersonalPassSlip" => 0,
                "totalHoursInSeconds" => 0,
            ];
        }


        if($record->remarks === 'EO' && $record->eo_sched_type === 'PARTIAL'){
            $formattedDate = Carbon::parse($record->date)->format('Y-m-d');
            $formattedTime = Carbon::parse($record->eo_start)->format('H:i');
            $_12pm = Carbon::parse('12:00:00');
            $_1pm = Carbon::parse('13:00:00');
            $_7pm = Carbon::parse('19:00:00');

            $dateTimeRecordToday = DB::table('daily_time_record')
                ->select(['date_time', 'remark'])
                ->where('user_id', '=', $currentUser)
                ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%e')"), $formattedDate)
                ->get();

            $time = Carbon::parse($formattedTime);
            $timeRecord = self::identifyInOut($dateTimeRecordToday);

            if($time->lte($_12pm)){
                $inAM = $timeRecord['inAM'] ?  $timeRecord['inAM'] : Carbon::parse($record->eo_start);
                $timeData = self::getTotalHours($inAM, $_12pm, $_1pm, $_7pm, $dayOfWeek);

                $entry = [
                    'date' => $date,
                    'day' => $dayOfWeek,
                    'inAM' => $inAM->format('h:i:00 A') ,
                    'outAM' =>  '12:00:00 AM',
                    'inPM' =>  '01:00:00 PM',
                    'outPM' =>  '07:00:00 PM',
                    'totalMinutes'=> 0,
                    'lateAM'=> 0,
                    'latePM'=> 0,
                    'utAM'=> 0,
                    'utPM'=> 0,
                    'absent'=> 0,
                    'totalHours' => $timeData['total'],
                    'remarks' => $record->remarks . ': ' . $record->off_title,
                    "totalPersonalPassSlip" => 0,
                    "totalHoursInSeconds" => 0,
                ];
            }else if($time->gte($_1pm)){
                // dd($timeRecord);
                $inAM = $timeRecord['inAM'];
                $outAM = $timeRecord['outAM'];
                $inPM = $timeRecord['inPM'];
                $timeData = self::getTotalHours($inAM, $outAM, $inPM, $_7pm, $dayOfWeek);

                $entry = [
                    'date' => $date,
                    'day' => $dayOfWeek,
                    'inAM' => $inAM->format('h:i:00 A') ,
                    'outAM' =>  $outAM->format('h:i:00 A'),
                    'inPM' =>  $inPM->format('h:i:00 A'),
                    'outPM' =>  '07:00:00 PM',
                    'totalMinutes'=> 0,
                    'lateAM'=> 0,
                    'latePM'=> 0,
                    'utAM'=> 0,
                    'utPM'=> 0,
                    'absent'=> 0,
                    'totalHours' => $timeData['total'],
                    'remarks' => $record->remarks . ': ' . $record->off_title,
                    "totalPersonalPassSlip" => 0,
                    "totalHoursInSeconds" => 0,
                ];
            }else{
                $entry = [
                    'date' => $date,
                    'day' => $dayOfWeek,
                    'inAM' => '08:00:00 AM',
                    'outAM' =>  '12:00:00 AM',
                    'inPM' =>  '01:00:00 PM',
                    'outPM' =>  '05:00:00 PM',
                    'totalMinutes'=> 0,
                    'lateAM'=> 0,
                    'latePM'=> 0,
                    'utAM'=> 0,
                    'utPM'=> 0,
                    'absent'=> 0,
                    'totalHours' => '08:00:00',
                    'remarks' => $record->remarks . ': ' . $record->off_title,
                    "totalPersonalPassSlip" => 0,
                    "totalHoursInSeconds" => 0,
                ];
            }

        }

        // offsetting

        if($record->remarks === 'OFFSETTING'){
            $formattedDate = Carbon::parse($record->date)->format('Y-m-d');
            $formattedTime = Carbon::parse($record->eo_start)->format('H:i');
            $_12pm = Carbon::parse('12:00:00');
            $_1pm = Carbon::parse('13:00:00');
            $_7pm = Carbon::parse('19:00:00');



            $dateTimeRecordToday = DB::table('daily_time_record')
                ->select(['date_time', 'remark'])
                ->where('user_id', '=', $currentUser)
                ->where(DB::raw("DATE_FORMAT(date_time, '%Y-%m-%e')"), $formattedDate)
                ->get();

            $time = Carbon::parse($formattedTime);
            $timeRecord = self::identifyInOut($dateTimeRecordToday);
            $inAM = $timeRecord['inAM'];
            $outAM = $timeRecord['outAM'];
            $inPM = $timeRecord['inPM'];
            $outPM = $timeRecord['outPM'];
            $totalHours = self::getTotalHours($inAM, $outAM, $inPM, $outPM, $dayOfWeek);

            $inAM = $timeRecord['inAM'];
            $outAM = $timeRecord['outAM'];
            $inPM = $timeRecord['inPM'];
            $outPM = $timeRecord['outPM'];

            $entry = [
                'date' => $date,
                'day' => $dayOfWeek,
                'inAM' => $inAM->format('h:i:00 A') ,
                'outAM' =>  $outAM->format('h:i:00 A'),
                'inPM' =>  $inPM->format('h:i:00 A'),
                'outPM' =>  $outPM ? $outPM->format('h:i:00 A') : null,
                'totalMinutes'=> 0,
                'lateAM'=> 0,
                'latePM'=> 0,
                'utAM'=> 0,
                'utPM'=> 0,
                'absent'=> 0,
                'totalHours' => $totalHours['total'],
                'remarks' => $record->remarks . ': ' . $record->off_title,
                "totalPersonalPassSlip" => 0,
                "totalHoursInSeconds" => 0,
            ];
        }

        // pass slip personal
        if($record->purpose == 'pass' && $record->pass_type == 'personal'){
            $passDeparture = Carbon::parse($record->pass_out);
            $passReturn = Carbon::parse($record->pass_in);
            $_7am = Carbon::parse('7:00:00');
            $_12pm = Carbon::parse('12:00:00');
            $_1pm = Carbon::parse('13:00:00');
            $_5pm = Carbon::parse('17:00:00');
            $_7pm = Carbon::parse('19:00:00');

            $totalPassSlipAM = 0;
            $totalPassSlipPM = 0;


            if($passDeparture->gte($_7am) && $passDeparture->lte($_12pm)){

                if($passReturn->lte($_12pm)){
                    $totalPassSlipAM = $passReturn->diffInSeconds($passDeparture);
                }else if($passReturn->lte($_1pm)){
                    $totalPassSlipAM = $passDeparture->diffInSeconds($_12pm);
                }else if($passReturn->greaterThan($_1pm) && $passReturn->lessThan($_5pm)){
                    $totalPassSlipAM = $_12pm->diffInSeconds($passDeparture);
                    $totalPassSlipPM = $passReturn->diffInSeconds($_1pm);
                }else if($passReturn->greaterThan($_5pm)){
                    $totalPassSlipAM = $_12pm->diffInSeconds($passDeparture);
                    $totalPassSlipPM = $_1pm->diffInSeconds($_5pm);
                }
            }else{

                if($passReturn->greaterThan($_1pm)){
                    $totalPassSlipAM = $passDeparture->diffInSeconds($passReturn);
                }else if($passDeparture->gte($_5pm)){
                    $totalPassSlipAM = $_5pm->diffInSeconds($passReturn);
                }else if($passReturn->gte($_1pm)){
                    $totalPassSlipAM = $passReturn->diffInSeconds($_1pm);
                }

            }

            return [
                'departure' => $record->pass_out,
                'return' => $record->pass_in,
                'total' => $totalPassSlipAM + $totalPassSlipPM
            ];


        }

        return $entry;
    }

}

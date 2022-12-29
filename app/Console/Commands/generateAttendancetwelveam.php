<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use App\models\RegisterPackage;

class generateAttendancetwelveam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:twelveAmAttendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Student Attendance twelve Am';

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


        $now  = Carbon::today()->addDays(1)->format('Y-m-d');
        \Log::info("Cron is 12 AM Student Attendance! ". $now);

        $this->info('Demo:Cron 12 AM Cummand Run successfully!');
        
        
        $now  = Carbon::today()->addDays(1)->format('Y-m-d');
        $resStudentAttendance  =  DB::table('student_days')->select(['student_days.*','student.isTafseer'])
        ->leftjoin('student', 'student.id', '=', 'student_days.student_id')
        ->whereRaw("(student.academicStatus = 1 || student.academicStatus = 8 )")
        ->whereRaw("student_days.day_name = dayname('$now')")
        ->whereRaw("date_format(local_time,'%r') = '12:00:00 AM'")
        ->get();       
        $arrr = [] ;
        
        // $rescheckattendance =  DB::table('studentattendance')->whereDate('created_at', Carbon::today())->get();
        // if(count($rescheckattendance) == 0){
                foreach($resStudentAttendance as $val){
                 
                       
                        $getPackage = RegisterPackage::where("student_id", $val->student_id)->first();
                        $packageID = 0;

                        if(!empty($getPackage)){
                            $packageID = $getPackage->package_id;
                        }
                        $arrr[] = [
                            'teacher_id'            => $val->teacher_id,
                            'student_id'            => $val->student_id,
                            'day'                   => $val->day_no,
                            'day_name'              => $val->day_name,
                            'student_day'           => $val->student_day_no,
                            'student_day_name'      => $val->student_day_name,
                            'attdendance_time'      => $val->local_time,
                            'attendance_time_text'  => $val->local_time_text,
                            'duration'              => $val->day_duration,
                            "package_id"            => $packageID,
                            'attendance_status'     => 9,
                            'attendance_type'       => 1,
                            'attendance_date_time'  => Carbon::now()->toDateString().' '.$val->local_time,
                            'created_by'            => 1,
                            'isTafseer'             => $val->isTafseer,
                            'created_at'            => Carbon::now(),
                            'updated_at'            => Carbon::now(),
                        ];
                
                        DB::table('studentattendance')->where('student_id',$val->student_id)->whereDate('created_at', Carbon::today())->delete();
                
                    
            
                }
        // }
        DB::table('studentattendance')->insert($arrr);
        // }
        \Log::info($arrr);
    }
}

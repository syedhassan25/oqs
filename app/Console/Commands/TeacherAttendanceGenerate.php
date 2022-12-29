<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class TeacherAttendanceGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teacher:attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Teacher Attendance';

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
         $rescheckattendance =  DB::table('teacherattendance')->whereDate('created_at', Carbon::today())->get();
        if(count($rescheckattendance) == 0){
                    $Employee = DB::table('employees')->Select(['employees.*','users.email'])
                    ->leftjoin('users', 'users.id', '=', 'employees.user_id')
                    ->where('users.status', '1')
                    ->get();
         
              $arrr=[];
              foreach($Employee as $val){
                  
                   $arrr[] = [
                    'teacher_id' => $val->id,
                    'attendance_date' => Carbon::today()->format('Y-m-d'),
                    'attendance_status' =>   0,
                    'created_by' => 8964,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    ];
                  
                  
              }
              
              DB::table('teacherattendance')->insert($arrr);
              
              
              \Log::info($arrr);
        }
    }
}

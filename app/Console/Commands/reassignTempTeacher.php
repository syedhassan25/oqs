<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use DB;

class reassignTempTeacher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:teacher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        \Log::info("Cron is working fine! ".Carbon::now()->format('H:i:s').'--'.Carbon::now()->addMinutes(30)->format('H:i:s'));
     
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
      
        $this->info('Demo:Cron Cummand Run successfully!');
        
        
         //  $resAssignteachertestsss  =  DB::table('studentReassignNewToOldTeacher')
        //  ->whereBetween('reAssigntime', array(Carbon::now()->format('H:i:s'), Carbon::now()->addMinutes(30)->format('H:i:s')))
        // ->whereDate('reassignDate', Carbon::today())->where('status',1)->where('temporaryAssignType',1)->toSql();
        
        
        $start = Carbon::now()->format('H:i:s');
        $end   =   Carbon::now()->addMinutes(30)->format('H:i:s');
        
        $resAssignteacher  =  DB::table('studentReassignNewToOldTeacher')
        ->whereRaw("date_format(`reAssigntime`,'%H:%i:%s') BETWEEN '$start' and '$end'")
        ->whereDate('reassignDate', Carbon::today())->where('status',1)->where('temporaryAssignType',1)->get();
        
        //  ->whereRaw("DATE_FORMAT(reAssigntime, '%H:%i:%s') >= '$start'  AND  DATE_FORMAT(local_Time, '%H:%i:%s') < '$end'")
        // $Student->whereRaw("DATE_FORMAT(student.teacheSchduletime, '%H:%i:%s') = DATE_FORMAT(STR_TO_DATE('$request->time', '%l:%i %p' ),'%H:%i:%s')")
        
        $arrr = [] ;
        foreach($resAssignteacher as $val){
            
              DB::table('student')->where('id', $val->studentid)->update(['teacher_id' =>  $val->oldTeacherId ,'teacher_assign_type' => 1]);
              DB::table('student_days')->where('student_id', $val->studentid)->update(['teacher_id' =>  $val->oldTeacherId]);
              DB::table('studentReassignNewToOldTeacher')->where('id', $val->id)->update(['status' => 0]);
            
            $arrr[] = $val;
        }
        
         \Log::info($arrr);
        
    }
}

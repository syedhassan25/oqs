<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\models\FcmNotification;
use App\models\Student;
use App\models\User;
use Carbon\Carbon;
use DateTime;
use DB;


class OldStudentTrailcompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:oldtrailcomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification if Trail Completed';

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
        $Student = Student::select(['student.*', 'countries.CountryName', 'studentdays.*', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')])
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id')
            ->join(DB::raw('(SELECT COUNT(student_id) Totalday,student_id FROM `student_days` GROUP BY student_id) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->join(DB::raw('(SELECT student_id, MIN(created_at) latestattendance FROM studentattendance GROUP BY student_id) lastattendance'),
                function ($join) {
                    $join->on('student.id', '=', 'lastattendance.student_id');
                });

        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5);
        $Student->whereRaw('(student.billing_status = 2)');
        $Student->groupBy('studentattendance.student_id');
        $Student->havingRaw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) >=  studentdays.Totalday ||  totaldaycount > 14 ');
        $studenttrailcomplete  =  $Student->orderby('student.id', 'desc')->get();
         $count3 = count($studenttrailcomplete);
         $receiveArra  = DB::table('notificationSenderUserBytype')->where('notificationtype','StudentTailComplete')->pluck('user_id')->toArray();
        //  if(count($count3) > 0){
              foreach($studenttrailcomplete as $val){
                  
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.' Trail Has Been completed ';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "StudentTailComplete";
                                             $route   =    route('admin.student.trailcompleted');
                                             $this->SendFcmNOtification($senderId,$receiveArra,$title,$Description,$action_id,$notificationtype,$route);
             
              }
         
        //  }
        
         
    }
    public function SendFcmNOtification($senderId,$recieverID,$title,$Description,$action_id,$notificationtype,$route){
        
               foreach($recieverID as $datauser){
                $data   =    User::where('id',$datauser)->first();
                $user_id  =  $data->id;
                $noti  = new  FcmNotification();
                $noti->sender_user_id = $senderId;
                $noti->route = $route;
                $noti->title = $title;
                $noti->text = $Description;
                $noti->user_id = $user_id;
                $noti->action_id =  $action_id;
                $noti->notificationtype = $notificationtype;
                $noti->save();
                $token = $data->fcm_token;
                if($token){
                   $noti->toSingleDevice($token,$user_id,$title,$Description,null,$route);
                }
        }
            
    }
}

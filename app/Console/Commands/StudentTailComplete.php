<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\models\FcmNotification;
use App\models\Student;
use App\models\User;
use App\models\Task;
use App\models\taskAssign;
use Carbon\Carbon;
use DateTime;
use DB;


class StudentTailComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:trailcomplete';

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
        \Log::info('trail student execute');

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
        $Student->havingRaw('sum(CASE WHEN (`studentattendance`.attendance_status = 1 || `studentattendance`.attendance_status = 8) then 1 ELSE 0 END) >=  studentdays.Totalday ||  totaldaycount > 14');
        $studenttrailcomplete  =  $Student->orderby('student.id', 'desc')->get();
         $count3 = count($studenttrailcomplete);
         $receiveArra  = DB::table('notificationSenderUserBytype')->where('notificationtype','StudentTailComplete')->pluck('user_id')->toArray();
        //  if(count($count3) > 0){
              foreach($studenttrailcomplete as $val){
                  
                  
                  
                       DB::table('student')->where('id', $val->id)
                        ->update([
                            'billing_status' => 1,
                            'class_type' =>  2
                            ]);
                                                      
                                            
                     $tasksubject = 'Student '.$val->studentname.' Trial Has Been completed ';
                     
                     \Log::info($tasksubject);
                     
                     
                     $studentid =  $val->id;
                     $group  =  $val->group;
                     $taskDescription  = 'Trial Has Been completed ';
                    //  $assignuserToArray = array(2273,2275,1,9013);
                    
                    //  $assignuserToArray  = DB::table('notificationSenderUserBytype')->whereIn('notificationtype',['task','DemoStudent'])->whereNotIn('user_id', [2273])->groupBy('user_id')->pluck('user_id')->toArray();
                    
                    $assignuserToArray  = DB::table('notificationSenderUserBytype')->whereIn('notificationtype',['task','DemoStudent'])->groupBy('user_id')->pluck('user_id')->toArray();
                  

                     $fcmDescription =  'Trail Has Been completed ';
                     $creatorID =  8964;
                     $taskrelateID =  $val->id;
                     $notificationtype = "task";
                     $this->generateTaskFoStudent($creatorID,$tasksubject,$studentid,$group,$taskDescription,$assignuserToArray,$fcmDescription,$taskrelateID,$notificationtype);
                                            
                                            
             
              }
         
        //  }
        
         
    }
  
    
    public function generateTaskFoStudent($taskCreatedBy,$tasksubject,$studentid,$group,$taskDescription,$assignuserToArray,$fcmDescription,$taskrelateID,$notificationtype,
    $taskCompleteddate=null,$taskCompletedtime = null
    ){
        
            $task = new  Task();
            $task->assignUserid = $taskCreatedBy;
            $task->taskName = $tasksubject;
            $task->isAttachment = null;
            $task->isImportant = 1;
            $task->multi_student =  $studentid;
            $task->multi_student_group = $group;
            $task->task_type   =   1;
            $task->task_assign_type =  2;
            $task->taskDescription = $taskDescription;
            $task->taskCompleteddate =   ($taskCompleteddate) ? $taskCompleteddate : date('Y-m-d');
            $task->taskCompletedtime =   ($taskCompletedtime) ? $taskCompletedtime: date('Y-m-d');
            $task->firsttaskCompleteddate =   ($taskCompleteddate) ? $taskCompleteddate : date('Y-m-d');
            $task->firsttaskCompletedtime =   ($taskCompletedtime) ? $taskCompletedtime: date('Y-m-d');
            $task->created_by  =   $taskCreatedBy;
            $task->save();
            
            
            
                $assignerdata =  $assignuserToArray;
                foreach($assignerdata as $val){
                    $taskassign =  new taskAssign();
                    $taskassign->taskId = $task->id;
                    $taskassign->assignTo = $val;
                    $taskassign->assignFrom = $taskCreatedBy;
                    $taskassign->save();
                }
               
               
              $user = User::whereIn('id',$assignerdata)->get();
              $daarr  = [];
              foreach($user as $data){

                // $datanotification[]  = array(
                //     'title' => $tasksubject,
                //     'body' => 'You Have a New Task',
                //     'targetid' => $task->id,
                //     'anchorroute' => route('admin.task.detail',$task->id),
                //  );
                 
                 
                $route  =  route('admin.task.detail',$task->id);
                $user_id  =  $data->id;
                $noti  = new  FcmNotification();
                $noti->sender_user_id = $taskCreatedBy;
                $noti->route = $route;
                $noti->title = $tasksubject;
                $noti->text = $fcmDescription;
                $noti->user_id = $user_id;
                $noti->action_id =  $taskrelateID;
                $noti->notificationtype = $notificationtype;
                $noti->save();
                $token = $data->fcm_token;
                if($token){
                   $noti->toSingleDevice($token,$user_id,$tasksubject,$fcmDescription,null,$route);
                }
                 

                //     $daarr[] = array(
                //     'id' => $data->id,
                //     'name' => $data->name,
                //     'role' => $data->role,
                //  );
                // \Notification::send($data ,  new TaskNotifications($datanotification,$data->id));
                
                
              }
            
            
        
        
    }
    
    
}

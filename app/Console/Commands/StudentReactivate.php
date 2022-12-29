<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use App\models\FcmNotification;
use App\models\User;
use App\models\Employee;


use App\models\Student;
use App\models\Task;
use App\models\taskAssign;
use DateTime;


class StudentReactivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:reactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Student Reactivate';

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
        
        $now  = Carbon::today()->format('Y-m-d');
        
        \Log::info($now);
        
        $CheckStudent  =  DB::table('student')->Select(['student.*'])
        ->whereDate('re_activate_date', '>=', $now)
        ->where('academicStatus',8)->get();
      \Log::info($CheckStudent);
        if(count($CheckStudent) > 0){
                   
              $arrr=[];
              foreach($CheckStudent as $val){
                  
                  \Log::info('first');
                  
                   $resStudentAttendance  =  DB::table('student_days')->select(['student_days.*'])
                    ->where('student_days.student_id', $val->id)
                    ->whereRaw("student_days.day_name = dayname('$now')")->get();
                    
                    if(count($resStudentAttendance) > 0){
                        
                        \Log::info('class Exist');
                        \Log::info('student_id '.$val->id);
                        
                        DB::table('studentattendance')->where('student_id', $val->id)
                        ->whereDate('studentattendance.created_at', Carbon::today())
                        ->where("student_day",$resStudentAttendance[0]->student_day_no)->update([
                            'attendance_status' => 3
                            ]);
                        
                    }
                    
                    $date1 = date_create($val->re_activate_date);
                    $date2 = date_create(Carbon::now()->format('Y-m-d'));
                    
                    $diff= date_diff($date1,$date2);
                    $total = $diff->format("%a");
                    
                    $recieverID  = Employee::where('id',$val->teacher_id)->first()->user_id;
                    
                     $assignuserToArray = $receiveArra  = DB::table('notificationSenderUserBytype')->where('notificationtype','DemoStudent')->pluck('user_id')->toArray();
                     $receiveArra[] = $recieverID;
                    
                    if($total <= 2){
                         \Log::info($total);
                         if($total == 0){
                             
                             DB::table('student')->Select(['student.*'])->where('id',$val->id)->where('academicStatus',8)
                             ->update(['academicStatus' => 1]);
                             
                             
                             
                             $taskDescription  = 'Student '.$val->studentname.'  Time Reserved to active Today ';
                             
                             DB::table('academicstatuschange')->
                            insert([
                                 'teacher_id' => $val->teacher_id,
                                 'student_id' => $val->id ,
                                 'previousStatus' => 8,
                                 'status' => 1,
                                 'reason_id' => 48,
                                 'description' => $taskDescription,
                                 'created_by' => 8964 
                            ]);
                             
                             
                            
                             
                             
                             foreach($receiveArra as $valdata){
                                 
                                             \Log::info('Student '.$val->studentname.'  Time Reserved to active Today ');
                                             \Log::info($valdata);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.'  Time Reserved to active Today ';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "StudentUpdate";
                                             $route   =    route('admin.student.edit',$val->id);
                                             if($valdata == $recieverID){
                                                  $route   =    route('teacherpanel.student.detail',$val->id);
                                             }
                                              
                                               $this->SendFcmNOtification($senderId,$valdata,$title,$Description,$action_id,$notificationtype,$route);
                                         }
                                         
                             $tasksubject = 'Student '.$val->studentname.' Status Change';
                             $fcmDescription = $taskDescription;
                             $creatorID =  8964;
                             $studentid =  $val->id;
                             $taskrelateID =  $val->id;
                             $group =  $val->group;
                             $notificationtype = "task";
                             $this->generateTaskFoStudent($creatorID,$tasksubject,$studentid,$group,$taskDescription,$assignuserToArray,$fcmDescription,$taskrelateID,$notificationtype);
                                          
                                         
                             
                                         
                             
                         }else{
                             foreach($receiveArra as $valdata){
                                              \Log::info('Student '.$val->studentname.' '.$total.' days remaining for  Time Reserved to active ');
                                             \Log::info($valdata);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.' '.$total.' days remaining for  Time Reserved to active ';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "StudentUpdate";
                                             $route   =    route('admin.student.edit',$val->id);
                                             if($valdata == $recieverID){
                                                  $route   =    route('teacherpanel.student.detail',$val->id);
                                             }
                                              
                                               $this->SendFcmNOtification($senderId,$valdata,$title,$Description,$action_id,$notificationtype,$route);
                                         }
                         }
                         
                         
                        
                                         
                         
                         
                    }else{
                         \Log::info($total);
                         \Log::info($receiveArra);
                         
                         
                    }
                    
                  
              }
              
              
             
        }
    }
    
    
     public function SendFcmNOtification($senderId,$recieverID,$title,$Description,$action_id,$notificationtype,$route){
        
            //   foreach($recieverID as $datauser){
                $data   =    User::where('id',$recieverID)->first();
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
        // }
            
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

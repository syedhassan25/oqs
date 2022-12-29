<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\models\FcmNotification;
use App\models\User;
use App\models\Employee;
use Carbon\Carbon;
use DateTime;
use DB;

class StudentTeacherDemoSchdule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:teacherdemoschedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Teacher Demo Schdule Notification';

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
        
         \Log::info('ssss');
        
        
        
         $studentdemotime  = DB::select("SELECT student.*,TIMESTAMPDIFF(MINUTE,DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %H:%i:%S'),DATE_FORMAT(DATE_ADD(CONCAT(teacheSchduledate,' ',teacheSchduletime),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S')) as differnceTime FROM `student`  WHERE 
date_format(CONCAT(teacheSchduledate,' ',teacheSchduletime),'%Y-%m-%d %T') BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630  MINUTE),'%Y-%m-%d %T')  AND
step_status = 4  ORDER BY student.id DESC");
        
       
             $count3 = count($studentdemotime);	
            //   \Log::info($query);
            
              $receiveArra  = DB::table('notificationSenderUserBytype')->where('notificationtype','DemoStudent')->pluck('user_id')->toArray();
             if($count3 > 0){
                    foreach($studentdemotime as $val){
                        
                        //  \Log::info($val->beforetime);
                        // \Log::info($val->studenttime);
                        
                      
                        
                        
                        $interval = $val->differnceTime;
                        
                        \Log::info($interval.'---');
                        if($interval >= 15  && $interval <= 30){
                            
                                            //  \Log::info($val);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.' '.$interval.' Minutes Left to Assign Teacher';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "DemoStudent";
                                             $route   =    route('admin.student.edit',$val->id);
                                             $this->SendFcmNOtification($senderId,$receiveArra,$title,$Description,$action_id,$notificationtype,$route);
                            
                        }
                        else if($interval >= 1  && $interval <= 14){
                                            //  \Log::info($val);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.' '.$interval.' Minutes Left to Assign Teacher';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "DemoStudent";
                                             $route   =    route('admin.student.edit',$val->id);
                                             $this->SendFcmNOtification($senderId,$receiveArra,$title,$Description,$action_id,$notificationtype,$route);
                        }
                        else if($interval == 0){
                                            //  \Log::info($val);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.'  Assign Teacher Time Now ';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "DemoStudent";
                                             $route   =    route('admin.student.edit',$val->id);
                                             $this->SendFcmNOtification($senderId,$receiveArra,$title,$Description,$action_id,$notificationtype,$route);
                        }
                    }
                
            }

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

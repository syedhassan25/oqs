<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\models\FcmNotification;
use App\models\User;
use App\models\Employee;
use Carbon\Carbon;
use DateTime;
use Config;

class StudentDemoSchdule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:demoschedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send DemoSchdule Notification';

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
        
        
          $studentdemotimeQuery  = "";
        
         $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');
       
            if($timeZoneChangeEuropeStatus){
                $studentdemotimeQuery  .= "SELECT student.*,TIMESTAMPDIFF(MINUTE,DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +660 MINUTE),'%Y-%m-%d %H:%i:%S'),DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S')) as differnceTime,DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S') as studenttime , DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +660 MINUTE),'%Y-%m-%d %H:%i:%S') as beforetime FROM `studentdemoschdules` inner join student on studentdemoschdules.studentID = student.id WHERE date_format(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),'%Y-%m-%d %T') BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 600 MINUTE),'%Y-%m-%d %T') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 660  MINUTE),'%Y-%m-%d %T') ORDER BY studentdemoschdules.id DESC";
                
            }else{
                $studentdemotimeQuery  .= "SELECT student.*,TIMESTAMPDIFF(MINUTE,DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %H:%i:%S'),DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S')) as differnceTime,DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S') as studenttime , DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %H:%i:%S') as beforetime FROM `studentdemoschdules` inner join student on studentdemoschdules.studentID = student.id WHERE date_format(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),'%Y-%m-%d %T') BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630  MINUTE),'%Y-%m-%d %T') ORDER BY studentdemoschdules.id DESC";
            }
        
        
        
         $studentdemotime  = DB::select($studentdemotimeQuery);
        
        
        
        
        //  $studentdemotime  = DB::select("SELECT student.*,TIMESTAMPDIFF(MINUTE,DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %H:%i:%S'),DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S')) as differnceTime,DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S') as studenttime , DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %H:%i:%S') as beforetime FROM `studentdemoschdules` inner join student on studentdemoschdules.studentID = student.id WHERE date_format(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),'%Y-%m-%d %T') BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630  MINUTE),'%Y-%m-%d %T') ORDER BY studentdemoschdules.id DESC");
        
       
        
        
        // $studentdemotime  = DB::select("SELECT student.*,DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S') as studenttime , DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %H:%i:%S') as beforetime FROM `studentdemoschdules` inner join student on studentdemoschdules.studentID = student.id WHERE date_format(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),'%Y-%m-%d %T') BETWEEN DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630  MINUTE),'%Y-%m-%d %T') ORDER BY studentdemoschdules.id DESC");
        
        
        
        
        // $studentdemotime  = DB::select("SELECT student.*,DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i:%S') as studenttime , DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +585  MINUTE),'%Y-%m-%d %H:%i:%S') as beforetime  FROM `studentdemoschdules`
        //  inner join  student on studentdemoschdules.studentID = student.id  WHERE 
        //  DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %h %i')BETWEEN  DATE_FORMAT(DATE_SUB(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),INTERVAL 30 MINUTE),'%Y-%m-%d %h %i')   AND DATE_FORMAT(DATE_ADD(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %h %i')
        // ");
        
        // $query  = "SELECT student.*,DATE_FORMAT(DATE_ADD(CONCAT(studentdemoschdules.schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') as studenttime , DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +585  MINUTE),'%Y-%m-%d %h %i') as beforetime  FROM `studentdemoschdules`
        //  inner join  student on studentdemoschdules.studentID = student.id  WHERE 
        //  DATE_FORMAT(DATE_ADD(CONCAT(schduleDate,' ',studentdemoschdules.local_Time),INTERVAL +0 HOUR),'%Y-%m-%d %h %i') BETWEEN  DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +530  MINUTE),'%Y-%m-%d %h %i') AND DATE_FORMAT(DATE_ADD(CONCAT(now()),INTERVAL +600 MINUTE),'%Y-%m-%d %h %i')
        // ";
             $count3 = count($studentdemotime);	
            //   \Log::info($query);
            
              $receiveArra  = DB::table('notificationSenderUserBytype')->where('notificationtype','DemoStudent')->pluck('user_id')->toArray();
             if($count3 > 0){
                    foreach($studentdemotime as $val){
                        
                         \Log::info($val->beforetime);
                        \Log::info($val->studenttime);
                        
                        // $date1 =  new DateTime($val->beforetime);
                        // $date2 =  new DateTime($val->studenttime);
                        // $interval = $date2->diff($date1);
                        // $interval = $interval->format('%i');
                        
                        
                        $interval = $val->differnceTime;
                        
                        \Log::info($interval.'---');
                        if($interval >= 15  && $interval <= 30){
                            
                                            //  \Log::info($val);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.' '.$interval.' Minutes Left to  Demo Start ';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "DemoStudent";
                                             $route   =    route('admin.student.edit',$val->id);
                                             $this->SendFcmNOtification($senderId,$receiveArra,$title,$Description,$action_id,$notificationtype,$route);
                            
                        }
                        else if($interval >= 1  && $interval <= 14){
                                            //  \Log::info($val);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.' '.$interval.' Minutes Left to  Demo Start ';
                                             $senderId =  8964;
                                             $action_id =  $val->id;
                                             $notificationtype = "DemoStudent";
                                             $route   =    route('admin.student.edit',$val->id);
                                             $this->SendFcmNOtification($senderId,$receiveArra,$title,$Description,$action_id,$notificationtype,$route);
                        }
                        else if($interval == 0){
                                            //  \Log::info($val);
                                             
                                             $title = 'Student '.$val->studentname;
                                             $Description =  'Student '.$val->studentname.'  Demo Start Time Now ';
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

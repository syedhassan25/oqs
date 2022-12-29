<?php

namespace App\models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use Carbon\Carbon;

class FcmNotification extends Model
{
    
    
    use SoftDeletes;
    protected $table = "notification_progress";
    protected $fillable = ['sender_user_id','user_id','notificationtype','text'];
    protected $date = ['deleted_at'];
    
     public function toSingleDevice($token=null,$user_id,$title=null,$body=null,$icon=null,$click_action){
        
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
        				    ->setSound('default')
        				     ->setClickAction($click_action)
	   ->setIcon("https://vignette2.wikia.nocookie.net/villains/images/9/9f/Bender_Rodr%C3%ADguez.jpg/revision/latest?cb=20150929231612");
	   
	   
        $dataBuilder = new PayloadDataBuilder();
       $dataBuilder->addData(['badge' =>$this->where('user_id',$user_id)->where('read_at',null)->count()]);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        
        $token = $token;
        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
        $downstreamResponse->tokensWithError();

        
    }
     
     public function scopetoMultipleDevice($query,$user_id,$model,$title=null,$body=null,$icon,$click_action){
         
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody($body)
        				    ->setSound('default')
        				     ->setBadge($this->where('user_id',$user_id)->where('read_at',null)->count())
        				     ->setIcon($icon)
        				     ->setClickAction($click_action);
        $dataBuilder = new PayloadDataBuilder();
         $dataBuilder->addData(['badge' =>$this->where('user_id',$user_id)->where('read_at',null)->count()]);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $tokens = $model->pluck('fcm_token')->toArray();
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();
        $downstreamResponse->tokensToDelete();
        $downstreamResponse->tokensToModify();
        $downstreamResponse->tokensToRetry();
        $downstreamResponse->tokensWithError();
         
         
     }
     
     public function broadcastMessage($token=null,$senderName, $message,$click_action,$type="notification"){
    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60 * 20);

    $notificationBuilder = new PayloadNotificationBuilder('New message from : ' . $senderName);
    $notificationBuilder->setBody($message)
        ->setSound('default')
        ->setClickAction($click_action);

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData([
        'sender_name' => $senderName,
        'mesage' => $message,
        'type' => $type
    ]);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    // $tokens = User::all()->pluck('fcm_token')->toArray();

    $tokens = $token;
    $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

    return $downstreamResponse->numberSuccess();

}
     
     public function allNotificationByType($user_id,$type){
         
          return $this->where('user_id',$user_id)->whereIn('notificationtype',$type)
           ->where('created_at', '>', now()->subDays(60)->endOfDay())
          ->orderBy('id', 'DESC')->get();
        // $student =  $this->where('user_id',$user_id)->where('notificationtype','StudentUpdate')->orderBy('id', 'DESC')->get();
        
        // return response()->json( [
        //     'task' => $task,
        //     'student' => $student,
        //     ]);
     }
     
     
     public  function Allnotification($user_id){
         return $this->where('user_id',$user_id)->orderBy('id', 'DESC')->get();
     }
     public  function Read($user_id){
         return $this->where('user_id',$user_id)->where('read_at',null)->get();
     }
     public function NumberAlert($user_id){
         return $this->where('user_id',$user_id)->where('read_at',null)->count();
        
     }
     public function NumberAlertByType($user_id,$type){
         return $this->where('user_id',$user_id)->whereIn('notificationtype',$type)->where('read_at',null)->count();
        
     }
     
}

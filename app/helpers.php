<?php

use App\models\TimeLineLog;
use App\models\SendFcmNOtificationHelper;
use App\models\FcmNotification;
use App\models\User;
use Carbon\Carbon;

if (!function_exists('Converttimezone')) {

    function Converttimezone($datetime, $existimezone = 'Asia/Tashkent', $newtimezone = 'Asia/Tashkent')
    {
        $user_date = date('Y-m-d H:i:s', strtotime($datetime));
        $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, $existimezone);
        $utc_date->setTimezone('UTC');

        $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $utc_date, 'UTC');
        $user_date->setTimezone($newtimezone);

        # check the user date
        return Carbon::createFromFormat('Y-m-d H:i:s', $user_date)->format('Y-m-d h:i A');
    }
}

if (!function_exists('timeLineLogCreate')) {

    function timeLineLogCreate($log_name, $log_description, $log_detail, $subject_type, $event_type, $event_id, $log_relate_type, $log_relate_type_id, $student_group, $created_by, $created_at, $updated_at)
    {
        $timeline = TimeLineLog::create([
            'log_name' => $log_name,
            'log_description' => $log_description,
            'log_detail' => $log_detail,
            'subject_type' => $subject_type,
            'event_type' => $event_type,
            'event_id' => $event_id,
            'log_relate_type' => $log_relate_type,
            'log_relate_type_id' => $log_relate_type_id,
            'student_group' => $student_group,
            'updated_at' => $updated_at,
            'created_at' => $created_at,
            'created_by' => $created_by,
        ]);

        # check the user date
        return $timeline;
    }
}
if (!function_exists('SendFcmNOtificationHelper')) {
    function SendFcmNOtificationHelper($senderId, $recieverID, $title, $Description, $action_id, $notificationtype, $route)
    {

        foreach ($recieverID as $datauser) {
            $data = User::where('id', $datauser)->first();
            $user_id = $data->id;
            $noti = new FcmNotification();
            $noti->sender_user_id = $senderId;
            $noti->route = $route;
            $noti->title = $title;
            $noti->text = $Description;
            $noti->user_id = $user_id;
            $noti->action_id = $action_id;
            $noti->notificationtype = $notificationtype;
            $noti->save();
            $token = $data->fcm_token;
            if ($token) {
                $noti->toSingleDevice($token, $user_id, $title, $Description, null, $route);
            }
        }
    }
}

<?php

namespace App\Listeners;

use App\models\Employee;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\Login;

class LoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->save();

        // $timezone = 'America/Los_Angeles';

        // // today at 8pm
        // $today = Carbon::parse('today 8pm', $timezone);

        // // tomorrow 9am
        // $tomorrow = Carbon::parse('tomorrow 9am', $timezone);

        // // Now
        // $now = Carbon::now($timezone);

        // if ($now->gte($today) && $now->lte($tomorrow)) {
        //     //now is >= today/8pm and <= tomorrow/9am
        // }


        $startDate = Carbon::parse('today 6pm');
        $endDate = Carbon::parse('today 11:59pm');
        // $startDate = Carbon::createFromFormat('H:i a', '00:00 PM');
        // $endDate = Carbon::createFromFormat('H:i a', '05:30 AM');

        $check = Carbon::now()->between($startDate, $endDate, true);

        if ($check) {
            $now = Carbon::now();

            $isemployee = Employee::where('user_id', $event->user->id)->first();
            if ($isemployee) {
                $checkattendance = DB::table('teacherattendance')->where('attendance_date', date('Y-m-d'))->where('teacher_id', $isemployee->id)->first();
                if ($checkattendance) {
                    if ($checkattendance->avail_time == null) {
                    DB::table('teacherattendance')->where('teacher_id', $isemployee->id)->where('attendance_date', date('Y-m-d'))->update(['attendance_status' => 1, 'avail_time' => Carbon::now(), 'created_by' => $event->user->id]);
                    }
                }
            }
        }

       

    }
}

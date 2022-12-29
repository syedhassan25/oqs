<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\BaseController;
use DB;
use Carbon\Carbon;
use Auth;
use App\models\Employee;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
       
        $attendanceTeacher =  DB::table('teacherattendance')->where('teacher_id',Employee::where('user_id',Auth::user()->id)->first()->id)->whereDate('created_at', Carbon::today())->get();
        $this->setPageTitle('Dashboard', 'View All Stats');
        return view('admin.teacherpanel.dashboard.index',compact('attendanceTeacher'));
    }
    
    public function saveattendance(Request $request){
        
        $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
        $status = 1;
        $teacherdata =  DB::table('teacherattendance')->where('teacher_id',$teacherId)->whereDate('created_at', Carbon::today())->get();
        if(count($teacherdata) > 0){
            
          DB::table('teacherattendance')->where('teacher_id',$teacherId)
            ->whereDate('created_at', Carbon::today())->update(['attendance_status' => $status , 'avail_time' => Carbon::now()]);
            
             return response()->json(['Success' => true , 'msg' => 'Successfully Save Attendance Status']);
        }
        

        
    }
    

    
}

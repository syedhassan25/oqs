<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\BaseController;
use App\models\Employee;
use App\models\Student;
use App\models\User;
use Auth;
use Carbon\Carbon;
use Datatables;
use DateTime;
use DateTimeZone;
use DB;
use Hash;
use Illuminate\Http\Request;
use Validator;
use Config;
class ClassController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Classes', 'View All Clasess');
        return view('admin.teacherpanel.class.index');
    }
    
   public function get_current_classes(){
       
        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');
       
       $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
        
        //   $Class = DB::table('studentattendance')->select(['student.*','studentattendance.day_name',DB::raw('TIME_FORMAT(studentattendance.attdendance_time,"%H:%i %p") as attdendancetime')])

        $Class = DB::table('studentattendance')->select(['student.group','student.studentname','student.id','studentattendance.day_name','studentattendance.attendance_time_text as attdendancetime'])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->where('studentattendance.teacher_id', $teacherId)
             ->whereRaw("(student.academicStatus = 1 || student.academicStatus = 8 )")
            ->whereDate('studentattendance.created_at', Carbon::today());
            
        if($timeZoneChangeEuropeStatus){
              $Class->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 660+student.duration MINUTE),'%Y-%m-%d %T')");
        }else{
              $Class->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 600+student.duration MINUTE),'%Y-%m-%d %T')");
        }

       $Class->orderby('studentattendance.attdendance_time', 'asc');

        return Datatables::of($Class)
            
            ->addColumn('studentprofile', function ($Class) {

                $editurl = route('teacherpanel.student.detail', $Class->id);
                

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .=  '<a href="'.$editurl.'">'.$Class->studentname.'</a>' ;
                // }

                return $ret;

            })
           

            ->rawColumns(['studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
   }
    
    
    
    public function get_today_classes()
    {


        $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
        
        //   $Class = DB::table('studentattendance')->select(['student.*','studentattendance.day_name',DB::raw('TIME_FORMAT(studentattendance.attdendance_time,"%H:%i %p") as attdendancetime')])

        $Class = DB::table('studentattendance')->select(['student.group','student.studentname','student.id','studentattendance.day_name','studentattendance.attendance_time_text as attdendancetime'])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->where('studentattendance.teacher_id', $teacherId)
             ->whereRaw("(student.academicStatus = 1 || student.academicStatus = 8 )")
            ->whereDate('studentattendance.created_at', Carbon::today())
            // ->whereRaw("DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 645 MINUTE),'%h:%i %p') BETWEEN  date_format(date_add(studentattendance.attdendance_time,INTERVAL +11 HOUR),'%h:%i %p') AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL +11 HOUR),'%Y-%m-%d'),' ',studentattendance.attdendance_time),INTERVAL +700+student.duration MINUTE),'%h:%i %p')")
            
            //   ->whereRaw("DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 660 MINUTE),'%h:%i %p') BETWEEN  date_format(date_add(studentattendance.attdendance_time,INTERVAL +0 MINUTE),'%h:%i %p') AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL +11 HOUR),'%Y-%m-%d'),' ',studentattendance.attdendance_time),INTERVAL +student.duration MINUTE),'%h:%i %p')")
             ->orderby('studentattendance.attdendance_time', 'asc');

        return Datatables::of($Class)
            
            ->addColumn('studentprofile', function ($Class) {

                $editurl = route('teacherpanel.student.detail', $Class->id);
                

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .=  '<a href="'.$editurl.'">'.$Class->studentname.'</a>' ;
                // }

                return $ret;

            })
           

            ->rawColumns(['studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    
    public function get_recovery_classes(){
         $teacherId = Employee::where('user_id',Auth::user()->id)->first()->id;
           $nowdate = Carbon::today();
         $recovery_class = DB::table('recovery_class')->select(['recovery_class.*','student.studentname','student.group','recoveryteacher.employeename as recoveryteachername','employees.employeename as currentteachername',
         DB::raw('TIME_FORMAT(recovery_class.time,"%H:%i %p") as classtime')
         ])
         ->leftjoin('student','recovery_class.studentid','=','student.id')
         ->leftjoin('employees as recoveryteacher','recovery_class.recoveryteacherid','=','recoveryteacher.id')
         ->leftjoin('employees','recovery_class.currentTeacherid','=','employees.id')
         ->where('recovery_class.recoveryteacherid', $teacherId);
        //  ->whereRaw("DATE_FORMAT(recovery_class.date,'%Y-%m-%d') = DATE_FORMAT('$nowdate','%Y-%m-%d')");
        //  ->whereDate('recovery_class.date', "'$nowdate'");
       
        //  ->whereRaw("DATE_FORMAT(recovery_class.date,'%d-%m-%Y') = DATE_FORMAT('$nowdate','%d-%m-%Y')");
         
          return Datatables::of($recovery_class)
            
            ->addColumn('studentprofile', function ($recovery_class) {

                $editurl = route('teacherpanel.student.detail', $recovery_class->studentid);
                

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .=  '<a href="'.$editurl.'">'.$recovery_class->studentname.'</a>' ;
                // }

                return $ret;

            })
           

            ->rawColumns(['studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
}
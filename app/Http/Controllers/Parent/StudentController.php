<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\BaseController;
use App\models\Ethics;
use App\models\Fundamentalislam;
use App\models\LessonNew;
use App\models\Memorization;
use App\models\Parents;
use App\models\Student;
use App\models\StudentDaysHistory;
use App\models\Subject;
use App\models\User;
use Auth;
use Carbon\Carbon;
use Config;
use Datatables;
use DB;
use Illuminate\Http\Request;

class StudentController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Student', 'View All Student');
        return view('include.rolebase-views.parentpanel.student.index');
    }

    public function studentdetail($id)
    {
        $StudentEl = Student::with(['studentdays', 'language', 'teacher'])->find($id);
        $this->setPageTitle('Student', 'Detail Student : ' . $StudentEl->studentname);

        $course = DB::table('course')->get();
        $Subject = Subject::get();
        $Subjectquran = Subject::where('course_id', 1)->get();
        $SubjectQaida = Subject::where('course_id', 4)->get();
        $SubjectHadeeth = Subject::where('course_id', 3)->get();
        $SubjectLangauges = Subject::where('course_id', 5)->get();
        $quranhifz = Subject::where('course_id', 1)->whereIn('id', [30, 29, 28, 27])->get();

        //   $quranhifz = [];
        $Memorizationdata = Memorization::get();
        $Fundamentalislam = Fundamentalislam::get();
        $Ethicsdata = Ethics::get();

        return view('include.rolebase-views.parentpanel.student.detail', compact('StudentEl', 'quranhifz', 'Subjectquran', 'SubjectQaida', 'SubjectHadeeth', 'SubjectLangauges', 'course', 'Memorizationdata', 'Fundamentalislam', 'Ethicsdata', 'Subject'));
    }

    public function studentdata()
    {
        $std = Student::with(['studentdays', 'teacher', 'country', 'city', 'language', 'attendance', 'lesson'])->limit(10)->get();

        $json_pretty = json_encode($std, JSON_PRETTY_PRINT);
        echo "<pre>" . $json_pretty . "<pre/>";

    }

    public function get_student_schdule_forms(Request $request)
    {

        $groupno = Parents::where('user_id', Auth::user()->id)->first()->groupno;

        $Student = Student::select(['student.group', 'student.studentname', 'student.id', 'student.duration', 'countries.CountryName', 'employees.employeename', 'studentdays.*'])
            ->selectRaw('GROUP_CONCAT(DISTINCT(l.languagename))  as languages')
            ->selectRaw('(CASE
        WHEN student.class_type = 1 THEN "Trial"
        ELSE "Regular"
    END) as class_status')
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->leftjoin('student_language_lookups as sll', 'student.id', '=', 'sll.student_id')
            ->leftjoin('languages as l', 'l.id', '=', 'sll.language_id')
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        $Student->where('student.group', $groupno);
        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5)->groupBy('student.id');

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('parentpanel.student.detail', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('day', function ($Student) {

                $editurl = '';
                $days = explode(',', $Student->days);
                $studentdays = explode(',', $Student->studentdays_name);
                $local_time_text = explode(',', $Student->local_time_text);
                $student_time_text = explode(',', $Student->student_time_text);

                $ret = '<table style="font-size:10px !important;text-align:center !important">';

                foreach ($days as $index => $val) {

                    $studentdaysss = (isset($studentdays[$index])) ? ($studentdays[$index] != "") ? substr($studentdays[$index], 0, 3) : 'no' : 'no';
                    $ret .= '<td>';
                    $ret .= '<table class="table-bordered">';
                    $ret .= '<tr><td style="padding:5px;" >' . substr($studentdays[$index], 0, 3) . '</td></tr>';
                    $ret .= '<tr><td style="padding:5px;" >' . $student_time_text[$index] . '</td></tr>';
                    $ret .= '</table>';
                    $ret .= '</td>';

                }
                $ret .= '</tr>';
                $ret .= '</table>';

                return $ret;

            })

            ->addColumn('detail', function ($Student) {

                $editurl = route('parentpanel.student.detail', $Student->id);

                $ret = '';

                $ret .= '<a class="btn btn-primary" href="' . $editurl . '">detail</a>';

                return $ret;

            })

            ->rawColumns(['studentprofile', 'day', 'detail'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_all_classes(Request $request)
    {

        $student_id = $request->student_id;

        //   DB::raw("date_format(date_add(studentattendance.updated_at,INTERVAL +660 MINUTE),'%h:%i %p') as attdendancetime ")

        $Class = DB::table('studentattendance')->select(['student.*', 'studentattendance.attendance_date_time', 'studentattendance.id as attendanceid', 'studentattendance.isDeduct', 'studentattendance.attendance_status', 'studentattendance.student_day_name', 'studentattendance.attendance_time_text as classtime', 'employees.employeename', 'attendance_status.status_name', 'attendance_status.color'
            , DB::raw("date_format(studentattendance.attendance_avail,'%h:%i %p') as attdendancetime")
            , DB::raw("date_format(studentattendance.created_at,'%Y-%m-%d') as attendancedate"),
        ])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentattendance.teacher_id')
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status');
        $Class->where('studentattendance.student_id', $student_id);
        $Class->orderby('studentattendance.attendance_date_time', 'desc');

        return Datatables::of($Class)

            ->addColumn('studentprofile', function ($Class) {

                $editurl = "";
                if ($Class->id) {
                    $editurl = route('admin.student.edit', $Class->id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Class->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('attendancestatusColor', function ($Class) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<span id="attendancestatus' . $Class->attendanceid . '" data-color="' . $Class->color . '" style="background-color:' . $Class->color . ' !important" class="badge">' . $Class->status_name . '</span>';
                // }

                return $ret;

            })
            ->addColumn('action', function ($Class) {

                $ret = '';

                return $ret;

            })
            ->addColumn('isLesson', function ($Class) {

                $rec = DB::table('student_lesson_new')->select(['id', 'student_id', DB::raw("date_format(student_lesson_new.created_at,'%Y-%m-%d') as lessondate")])->where('student_id', $Class->id)->whereRaw("date_format(student_lesson_new.created_at,'%Y-%m-%d') = date_format('$Class->attendancedate','%Y-%m-%d') ")->first();

                $ret = '';
                if ($rec) {
                    $ret .= '<button class="btn btn-primary btneditleson" data-id="' . $rec->id . '">Yes</button>';
                } else {
                    $ret .= '<button class="btn btn-danger">No</button>';
                }

                return $ret;

            })
            ->addColumn('timeConvertclasstime', function ($Class) {

                return Converttimezone($Class->attendance_date_time, 'Asia/Tashkent', $Class->timezone);

                // return  date('Y-m-d H:i:s', strtotime($Class->attendance_date_time));

                // $user_date = date('Y-m-d H:i:s', strtotime(($Class->attendance_date_time)));
                // $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, 'Asia/Tashkent');
                // $utc_date->setTimezone('UTC');

                // $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $utc_date, 'UTC');
                // $user_date->setTimezone($Class->timezone);

                // # check the user date
                //   return   Carbon::createFromFormat('Y-m-d H:i:s',$user_date)->format('h:i A');

            })
            ->addColumn('timeConvert', function ($Class) {

                // return  date('Y-m-d H:i:s', strtotime($Class->attendance_date_time));

                $user_date = date('Y-m-d H:i:s', strtotime(($Class->attendance_date_time)));
                $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, 'Asia/Tashkent');
                $utc_date->setTimezone('UTC');

                $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $utc_date, 'UTC');
                $user_date->setTimezone($Class->timezone);

                # check the user date
                return Carbon::createFromFormat('Y-m-d H:i:s', $user_date)->format('d-m-Y');

                // return Carbon::parse('2022-03-22 12:30:00'.' '.$Class->timezone)->tz('UTC');

                //   return  Carbon('YYYY-MM-DD HH:II:SS', 'America/Los_Angeles');

            })
            ->rawColumns(['studentprofile', 'attendancestatusColor', 'action', 'isLesson', 'timeConvert', 'timeConvertclasstime'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        // return request()->ip(); // it will return server ip when no client ip found
    }

    public function teacherchangehistoryDatatable(Request $request)
    {

        $stdid = $request->id;

        // return $request->getClientIps().'--'.$request->ip().'--'.$this->getIp().'--'.$this->get_client_ip();

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {
            $Student = DB::table('teacherchange')->select(['teacherchange.*', 'student.timezone', 'reason.reason', 'users.name as creatorname', 'oldteacher.employeename as oldteachername', 'newteacher.employeename as newteachername', DB::raw("date_format(date_add(teacherchange.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")]);
        } else {
            $Student = DB::table('teacherchange')->select(['teacherchange.*', 'student.timezone', 'reason.reason', 'users.name as creatorname', 'oldteacher.employeename as oldteachername', 'newteacher.employeename as newteachername', DB::raw("date_format(date_add(teacherchange.created_at,INTERVAL +10 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")]);
        }

        $Student->leftjoin('employees as oldteacher', 'oldteacher.id', '=', 'teacherchange.teacher_id')
            ->leftjoin('student', 'teacherchange.student_id', '=', 'student.id')
            ->leftjoin('employees as newteacher', 'newteacher.id', '=', 'teacherchange.newteacher_id')
            ->leftjoin('reason', 'reason.id', '=', 'teacherchange.reason_id')
            ->leftjoin('users', 'users.id', '=', 'teacherchange.created_by')
            ->where('teacherchange.student_id', $stdid)
            ->orderby('teacherchange.created_at', 'desc');

        return Datatables::of($Student)
            ->addColumn('timeConvertclasstime', function ($Student) {

                return Converttimezone($Student->createt_at_new, 'Asia/Tashkent', $Student->timezone);

                // $user_date = date('Y-m-d H:i:s', strtotime(($Student->createt_at_new)));
                // $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, 'Asia/Tashkent');
                // $utc_date->setTimezone('UTC');

                // $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $utc_date, 'UTC');
                // $user_date->setTimezone($Student->timezone);

                // # check the user date
                //   return   Carbon::createFromFormat('Y-m-d H:i:s',$user_date)->format('Y-m-d h:i A');

            })
            ->rawColumns(['timeConvertclasstime'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_all_days_history_bystudent(Request $request)
    {

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        $id = $request->id;

        if ($timeZoneChangeEuropeStatus) {
            $daysHistory = StudentDaysHistory::select(['studentDayshistory.*', DB::raw("date_format(date_add(studentDayshistory.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")])->with(['Student']);
        } else {
            $daysHistory = StudentDaysHistory::select(['studentDayshistory.*', DB::raw("date_format(date_add(studentDayshistory.created_at,INTERVAL +10 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")])->with(['Student']);
        }
        $daysHistory->where('studentDayshistory.student_id', $id);
        $daysHistory->orderby('studentDayshistory.created_at', 'desc');

        return Datatables::of($daysHistory)

            ->addColumn('day', function ($daysHistory) {

                $editurl = '';
                if (isset($daysHistory->id)) {
                    $editurl = route('admin.student.edit', $daysHistory->id);
                }

                $days = json_decode($daysHistory->days, true);
                // $studentdays = explode(',', $Student->studentdays_name);
                // $local_time_text = explode(',', $Student->local_time_text);
                // $student_time_text = explode(',', $Student->student_time_text);

                $ret = '<table style="font-size:10px !important;text-align:center !important">';

                $ret .= '<tr>';

                $ret .= '<td>';
                $ret .= '<table class="table-bordered">';
                $ret .= '<tr><td style="padding:5px;">' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td style="padding:5px;">Local</td></tr>';
                $ret .= '<tr><td style="padding:5px;">' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td style="padding:5px;">Student</td></tr>';
                $ret .= '</table>';
                $ret .= '</td>';
                foreach ($days as $index => $val) {

                    $ret .= '<td>';
                    $ret .= '<table class="table-bordered">';
                    $ret .= '<tr><td style="padding:5px;">' . $val['day_name'] . '</td></tr>';
                    $ret .= '<tr><td style="padding:5px;">' . $val['local_time_text'] . '</td></tr>';
                    $ret .= '<tr><td style="padding:5px;">' . $val['student_day_name'] . '</td></tr>';
                    $ret .= '<tr><td style="padding:5px;">' . $val['student_time_text'] . '</td></tr>';
                    $ret .= '</table>';
                    $ret .= '</td>';

                }
                $ret .= '</tr>';
                $ret .= '</table>';

                return $ret;

            })
            ->addColumn('timeConvertclasstime', function ($daysHistory) {
                return Converttimezone($daysHistory->createt_at_new, 'Asia/Tashkent', $daysHistory->Student->timezone);
            })
            ->rawColumns(['teacherprofile', 'day', 'timeConvertclasstime'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_lesson_forms(Request $request)
    {

        $id = $request->id;
        $lesson = LessonNew::select(['student_lesson_new.*', 'ethics.ethicsname', 'course.courseName as courseName', 'fundamental_islam.fundamental_islam_name as fundamental_islam_name', 'memorization.memorizationname as memorizationname', DB::raw('(CASE WHEN student_lesson_new.accent_type = 1 THEN "Asian" ELSE "Arabic" END) AS accent'), DB::raw('(CASE WHEN student_lesson_new.startlesson = 1 THEN "Start TO End" ELSE "End TO Start" END) AS start_to_from')
            , DB::raw("date_format(date_add(student_lesson_new.created_at,INTERVAL +0 HOUR),'%d-%m-%Y %h:%i %p') as created_at_new"),
        ])->with(['Student'])
            ->leftJoin('users', 'student_lesson_new.created_by', '=', 'users.id')
            ->leftJoin('course', 'course.id', '=', 'student_lesson_new.course_id')
            ->leftJoin('fundamental_islam', 'fundamental_islam.id', '=', 'student_lesson_new.fundamental_islam_id')
            ->leftJoin('memorization', 'memorization.id', '=', 'student_lesson_new.memorization_id')
            ->leftJoin('ethics', 'ethics.id', '=', 'student_lesson_new.ethics_id')
            ->where('student_lesson_new.student_id', $id)->orderby('id', 'desc');

        return Datatables::of($lesson)
            ->addColumn('action', function ($lesson) {

                $ret = '';

                $ret .= '<button type="button" class="btn btm-primary btneditleson" data-id="' . $lesson->id . '" >View detail</button>';

                return $ret;

            })
            ->addColumn('timeConvertclasstime', function ($lesson) {
                return Converttimezone($lesson->created_at, 'Asia/Tashkent', $lesson->Student->timezone);
            })

            ->rawColumns(['action', 'timeConvertclasstime'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
}

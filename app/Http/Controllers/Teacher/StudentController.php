<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\BaseController;
use App\models\Employee;
use App\models\Ethics;
use App\models\Fundamentalislam;
use App\models\Lesson;
use App\models\LessonNew;
use App\models\Memorization;
use App\models\Student;
use App\models\StudentAttendance;
use App\models\Subject;
use App\models\User;
use Auth;
use Carbon\Carbon;
use Config;
use Datatables;
use DB;
use Illuminate\Http\Request;
use Validator;

class StudentController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Dashboard', 'View All Students');
        return view('admin.teacherpanel.student.index');
    }

    public function saveattendance(Request $request)
    {

        $teacherId = Employee::where('user_id', Auth::user()->id)->first()->id;
        $student_id = $request->studentid;
        $status = $request->status;
        $attendanceid = $request->attendanceid;
        $comment = $request->comment;

        $teacherStudentclassesdata = DB::table('studentattendance')->where('id', $attendanceid)->where('student_id', $student_id)->where('teacher_id', $teacherId)
            ->whereDate('created_at', Carbon::today())
            ->get();

        if (count($teacherStudentclassesdata) > 0) {

            if ($status == 3 && $comment == "") {
                return response()->json(['Success' => 'false', 'msg' => 'Please Must Fill Comment Box']);
            }
            DB::table('studentattendance')->where('id', $attendanceid)->where('student_id', $student_id)->where('teacher_id', $teacherId)
                ->whereDate('created_at', Carbon::today())
                ->update(['comment' => $comment, 'attendance_status' => $status, 'attendance_avail' => Carbon::now(), 'created_by' => Auth::user()->id]);

            $attendid = $teacherStudentclassesdata[0]->id;

            DB::table('attendance_mark_history')->insert(['teacher_id' => $teacherId, 'status' => $status, 'attendance_id' => $attendid, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => Auth::user()->id]);

            $status_name = DB::table('attendance_status')->select(['status_name'])->where('status', $status)->first()->status_name;

            return response()->json(['Success' => 'true', 'msg' => 'Successfully Save Attendance Status', 'status_name' => $status_name]);
        }

        return response()->json(['Success' => 'false', 'msg' => 'Today is Not Class Time']);

    }
    public function saveattendancecomment(Request $request)
    {

        $teacherId = Employee::where('user_id', Auth::user()->id)->first()->id;
        $student_id = $request->studentid;
        $status = $request->status;
        $attendanceid = $request->attendanceid;
        $comment = $request->comment;

        $teacherStudentclassesdata = DB::table('studentattendance')->where('id', $attendanceid)->where('student_id', $student_id)->where('teacher_id', $teacherId)
        // ->whereDate('created_at', Carbon::today())
            ->get();

        if (count($teacherStudentclassesdata) > 0) {
            DB::table('studentattendance')->where('id', $attendanceid)->where('student_id', $student_id)->where('teacher_id', $teacherId)
            // ->whereDate('created_at', Carbon::today())
                ->update(['comment' => $comment]);
            return response()->json(true);
        }

        return response()->json(['Success' => 'false', 'msg' => 'Today is Not Class Time']);
    }
    public function detail($id)
    {
        $nowdate = Carbon::today()->format('Y-m-d');
        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        $teacherId = Employee::where('user_id', Auth::user()->id)->first()->id;

        $studentIsteach = Student::where('teacher_id', $teacherId)->where('id', $id)->get();
        if (count($studentIsteach) == 0) {
           $recoveryClass_counter =  DB::table('recovery_class')->where('studentid',$id)->whereDate('date', '=', $nowdate)->get();
        //    return $recoveryClass_counter;
           if (count($recoveryClass_counter) == 0) {
                return redirect()->route('teacherpanel.class.index');
            }
        }

        $lastAttendanceId = DB::table('studentattendance')->where('studentattendance.teacher_id', $teacherId)
            ->where('studentattendance.student_id', $id)->orderby('id', 'desc')->first();
        if ($lastAttendanceId) {
            $lastAttendanceId = $lastAttendanceId->id;
        } else {
            $lastAttendanceId = 0;
        }

        

        $Student = DB::Select("select GROUP_CONCAT(DISTINCT(l.languagename))  as languages,GROUP_CONCAT(stddays.student_day_name) studentdays_name, GROUP_CONCAT(DISTINCT(stddays.day_name))  as days,GROUP_CONCAT(stddays.local_time_text) local_time_text,student.*  from student
        left join   student_days  stddays on stddays.student_id = student.id
        left join   student_language_lookups as stl on stl.student_id = student.id
        LEFT JOIN  languages  l  on l.id = stl.language_id
        WHERE student.id = $id ");

        $currenttime = Carbon::now();
        $currentdate = Carbon::today();

        //   $teacherStudentclassesdata =  DB::table('studentattendance')->where('teacher_id',$teacherId)->whereDate('created_at', Carbon::today())->get();

        $teacherStudentclassesdata = DB::table('studentattendance')->select(['studentattendance.*'])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->whereDate('studentattendance.created_at', Carbon::today())
            ->where('studentattendance.teacher_id', $teacherId);
        //  ->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 660+student.duration MINUTE),'%Y-%m-%d %T')")->get();

        //   ->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 600+student.duration MINUTE),'%Y-%m-%d %T')")->get();

        if ($timeZoneChangeEuropeStatus) {
            $teacherStudentclassesdata = $teacherStudentclassesdata->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_sub(NOW(),INTERVAL 215 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_sub(NOW(),INTERVAL 200+student.duration MINUTE),'%Y-%m-%d %T')")->get();
        } else {
            $teacherStudentclassesdata = $teacherStudentclassesdata->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_sub(NOW(),INTERVAL 215 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_sub(NOW(),INTERVAL 200+student.duration MINUTE),'%Y-%m-%d %T')")->get();
        }

        $teacherStudentclasses = [];
        foreach ($teacherStudentclassesdata as $val) {

            $teacherStudentclasses[] = $val;
        }

        //   $teacherStudentclasses = "select * from studentattendance where teacher_id =  $teacherId and date(created_at)= '"$currentdate"'";

        //  $teacherStudentclassesdata =  DB::table('studentattendance')->where('student_id',$id)->where('teacher_id',$teacherId)->whereDate('created_at', Carbon::today())->get();

        $teacherStudentclassesdata = DB::table('studentattendance')->select(['studentattendance.*'])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->whereDate('studentattendance.created_at', Carbon::today())
            ->where('studentattendance.teacher_id', $teacherId)
            ->where('studentattendance.student_id', $id);

        if ($timeZoneChangeEuropeStatus) {
            $teacherStudentclassesdata = $teacherStudentclassesdata->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_sub(NOW(),INTERVAL 215 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_sub(NOW(),INTERVAL 200+student.duration MINUTE),'%Y-%m-%d %T')")->get();
        } else {
            $teacherStudentclassesdata = $teacherStudentclassesdata->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_sub(NOW(),INTERVAL 215 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_sub(NOW(),INTERVAL 200+student.duration MINUTE),'%Y-%m-%d %T')")->get();
        }

        if (count($teacherStudentclassesdata) > 0) {
            $status_name = DB::table('attendance_status')->select(['status_name'])->where('status', $teacherStudentclassesdata[0]->attendance_status)->first()->status_name;
        } else {
            $status_name = 'none';
        }

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
        $this->setPageTitle('Student Detail', '');
        return view('admin.teacherpanel.student.detail', compact('lastAttendanceId', 'quranhifz', 'Subjectquran', 'SubjectQaida', 'SubjectHadeeth', 'SubjectLangauges', 'course', 'Memorizationdata', 'Fundamentalislam', 'Ethicsdata', 'Subject', 'Student', 'currenttime', 'teacherStudentclasses', 'status_name'));

    }

    public function get_student_schdule_forms(Request $request)
    {

        $teacherId = Employee::where('user_id', Auth::user()->id)->first()->id;

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

        $Student->where('student.teacher_id', $teacherId);
        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5)->groupBy('student.id');

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('teacherpanel.student.detail', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('day', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->id);
                }

                $days = explode(',', $Student->days);
                $studentdays = explode(',', $Student->studentdays_name);
                $local_time_text = explode(',', $Student->local_time_text);
                $student_time_text = explode(',', $Student->student_time_text);

                $ret = '<table style="font-size:10px !important;text-align:center !important">';
                // $ret .= '<tr>';

                // $ret .= '<td>';
                // $ret .= '<table class="table-bordered">';
                // $ret .= '<tr><td>Day</td></tr>';
                // $ret .= '<tr><td>Local</td></tr>';

                // $ret .= '</table>';
                // $ret .= '</td>';
                foreach ($days as $index => $val) {

                    $studentdaysss = (isset($studentdays[$index])) ? ($studentdays[$index] != "") ? substr($studentdays[$index], 0, 3) : 'no' : 'no';
                    $ret .= '<td>';
                    $ret .= '<table class="table-bordered">';
                    $ret .= '<tr><td>' . substr($days[$index], 0, 3) . '</td></tr>';
                    $ret .= '<tr><td>' . $local_time_text[$index] . '</td></tr>';
                    $ret .= '</table>';
                    $ret .= '</td>';

                }
                $ret .= '</tr>';
                $ret .= '</table>';

                return $ret;

            })

            ->rawColumns(['action', 'studentprofile', 'day'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_lesson_forms(Request $request)
    {

        $id = $request->id;
        $lesson = Lesson::select(['student_lesson.*'
            , DB::raw("date_format(date_add(student_lesson.created_at,INTERVAL +0 HOUR),'%d-%m-%Y %h:%i %p') as created_at_new")
        ])
            ->leftJoin('users', 'student_lesson.created_by', '=', 'users.id')
            ->where('student_lesson.student_id', $id)->orderby('id', 'desc');

        return Datatables::of($lesson)
            ->addColumn('action', function ($lesson) {

                $ret = '';

                //           $ret = '';

                $leassondatetime = $lesson->leassondatetime;
                $start_date = strtotime($leassondatetime);
                $currentTime = strtotime(date("Y/m/d H:i:s"));
                // $lateminutes = (int)$since_start->i;

                $lateminutes = ($currentTime - $start_date) / 60;

                if ($lateminutes >= 0 && $lateminutes <= 1440) {

                    $ret .= '<button class="btn btm-primary btneditleson" data-id="' . $lesson->id . '" >Edit</button>';

                }

                //         $leassondatetime = $lesson->leassondatetime;
                //         $start_date = new DateTime($leassondatetime);
                //         $since_start = $start_date->diff(new DateTime());
                //         $lateminutes = (int)$since_start->i;
                //         if($lateminutes <= 84600){

                //               $ret .= $lateminutes;

                //         }

                // if($lesson->leassondate == $lesson->currentdate){

                //      $ret .= '<button class="btn btm-primary btneditleson" data-id="'.$lesson->id.'" >Edit</button>';

                // }

                return $ret;

            })

            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function savelesson(Request $request)
    {
        $rules = array(
            'Lesson' => "required",
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

            $Lesson = new Lesson();
            $Lesson->comments = $request->Lesson;
            $Lesson->student_id = $request->student_id;
            if ($request->id) {
                $Lesson->id = $request->id;
                $Lesson->exists = true;
            }
            $Lesson->attendance_id = $request->lastattendance_id;
            $Lesson->created_by = Auth::user()->id;
            $Lesson->save();

            DB::commit();

            return response()->json([
                'Success' => 'true', 'msg' => 'Successfully Save Lesson']);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'Error' => $e]);
        }
    }

    public function savelessonnew(Request $request)
    {
        $rules = array(
            'course' => "required|numeric|min:1|max:7",
            'accent_type' => "required|numeric|min:1|max:2",
        );

        if ($request->course == 1) {
            $rules['quransubject'] = "required|numeric|min:1";
            $rules['quranjuznumber'] = "required|numeric|min:1";
            $rules['quranstartpage'] = "required|numeric|min:1";
            $rules['quranendpage'] = "required|numeric|min:1";
            $rules['quranstartaya'] = "required|numeric|min:1";
            $rules['quranendaya'] = "required|numeric|min:1";
            $rules['startlesson'] = "required|numeric|min:1|max:2";

        }

        if ($request->course == 2) {
            $rules['quranhifzsubject'] = "required|numeric|min:1";
            $rules['quranhifzpageline'] = "required";
            $rules['quranhifzsabaq'] = "required";
            $rules['quranhifzsabaqjuznumber'] = "required|numeric|min:1";
            $rules['quranhifzsabaqstartpage'] = "required|numeric|min:1";
            $rules['quranhifzsabaqendpage'] = "required|numeric|min:1";
            $rules['quranhifzsabaqstartaya'] = "required|numeric|min:1";
            $rules['quranhifzsabaqendaya'] = "required|numeric|min:1";

            $rules['quranhifzsabaqi'] = "required";
            $rules['quranhifzsabaqijuznumber'] = "required|numeric|min:1";
            $rules['quranhifzsabaqistartpage'] = "required|numeric|min:1";
            $rules['quranhifzsabaqiendpage'] = "required|numeric|min:1";
            $rules['quranhifzsabaqistartaya'] = "required|numeric|min:1";
            $rules['quranhifzsabaqiendaya'] = "required|numeric|min:1";

            $rules['quranhifzmanzil'] = "required";
            $rules['quranhifzmanziljuznumber'] = "required|numeric|min:1";
            $rules['quranhifzmanzilstartpage'] = "required|numeric|min:1";
            $rules['quranhifzmanzilendpage'] = "required|numeric|min:1";
            $rules['quranhifzmanzilstartaya'] = "required|numeric|min:1";
            $rules['quranhifzmanzilendaya'] = "required|numeric|min:1";

        }

        if ($request->course == 3) {
            $rules['hadeethsubject'] = "required|numeric|min:1";
            $rules['hadeethstartpage'] = "required|numeric|min:1";
            $rules['hadeethendpage'] = "required|numeric|min:1";
            $rules['hadeethstartline'] = "required|numeric|min:1";
            $rules['hadeethendline'] = "required|numeric|min:1";

        }

        if ($request->course == 4) {
            $rules['qaidasubject'] = "required|numeric|min:1";
            $rules['qaidachapterlesson'] = "required|numeric|min:1";
            $rules['qaidastartpage'] = "required|numeric|min:1";
            $rules['qaidaendpage'] = "required|numeric|min:1";
            $rules['qaidastartline'] = "required|numeric|min:1";
            $rules['qaidaendline'] = "required|numeric|min:1";
        }

        if ($request->course == 5) {
            $rules['languagesubject'] = "required|numeric|min:1";
            $rules['languagestartpage'] = "required|numeric|min:1";
            $rules['languageendpage'] = "required|numeric|min:1";
            $rules['languagestartline'] = "required|numeric|min:1";
            $rules['languageendline'] = "required|numeric|min:1";
        }
        if ($request->course == 6) {
            $rules['islamichistorybook'] = "required|min:1";
            $rules['islamichistorypage'] = "required|numeric|min:1";
        }
        if ($request->course == 7) {
            $rules['islamicKnowledgebook'] = "required|min:1";
            $rules['islamicKnowledgepage'] = "required|numeric|min:1";
        }

        if ($request->fundamentalislam) {

            $rules['fundamentalislam'] = "required|numeric|min:1";
            $rules['fundamentalislamstartpage'] = "required|numeric|min:1";
            $rules['fundamentalislamendpage'] = "required|numeric|min:1";
            $rules['fundamentalislamstartline'] = "required|numeric|min:1";
            $rules['fundamentalislamendline'] = "required|numeric|min:1";
        }

        if ($request->memorizarion) {

            $rules['memorizarion'] = "required|numeric|min:1";

            if ($request->memorizarion == 1) {
                $rules['kalma'] = "required|numeric|min:1";
                $rules['kalmastartmark'] = "required|numeric|min:1";
                $rules['kalmaendmark'] = "required|numeric|min:1";
            }
            if ($request->memorizarion == 2) {
                $rules['masnoonduapageno'] = "required|numeric|min:1";
                $rules['masnoonduaduano'] = "required";
            }
           if($request->memorizarion == 3){
                $rules['surahname'] = "required";
                $rules['surahstartaya'] = "required|numeric|min:1";
                $rules['surahendaya'] = "required|numeric|min:1";
             }
             if($request->memorizarion == 4){
                $rules['duaname'] = "required";
                $rules['duanamestartline'] = "required|numeric|min:1";
                $rules['duanameendline'] = "required|numeric|min:1";
             }
             if($request->memorizarion == 5){
                $rules['longsurahname'] = "required";
                $rules['longsurahstartaya'] = "required|numeric|min:1";
                $rules['longsurahendaya'] = "required|numeric|min:1";
             }

        }

        if ($request->ethics) {
            $rules['ethics'] = "required|numeric|min:1";
            $rules['ethicsstartpage'] = "required|numeric|min:1";
            $rules['ethicsendpage'] = "required|numeric|min:1";
            $rules['ethicsstartline'] = "required|numeric|min:1";
            $rules['ethicsendline'] = "required|numeric|min:1";
        }

        $messages = [
            'required' => 'required',
            'string' => 'The :attribute must be text format',
            'file' => 'The :attribute must be a file',
            'mimes' => 'Supported file format for :attribute are :mimes',
            'max' => 'Enter less value :max',
            'min' => 'Enter greater value :min',
            'numeric' => 'required numeric',
        ];

        //  $messages = [
        //   'required' => 'The :attribute field is required',
        //   'string'    => 'The :attribute must be text format',
        //   'file'    => 'The :attribute must be a file',
        //   'mimes' => 'Supported file format for :attribute are :mimes',
        //   'max'      => 'The :attribute must have a maximum length of :max',
        // ];

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

            $teacherId = Employee::where('user_id', Auth::user()->id)->first()->id;

            if ($request->course == 1) {

                $datacheck = DB::table('student_lesson_new')
                    ->where('teacher_id', $teacherId)
                    ->where('student_id', $request->student_id)
                    ->where('subject_id', $request->quransubject)
                    ->where('juz_number', $request->quranjuznumber)
                    ->where('startpage_course', $request->quranstartpage)
                    ->where('endpage_course', $request->quranendpage)
                    ->where('startaya_course', $request->quranstartaya)
                    ->where('endaya_course', $request->quranendaya)->get();

                if (count($datacheck) > 0) {
                    return response()->json([
                        'Success' => false, 'msg' => 'You Cant Add Same Previous Lesson']);
                }

            }
            if ($request->course == 4) {

                $datacheck = DB::table('student_lesson_new')
                    ->where('teacher_id', $teacherId)
                    ->where('student_id', $request->student_id)
                    ->where('subject_id', $request->qaidasubject)
                    ->where('startpage_course', $request->qaidastartpage)
                    ->where('endpage_course', $request->qaidaendpage)
                    ->where('startline_course', $request->qaidastartline)
                    ->where('endline_course', $request->qaidaendline)
                    ->where('qaidachapterlesson', $request->qaidachapterlesson)->get();
                if (count($datacheck) > 0) {
                    return response()->json([
                        'Success' => 'false', 'msg' => 'You Cant Add Same Previous Lesson']);
                }

            }

            if ($request->id) {
                DB::statement("UPDATE `student_lesson_new` SET `startlesson` = '',  `subject_id` = '', `juz_number` = '', `startpage_course` = '', `endpage_course` = '', `startaya_course` = '', `endaya_course` = '', `accent_type` = '', `comments` = '', `created_by` = '' WHERE `student_lesson_new`.`id` = " . $request->id);
            } else {

                //              $currendate = date('Y-m-d');
                //              $checklessonExist = DB::table('student_lesson_new')->where('student_id',$request->student_id)
                //  ->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') = DATE_FORMAT('$currendate'),'%Y-%m-%d')")->get();
                //  if(count($checklessonExist) > 0){
                //       return response()->json(['Success' => 'true' , 'msg' => 'Today Lesson Already Added']);
                //   }

            }

            $Lesson = new LessonNew();
            $Lesson->teacher_id = $teacherId;
            $Lesson->student_id = $request->student_id;
            $Lesson->course_id = $request->course;
            $Lesson->startlesson = $request->startlesson;

            if ($request->course == 1) {
                $Lesson->subject_id = $request->quransubject;
                $Lesson->juz_number = $request->quranjuznumber;
                $Lesson->startpage_course = $request->quranstartpage;
                $Lesson->endpage_course = $request->quranendpage;
                $Lesson->startaya_course = $request->quranstartaya;
                $Lesson->endaya_course = $request->quranendaya;
                $Lesson->comments_course = $request->qurancomments;

            }

            if ($request->course == 2) {

                $Lesson->subject_id = $request->quranhifzsubject;
                $Lesson->quranhifzpageline = $request->quranhifzpageline;
                $Lesson->juz_number = $request->quranhifzsabaqjuznumber;
                $Lesson->startpage_course = $request->quranhifzsabaqstartpage;
                $Lesson->endpage_course = $request->quranhifzsabaqendpage;
                $Lesson->startaya_course = $request->quranhifzsabaqstartaya;
                $Lesson->endaya_course = $request->quranhifzsabaqendaya;

                $Lesson->sabaqi_juz_number = $request->quranhifzsabaqijuznumber;
                $Lesson->sabaqi_start_page = $request->quranhifzsabaqistartpage;
                $Lesson->sabaqi_end_page = $request->quranhifzsabaqiendpage;
                $Lesson->sabaqi_start_aya = $request->quranhifzsabaqistartaya;
                $Lesson->sabaqi_end_aya = $request->quranhifzsabaqiendaya;

                $Lesson->manzil__juz_number = $request->quranhifzmanziljuznumber;
                $Lesson->manzil_start_page = $request->quranhifzmanzilstartpage;
                $Lesson->manzil_end_page = $request->quranhifzmanzilendpage;
                $Lesson->manzil_start_aya = $request->quranhifzmanzilstartaya;
                $Lesson->manzil_end_aya = $request->quranhifzmanzilendaya;

                $Lesson->comments_course = $request->quranhifzcomments;

            }

            if ($request->course == 3) {

                $Lesson->subject_id = $request->hadeethsubject;
                $Lesson->startpage_course = $request->hadeethstartpage;
                $Lesson->endpage_course = $request->hadeethendpage;
                $Lesson->startline_course = $request->hadeethstartline;
                $Lesson->endline_course = $request->hadeethendline;
                $Lesson->comments_course = $request->hadeethcomments;

            }

            if ($request->course == 4) {

                $Lesson->subject_id = $request->qaidasubject;
                $Lesson->startpage_course = $request->qaidastartpage;
                $Lesson->endpage_course = $request->qaidaendpage;
                $Lesson->startline_course = $request->qaidastartline;
                $Lesson->endline_course = $request->qaidaendline;
                $Lesson->comments_course = $request->qaidacomments;
                $Lesson->qaidachapterlesson = $request->qaidachapterlesson;
            }

            if ($request->course == 5) {

                $Lesson->subject_id = $request->languagesubject;
                $Lesson->startpage_course = $request->languagestartpage;
                $Lesson->endpage_course = $request->languageendpage;
                $Lesson->startline_course = $request->languagestartline;
                $Lesson->endline_course = $request->languageendline;
                $Lesson->comments_course = $request->languagecomments;

            }

            if ($request->course == 6) {

                $Lesson->islamic_history_book = $request->islamichistorybook;
                $Lesson->startpage_course = $request->islamichistorypage;
                $Lesson->comments_course = $request->islamichistorycomments;
            }
            if ($request->course == 7) {

                $Lesson->islamic_knowlege_book = $request->islamicKnowledgebook;
                $Lesson->startpage_course = $request->islamicKnowledgepage;
                $Lesson->comments_course = $request->islamicKnowledgecomments;

            }

            if ($request->fundamentalislam) {
                $Lesson->fundamental_islam_id = $request->fundamentalislam;
                $Lesson->startpage_fundamentalislam = $request->fundamentalislamstartpage;
                $Lesson->endpage_fundamentalislam = $request->fundamentalislamendpage;
                $Lesson->startline_fundamentalislam = $request->fundamentalislamstartline;
                $Lesson->endline_fundamentalislam = $request->fundamentalislamendline;
            }

            if ($request->memorizarion) {

                $Lesson->memorization_id = $request->memorizarion;

                if ($request->memorizarion == 1) {

                    $Lesson->kalma_no = $request->kalma;
                    $Lesson->startmark = $request->kalmastartmark;
                    $Lesson->endmark = $request->kalmaendmark;

                }
                if ($request->memorizarion == 2) {

                    $Lesson->pageno_masnoondua = $request->masnoonduapageno;
                    $Lesson->dua_no_masnoondua = $request->masnoonduaduano;

                }
                
                if($request->memorizarion == 3){
                
                    $Lesson->surah_name_shortsurah = $request->surahname ; 
                    $Lesson->startaya_shortsurah = $request->surahstartaya ; 
                    $Lesson->endaya_shortsurah = $request->surahendaya ; 
                    
                 }
                 if($request->memorizarion == 5){
                    
                    $Lesson->surah_name_shortsurah = $request->longsurahname ; 
                    $Lesson->startaya_shortsurah = $request->longsurahstartaya ; 
                    $Lesson->endaya_shortsurah = $request->longsurahendaya ; 
                    
                 }
                if ($request->memorizarion == 4) {
                    $Lesson->dua_Name_mainduas = $request->duaname;
                    $Lesson->startline_mainduas = $request->duanamestartline;
                    $Lesson->endline_mainduas = $request->duanameendline;
                }

            }

            if ($request->ethics) {
                $Lesson->ethics_id = $request->ethics;
                $Lesson->startpage_ethics = $request->ethicsstartpage;
                $Lesson->endpage_ethics = $request->ethicsendpage;
                $Lesson->startline_ethics = $request->ethicsstartline;
                $Lesson->endline_ethics = $request->ethicsendline;
            }

            $Lesson->comments = $request->comments;
            $Lesson->accent_type = $request->accent_type;
            if ($request->id) {
                $Lesson->id = $request->id;
                $Lesson->exists = true;
                // $Lesson->updated_at = Carbon::now();
            } else {
                // $Lesson->created_at = Carbon::now();

                $Lesson->lesson_date = Carbon::now();
            }

            $Lesson->attendance_id = $request->lastattendance_id;
            $Lesson->created_by = Auth::user()->id;
            $Lesson->save();

            // $Lesson->ethics_id = $request-> ;
            // $Lesson->startpage_ethics = $request-> ;
            // $Lesson->endpage_ethics = $request-> ;
            // $Lesson->startline_ethics = $request-> ;
            // $Lesson->endline_ethic = $request-> ;

            //     $Lesson = new Lesson();
            //     $Lesson->student_id = $request->student_id;
            //     $Lesson->chapter = $request->chapter;
            //     $Lesson->subject_id = $request->subject;

            //     $Lesson->fundamental_islam_id = $request->fundamentalislam;
            //     $Lesson->ethics_id = $request->ethics;
            //     $Lesson->memorization_id = $request->memorizationLesson;
            //     $Lesson->start_to_end = $request->startlesson;
            //     $Lesson->average = $request->average;
            //     $Lesson->page_to_from = $request->frompage;
            //     $Lesson->ayah_line = $request->fromayah;
            //     $Lesson->memorization = $request->memorization;
            //     $Lesson->memorization_detail = $request->memorizationdetail;
            //     $Lesson->accent_type = $request->accent_type;
            //     if($request->id){
            //         $Lesson->id = $request->id;
            //         $Lesson->exists = true;
            //     }
            //     $Lesson->save();

            DB::commit();

            return response()->json([
                'Success' => true, 'msg' => 'Successfully Save Lesson']);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'Error' => $e]);
        } catch (\Exception $e) {
            // DB::rollback();
            return response()->json([
                'Error' => '33']);
        }

    }

    public function getlastlesson($id)
    {
        return Lesson::where('student_id', $id)->orderby('id', 'desc')->first();
    }

    public function editlesson($id)
    {
        return Lesson::where('id', $id)->first();
    }

    public function Classtodaymonitoring()
    {

        $this->setPageTitle('Students Today Classes Lesson ', 'List  of all Students Today Classes Lesson');

        return view('admin.teacherpanel.student.todaylesson');

    }
    public function get_today_classes(Request $request)
    {

        $teacherID = Employee::where('user_id', Auth::user()->id)->first()->id;

        $Class = StudentAttendance::select(['student.*', 'studentattendance.attendance_date_time', 'studentattendance.comment as attendancecomment', 'studentattendance.id as attendanceid', 'studentattendance.isDeduct', 'studentattendance.attendance_status', 'studentattendance.day_name', 'studentattendance.attendance_time_text as classtime', 'employees.employeename', 'attendance_status.status_name', 'attendance_status.color'
            , DB::raw("date_format(studentattendance.attendance_avail,'%h:%i %p') as attdendancetime")
            , DB::raw("date_format(studentattendance.created_at,'%Y-%m-%d') as attendancedate"),
        ])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentattendance.teacher_id')
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status');
        $Class->where('studentattendance.teacher_id', $teacherID);
        $Class->where('studentattendance.attendance_status','!=',9);
        $Class->whereDate('studentattendance.attendance_date_time', Carbon::today());

        $Class->orderby('studentattendance.attendance_date_time', 'asc');

        return Datatables::of($Class)

            ->addColumn('studentprofile', function ($Class) {

                $editurl = "";
                if ($Class->id) {
                    $editurl = route('teacherpanel.student.detail', $Class->id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Class->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('isLesson', function ($Class) {

                $rec = DB::table('student_lesson_new')->select(['id', 'student_id', DB::raw("date_format(student_lesson_new.created_at,'%Y-%m-%d') as lessondate")])->where('student_id', $Class->id)->whereRaw("date_format(student_lesson_new.created_at,'%Y-%m-%d') = date_format('$Class->attendancedate','%Y-%m-%d') ")->first();

                $ret = '';
                if ($rec) {
                    $ret .= '<button class="btn btn-primary" data-id="' . $rec->id . '">Yes</button>';
                } else {
                    $ret .= '<button class="btn btn-danger">No</button>';
                }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'isLesson'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

}

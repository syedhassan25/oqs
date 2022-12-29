<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentAttendanceExport;
use App\Http\Controllers\BaseController;
use App\models\AdvertisementAgencies;
use App\models\City;
use App\models\Country;
use App\models\Employee;
use App\models\Ethics;
use App\models\FcmNotification;
use App\models\Fundamentalislam;
use App\models\Language;
use App\models\LessonNew;
use App\models\Memorization;
use App\models\Package;
use App\models\RecoveryClass;
use App\models\RegisterPackage;
use App\models\SchduleStudentdemo;
use App\models\Student;
use App\models\StudentAttendance;
use App\models\StudentLanguageLookup;
use App\models\Studentmeetingschdule;
use App\models\Subject;
use App\models\Task;
use App\models\taskAssign;
use App\models\User;
use Auth;
use Carbon\Carbon;
use Config;
use Datatables;
use DateTime;
use DateTimeZone;
use DB;
use Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class StudentController extends BaseController
{

    public function export_attendace()
    {
        return Excel::download(new StudentAttendanceExport, 'studentattendance.xlsx');
    }

    public function get_recovery_classes(Request $request)
    {

        $studentid = $request->id;

        $Class = RecoveryClass::with(['Currentteacher', 'Recoveryteacher'])->where('studentid', $studentid);

        return Datatables::of($Class)

            ->addColumn('Currentteacherprofile', function ($Class) {

                $editurl = "";
                if ($Class->currentteacher->id) {
                    $editurl = route('admin.student.edit', $Class->id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Class->currentteacher->employeename . '</a>';
                // }

                return $ret;

            })
            ->addColumn('Recoveryteacherprofile', function ($Class) {

                $editurl = "";
                if ($Class->recoveryteacher->id) {
                    $editurl = route('admin.student.edit', $Class->id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Class->recoveryteacher->employeename . '</a>';
                // }

                return $ret;

            })
            ->rawColumns(['Currentteacherprofile', 'Recoveryteacherprofile'])
            ->make(true);

    }

    public function saveFollowUpAttendanceCommentForm(Request $request)
    {

        $rules = array(
            'comment' => 'required',
            'id' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $studentSchd = DB::table('student_follow_up_comments')->insert([
                'student_id' => $request->id,
                'comments' => $request->comment,
                'created_by' => auth()->id(),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (!$studentSchd) {
                return response()->json([
                    'success' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Comment Save Successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function getStudentFollowUpAttendanceCommentsforms(Request $request)
    {
        $Student = DB::table('student_follow_up_comments')->select(['student_follow_up_comments.*', 'users.name'])
            ->leftjoin('users', 'users.id', '=', 'student_follow_up_comments.created_by');
        $Student->where('student_follow_up_comments.student_id', $request->id)
            ->orderby('student_follow_up_comments.created_at', 'desc');

        return Datatables::of($Student)->make(true);

    }

    public function compareDate($date1, $date2)
    {
        return strtotime($date1) - strtotime($date2);
    }

    public function getTestingData()
    {

        $Studentdata = Student::select(['student.studentname', 'studentdays.*', 'student.trial_started_date'])
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_no) daynos,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })->where('trial_started_date', '!=', '')->get();

        foreach ($Studentdata as $index => $Student) {

            $ret = '';

            $days = explode(',', $Student->daynos);
            $daysinner = explode(',', $Student->daynos);
            $daynames = explode(',', $Student->days);
            $studentdays = explode(',', $Student->studentdays_name);
            $local_time_text = explode(',', $Student->local_time_text);
            $student_time_text = explode(',', $Student->student_time_text);
            $alldays = [1, 2, 3, 4, 5, 6, 7];
            if (count($days) > 0) {

                $firstday = $days[0];
                $lastday = $days[count($days) - 1];
                $todayday = date('N');

                $Date = $Student->trial_started_date;
                $datearrray = [];
                for ($i = 0; $i < count($alldays); $i++) {
                    for ($j = 0; $j < count($days); $j++) {
                        if ($alldays[$i] == $days[$j]) {
                            if ($j != 0) {
                                //   echo $daynames[$j].'<br/>';
                                //   echo date( 'Y-m-d', strtotime($Date.''.$daynames[$j].'  today' ) ).'<br/>';
                                $datearrray[] = date('Y-m-d', strtotime($Date . '' . $daynames[$j] . '  today'));
                            }
                        }
                    }
                }

                usort($datearrray, array($this, 'compareDate'));
                $lastdatearray = " ";
                if (count($datearrray)) {
                    $lastdatearray = $datearrray[count($datearrray) - 1];
                }
                // $ret = $lastdatearray;

                $Studentdata[$index]['datesarray'] = $lastdatearray;

                // $daynameval  =  $dayname[count($days) - 1] ;
                // if($lastday  > $todayday){
                //     if($firstday  < $todayday){
                //       $lastday = $lastday - $todayday;
                //         if($lastday  == 1){
                //             $Studentdata[$index]->trailendingdate = date('Y-m-d', strtotime( $daynameval.'  today' ) );
                //         }

                //         $Studentdata[$index]->check = 'next week';
                //         $Studentdata[$index]->firstday = $firstday;
                //         $Studentdata[$index]->lastday = $lastday;
                //         $Studentdata[$index]->todayday = $todayday;

                //         $Studentdata[$index]->daynameval = $daynameval;
                //     }

                // }else{
                //   $Studentdata[$index]->trailendingdate =  date( 'Y-m-d', strtotime( $daynameval.' previous week' ) );
                //     $Studentdata[$index]->previous = 'previous week';
                //     $Studentdata[$index]->firstday = $firstday;
                //     $Studentdata[$index]->lastday = $lastday;
                //     $Studentdata[$index]->todayday = $todayday;
                // }

            }

        }

        return $Studentdata;

    }

    public function getSideBarStats()
    {
        $studentarray = Student::select('id')->where('academicStatus', 1)->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(2), Carbon::now()->endOfMonth()])->pluck('id');

        $Student = Student::select(['student.*', 'countries.CountryName', DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')])
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id');
        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5);
        $Student->groupBy('student.id');
        $Student->having(DB::raw(' sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END)'), '=', 0);
        $Student->orderby('student.id', 'desc');
        $studentPendingCount = $Student->get();

        $Student = Student::select(['student.*', 'countries.CountryName', 'studentdays.*', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')])
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id')
            ->join(DB::raw('(SELECT COUNT(student_id) Totalday,student_id FROM `student_days` GROUP BY student_id) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->join(DB::raw('(SELECT student_id, MIN(created_at) latestattendance FROM studentattendance  GROUP BY student_id) lastattendance'),
                function ($join) {
                    $join->on('student.id', '=', 'lastattendance.student_id');
                });
        $Student->whereIn('student.id', $studentarray);
        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5);
        $Student->groupBy('studentattendance.student_id');
        $Student->havingRaw('(sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) <  studentdays.Totalday  &&  totaldaycount <= 14 ) &&  sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END)  >=1 ');
        $Student = $Student->orderby('student.id', 'desc')->get();

        return response()->json([
            'studentPendingCount' => count($studentPendingCount),
            'studentStarttrailcount' => count($Student),
        ]);

    }

    public function report_grade_name($val)
    {
        return DB::table('reportGrade')->where('grade_val', $val)->first()->grade;
    }

    public function get_agency_name($val)
    {
        return DB::table('advertisement_agencies')->where('id', $val)->first()->agencyname;
    }

    public function StudentTestAttendreportedit(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->id;
            //   $studentdata = DB::table('studentattendance')->select(['student.*','employees.employeename'])->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')->where('student.id',$id)->first();

            $studentdata = Db::table('reportTestTbl')->select(['student.id as studentid', 'student.studentname', 'student.age', 'student.joining_date', 'employees.employeename', 'reportTestTbl.*', 'reportTestTbl.8SurahHifzComplete as SurahHifzComplete8'
                , 'reportTestTbl.8SurahHifzRemarks as SurahHifzRemarks8', 'reportTestTbl.20SurahHifzComplete as SurahHifzComplete20', 'reportTestTbl.20SurahHifzRemarks as SurahHifzRemarks20',
            ])
                ->leftjoin('student', 'reportTestTbl.studentId', '=', 'student.id')
                ->leftjoin('employees', 'employees.id', '=', 'reportTestTbl.teacherId')->where('reportTestTbl.id', $id)->first();

            $totalClassess = DB::table('studentattendance')->select([DB::raw('sum(CASE WHEN studentattendance.attendance_status = 1 then 1 ELSE 0 END)  AS totalPresentattendance'), DB::raw('count(*)  AS totalattendance'), DB::raw('sum(CASE WHEN studentattendance.attendance_status != 1 then 1 ELSE 0 END)  AS totalAbsentattendance')])->where('student_id', $studentdata->studentid)->groupBy('studentattendance.student_id')->first();

            $totalClassessaftertest = DB::table('studentattendance')->select([DB::raw('sum(CASE WHEN studentattendance.attendance_status = 1 then 1 ELSE 0 END)  AS totalPresentattendance'), DB::raw('count(*)  AS totalattendance'), DB::raw('sum(CASE WHEN studentattendance.attendance_status != 1 then 1 ELSE 0 END)  AS totalAbsentattendance')])
                ->where('student_id', $studentdata->studentid)
                ->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') BETWEEN DATE_FORMAT(DATE_SUB('$studentdata->examination_date', INTERVAL 3 MONTH),'%Y-%m-%d') AND DATE_FORMAT('$studentdata->examination_date','%Y-%m-%d')")
                ->groupBy('studentattendance.student_id')->first();

            return compact('studentdata', 'totalClassess', 'totalClassessaftertest');
        }
    }

    public function studentReportResult()
    {
        $grade = DB::table('reportGrade')->get();
        $this->setPageTitle('Student Test Result', 'List  of all  Student Test Result');
        return view('admin.student.studentReportResult', compact('grade'));
    }

    public function get_test_student_save(Request $request)
    {

        $Student = Db::table('reportTestTbl')->select(['student.*', 'reportTestTbl.id as reportTestID', 'reportTestTbl.Conduct', 'reportTestTbl.Cooperative', 'reportTestTbl.Punctual', 'reportTestTbl.Attentive', 'reportTestTbl.GoodListener', 'reportTestTbl.HardWorking', 'reportTestTbl.PoliteAndKind'])
            ->leftjoin('student', 'reportTestTbl.studentId', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'reportTestTbl.teacherId');
        $Student->orderby('reportTestTbl.examination_date', 'desc');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $ret = '';

                $ret .= $this->academic_status_name($Student->academicStatus);

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                // $editurl = route('demonstrationpanel.student.editnewform', $Student->id);

                $editurl = '#';

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('detail', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button class="btn btn-primary viewReportID" data-id="' . $Student->reportTestID . '" >View Exam</button>';
                // }

                return $ret;

            })
            ->addColumn('Conduct', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->Conduct);

                return $ret;

            })
            ->addColumn('Cooperative', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->Cooperative);

                return $ret;

            })
            ->addColumn('Punctual', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->Punctual);

                return $ret;

            })
            ->addColumn('Attentive', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->Attentive);

                return $ret;

            })
            ->addColumn('GoodListener', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->GoodListener);

                return $ret;

            })
            ->addColumn('HardWorking', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->HardWorking);

                return $ret;

            })
            ->addColumn('PoliteAndKind', function ($Student) {

                $ret = '';

                $ret .= $this->report_grade_name($Student->PoliteAndKind);

                return $ret;

            })
            ->rawColumns(['action', 'studentprofile', 'detail', 'Conduct', 'Cooperative', 'Punctual', 'Attentive', 'GoodListener', 'HardWorking', 'PoliteAndKind'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function getStudentReportCommentsforms(Request $request)
    {
        $Student = DB::table('reportStudentCommentHistory')->select(['reportStudentCommentHistory.*', 'users.name'])
            ->leftjoin('users', 'users.id', '=', 'reportStudentCommentHistory.created_by');
        $Student->where('reportStudentCommentHistory.studentId', $request->id)
            ->orderby('reportStudentCommentHistory.created_at', 'desc');

        return Datatables::of($Student)->make(true);

    }

    public function last3daysAttendanceStatus()
    {

        $student = Student::select(['student.*'])->with(['teacher'])->where('academicStatus', 1)->get();
        $studentattenacedata = array();
        $i = 0;
        foreach ($student as $index => $stddata) {
            $studentattendance = DB::table('studentattendance')->where('student_id', $stddata->id)->whereDate('studentattendance.created_at', '!=', Carbon::today())->orderby('studentattendance.created_at', 'desc')->limit(3)->get();
            $esitattend = true;
            $counter = 0;
            foreach ($studentattendance as $stdattendance) {
                if ($stdattendance->attendance_status == 1 || $stdattendance->attendance_status == 8) {
                    $esitattend = false;
                    break;
                } else {
                    $counter++;
                }
            }
            //   $studentattenacedata[$i][] =  $stddata;

            if ($esitattend == true) {
                if ($counter >= 3) {

                    $studentattenacedata[$i]['counter'] = $counter;
                    $studentattenacedata[$i]['student_id'] = $stddata->id;
                    $studentattenacedata[$i]['fathername'] = $stddata->fathername;
                    $studentattenacedata[$i]['group'] = $stddata->group;
                    $studentattenacedata[$i]['contact_no'] = $stddata->contact_no;
                    $studentattenacedata[$i]['studentname'] = $stddata->studentname;
                    $studentattenacedata[$i]['teacher'] = $stddata->teacher;

                    $i++;
                }

            }
        }

        // dd($studentattenacedata);
        // die();

        $this->setPageTitle(' Last Three Attendance Status. Except Online', 'Days Attendance');
        return view('admin.student.last3daysAttendanceStatus', compact('studentattenacedata'));
    }

    public function getAttendanceStatusExceptOnlineforms(Request $request)
    {
        $Student = Student::select(['student.*', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status != 1 then 1 ELSE 0 END)  AS totalattendance')])
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id');
        $Student->whereRaw('date(studentattendance.created_at) > DATE_SUB(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"), INTERVAL 3 DAY)');
        $Student->whereDate('studentattendance.created_at', '!=', Carbon::today());
        $Student->groupBy('studentattendance.student_id');
        $Student->havingRaw('totalattendance >= 3');
        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('totalattendance', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<span class="badge badge-warning">' . $Student->totalattendance . '</span>';
                // }

                return $ret;

            })
            ->addColumn('attendancebtn', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a  class="btn btn-primary btnattendancehisotoryclick"  data-id="' . $Student->id . '"  href="#" >View</a>';
                // }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'totalattendance', 'attendancebtn'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function GetExceptActiveAttendanceHistory(Request $request)
    {

        return StudentAttendance::select(['studentattendance.*', 'attendance_status.status_name', 'attendance_status.color'])
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status')
            ->where('studentattendance.student_id', $request->id)
        // ->whereRaw('date(studentattendance.created_at) > DATE_SUB(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"), INTERVAL 3 DAY)')
            ->orderby('studentattendance.created_at', 'desc')
        //   ->limit(3)
            ->get();

    }

    public function generateAttendance(Request $request)
    {

        $now = Carbon::today()->format('Y-m-d');
        $resStudentAttendance = DB::table('student_days')->select(['student_days.*'])
            ->leftjoin('student', 'student.id', '=', 'student_days.student_id')
            ->where('student.academicStatus', 1)
            ->whereRaw("student_days.day_name = dayname('$now')")->get();

        $arrr = [];

        foreach ($resStudentAttendance as $val) {

            $rescheckattendance = DB::table('studentattendance')->select(['studentattendance.*'])
                ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
                ->where('student.academicStatus', 1)
                ->where('studentattendance.teacher_id', $val->teacher_id)->where('studentattendance.student_id', $val->student_id)->whereDate('studentattendance.created_at', Carbon::today())->get();

            if (count($rescheckattendance) == 0) {

                $arrr[] = [
                    'teacher_id' => $val->teacher_id,
                    'student_id' => $val->student_id,
                    'day' => $val->day_no,
                    'day_name' => $val->day_name,
                    'student_day' => $val->student_day_no,
                    'student_day_name' => $val->student_day_name,
                    'attdendance_time' => $val->local_time,
                    'attendance_time_text' => $val->local_time_text,
                    'attendance_status' => 9,
                    'attendance_type' => 1,
                    'attendance_date_time' => Carbon::now()->toDateString() . ' ' . $val->local_time,
                    'created_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                DB::table('studentattendance')->where('student_id', $val->student_id)->whereDate('created_at', Carbon::today())->delete();

            }

        }

        DB::table('studentattendance')->insert($arrr);

        return response()->json(['success' => true]);

    }

    public function DeleteGenerateAttendance(Request $request)
    {

        DB::table('studentattendance')->where('attendance_status', 9)->whereDate('created_at', Carbon::today())->delete();
        return response()->json(['success' => true]);
    }

    public function GetAttendanceHistory(Request $request)
    {
        //  DB::raw("date_format(DATE_ADD(attendance_mark_history.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d %h:%i %p') as attendancedate")

        return DB::table('attendance_mark_history')->select(['attendance_mark_history.*', 'attendance_status.status_name', 'attendance_status.color', DB::raw("date_format(attendance_mark_history.created_at,'%Y-%m-%d %h:%i %p') as attendancedate")])->leftjoin('attendance_status', 'attendance_status.status', '=', 'attendance_mark_history.status')->where('attendance_id', $request->id)->orderby('attendance_mark_history.id', 'asc')->get();

    }

    public function getAgencyName($param)
    {

        $stats = '';
        if ($param == 9) {
            $stats = "Web";
        } else if ($param == 10) {
            $stats = "B Marketing";
        } else if ($param == 11) {
            $stats = "A Marketing";
        } else if ($param == 12) {
            $stats = "C Marketing";
        } else if ($param == 1) {
            $stats = "Referral";
        }

        return $stats;
    }

    public function AcademichistorystatsBydate(Request $request)
    {

        $agencyName = $this->getAgencyName($request->type);

        $this->setPageTitle($agencyName . ' ' . $this->academic_status_name($request->status) . ' Academic  Stats', 'List  of all Academic ' . $this->academic_status_name($request->status) . '  Stats');

        $teacher = Employee::select(['employees.*'])->where('employees.role_type', 'teacher')->get();
        $reason = DB::table('reason')->get();

        return view('admin.student.academicStatusHistory', compact('teacher', 'reason'));

    }

    public function saveacademicstatusbilling(Request $request)
    {

        $id = $request->id;
        $status = $request->status;

        DB::table('academicstatuschange')->where('id', $id)->update(['action_status' => $status]);

        return response()->json(['success' => true, 'msg' => 'Successfully Save Status Change']);

    }

    public function acdemichistoryDatatableforstatsbyteacher(Request $request)
    {
        $stdid = $request->status;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $type = $request->type;

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'employees.employeename', DB::raw("count(academicstatuschange.id) as totalStudent")]);
        $Student->leftjoin('student', 'academicstatuschange.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'academicstatuschange.teacher_id')
            ->where('academicstatuschange.status', $stdid);
        if (!empty($start_date) && !empty($end_date)) {
            // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");

        }

        if ($request->type) {
            if ($request->type == 1) {
                $Student->where('student.joining_source', 2);
            } else {
                $Student->where('student.joining_source', 1);
                $Student->where('student.agency_id', $request->type);
            }
        }

        if ($request->teacher) {
            $Student->where('academicstatuschange.teacher_id', $request->teacher);
        }
        $Student->groupby('academicstatuschange.teacher_id');
        $Student->orderby('academicstatuschange.created_at', 'desc');

        return Datatables::of($Student)

            ->addColumn('totalStudent', function ($Student) {

                $ret = '<button data-teachid="' . $Student->teacher_id . '" class="btn btn-primary btnopenModal">View &nbsp<span style="text-decoration:none" title="Total No Of Students" class="badge badge-success">' . $Student->totalStudent . '</span></button>';

                return $ret;

            })
            ->rawColumns(['totalStudent'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function acdemichistoryDatatableforstatsbydate(Request $request)
    {
        $stdid = $request->status;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $type = $request->type;

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {

            $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'employees.employeename', 'reason.reason', 'student.studentname', 'student.group'
                , DB::raw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') as created_new"),
            ]);

        } else {

            $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'employees.employeename', 'reason.reason', 'student.studentname', 'student.group'
                , DB::raw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 600 MINUTE),'%Y-%m-%d') as created_new"),
            ]);

        }

        $Student->leftjoin('student', 'academicstatuschange.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'academicstatuschange.teacher_id')
            ->leftjoin('reason', 'reason.id', '=', 'academicstatuschange.reason_id')
            ->where('academicstatuschange.status', $stdid);
        if (!empty($start_date) && !empty($end_date)) {
            // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");

        }

        if ($request->type) {
            if ($request->type == 1) {
                $Student->where('student.joining_source', 2);
            } else {
                $Student->where('student.joining_source', 1);
                $Student->where('student.agency_id', $request->type);
            }
        }
        $Student->where('academicstatuschange.teacher_id', $request->teacher);

        if ($request->reason) {
            $Student->where('academicstatuschange.reason_id', $request->reason);
        }

        $Student->orderby('academicstatuschange.created_at', 'desc');

        return Datatables::of($Student)->addColumn('statustext', function ($Student) {

            return $this->academic_status_name($Student->status);

        })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = "";
                if ($Student->student_id) {
                    $editurl = route('admin.student.edit', $Student->student_id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('statusaction', function ($Student) {

                $ret = "";
                $arrayenum = array(
                    'Billing Started',
                    'Billing Stopped',
                    'No Need',
                    'Task Created',
                    'Pending',
                );

                $ret .= '<select data-id="' . $Student->id . '"  data-status="' . $Student->action_status . '" class="form-control Billingstatus" name="Billingstatus">';

                $ret .= '<option value="0"> Select Billing Status</option>';

                foreach ($arrayenum as $index => $val) {

                    $value = $index + 1;

                    $sel = ($Student->action_status == $value) ? 'selected' : '';

                    $color = "black";
                    //   if($value == 1){
                    //       $color = "green";
                    //   }else if($value == 2){
                    //       $color = "red";
                    //   }else if($value == 3){
                    //       $color = "blue";
                    //   }

                    $ret .= '<option style="color:' . $color . '" data-id="' . $Student->id . '" ' . $sel . ' value="' . $value . '">' . $val . '</option>';
                }

                $ret .= '</select>';

                return $ret;

            })
            ->rawColumns(['statustext', 'studentprofile', 'statusaction'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function getStudentCommentsforms(Request $request)
    {
        $Student = DB::table('student_comment_history')->select(['student_comment_history.*', 'users.name'])
            ->leftjoin('users', 'users.id', '=', 'student_comment_history.created_by');

        $Student->where('student_comment_history.studentId', $request->id)
            ->orderby('student_comment_history.created_at', 'desc');

        return Datatables::of($Student)->make(true);

    }

    public function timeconversion()
    {
        $Country = Country::get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::get();
        $Subject = Subject::get();
        $City = [];
        $Currency = Country::first()->currency;
        $timezones = $this->timezones();
        $student_days = DB::table('student_days')->get();

        $teacher = Employee::select(['employees.*'])->where('employees.role_type', 'teacher')->get();

        $this->setPageTitle('Time Search', 'Search Student TIme');
        return view('admin.student.timeconversion', compact('teacher', 'Country', 'City', 'Agencies', 'Language', 'Subject', 'timezones', 'Currency', 'student_days'));
    }

    public function Classmonitoring()
    {

        $this->setPageTitle('Classes  Monitoring', 'List  of all Today Classess');
        $allatendancestatus = DB::table('attendance_status')->get();
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        return view('admin.student.monitoring', compact('allatendancestatus', 'Employee'));

    }

    public function get_today_classes(Request $request)
    {

        $status = $request->status;
        $teacherID = $request->teacherId;
        $classstatus = $request->classstatus;

        $Class = DB::table('studentattendance')->select(['student.*', 'studentattendance.attendance_type', 'studentattendance.attendance_time_text', 'studentattendance.duration as attendanceduration', 'studentattendance.created_at as attendancecreated_at', 'studentattendance.comment as attendancecomment', 'studentattendance.student_id', 'studentattendance.attendance_date_time', 'studentattendance.id as attendanceid', 'studentattendance.attendance_status', 'studentattendance.day_name', 'studentattendance.attendance_time_text as classtime', 'employees.employeename', 'attendance_status.status_name', 'attendance_status.color', DB::raw("date_format(studentattendance.attendance_avail,'%h:%i %p') as attdendancetime"), DB::raw("date_format(studentattendance.created_at,'%Y-%m-%d') as attendancedate")])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentattendance.teacher_id')
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status')
            ->whereDate('studentattendance.created_at', Carbon::today());

        //   $Class->whereRaw("date_format(studentattendance.attdendance_time,'%h:%i %p') BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 645 MINUTE),'%h:%i %p') AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL +660+student.duration MINUTE),'%h:%i %p')");

        // working
        //  $Class->whereRaw("DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 640 MINUTE),'%h:%i %p') BETWEEN  date_format(date_add(studentattendance.attdendance_time,INTERVAL +11 HOUR),'%h:%i %p') AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL +11 HOUR),'%Y-%m-%d'),' ',studentattendance.attdendance_time),INTERVAL +700+student.duration MINUTE),'%h:%i %p')");

        // studentattendance.attendance_date_time,'%Y-%m-%d %T'

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {
            $Class->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 630 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 660+student.duration MINUTE),'%Y-%m-%d %T')");
        } else {
            $Class->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T')  BETWEEN  DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 570 MINUTE),'%Y-%m-%d %T')  AND DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 600+student.duration MINUTE),'%Y-%m-%d %T')");
        }

        //  $Class->whereRaw("DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 645 MINUTE),'%h:%i %p') BETWEEN  date_format(date_add(studentattendance.attdendance_time,INTERVAL +0 HOUR),'%h:%i %p')  AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL +0 HOUR),'%Y-%m-%d'),' ',studentattendance.attdendance_time),INTERVAL +30+student.duration MINUTE),'%h:%i %p')");
        if ($status) {
            $Class->where('studentattendance.attendance_status', $status);
        }
        if ($teacherID) {
            $Class->where('student.teacher_id', $teacherID);
        }
        if ($classstatus) {
            $Class->where('student.class_type', $classstatus);
        }

        $Class->orderby('studentattendance.attdendance_time', 'asc');

        return Datatables::of($Class)

            ->addColumn('studentprofile', function ($Class) {

                $editurl = route('admin.student.edit', $Class->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" href="' . $editurl . '"   style="color:blue" target="_blank" >' . $Class->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('Classtypecol', function ($Class) {

                $ret = ($Class->class_type == 1) ? 'Trial' : 'Regular';

                return $ret;

            })
            ->addColumn('attendancestatusColor', function ($Class) {

                $ret = '';

                $tooltip = '';
                if ($Class->attendance_status == 3) {
                    $tooltip = 'data-html="true" data-tooltip="' . $Class->attendancecomment . '" data-tooltip-position="bottom"';
                }

                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<span  ' . $tooltip . ' id="attendancestatus' . $Class->attendanceid . '" style="background-color:' . $Class->color . ' !important" class="badge">' . $Class->status_name . '</span>';
                // }

                if ($Class->attendance_type == 2) {
                    $ret .= '<br><span style="font-weight: bold" class="">(Need To Be Recover)</span>';
                } else if ($Class->attendance_type == 3) {
                    if ($Class->status_name != "none") {
                        $ret .= '<br><span style="font-weight: bold" class="">(Recovered)</span>';
                    } else {
                        $ret .= '<br><span style="font-weight: bold" class="">(Recover Soon)</span>';
                    }

                }

                return $ret;

            })
            ->addColumn('action', function ($Class) {

                $ret = '';
                $ret .= '<button  class="btn btn-primary btngetallattendanceclick" data-id="' . $Class->student_id . '">View Attendance</button> | <button  class="btn btn-primary btnattendancehisotoryclick" data-id="' . $Class->attendanceid . '">History</button> | <button class="btn btn-primary btnattendanceclick" data-id="' . $Class->attendanceid . '">Attendance</button> | <button class="btn btn-danger btndeleteattendanceclick" data-id="' . $Class->attendanceid . '">Delete</button> | <button class="btn btn-primary btnrecoverymodal"  data-teacherid="' . $Class->teacher_id . '" data-studentid="' . $Class->id . '"  data-classtime="' . $Class->attendance_time_text . '" data-date="' . $Class->attendancecreated_at . '" data-duration="' . $Class->attendanceduration . '"  data-id="' . $Class->attendanceid . '">Transfer Class</button>&nbsp;|&nbsp;<button  class="btn btn-primary btnstudenFollowUptcommentmodal" title="Follow Up Message" style="cursor:pointer" href="#"    data-id="' . $Class->id . '">Follow up</button>';
                return $ret;

            })
            ->addColumn('empprofile', function ($Student) {

                $ret = '';
                if ($Student->teacher_id) {
                    $editurl = ($Student->teacher_id) ? route('admin.teacher.edit', $Student->teacher_id) : '#';
                    $schurl = ($Student->teacher_id) ? route('admin.teacher.student.weekly.schedule.calender', $Student->teacher_id) : '#';

                    $ret = '';
                    // if (Gate::allows('user-edit'))
                    // {
                    $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->employeename . '</a> | <a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $schurl . '">schedule</a>';
                    // }
                }

                return $ret;

            })
            ->addColumn('timeConvert', function ($Class) {

                // return  date('Y-m-d H:i:s', strtotime($Class->attendance_date_time));

                $user_date = date('Y-m-d H:i:s', strtotime(($Class->attendance_date_time)));
                $utc_date = Carbon::createFromFormat('Y-m-d H:i:s', $user_date, 'Asia/Tashkent');
                $utc_date->setTimezone('UTC');

                $user_date = Carbon::createFromFormat('Y-m-d H:i:s', $utc_date, 'UTC');
                $user_date->setTimezone($Class->timezone);

                # check the user date
                return $user_date;

                // return Carbon::parse('2022-03-22 12:30:00'.' '.$Class->timezone)->tz('UTC');

                //   return  Carbon('YYYY-MM-DD HH:II:SS', 'America/Los_Angeles');

            })

            ->rawColumns(['action', 'studentprofile', 'attendancestatusColor', 'empprofile', 'Classtypecol', 'timeConvert'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function Classallmonitoring()
    {

        $this->setPageTitle('Students Attendance ', 'List  of all Students Attendance');
        $allatendancestatus = DB::table('attendance_status')->get();
        $Employee = Employee::where('employees.role_type', 'teacher')->get();

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

        return view('admin.student.studentAttendance', compact('course',
            'Subject',
            'Subjectquran',
            'SubjectQaida',
            'SubjectHadeeth',
            'SubjectLangauges',
            'quranhifz',
            'Memorizationdata',
            'Fundamentalislam',
            'Ethicsdata', 'allatendancestatus', 'Employee'));

    }

    public function saveattendance(Request $request)
    {

        $status = $request->status;
        $attendanceID = $request->attendanceID;

        $teacherStudentclassesdata = DB::table('studentattendance')->where('id', $attendanceID)->get();

        if (count($teacherStudentclassesdata) > 0) {
            DB::table('studentattendance')->where('id', $attendanceID)->update(['attendance_status' => $status, 'attendance_avail' => Carbon::now(), 'created_by' => Auth::user()->id]);

            $attendid = $teacherStudentclassesdata[0]->id;
            $teacherId = $teacherStudentclassesdata[0]->teacher_id;

            DB::table('attendance_mark_history')->insert(['teacher_id' => $teacherId, 'status' => $status, 'attendance_id' => $attendid, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'created_by' => Auth::user()->id]);

            return response()->json(['Success' => 'true', 'msg' => 'Successfully Save Attendance Status']);
        }

        return response()->json(['Success' => 'false']);

    }
    public function deleteattendance(Request $request)
    {

        $status = $request->status;
        $attendanceID = $request->attendanceID;

        // $teacherStudentclassesdata = DB::table('studentattendance')->where('attendance_status', 9)->where('id', $attendanceID)->get();
        $teacherStudentclassesdata = DB::table('studentattendance')->where('id', $attendanceID)->get();

        if (count($teacherStudentclassesdata) > 0) {

            DB::table('studentattendance')->where('id', $attendanceID)->delete();
            return response()->json(['Success' => 'true', 'msg' => 'Successfully Attendance Delete']);
        }

        return response()->json(['Success' => 'false']);

    }

    public function get_all_classes(Request $request)
    {

        $status = $request->status;
        $teacherID = $request->teacherId;
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        //   DB::raw("date_format(date_add(studentattendance.updated_at,INTERVAL +660 MINUTE),'%h:%i %p') as attdendancetime ")

        $Class = StudentAttendance::select(['student.*', 'studentattendance.attendance_type', 'studentattendance.attendance_time_text', 'studentattendance.duration as attendanceduration', 'studentattendance.created_at as attendancecreated_at', 'studentattendance.comment as attendancecomment', 'studentattendance.id as attendanceid', 'studentattendance.isDeduct', 'studentattendance.attendance_status', 'studentattendance.day_name', 'studentattendance.attendance_time_text as classtime', 'employees.employeename', 'attendance_status.status_name', 'attendance_status.color'
            , DB::raw("date_format(studentattendance.attendance_avail,'%h:%i %p') as attdendancetime")
            , DB::raw("date_format(studentattendance.created_at,'%Y-%m-%d') as attendancedate"),
        ])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentattendance.teacher_id')
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status');

        if ($status) {
            $Class->where('studentattendance.attendance_status', $status);
        }
        if ($teacherID) {
            $Class->where('studentattendance.teacher_id', $teacherID);
        }
        if (!empty($start_date) && !empty($end_date)) {

            $start_date = Carbon::parse($start_date)->format('Y-m-d H:i:s');

            $end_date = Carbon::parse($end_date)->format('Y-m-d H:i:s');

            $Class->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T') between '$start_date' and '$end_date'");

            //  $start_date_by =   Carbon::parse($start_date)->format('Y-m-d');

            //  $end_date_by =  Carbon::parse($end_date)->format('Y-m-d');

            //     $Class->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d') between '$start_date_by' and '$end_date_by'");

            //   $start_datetime =   Carbon::parse($start_date)->format('H:i:s');

            //   $end_datetime =  Carbon::parse($end_date)->format('H:i:s');

            //     $Class->whereRaw("studentattendance.attdendance_time >= '$start_datetime' AND studentattendance.attdendance_time <= '$end_datetime'");

        } else {
            $Class->whereDate('studentattendance.created_at', Carbon::today());
        }

        $Class->orderby('studentattendance.attendance_date_time', 'asc');

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
                $tooltip = '';
                if ($Class->attendance_status == 3) {
                    $tooltip = 'data-html="true" data-tooltip="' . $Class->attendancecomment . '" data-tooltip-position="bottom"';
                }
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<span  ' . $tooltip . '  id="attendancestatus' . $Class->attendanceid . '" data-color="' . $Class->color . '" style="background-color:' . $Class->color . ' !important" class="badge">' . $Class->status_name . '</span>';
                // }

                if ($Class->attendance_type == 2) {
                    $ret .= '<br><span style="font-weight: bold" class="">(Need To Be Recover)</span>';
                } else if ($Class->attendance_type == 3) {
                    if ($Class->status_name != "none") {
                        $ret .= '<br><span style="font-weight: bold" class="">(Recovered)</span>';
                    } else {
                        $ret .= '<br><span style="font-weight: bold" class="">(Recover Soon)</span>';
                    }

                }

                return $ret;

            })
            ->addColumn('action', function ($Class) {

                $ret = '';
                $ret .= '<div class="input-group mrg15T mrg15B">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions <span class="caret"></span></button>
                                        <ul class="dropdown-menu pull-right">
                                            <li class="ms-hover"><a class="btnstudenFollowUptcommentmodal" data-id="' . $Class->id . '">Follow Up Message</a></li>
                                            <li class="ms-hover"><a class="btnattendanceclick" data-id="' . $Class->attendanceid . '">Mark Attendance</a></li>
                                            <li class="ms-hover"><a class="btnrecoverymodal"  data-teacherid="' . $Class->teacher_id . '" data-studentid="' . $Class->id . '"  data-classtime="' . $Class->attendance_time_text . '" data-date="' . $Class->attendancecreated_at . '" data-duration="' . $Class->attendanceduration . '"  data-id="' . $Class->attendanceid . '">Transfer Class</a></li>';

                //  if($Class->attendancedate == Carbon::now()->toDateString() && $Class->attendance_status  == 9){
                $ret .= '<li class="divider"></li>
                                            <li class="ms-hover"><a href="#"  data-id="' . $Class->attendanceid . '" class="btndeleteattendanceclick"  >Delete Attendance</a></li>';

                //  }

                $ret .= '</ul>
                                    </div>
                                </div>';
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
            ->addColumn('isDeductBtn', function ($Class) {

                //   $rec = DB::table('student_lesson_new')->select(['id','student_id',DB::raw("date_format(student_lesson_new.created_at,'%Y-%m-%d') as lessondate")])->where('student_id',$Class->id)->whereRaw("date_format(student_lesson_new.created_at,'%Y-%m-%d') = date_format('$Class->attendancedate','%Y-%m-%d') ")->first();

                $ret = '';
                if ($Class->isDeduct == 1) {
                    $ret .= '<button id="btndeductionamount' . $Class->attendanceid . '" class="btn btn-primary btndeductionamount" data-status="1" data-attendanceid="' . $Class->attendanceid . '">Yes</button>';
                } else {
                    $ret .= '<button id="btndeductionamount' . $Class->attendanceid . '" class="btn btn-danger btndeductionamount" data-status="2" data-attendanceid="' . $Class->attendanceid . '" >No</button>';
                }

                return $ret;

            })
            ->addColumn('History', function ($Class) {

                $ret = '<button  class="btn btn-primary btnattendancehisotoryclick" data-id="' . $Class->attendanceid . '">History</button>';

                return $ret;

            })

            ->rawColumns(['History', 'studentprofile', 'attendancestatusColor', 'action', 'isLesson', 'isDeductBtn'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_all_classesold(Request $request)
    {

        $status = $request->status;
        $teacherID = $request->teacherId;
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        //   DB::raw("date_format(date_add(studentattendance.updated_at,INTERVAL +660 MINUTE),'%h:%i %p') as attdendancetime ")

        $Class = DB::table('studentattendance')->select(['student.*', 'studentattendance.id as attendanceid', 'studentattendance.attendance_status', 'studentattendance.day_name', 'studentattendance.attendance_time_text as classtime', 'employees.employeename', 'attendance_status.status_name', 'attendance_status.color'
            , DB::raw("date_format(studentattendance.attendance_avail,'%h:%i %p') as attdendancetime")
            , DB::raw("date_format(studentattendance.created_at,'%Y-%m-%d') as attendancedate"),
        ])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status');

        if ($status) {
            $Class->where('studentattendance.attendance_status', $status);
        }
        if ($teacherID) {
            $Class->where('student.teacher_id', $teacherID);
        }
        if (!empty($start_date) && !empty($end_date)) {
            // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Class->whereRaw("Date(studentattendance.created_at) BETWEEN '$start_date' AND '$end_date'");

        } else {
            $Class->whereDate('studentattendance.created_at', Carbon::today());
        }
        $Class->orderby('studentattendance.attdendance_time', 'asc');

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
                $ret .= '<span style="background-color:' . $Class->color . ' !important" class="badge">' . $Class->status_name . '</span>';
                // }

                return $ret;

            })
            ->addColumn('action', function ($Class) {

                $ret = '';
                $ret .= '<div class="input-group mrg15T mrg15B">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Actions <span class="caret"></span></button>
                                        <ul class="dropdown-menu pull-right">
                                            <li class="ms-hover"><a class="btnattendanceclick" data-id="' . $Class->attendanceid . '">Mark Attendance</a></li>';

                if ($Class->attendancedate == Carbon::now()->toDateString() && $Class->attendance_status == 9) {
                    $ret .= '<li class="divider"></li>
                                            <li class="ms-hover"><a href="#"  data-id="' . $Class->attendanceid . '" class="btndeleteattendanceclick"  >Delete Attendance</a></li>';

                }

                $ret .= '</ul>
                                    </div>
                                </div>';
                return $ret;

            })

            ->rawColumns(['studentprofile', 'attendancestatusColor', 'action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_all_classes_bystudent(Request $request)
    {

        $status = $request->status;
        $teacherID = $request->teacherId;
        $start_date = $request->startdate;
        $end_date = $request->enddate;
        $id = $request->id;

        //   DB::raw("date_format(date_add(studentattendance.updated_at,INTERVAL +660 MINUTE),'%h:%i %p') as attdendancetime ")

        $Class = DB::table('studentattendance')->select(['student.*', 'student_days.student_time_text', 'studentattendance.attendance_type', 'studentattendance.day_name', 'studentattendance.attendance_time_text as classtime', 'employees.employeename', 'attendance_status.status_name', 'attendance_status.color'
            , DB::raw("date_format(studentattendance.attendance_avail,'%h:%i %p') as attdendancetime ")
            , DB::raw("date_format(studentattendance.created_at,'%d-%m-%Y') as created_at_attendance "),
        ])
            ->leftjoin('student', 'studentattendance.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentattendance.teacher_id')
            ->leftjoin('attendance_status', 'attendance_status.status', '=', 'studentattendance.attendance_status')
            ->leftJoin('student_days', function ($join) {
                $join->on('studentattendance.day', '=', 'student_days.day_no');
                $join->on('studentattendance.student_id', '=', 'student_days.student_id');
            });

        if ($status) {
            $Class->where('studentattendance.attendance_status', $status);
        }

        $Class->where('studentattendance.student_id', $id);

        if (!empty($start_date) && !empty($end_date)) {
            // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Class->whereRaw("Date(studentattendance.created_at) BETWEEN '$start_date' AND '$end_date'");

        }

        // else {
        //     $Class->whereDate('studentattendance.created_at', Carbon::today());
        // }
        $Class->orderby('studentattendance.created_at', 'desc');

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
                $ret .= '<span style="background-color:' . $Class->color . ' !important" class="badge">' . $Class->status_name . '</span>';

                if ($Class->attendance_type == 2) {
                    $ret .= '<br><span style="font-weight: bold" class="">(Need To Be Recover)</span>';
                } else if ($Class->attendance_type == 3) {
                    if ($Class->status_name != "none") {
                        $ret .= '<br><span style="font-weight: bold" class="">(Recovered)</span>';
                    } else {
                        $ret .= '<br><span style="font-weight: bold" class="">(Recover Soon)</span>';
                    }

                }
                // }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'attendancestatusColor'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_all_days_history_bystudent(Request $request)
    {

        $id = $request->id;

        $daysHistory = DB::table('studentDayshistory')->select(['studentDayshistory.*', 'users.name as creatorname', 'employees.employeename', 'employees.id as employeeid'
            , DB::raw("date_format(date_add(studentDayshistory.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new"),
        ])
            ->leftjoin('student', 'studentDayshistory.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentDayshistory.teacher_id')
            ->leftjoin('users', 'users.id', '=', 'studentDayshistory.created_by');
        $daysHistory->where('studentDayshistory.student_id', $id);
        $daysHistory->orderby('studentDayshistory.created_at', 'desc');

        return Datatables::of($daysHistory)

            ->addColumn('teacherprofile', function ($daysHistory) {

                $editurl = "";
                if ($daysHistory->employeeid) {
                    $editurl = route('admin.teacher.edit', $daysHistory->employeeid);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a href="' . $editurl . '">' . $daysHistory->employeename . '</a>';
                // }

                return $ret;

            })
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
                $ret .= '<tr><td>' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td>Local</td></tr>';
                $ret .= '<tr><td>' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td>Student</td></tr>';
                $ret .= '</table>';
                $ret .= '</td>';
                foreach ($days as $index => $val) {

                    $ret .= '<td>';
                    $ret .= '<table class="table-bordered">';
                    $ret .= '<tr><td>' . $val['day_name'] . '</td></tr>';
                    $ret .= '<tr><td>' . $val['local_time_text'] . '</td></tr>';
                    $ret .= '<tr><td>' . $val['student_day_name'] . '</td></tr>';
                    $ret .= '<tr><td>' . $val['student_time_text'] . '</td></tr>';
                    $ret .= '</table>';
                    $ret .= '</td>';

                }
                $ret .= '</tr>';
                $ret .= '</table>';

                return $ret;

            })
            ->rawColumns(['teacherprofile', 'day'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function SchduleForm()
    {
        $Country = Country::get();
        $this->setPageTitle('Students Schdules', 'List  of all Students Schdules');
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        $academicStatusArr = DB::table('academic_status')->get();

        return view('admin.student.schduleform', compact('academicStatusArr', 'Country', 'Employee'));
    }

    public function index(Request $request)
    {

        // $user = User::where('id', auth()->id())->first();
        // $user->givePermissionTo([31]);
        // $user->hasPermissionTo(['role-create', 'role-edit']);

        $status = '';
        if ($request->status) {

            $status = DB::table('academic_status')->where('academic_status', $request->status)->first()->academic_status_val;

            //   $status = $this->getStatus($request->status);
            // $status =  $request->status;
        }

        $groupno = '';
        if ($request->group) {

            $groupno = $request->group;

            //   $status = $this->getStatus($request->status);
            // $status =  $request->status;
        }

        $Country = Country::get();
        $academicStatusArr = DB::table('academic_status')->get();
        $timezones = $this->timezones();
        $this->setPageTitle('Students Details', 'List  of all Students Details');
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        $Agencies = AdvertisementAgencies::whereIn('id', [9, 10, 11, 12])->get();
        return view('admin.student.index', compact('academicStatusArr', 'Country', 'Employee', 'status', 'timezones', 'Agencies', 'groupno'));
    }

    public function NewForm()
    {
        $Country = Country::get();

        $timezones = $this->timezones();
        $Agencies = AdvertisementAgencies::whereIn('id', [9, 10, 11, 12])->get();
        $this->setPageTitle('New Student Form', 'List  of all New Student Form');
        return view('admin.student.newform', compact('Country', 'timezones', 'Agencies'));
    }
    public function TeacherSchduleForm()
    {
        $Country = Country::get();
        $timezones = $this->timezones();
        $this->setPageTitle('Teacher Assign Schdule  Student', 'List  of all  Student Form');
        return view('admin.student.teacherAssginSchdule', compact('Country', 'timezones'));
    }

    public function TrailPendingForm()
    {
        $Country = Country::get();
        $this->setPageTitle('Trail Pending', 'List  of all Trail Pending Student');
        return view('admin.student.trailPending', compact('Country'));
    }
    public function TrailCompletedForm()
    {
        $Country = Country::get();
        $this->setPageTitle('Trail Completed', 'List  of all Trail Completed Student');
        return view('admin.student.trailCompleted', compact('Country'));
    }

    public function TrailStartedForm()
    {
        $Country = Country::get();
        $this->setPageTitle('Trail Started', 'List  of all Trail Started Student');
        return view('admin.student.trailStarted', compact('Country'));
    }

    public function get_trailPending_forms(Request $request)
    {
        $studentarray = Student::select('id')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(2), Carbon::now()->endOfMonth()])->pluck('id');

        //   return $studentarray;

        // ->leftjoin(DB::raw('(SELECT count(student_id) as countattendance ,student_id FROM studentattendance where attendance_status = 1 GROUP BY student_id) attendance'),
        // function ($join) {
        //     $join->on('student.id', '=', 'attendance.student_id');
        // });
        // $Student->whereNull('studentattendance.student_id');
        // $Student->having(DB::raw('count(studentattendance.student_id)'), '=', 0);

        $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename', DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate'), 'studentdays.*'])
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_no) daynos,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id');
        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5);
        if ($request->date) {
            $Student->whereRaw("DATE_FORMAT(student.created_at,'%Y-%m-%d') = DATE_FORMAT('$request->date','%Y-%m-%d')");
        } else {

            // $Student->whereRaw("DATE_FORMAT(DATE_ADD(studentattendance.attendance_date_time,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  NOW() - INTERVAL 30 DAY AND NOW()");
            //  $Student->whereDate('student.created_at', Carbon::today());
        }
        $Student->whereIn('student.id', $studentarray);
        $Student->groupBy('student.id');
        $Student->having(DB::raw(' sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END)'), '=', 0);
        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('studentdetail', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button class="btn btn-primary btnstudentdetail" data-id="' . $Student->id . '">View Detail</button>';
                // }

                return $ret;

            })

            ->addColumn('trailendingdate', function ($Student) {
                $ret = '';
                $trailstart = DB::table('studentattendance')->select([DB::raw('DATE_FORMAT(studentattendance.created_at,"%d-%m-%Y") as trailstartdate')])->where('student_id', $Student->id)->orderby('id', 'asc')->first();
                // if($trailstart){
                //     $ret = $trailstart->trailstartdate;
                // }else{

                $days = explode(',', $Student->daynos);
                $daysinner = explode(',', $Student->daynos);
                $dayname = explode(',', $Student->days);
                $studentdays = explode(',', $Student->studentdays_name);
                $local_time_text = explode(',', $Student->local_time_text);
                $student_time_text = explode(',', $Student->student_time_text);

                $daynames = explode(',', $Student->days);
                $datearrray = [];
                $alldays = [1, 2, 3, 4, 5, 6, 7];
                if (count($days) > 0) {

                    $firstday = $days[0];
                    $lastday = $days[count($days) - 1];
                    $todayday = date('N');

                    $Date = $Student->trial_started_date;
                    $datearrray = [];
                    for ($i = 0; $i < count($alldays); $i++) {
                        for ($j = 0; $j < count($days); $j++) {
                            if ($alldays[$i] == $days[$j]) {
                                if ($j != 0) {
                                    $datearrray[] = date('Y-m-d', strtotime($Date . '' . $daynames[$j] . '  today'));
                                }
                            }
                        }
                    }

                }

                usort($datearrray, array($this, 'compareDate'));
                $lastdatearray = " ";
                if (count($datearrray)) {
                    $lastdatearray = $datearrray[count($datearrray) - 1];
                }
                $ret = $lastdatearray;

                // if(count($days) > 0){

                //     $firstday = $days[0];
                //     $lastday  = $days[count($days) - 1];
                //     $todayday  = date('N');

                //     // $daynameval  =  $dayname[count($days) - 1] ;
                //     // if($lastday  > $todayday){
                //     //     date( 'Y-m-d', strtotime( $daynameval.' next week' ) );
                //     // }else if($lastday  < $todayday ){
                //     //     date( 'Y-m-d', strtotime( $daynameval.' next week' ) );
                //     // }else{
                //     //     date( 'Y-m-d', strtotime( 'monday next week' ) );
                //     // }

                //     if(count($days) == 1){
                //         // foreach ($days as $index => $val) {

                //         //     if($todayday == $days[$index] && $todayday == 1){

                //         //     }
                //         //     if($todayday == $days[$index] && $todayday == 2){

                //         //     }
                //         //     if($todayday == $days[$index] && $todayday == 3){

                //         //     }
                //         //     if($todayday == $days[$index] && $todayday == 4){

                //         //     }
                //         //     if($todayday == $days[$index] && $todayday == 5){

                //         //     }
                //         //     if($todayday == $days[$index] && $todayday == 6){

                //         //     }
                //         //     if($todayday == $days[$index] && $todayday == 7){

                //         //     }

                //         // }

                //     }
                //     if(count($days) == 2){

                //     }
                //     if(count($days) == 3){

                //     }
                //     if(count($days) == 4){

                //     }
                //     if(count($days) == 5){

                //     }
                //     if(count($days) == 6){

                //     }
                //     if(count($days) == 7){

                //     }

                // }

                // foreach ($days as $index => $val) {

                //     foreach ($daysinner as $innerindex => $innerval) {

                //         $todayday  = date('N');
                //         $dayno    =  $days[$index] + 1;
                //         $daynameval  =  $dayname[$index] ;
                //         $checkday = false;
                //         if($dayno == $todayday){
                //             $daynameval = strtolower($daynameval);
                //             $ret  = date( 'Y-m-d', strtotime( 'monday next week' ) );
                //             $checkday = true;
                //         }

                //     }

                // }

                // }
                return $ret;
                // $ret = '';

                // return $ret;

            })

            ->rawColumns(['studentdetail', 'studentprofile', 'trailendingdate'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_trailcompleted_forms(Request $request)
    {
        $Student = Student::select(['student.*', 'countries.CountryName', 'studentdays.*', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')])
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id')
            ->join(DB::raw('(SELECT COUNT(student_id) Totalday,student_id FROM `student_days` GROUP BY student_id) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->join(DB::raw('(SELECT student_id, MIN(created_at) latestattendance FROM studentattendance GROUP BY student_id) lastattendance'),
                function ($join) {
                    $join->on('student.id', '=', 'lastattendance.student_id');
                });

        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5);
        if ($request->date) {
            $Student->whereRaw("DATE_FORMAT(student.created_at,'%Y-%m-%d') = DATE_FORMAT('$request->date','%Y-%m-%d')");
        }
        $Student->whereRaw('(student.billing_status = 2 ||  student.feedbackstatus = 2)');
        $Student->groupBy('studentattendance.student_id');
        // $Student->having(DB::raw('count(studentattendance.student_id) >=  studentdays.Totalday ||  studentdays.Totalday <= 20'));
        // $Student->having(DB::raw('count(studentattendance.student_id)'), '>=',DB::raw('studentdays.Totalday'));

        $Student->havingRaw('sum(CASE WHEN (`studentattendance`.attendance_status = 1 || `studentattendance`.attendance_status = 8) then 1 ELSE 0 END) >=  studentdays.Totalday ||  totaldaycount > 14 ');
        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)

            ->addColumn('Feedback', function ($Student) {

                $ret = '<button class="btn btn-primary btnfeedbackmodal" data-teacher-id="' . $Student->teacher_id . '"  data-id="' . $Student->id . '" >Save Feedback</button>';
                if ($Student->feedbackstatus == 1) {
                    $ret = "Feedback Saved";
                }

                return $ret;

            })
            ->addColumn('BillingStatus', function ($Student) {

                $billingStatus = "Deactive";
                if ($Student->billing_status == 1) {
                    $billingStatus = "Active";
                }

                $ret = '';

                $ret .= '<div class="dropdown myclassDropBiiling">
                <button class="btn btn-primary dropdown-toggle btnstatustext" type="button" data-toggle="dropdown">' . $billingStatus . '
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" class="btnbillingStart" data-status="1"  data-id="' . $Student->id . '" >Active</a></li>
                  <li><a href="#" class="btnbillingStart" data-status="2"  data-id="' . $Student->id . '" >Deactive</a></li>
                </ul>
              </div>';

                return $ret;

            })

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })

            ->rawColumns(['Feedback', 'BillingStatus', 'studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_trailstarted_forms(Request $request)
    {
        $studentarray = Student::select('id')
            ->where('academicStatus', 1)->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(2), Carbon::now()->endOfMonth()])->pluck('id');

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {
            $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename', 'studentdays.*', 'lastattendance.latestattendance', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +11 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')]);
        } else {
            $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename', 'studentdays.*', 'lastattendance.latestattendance', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')]);
        }

        $Student->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id')
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_no) daynos,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,COUNT(student_id) Totalday,student_id FROM `student_days` GROUP BY student_id) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->join(DB::raw('(SELECT student_id, MIN(created_at) latestattendance FROM studentattendance  GROUP BY student_id) lastattendance'),
                function ($join) {
                    $join->on('student.id', '=', 'lastattendance.student_id');
                });
        if ($request->date) {
            $Student->whereRaw("DATE_FORMAT(student.created_at,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')");
        } else {

            // $Student->whereDate('student.created_at', Carbon::today());
        }
        $Student->whereIn('student.id', $studentarray);
        $Student->where('student.academicStatus', 1);
        $Student->where('student.step_status', 5);
        $Student->groupBy('studentattendance.student_id');
        $Student->havingRaw('(sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) <  studentdays.Totalday  &&  totaldaycount <= 14 ) &&  sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END)  >=1 ');
        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })

            ->addColumn('trailendingdate', function ($Student) {
                $ret = '';
                // $trailstart = DB::table('studentattendance')->select([DB::raw('DATE_FORMAT(studentattendance.created_at,"%d-%m-%Y") as trailstartdate')])->where('student_id',$Student->id)->orderby('id','asc')->first();
                // if($trailstart){
                //     $ret = $trailstart->trailstartdate;
                // }else{

                $days = explode(',', $Student->daynos);
                $daysinner = explode(',', $Student->daynos);
                $dayname = explode(',', $Student->days);
                $studentdays = explode(',', $Student->studentdays_name);
                $local_time_text = explode(',', $Student->local_time_text);
                $student_time_text = explode(',', $Student->student_time_text);

                $daynames = explode(',', $Student->days);
                $datearrray = [];
                $alldays = [1, 2, 3, 4, 5, 6, 7];
                if (count($days) > 0) {

                    $firstday = $days[0];
                    $lastday = $days[count($days) - 1];
                    $todayday = date('N');

                    $Date = $Student->trial_started_date;
                    $datearrray = [];
                    for ($i = 0; $i < count($alldays); $i++) {
                        for ($j = 0; $j < count($days); $j++) {
                            if ($alldays[$i] == $days[$j]) {
                                if ($j != 0) {
                                    $datearrray[] = date('Y-m-d', strtotime($Date . '' . $daynames[$j] . '  today'));
                                }
                            }
                        }
                    }

                }

                usort($datearrray, array($this, 'compareDate'));
                $lastdatearray = " ";
                if (count($datearrray)) {
                    $lastdatearray = $datearrray[count($datearrray) - 1];
                }
                $ret = $lastdatearray;

                return $ret;

            })

            ->rawColumns(['action', 'studentprofile', 'trailendingdate'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_assingnteacher_forms(Request $request)
    {
        $Student = Student::select(['student.*', 'countries.CountryName', 'countries.zone', 'studentdays.*', DB::raw('TIME_FORMAT(student.teacheSchduletime, "%h:%i%p") teacheSchduletimenew')])
            ->selectRaw('(CASE
            WHEN student.gender = 1 THEN "Male"
            ELSE "female"
        END) as gender_type')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->where('step_status', 4)
            ->where('teacher_assign_status', 2);
        if ($request->date) {
            $Student->whereRaw("DATE_FORMAT(student.teacheSchduledate,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')");
        } else {

            //  $Student->whereRaw("DATE_FORMAT(student.teacheSchduledate,'%d-%m-%Y') = date_format(date_add(NOW(),INTERVAL +10 HOUR),'%d-%m-%Y')");

            // $Student->whereDate('student.teacheSchduledate', Carbon::today());

        }
        if ($request->time) {

            $Student->whereRaw("DATE_FORMAT(student.teacheSchduletime, '%H:%i:%s') = DATE_FORMAT(STR_TO_DATE('$request->time', '%l:%i %p' ),'%H:%i:%s')");

        }

        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Select Demo Type
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="' . $editurl . '">Start Demo</a></li>
                  <li><a href="#" data-zone="' . $Student->timezone . '" class="btnscduleDemo" data-id="' . $Student->id . '" >Schdule Demo</a></li>
                  <li><a href="#" class="btnscduleMeeting" data-id="' . $Student->id . '" >Schdule Meeting</a></li>

                </ul>
              </div>';
                // }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
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

                $ret .= '<tr>';

                $ret .= '<td>';
                $ret .= '<table class="table-bordered">';
                $ret .= '<tr><td>' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td>Local</td></tr>';
                $ret .= '<tr><td>' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td>Student</td></tr>';
                $ret .= '</table>';
                $ret .= '</td>';
                foreach ($days as $index => $val) {

                    $studentdaysss = (isset($studentdays[$index])) ? ($studentdays[$index] != "") ? substr($studentdays[$index], 0, 3) : 'no' : 'no';
                    $ret .= '<td>';
                    $ret .= '<table class="table-bordered">';
                    $ret .= '<tr><td>' . substr($days[$index], 0, 3) . '</td></tr>';
                    $ret .= '<tr><td>' . $local_time_text[$index] . '</td></tr>';
                    $ret .= '<tr><td>' . $studentdaysss . '</td></tr>';
                    $ret .= '<tr><td>' . $student_time_text[$index] . '</td></tr>';
                    $ret .= '</table>';
                    $ret .= '</td>';

                }
                $ret .= '</tr>';
                $ret .= '</table>';

                return $ret;

            })

            ->rawColumns(['action', 'day', 'studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_meeting_schdule_student_today_forms(Request $request)
    {
        $today = Carbon::today();

        $Student = Studentmeetingschdule::select(['schdule_meeting_contact_form.comment', 'schdule_meeting_contact_form.localTimeText', 'schdule_meeting_contact_form.schduleDate', 'student.*', 'countries.CountryName', 'countries.zone'])
            ->leftjoin('student', 'schdule_meeting_contact_form.studentID', '=', 'student.id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        $Student->whereDate('schdule_meeting_contact_form.schduleDate', Carbon::today());
        $innerquery = "where DATE_FORMAT(a2.schduleDate,'%d-%m-%Y') = DATE_FORMAT('$today','%d-%m-%Y')";

        $Student->where('student.academicStatus', 6);
        $Student->whereRaw('schdule_meeting_contact_form.id IN (select MAX(a2.id) from schdule_meeting_contact_form a2 ' . $innerquery . ' group by a2.studentID)');
        $Student->groupBy('schdule_meeting_contact_form.studentID')
            ->orderby('schdule_meeting_contact_form.schduleDate', 'asc')
            ->orderby('schdule_meeting_contact_form.time', 'asc')
        ;

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $editurl = route('admin.student.editnewform', $Student->id);

                $ret = '';

                $ret .= '<div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Select Demo Type
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="' . $editurl . '">Start Demo</a></li>
              <li><a href="#" data-zone="' . $Student->timezone . '" class="btnscduleDemo" data-id="' . $Student->id . '" >schdule Demo</a></li>
              <li><a href="#" class="btnscduleMeeting" data-id="' . $Student->id . '" >Rescdule Meeting</a></li>
            </ul>
          </div>';

                return $ret;

            })
            ->addColumn('commentss', function ($Student) {

                $ret = '';

                $ret .= '<button data-id="' . $Student->id . '"  class="btn btn-primary btnstudentcommentmodal">Comments</button>';

                return $ret;

            })
            ->addColumn('reference', function ($Student) {

                $ret = '';
                if ($Student->joining_source == 1) {
                    $ret .= $this->get_agency_name($Student->agency_id);
                } else {
                    $ret .= $Student->ref_email;
                }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" class="btnEditnewstudentform"  href="#" data-studenid="' . $Student->id . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->rawColumns(['studentprofile', 'action', 'commentss', 'reference'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_demo_schdule_student_today_forms(Request $request)
    {

        $latestArray = SchduleStudentdemo::select([DB::raw('max(id) as ids')])->whereDate('schduleDate', '>=', Carbon::now())->groupBy('studentID')->pluck('ids');
        $currentArray = SchduleStudentdemo::select([DB::raw('max(id) as ids')])->whereDate('schduleDate', '=', Carbon::now())->groupBy('studentID')->pluck('ids');

        // return  array_merge($latestArray, $currentArray);

        if (count($latestArray) > 0 && count($currentArray) > 0) {
            //  $currentArray  = array_unique( array_merge($latestArray, $currentArray) );
        }

        //   $currentArrayss = implode(', ', $currentArray);
        //   return  $currentArray = implode(', ', $currentArray);

        $today = Carbon::today();
        $Student = SchduleStudentdemo::select([DB::raw('max(studentdemoschdules.id) as sid'), 'studentdemoschdules.studentTimeText', 'studentdemoschdules.localTimeText', 'studentdemoschdules.schduleDate', 'student.*', 'countries.CountryName', 'countries.zone'])
            ->leftjoin('student', 'studentdemoschdules.studentID', '=', 'student.id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->where('step_status', 2)
            ->where('academicStatus', 6);

        $Student->whereDate('studentdemoschdules.schduleDate', Carbon::today());
        $innerquery = "where DATE_FORMAT(a2.schduleDate,'%d-%m-%Y') = DATE_FORMAT('$today','%d-%m-%Y')";

        $Student->whereRaw("studentdemoschdules.id IN (select MAX(a2.id) from studentdemoschdules a2 $innerquery  group by a2.studentID)");
        $Student->orderby('studentdemoschdules.schduleDate', 'asc');
        $Student->orderby('studentdemoschdules.local_Time', 'asc');
        $Student->groupBy('studentdemoschdules.studentID');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                // $editurl = route('admin.student.editnewform', $Student->id);

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';

                $ret .= '<div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Select Demo Type
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="' . $editurl . '">Start Demo</a></li>
                  <li><a href="#" data-zone="' . $Student->timezone . '" class="btnscduleDemo" data-id="' . $Student->id . '" >Reschdule Demo</a></li>

                </ul>
              </div>';

                return $ret;

            })
            ->addColumn('comment', function ($Student) {

                $ret = '';

                $ret .= '<button data-id="' . $Student->id . '"  class="btn btn-primary btnstudentcommentmodal">Comments</button>';

                return $ret;

            })
            ->addColumn('reference', function ($Student) {

                $ret = '';
                if ($Student->joining_source == 1) {
                    $ret .= $this->get_agency_name($Student->agency_id);
                } else {
                    $ret .= $Student->ref_email;
                }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" class="btnEditnewstudentform"  href="#" data-studenid="' . $Student->id . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'action', 'comment', 'reference'])
            ->editColumn('id', 'ID: {{$id}}')
            ->with('arraydata', '22')
            ->make(true);

    }

    public function get_meeting_schdule_student_forms(Request $request)
    {

        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $Student = Studentmeetingschdule::select(['schdule_meeting_contact_form.comment', 'schdule_meeting_contact_form.localTimeText', 'schdule_meeting_contact_form.schduleDate', 'student.*', 'countries.CountryName', 'countries.zone'])
            ->leftjoin('student', 'schdule_meeting_contact_form.studentID', '=', 'student.id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        if (!empty($start_date) && !empty($end_date)) {

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("Date(schdule_meeting_contact_form.schduleDate) BETWEEN '$start_date' AND '$end_date'");

            $innerquery = "where Date(schdule_meeting_contact_form.schduleDate) BETWEEN '$start_date' AND '$end_date'";

        }

        // if ($request->date) {
        //     $Student->whereRaw("DATE_FORMAT(schdule_meeting_contact_form.schduleDate,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')");

        //     $innerquery = "where DATE_FORMAT(a2.schduleDate,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')";
        // }

        else {

            $innerquery = "";
            //  $Student->whereDate('schdule_meeting_contact_form.schduleDate', Carbon::today());
            //  $cudata = Carbon::today();
            //  $innerquery = " where Date(a2.schduleDate) = '$cudata'";

        }
        if ($request->time) {

            $Student->whereRaw("DATE_FORMAT(schdule_meeting_contact_form.time, '%H:%i:%s') = DATE_FORMAT(STR_TO_DATE('$request->time', '%l:%i %p' ),'%H:%i:%s')");

            $innerquery .= " and  DATE_FORMAT(a2.time, '%H:%i:%s') = DATE_FORMAT(STR_TO_DATE('$request->time', '%l:%i %p' ),'%H:%i:%s')";
        }
        $Student->where('student.academicStatus', 6);
        $Student->whereRaw('schdule_meeting_contact_form.id IN (select MAX(a2.id) from schdule_meeting_contact_form a2 ' . $innerquery . ' group by a2.studentID)');
        $Student->groupBy('schdule_meeting_contact_form.studentID')
            ->orderby('schdule_meeting_contact_form.schduleDate', 'asc')
            ->orderby('schdule_meeting_contact_form.time', 'asc')
        ;

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $editurl = route('admin.student.editnewform', $Student->id);

                $ret = '';

                $ret .= '<div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Select Demo Type
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="' . $editurl . '">Start Demo</a></li>
              <li><a href="#" data-zone="' . $Student->timezone . '" class="btnscduleDemo" data-id="' . $Student->id . '" >schdule Demo</a></li>
              <li><a href="#" class="btnscduleMeeting" data-id="' . $Student->id . '" >Rescdule Meeting</a></li>
            </ul>
          </div>';

                return $ret;

            })
            ->addColumn('commentss', function ($Student) {

                $ret = '';

                $ret .= '<button data-id="' . $Student->id . '"  class="btn btn-primary btnstudentcommentmodal">Comments</button>';

                return $ret;

            })
            ->addColumn('reference', function ($Student) {

                $ret = '';
                if ($Student->joining_source == 1) {
                    $ret .= $this->get_agency_name($Student->agency_id);
                } else {
                    $ret .= $Student->ref_email;
                }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" class="btnEditnewstudentform"  href="#" data-studenid="' . $Student->id . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->rawColumns(['studentprofile', 'action', 'commentss', 'reference'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_demo_schdule_student_forms(Request $request)
    {

        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $Student = SchduleStudentdemo::select([DB::raw('max(studentdemoschdules.id) as sid'), 'studentdemoschdules.studentTimeText', 'studentdemoschdules.localTimeText', 'studentdemoschdules.schduleDate', 'student.*', 'countries.CountryName', 'countries.zone'])
            ->leftjoin('student', 'studentdemoschdules.studentID', '=', 'student.id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->where('step_status', 2)
            ->where('academicStatus', 6);

        // if ($request->date) {
        //     $Student->whereRaw("DATE_FORMAT(studentdemoschdules.schduleDate,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')");
        //     $innerquery = "where DATE_FORMAT(a2.schduleDate,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')";

        // }

        if (!empty($start_date) && !empty($end_date)) {

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("Date(studentdemoschdules.schduleDate) BETWEEN '$start_date' AND '$end_date'");

            $innerquery = "where Date(studentdemoschdules.schduleDate) BETWEEN '$start_date' AND '$end_date'";

        } else {

            $innerquery = '';

            // $Student->whereDate('studentdemoschdules.schduleDate', Carbon::today());
            // $cudata = Carbon::today();
            // $innerquery = " where Date(a2.schduleDate) = '$cudata'";

        }
        if ($request->time) {

            $Student->whereRaw("DATE_FORMAT(studentdemoschdules.local_Time, '%H:%i:%s') = DATE_FORMAT(STR_TO_DATE('$request->time', '%l:%i %p' ),'%H:%i:%s')");

            $innerquery .= " and  DATE_FORMAT(a2.local_Time, '%H:%i:%s') = DATE_FORMAT(STR_TO_DATE('$request->time', '%l:%i %p' ),'%H:%i:%s')";
        }

        $Student->whereRaw("studentdemoschdules.id IN (select MAX(a2.id) from studentdemoschdules a2 $innerquery  group by a2.studentID)");
        $Student->orderby('studentdemoschdules.schduleDate', 'asc');
        $Student->orderby('studentdemoschdules.local_Time', 'asc');
        $Student->groupBy('studentdemoschdules.studentID');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                // $editurl = route('admin.student.editnewform', $Student->id);

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';

                $ret .= '<div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Select Demo Type
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="' . $editurl . '">Start Demo</a></li>
                  <li><a href="#" data-zone="' . $Student->timezone . '" class="btnscduleDemo" data-id="' . $Student->id . '" >Reschdule Demo</a></li>

                </ul>
              </div>';

                return $ret;

            })
            ->addColumn('comment', function ($Student) {

                $ret = '';

                $ret .= '<button data-id="' . $Student->id . '"  class="btn btn-primary btnstudentcommentmodal">Comments</button>';

                return $ret;

            })
            ->addColumn('reference', function ($Student) {

                $ret = '';
                if ($Student->joining_source == 1) {
                    $ret .= $this->get_agency_name($Student->agency_id);
                } else {
                    $ret .= $Student->ref_email;
                }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" class="btnEditnewstudentform"  href="#" data-studenid="' . $Student->id . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->rawColumns(['studentprofile', 'action', 'comment', 'reference'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_new_student_forms(Request $request)
    {
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $Student = Student::select(['student.*', 'countries.CountryName', 'countries.zone'])
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        if (!empty($start_date) && !empty($end_date)) {

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("Date(student.created_at) BETWEEN '$start_date' AND '$end_date'");

        } else {
            // $Student->whereRaw("DATE_FORMAT(student.created_at,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')");

        }

        $Student->where('academicStatus', 6);
        $Student->where('step_status', 1)
            ->orderby('student.id', 'desc');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> Select Demo Type
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="' . $editurl . '">Start Demo</a></li>
                  <li><a href="#" data-zone="' . $Student->timezone . '" class="btnscduleDemo" data-id="' . $Student->id . '" >Schdule Demo</a></li>
                  <li><a href="#" class="btnscduleMeeting" data-id="' . $Student->id . '" >Schdule Meeting</a></li>

                </ul>
              </div>';
                // }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" class="btnEditnewstudentform"  href="#" data-studenid="' . $Student->id . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('comment', function ($Student) {

                $ret = '';

                $ret .= '<button data-id="' . $Student->id . '"  class="btn btn-primary btnstudentcommentmodal">Comments</button>';

                return $ret;

            })
            ->addColumn('reference', function ($Student) {

                $ret = '';
                if ($Student->joining_source == 1) {
                    $ret .= $this->get_agency_name($Student->agency_id);
                } else {
                    $ret .= $Student->ref_email;
                }

                return $ret;

            })
            ->rawColumns(['action', 'studentprofile', 'comment', 'reference'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    public function studentSchdulesave(Request $request)
    {
        $rules = array(
            'id' => 'required',
            'studenttime' => 'required',
            'timezoneName' => 'required',
            'studentlocaltime' => 'required',
            'schduleDate' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $studentSchd = new SchduleStudentdemo();
            $studentSchd->studentID = $request->id;
            $studentSchd->studentTime = Carbon::createFromFormat('g:i a', $request->studenttime);
            $studentSchd->studentTimeText = $request->studenttime;
            $studentSchd->timeZone = $request->timezoneName;
            $studentSchd->local_Time = Carbon::createFromFormat('g:i a', $request->studentlocaltime);
            $studentSchd->localTimeText = $request->studentlocaltime;
            $studentSchd->schduleDate = $request->schduleDate;
            $studentSchd->save();

            Student::where('id', $request->id)->update(['step_status' => 2, 'timezone' => $request->timezoneName]);

            if (!$studentSchd) {
                return response()->json([
                    'success' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Student Schdule  Time Set Successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }
    }

    public function studentMeetingSchdulesave(Request $request)
    {
        $rules = array(
            'id' => 'required',
            'localtime' => 'required',
            'schduleDate' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $studentSchd = new Studentmeetingschdule();
            $studentSchd->studentID = $request->id;
            $studentSchd->time = Carbon::createFromFormat('g:i a', $request->localtime);
            $studentSchd->localTimeText = $request->localtime;
            $studentSchd->schduleDate = $request->schduleDate;
            $studentSchd->comment = $request->comment;
            $studentSchd->save();

            if (!$studentSchd) {
                return response()->json([
                    'success' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Student Schdule  Time Set Successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }
    }

    public function create()
    {
        $Country = Country::get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::whereIn('id', [9, 10, 11, 12])->get();
        $City = [];
        $Currency = Country::first()->currency;
        $timezones = $this->timezones();
        $student_days = DB::table('student_days')->get();

        $teacher = Employee::select(['employees.*'])->where('employees.role_type', 'teacher')->get();
        $academicStatusArr = DB::table('academic_status')->get();

        $course = DB::table('course')->get();
        $Subject = Subject::get();
        $Subjectquran = Subject::where('course_id', 1)->get();
        $SubjectQaida = Subject::where('course_id', 4)->get();
        $SubjectHadeeth = Subject::where('course_id', 3)->get();
        $SubjectLangauges = Subject::where('course_id', 5)->get();
        $quranhifz = Subject::where('course_id', 1)->whereIn('id', [30, 29, 28])->get();

        //   $quranhifz = [];
        $Memorizationdata = Memorization::get();
        $Fundamentalislam = Fundamentalislam::get();
        $Ethicsdata = Ethics::get();

        $durationArr = DB::table('duration_tbl')->where('durationStatus', 1)->orderby('id', 'desc')->get();

        $this->setPageTitle('Student', 'Create Student');
        return view('admin.student.create', compact('durationArr', 'academicStatusArr', 'quranhifz', 'Subjectquran', 'SubjectQaida', 'SubjectHadeeth', 'SubjectLangauges', 'course', 'Memorizationdata', 'Fundamentalislam', 'Ethicsdata', 'teacher', 'Country', 'City', 'Agencies', 'Language', 'Subject', 'timezones', 'Currency', 'student_days'));
    }

    public function get_student_by_group(Request $request)
    {
        $groupno = $request->groupno;
        $Student = Student::where('group', $groupno)->first();

        if (!$Student) {
            return response()->json([
                'success' => 2,
                'msg' => 'Group Not Found',
            ]);
        }
        return response()->json([
            'success' => 1,
            'data' => $Student,
        ]);

    }

    public function timezones()
    {
        $timezones = [];

        foreach (timezone_identifiers_list() as $timezone) {
            $datetime = new \DateTime('now', new DateTimeZone($timezone));
            $timezones[] = [
                'sort' => str_replace(':', '', $datetime->format('P')),
                'offset' => $datetime->format('P'),
                'name' => str_replace('_', ' ', implode(', ', explode('/', $timezone))),
                'timezone' => $timezone,
            ];
        }

        usort($timezones, function ($a, $b) {
            return $a['sort'] - $b['sort'] ?: strcmp($a['name'], $b['name']);
        });

        return $timezones;
    }

    public function get_student_forms(Request $request)
    {
        $teacherID = $request->teacherId;
        $groupno = $request->groupno;
        $agency = $request->agency;
        $isTafseer = $request->isTafseer;
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename', 'users.name',
            DB::raw("date_format(student.demo_time,'%Y-%m-%d %h:%i %p') as demoformattime"),
        ])
            ->selectRaw('(CASE WHEN student.class_type = 1 THEN "Trail" ELSE "Regular" END) as class_status')
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin('users', 'users.id', '=', 'student.demo_by');
        // if ($request->date) {
        //     $Student->whereRaw("DATE_FORMAT(student.created_at,'%Y-%m-%d') = DATE_FORMAT('$request->date','%Y-%m-%d')");
        // }

        if (!empty($start_date) && !empty($end_date)) {
            // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("DATE_FORMAT(DATE_ADD(student.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");

        }
        if ($request->academicStatus) {
            // $Student->where('student.academicStatus', $request->academicStatus);

            $Student->whereIn('student.academicStatus', $request->academicStatus);
        }

        if ($teacherID) {
            $Student->where('student.teacher_id', $teacherID);
        }

        if ($groupno) {
            $Student->where('student.group', $groupno);
        }
        if ($agency) {
            $Student->where('student.agency_id', $agency);
        }

        if ($isTafseer == 2) {
            $Student->where('student.isTafseer', 0);
        } else if ($isTafseer == 1) {
            $Student->where('student.isTafseer', 1);
        }

        // $Student->where('student.step_status', 5);
        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                //     $ret .= '<div class="dropdown myclassDropStatsus">
                //     <button class="btn btn-primary dropdown-toggle btnstatustext" type="button" data-toggle="dropdown">' . $this->academic_status_name($Student->academicStatus) . '
                //     <span class="caret"></span></button>
                //     <ul class="dropdown-menu">
                //       <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="1" >Active</a></li>
                //       <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="2" >InActive</a></li>
                //       <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="3" >Leave</a></li>
                //       <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="4" >Close</a></li>
                //       <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="5" >Rejected</a></li>
                //       <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="6" >Pending</a></li>
                //     </ul>
                //   </div>';
                // }

                $ret .= $this->academic_status_name($Student->academicStatus);

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('empprofile', function ($Student) {

                $ret = '';
                if ($Student->teacher_id) {
                    $editurl = ($Student->teacher_id) ? route('admin.teacher.edit', $Student->teacher_id) : '#';
                    $schurl = ($Student->teacher_id) ? route('admin.teacher.student.weekly.schedule.calender', $Student->teacher_id) : '#';

                    $ret = '';
                    // if (Gate::allows('user-edit'))
                    // {
                    $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->employeename . '</a> | <a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $schurl . '">schdule</a>';
                    // }
                }

                return $ret;

            })
            ->addColumn('detail', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                // $ret .= '<button class="btn btn-primary btnstudentdetail" data-id="' . $Student->id . '" >View Detail</button> <button data-id="' . $Student->id . '"  class="btn btn-primary btnstudentcommentmodal">Comments</button><a href="#" data-zone="'.$Student->zone.'" class="btnscduleDemo" data-id="' . $Student->id . '" >Schdule Demo</a>';
                // }

                $ret .= '<button  class="btnstudentdetail" title="Detail" style="cursor:pointer"  data-id="' . $Student->id . '"><i class="fa fa-eye"></i></button >&nbsp;|&nbsp;<button  class="btnstudentcommentmodal" title="Comments" style="cursor:pointer" href="#"   data-id="' . $Student->id . '"><i class="fa fa-comment"></i></button >&nbsp;|&nbsp;<button  class="btnscduleDemo" title="Schdule Demo" style="cursor:pointer" href="#" data-zone="' . $Student->timezone . '"    data-id="' . $Student->id . '"><i class="fa fa-play"></i></button >&nbsp;|&nbsp;<button  class="btnstudenFollowUptcommentmodal" title="Follow Up Message" style="cursor:pointer" href="#" data-zone="' . $Student->timezone . '"    data-id="' . $Student->id . '"><i class="fa fa-comment"></i></button>';

                return $ret;

            })
            ->addColumn('reference', function ($Student) {

                $ret = '';
                if ($Student->joining_source == 1) {
                    $ret .= ($this->get_agency_name($Student->agency_id)) ? substr($this->get_agency_name($Student->agency_id), 0, 5) : "";
                } else {
                    $ret .= ($Student->ref_email) ? substr($Student->ref_email, 0, 5) : "";
                }

                return $ret;

            })

            ->addColumn('demoprofile', function ($Student) {

                $ret = '';
                $ret .= '<a href="#" data-toggle="dropdown" data-placement="bottom" title="' . $Student->demoformattime . '">
                 ' . $Student->name . '
                </a>';
                return $ret;

            })

            ->rawColumns(['action', 'studentprofile', 'detail', 'empprofile', 'reference', 'demoprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_student_schdule_forms(Request $request)
    {
        // $Student = Student::select(['currendaysdata.day_name','currendaysdata.student_time_text','currendaysdata.local_time_text','student.*', 'countries.CountryName','employees.employeename'])
        //     ->selectRaw('GROUP_CONCAT(student_days.day_name) as days')
        //     ->selectRaw('GROUP_CONCAT(l.languagename) as languages')
        //     ->selectRaw('(CASE
        //     WHEN student.class_type = 1 THEN "Trail"
        //     ELSE "Regular"
        // END) as class_status')
        //     ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
        //     ->leftjoin('student_days', 'student_days.student_id', '=', 'student.id')
        //     ->leftjoin('countries', 'student.country', '=', 'countries.id')
        //     ->leftjoin('student_language_lookups as sll','sll.student_id','=','student.id')
        //     ->leftjoin('languages as l','l.id','=','sll.language_id')
        //     ->join(DB::raw('(SELECT student_day_new.*  FROM `student_days` as student_day_new where student_day_new.day_name = DAYNAME(CURDATE()) ) currendaysdata'),
        //     function($join)
        //     {
        //         $join->on('student.id', '=', 'currendaysdata.student_id');
        //     });

        //     $Student->where('student.step_status', 5)
        //     ->groupBy('student.id');

        // $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename'])
        //     ->selectRaw('GROUP_CONCAT(DISTINCT(student_days.day_name)) as days')
        //     ->selectRaw('GROUP_CONCAT(DISTINCT(student_days.local_time_text)) as local_time_text')
        //     ->selectRaw('GROUP_CONCAT(DISTINCT(student_days.student_time_text)) as student_time_text')
        //     ->selectRaw('GROUP_CONCAT(DISTINCT(l.languagename))  as languages')
        //     ->selectRaw('(CASE
        //     WHEN student.class_type = 1 THEN "Trail"
        //     ELSE "Regular"
        // END) as class_status')
        //     ->leftjoin('student_days', 'student.id', '=', 'student_days.student_id')
        //     ->leftjoin('student_language_lookups as sll', 'student.id', '=', 'sll.student_id')
        //     ->leftjoin('languages as l', 'l.id', '=', 'sll.language_id')
        //     ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
        //     ->leftjoin('countries', 'student.country', '=', 'countries.id');

        // $Student->where('student.step_status', 5)
        //     ->groupBy('student.id');

        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $teacherID = $request->teacherId;
        $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename', 'studentdays.*'])
            ->selectRaw('GROUP_CONCAT(DISTINCT(l.languagename))  as languages')
            ->selectRaw('(CASE
        WHEN student.class_type = 1 THEN "Trial"
        ELSE "Regular"
    END) as class_status')
            ->selectRaw('(CASE
        WHEN student.teacher_assign_type = 1 THEN "Regular"
        ELSE "Temporary"
    END) as teacher_assign_status_type')
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->leftjoin('student_language_lookups as sll', 'student.id', '=', 'sll.student_id')
            ->leftjoin('languages as l', 'l.id', '=', 'sll.language_id')
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        if (!empty($start_date) && !empty($end_date)) {
            // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

            $start_date = date($start_date);
            $end_date = date($end_date);

            $Student->whereRaw("DATE_FORMAT(DATE_ADD(student.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");

        }
        if ($request->academicStatus) {
            $Student->where('student.academicStatus', $request->academicStatus);
        } else {
            $Student->where('student.academicStatus', 1);
        }
        if ($teacherID) {
            $Student->where('student.teacher_id', $teacherID);
        }
        // $Student->where('student.step_status', 5);
        $Student->groupBy('student.id');
        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<div class="dropdown myclassDropStatsus">
                <button class="btn btn-primary dropdown-toggle btnstatustext" type="button" data-toggle="dropdown">' . $this->academic_status_name($Student->academicStatus) . '
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="1" >Active</a></li>
                  <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="2" >InActive</a></li>
                  <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="3" >Leave</a></li>
                  <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="4" >Close</a></li>
                   <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="5" >Rejected</a></li>
                  <li><a href="#" class="btnChangeAcademiStatus" data-id="' . $Student->id . '" data-status="6" >Pending</a></li>
                </ul>
              </div>';
                // }

                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
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

                $ret .= '<tr>';

                $ret .= '<td>';
                $ret .= '<table class="table-bordered">';
                $ret .= '<tr><td>' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td>Local</td></tr>';
                $ret .= '<tr><td>' . count($days) . '&nbsp;Days</td></tr>';
                $ret .= '<tr><td>Student</td></tr>';
                $ret .= '</table>';
                $ret .= '</td>';
                foreach ($days as $index => $val) {

                    $studentdaysss = (isset($studentdays[$index])) ? ($studentdays[$index] != "") ? substr($studentdays[$index], 0, 3) : 'no' : 'no';
                    $ret .= '<td>';
                    $ret .= '<table class="table-bordered">';
                    $ret .= '<tr><td>' . substr($days[$index], 0, 3) . '</td></tr>';
                    $ret .= '<tr><td>' . $local_time_text[$index] . '</td></tr>';
                    $ret .= '<tr><td>' . $studentdaysss . '</td></tr>';
                    $ret .= '<tr><td>' . $student_time_text[$index] . '</td></tr>';
                    $ret .= '</table>';
                    $ret .= '</td>';

                }
                $ret .= '</tr>';
                $ret .= '</table>';

                return $ret;

            })
            ->addColumn('empprofile', function ($Student) {

                $ret = '';
                if ($Student->teacher_id) {
                    $editurl = ($Student->teacher_id) ? route('admin.teacher.edit', $Student->teacher_id) : '#';
                    $schurl = ($Student->teacher_id) ? route('admin.teacher.student.weekly.schedule.calender', $Student->teacher_id) : '#';

                    $ret = '';
                    // if (Gate::allows('user-edit'))
                    // {
                    $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->employeename . '</a> | <a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $schurl . '">schdule</a>';
                    // }
                }

                return $ret;

            })
            ->rawColumns(['action', 'studentprofile', 'day', 'empprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_student_feedback_forms(Request $request)
    {

        $stdid = $request->id;

        $Student = DB::table('feedbackaboutteacher')->select(['feedbackaboutteacher.*', 'employees.employeename'])
            ->leftjoin('employees', 'employees.id', '=', 'feedbackaboutteacher.teacher_id')
            ->where('feedbackaboutteacher.student_id', $stdid);

        return Datatables::of($Student)
            ->addColumn('question1', function ($Student) {

                $ret = '';
                foreach (range(1, 5) as $i) {

                    if ($i <= $Student->question1) {
                        $ret .= '<span class="fa fa-star  checked"></span>';
                    } else {
                        $ret .= '<span class="fa fa-star "></span>';
                    }

                }

                return $ret;

            })
            ->addColumn('question2', function ($Student) {

                $ret = '';
                foreach (range(1, 5) as $i) {

                    if ($i <= $Student->question2) {
                        $ret .= '<span class="fa fa-star  checked"></span>';
                    } else {
                        $ret .= '<span class="fa fa-star  "></span>';
                    }

                }

                return $ret;
            })
            ->addColumn('question3', function ($Student) {

                $ret = '';
                foreach (range(1, 5) as $i) {

                    if ($i <= $Student->question3) {
                        $ret .= '<span class="fa fa-star  checked"></span>';
                    } else {
                        $ret .= '<span class="fa fa-star  "></span>';
                    }

                }

                return $ret;
            })
            ->addColumn('question4', function ($Student) {

                $ret = '';
                foreach (range(1, 5) as $i) {

                    if ($i <= $Student->question4) {
                        $ret .= '<span class="fa fa-star  checked"></span>';
                    } else {
                        $ret .= '<span class="fa fa-star  "></span>';
                    }

                }

                return $ret;
            })
            ->addColumn('question5', function ($Student) {

                $ret = '';
                foreach (range(1, 5) as $i) {

                    if ($i <= $Student->question5) {
                        $ret .= '<span class="fa fa-star  checked"></span>';
                    } else {
                        $ret .= '<span class="fa fa-star  "></span>';
                    }

                }

                return $ret;
            })
            ->addColumn('average', function ($Student) {

                return $this->calcualteaverage($Student->question1, $Student->question2, $Student->question3, $Student->question4, $Student->question5);

            })
            ->rawColumns(['average', 'question1', 'question2', 'question3', 'question4', 'question5'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function acdemichistoryDatatable(Request $request)
    {
        $stdid = $request->id;

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {

            $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'users.name as creatorname', 'employees.employeename', 'reason.reason', DB::raw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d %h:%i %p') as created_new")])
                ->leftjoin('employees', 'employees.id', '=', 'academicstatuschange.teacher_id')
                ->leftjoin('reason', 'reason.id', '=', 'academicstatuschange.reason_id')
                ->leftjoin('users', 'users.id', '=', 'academicstatuschange.created_by')
                ->where('academicstatuschange.student_id', $stdid)
                ->orderby('academicstatuschange.created_at', 'desc');

        } else {

            $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'users.name as creatorname', 'employees.employeename', 'reason.reason', DB::raw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 600 MINUTE),'%Y-%m-%d %h:%i %p') as created_new")])
                ->leftjoin('employees', 'employees.id', '=', 'academicstatuschange.teacher_id')
                ->leftjoin('reason', 'reason.id', '=', 'academicstatuschange.reason_id')
                ->leftjoin('users', 'users.id', '=', 'academicstatuschange.created_by')
                ->where('academicstatuschange.student_id', $stdid)
                ->orderby('academicstatuschange.created_at', 'desc');

        }

        return Datatables::of($Student)
            ->addColumn('statustext', function ($Student) {

                return $this->academic_status_name($Student->status);

            })
            ->addColumn('previosstatustext', function ($Student) {

                return ($Student->previousStatus != 0) ? $this->academic_status_name($Student->previousStatus) : '';

            })
            ->rawColumns(['statustext', 'previosstatustext'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function teacherchangehistoryDatatable(Request $request)
    {
        $stdid = $request->id;

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {
            $Student = DB::table('teacherchange')->select(['teacherchange.*', 'reason.reason', 'users.name as creatorname', 'oldteacher.employeename as oldteachername', 'newteacher.employeename as newteachername', DB::raw("date_format(date_add(teacherchange.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")]);
        } else {
            $Student = DB::table('teacherchange')->select(['teacherchange.*', 'reason.reason', 'users.name as creatorname', 'oldteacher.employeename as oldteachername', 'newteacher.employeename as newteachername', DB::raw("date_format(date_add(teacherchange.created_at,INTERVAL +10 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")]);
        }

        $Student->leftjoin('employees as oldteacher', 'oldteacher.id', '=', 'teacherchange.teacher_id')
            ->leftjoin('employees as newteacher', 'newteacher.id', '=', 'teacherchange.newteacher_id')
            ->leftjoin('reason', 'reason.id', '=', 'teacherchange.reason_id')
            ->leftjoin('users', 'users.id', '=', 'teacherchange.created_by')
            ->where('teacherchange.student_id', $stdid)
            ->orderby('teacherchange.created_at', 'desc');

        return Datatables::of($Student)->make(true);
    }

    public function calcualteaverage($q1, $q2, $q3, $q4, $q5)
    {

        $values = array($q1, $q2, $q3, $q4, $q5);

        $average = array_sum($values) / count($values);

        return $average;
    }

    // public function Studentgroupgenerator($group = null)
    // {
    //     if ($group) {
    //         $data = Student::where('group', $group)->get();
    //         if (count($data) > 0) {
    //             $group = 1 + (int) $group;
    //             $this->Studentgroupgenerator($group);
    //         } else {
    //             return $group;
    //         }
    //     } else {
    //         $groupid = Student::latest()->first();
    //         if ($groupid) {
    //             return 1 + (int) $groupid->group;
    //         } else {
    //             return rand(10000, 99999);
    //         }

    //     }
    // }

    public function Studentgroupgenerator($group = null)
    {
        if ($group) {
            $data = Student::where('group', $group)->get();
            if (count($data) > 0) {
                $group = 1 + (int) $group;
                return $this->Studentgroupgenerator($group);
            } else {
                return $group;
            }
        } else {
            // $groupid = Student::latest()->first();

            $groupid = Student::orderby('group', 'desc')->first();
            if ($groupid) {
                // return 1 + (int) $groupid->group;

                $group = 1 + (int) $groupid->group;

                return $this->Studentgroupgenerator($group);
            } else {
                return rand(10000, 99999);
            }

        }
    }

    public function getStudentGUIDnoHash()
    {
        mt_srand((double) microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*", $charid);
        $c = implode("", $c);

        return substr($c, 0, 20);
    }

    public function storefullform(Request $request)
    {

        $rules = array(
            'name' => 'required|max:191',
        );

        if ($request->academicStatus == 1) {

            $rules['fathername'] = 'required|max:191';
            $rules['contact_no'] = 'required|max:191';
            $rules['email'] = 'required|email|max:191';
            $rules['country'] = 'required';
            $rules['contact_no'] = 'required|max:191';
            $rules['detail'] = 'max:191';
            $rules['age'] = 'required|max:191';
            $rules['gender'] = 'required|max:191';
            $rules['city'] = 'required|max:191';
            $rules['timezoneName'] = 'required';
            $rules['resource'] = 'required|max:191';
            $rules['currencysymbol'] = 'required|max:191';
            $rules['joiningdate'] = 'required';
            $rules['classtype'] = 'required|max:191';
            $rules['country'] = 'required';
            $rules['days.*'] = "required";
            $rules['localtimeday.*'] = "required";
            $rules['localtime.*'] = "required";
            $rules['language.*'] = "required";
            $rules['studenttime.*'] = "required";
            $rules['teacherrequirement'] = 'max:191';
            $rules['duration'] = 'required';
            $rules['academicStatus'] = "required|numeric";
            $rules['isTafseer'] = "required|numeric|min:0|max:1";

        }

        if ($request->teacherassign == 2) {
            $rules['teacherscduledate'] = 'required';
            $rules['teacherscduletime'] = 'required';
        }

        if ($request->course) {

            $rules['course'] = "required|numeric|min:1|max:7";
            $rules['accent_type'] = "required|numeric|min:1|max:2";

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
                if ($request->memorizarion == 3) {
                    $rules['surahname'] = "required";
                    $rules['surahstartaya'] = "required|numeric|min:1";
                    $rules['surahendaya'] = "required|numeric|min:1";
                }
                if ($request->memorizarion == 4) {
                    $rules['duaname'] = "required";
                    $rules['duanamestartline'] = "required|numeric|min:1";
                    $rules['duanameendline'] = "required|numeric|min:1";
                }

            }

            if ($request->ethics) {
                $rules['ethics'] = "required|numeric|min:1";
                $rules['ethicsstartpage'] = "required|numeric|min:1";
                $rules['ethicsendpage'] = "required|numeric|min:1";
                $rules['ethicsstartline'] = "required|numeric|min:1";
                $rules['ethicsendline'] = "required|numeric|min:1";
            }

        }

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

            $groupnoVal = ($request->groupno) ? $request->groupno : $this->Studentgroupgenerator();

            $user = new User();
            $user->email = 'student' . $this->getStudentGUIDnoHash() . '@sispn.com';
            $user->name = $request->name;
            $user->password = Hash::make('12345');
            $user->role = 'student';
            $user->save();
            $user->assignRole('student');
            $userid = $user->id;

            $Student = new Student();
            $Student->user_id = $userid;
            $Student->studentname = $request->name;
            $Student->country = $request->country;
            $Student->fathername = $request->fathername;
            $Student->studentemail = $request->email;
            $Student->contact_no = $request->contact_no;
            $Student->detail = $request->detail;
            $Student->group = $groupnoVal;
            $Student->whatsapp = $request->whatsApp;
            $Student->skypid_1 = $request->skype1;
            $Student->skypid_2 = $request->skype2;
            $Student->age = $request->age;
            $Student->gender = $request->gender;
            $Student->city = $request->city;
            $Student->timezone = $request->timezoneName;
            $Student->joining_source = $request->resource;
            $Student->agency_id = $request->marketingagencies;
            $Student->ref_name = $request->referencename;
            $Student->ref_email = $request->referenceemail;
            $Student->ref_group = $request->referencegroup;
            $Student->payment_currency = $request->currencysymbol;
            $Student->duration = $request->duration;
            $Student->joining_date = date('Y-m-d');
            $Student->examination_date = date('Y-m-d', strtotime(" +3 months"));
            $Student->class_type = $request->classtype;
            $Student->created_by = auth()->id();
            $Student->teacher_assign_status = $request->teacherassign;
            $Student->dob = $request->dob;
            if ($request->teacherassign == 2) {
                $Student->teacheSchduledate = $request->teacherscduledate;
                $Student->teacheSchduletime = Carbon::createFromFormat('g:i a', $request->teacherscduletime);
                $Student->step_status = 4;
                $teacherID = 0;
            } else if ($request->teacherassign == 1) {
                $Student->teacher_id = $request->teacherid;
                $Student->step_status = 5;

                $teacherID = $request->teacherid;
            } else {
                $Student->step_status = 1;
                $teacherID = 0;
            }
            if ($request->academicStatus == 1) {
                $Student->trial_started_date = date('Y-m-d');
            }
            $Student->teacher_requirement = $request->teacherrequirement;
            $Student->academicStatus = $request->academicStatus;
            $Student->isTafseer = $request->isTafseer;
            $Student->save();

            User::where('id', $userid)->update([
                'email' => 'student' . $Student->id . '@sispn.com',
            ]);

            if ($request->resource == 2) {

                if ($request->referencegroup) {

                    $referencegroup = $request->referencegroup;

                    $ReferralStudetn = DB::table('student')->where('group', $referencegroup)->where('id', '!=', $Student->id)->where('academicStatus', 1)->get();
                    if (count($ReferralStudetn) > 0) {

                        $totalReferStudent = count($ReferralStudetn);
                        $amount = 2000 / $totalReferStudent;
                        $data = array();
                        foreach ($ReferralStudetn as $valreferal) {
                            $data[] = [
                                'referraStudentId' => $Student->id,
                                'referraGroup' => $groupnoVal,
                                'studentID' => $valreferal->id,
                                'teacherID' => $valreferal->teacher_id,
                                'groupno' => $valreferal->group,
                                'amount' => $amount,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'created_by' => Auth::user()->id,
                            ];
                        }
                        DB::table('teacherReferal')->insert($data);
                    }
                }

            }

            // $Lesson = new Lesson();
            // $Lesson->student_id = $Student->id;
            // $Lesson->chapter = $request->chapter;
            // $Lesson->subject_id = $request->subject;
            // $Lesson->start_to_end = $request->startlesson;
            // $Lesson->average = $request->average;
            // $Lesson->page_to_from = $request->frompage;
            // $Lesson->ayah_line = $request->fromayah;
            // $Lesson->memorization = $request->memorization;
            // $Lesson->memorization_detail = $request->memorizationdetail;
            // $Lesson->accent_type = $request->accent_type;
            // $Lesson->save();

            if ($request->course) {

                $Lesson = new LessonNew();
                $Lesson->teacher_id = $teacherID;
                $Lesson->student_id = $Student->id;
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
                    if ($request->memorizarion == 3) {

                        $Lesson->surah_name_shortsurah = $request->surahname;
                        $Lesson->startaya_shortsurah = $request->surahstartaya;
                        $Lesson->endaya_shortsurah = $request->surahendaya;

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
                }
                $Lesson->created_by = Auth::user()->id;
                $Lesson->save();

                $StudentUpdata = new Student();
                $StudentUpdata->demo_by = Auth::user()->id;
                $StudentUpdata->demo_time = Carbon::now();
                $StudentUpdata->lessoninformativecomment = $request->informativecomment;
                $StudentUpdata->id = $Student->id;
                $StudentUpdata->exists = true;
                $StudentUpdata->save();

            }

            if (isset($request->language)) {
                if (count($request->language) > 0) {
                    foreach ($request->language as $key => $lang) {
                        $stdlanguage = new StudentLanguageLookup();
                        $stdlanguage->student_id = $Student->id;
                        $stdlanguage->language_id = $lang;
                        $stdlanguage->save();
                    }
                }
            }

            if (isset($request->days)) {
                if (count($request->days) > 0) {

                    $days = $request->days;
                    $localtimeday = $request->localtimeday;
                    $studenttimeday = $request->studenttimeday;
                    $localtime = $request->localtime;
                    $studenttime = $request->studenttime;
                    $daysarray = array();
                    foreach ($days as $key => $val) {
                        // date("H:i:s", strtotime($studenttime[$key]))
                        $data = array(
                            'day_name' => $this->days_name($localtimeday[$key]),
                            'day_no' => $localtimeday[$key],
                            'student_day_name' => $this->days_name($studenttimeday[$key]),
                            'student_day_no' => $studenttimeday[$key],
                            'local_time' => Carbon::createFromFormat('g:i a', $localtime[$key]),
                            'End_local_Time' => Carbon::createFromFormat('g:i a', $localtime[$key])->addMinutes($request->duration),
                            'local_time_text' => $localtime[$key],
                            'student_time' => Carbon::createFromFormat('g:i a', $studenttime[$key]),
                            'student_time_text' => $studenttime[$key],
                            'teacher_id' => $teacherID,
                            'student_id' => $Student->id,
                            'day_duration' => $request->duration,
                        );

                        $daysarray[] = $data;
                    }
                    DB::table('student_days')->insert($daysarray);

                    DB::table('studentDayshistory')->insert([
                        'teacher_id' => $teacherID,
                        'student_id' => $Student->id,
                        'days' => json_encode($daysarray),
                    ]);

                }
            }

            if ($request->academicStatus != 6) {

                $studentdata = DB::table('student')->where('id', $Student->id)->first();
                $tasksubject = 'New Student Added';
                $studentid = $Student->id;
                $group = $Student->group;
                $taskDescription = 'Student ' . $studentdata->studentname . ' Added and Academic Status is ' . $this->academic_status_name($request->academicStatus);
                //  $assignuserToArray = array(2273,2275,1,9013);

                $assignuserToArray = DB::table('notificationSenderUserBytype')->where('notificationtype', 'task')->pluck('user_id')->toArray();

                $fcmDescription = 'Student ' . $studentdata->studentname . ' Added and Academic Status  is ' . $this->academic_status_name($request->academicStatus);
                $creatorID = 8964;
                $taskrelateID = $Student->id;
                $notificationtype = "task";
                $this->generateTaskFoStudent($creatorID, $tasksubject, $studentid, $group, $taskDescription, $assignuserToArray, $fcmDescription, $taskrelateID, $notificationtype);

            }

            if (!$Student) {
                return response()->json([
                    'error' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Student Added successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function store(Request $request)
    {

        try {

          

                $rules = array(
                    'name.*' => 'required|max:191',
                    'fathername' => 'required|max:191',
                    'contact_no' => 'required|max:191',
                    'email' => 'required|email|max:191',
                    'country' => 'required',
                );


                $error = Validator::make($request->all(), $rules);
                if ($error->fails()) {
                    return response()->json([
                        'error' => $error->errors()->getMessageBag(),
                    ]);
                }

                $name = $request->name;
                if ($request->groupno) {
                    $group = $request->groupno;
                } else {
                    $group = $this->Studentgroupgenerator();
                }

              
                    $user = new User();
                    $user->email = 'student' . $this->getStudentGUIDnoHash() . '@sispn.com';
                    $user->name = $name[0];
                    $user->password = Hash::make('12345');
                    $user->role = 'student';
                    $user->save();
                    $user->assignRole('student');
                    $userid = $user->id;

                    $Student = new Student();
                    $Student->user_id = $userid;
                    $Student->group = $group;
                    $Student->studentname = $name[0];
                    $Student->country = $request->country;
                    $Student->fathername = $request->fathername;
                    $Student->studentemail = $request->email;
                    $Student->contact_no = $request->contact_no;
                    $Student->skypid_1 = $request->skype1;
                 
                    $Student->detail = $request->detail;
                    $Student->studentemail2 = $request->studentemail2;
                    $Student->whatsapp = $request->whatsApp;
                    $Student->timezone = $request->timezone;

                    $Student->joining_date = date('Y-m-d');
                    $Student->examination_date = date('Y-m-d', strtotime(" +3 months"));
                    $Student->step_status = 1;
                    $Student->created_by = auth()->id();
                    $Student->save();

                    User::where('id', $userid)->update([
                        'email' => 'student' . $Student->id . '@sispn.com',
                    ]);

                    if ($request->comment) {

                        DB::table('student_comment_history')->insert([
                            'studentId' => $Student->id,
                            'comment' => $request->comment,
                            'created_by' => auth()->id(),
                            'updated_at' => date('Y-m-d H:i:s'),
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);


                

                // if (!$Student) {
                //     return response()->json([
                //         'success' => 'Something Went Wrong.',
                //         'alert' => 'error',
                //     ]);
                // }

                return response()->json([
                    'success' => 'Student Added Successfully',
                    'alert' => 'success',
                ]);
            }

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function edit($id)
    {

        $targetStudent = Student::with(['TeacherChangeHistory' => function ($query) {
            $query->select('teacher_id', 'newteacher_id', 'student_id', 'reason_id');
        }])->find($id);
        $User = User::where('id', $targetStudent->user_id)->first();
        $Country = Country::get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::whereIn('id', [9, 10, 11, 12])->get();
        $City = City::where('CountryID', $targetStudent->country)->get();

        $last40daysstudent = DB::table('studentattendance')->select(['studentattendance.*', 'a.status_name', 'a.color'])->leftjoin('attendance_status as a', 'a.status', '=', 'studentattendance.attendance_status')->where('studentattendance.student_id', $targetStudent->id)->whereDate('studentattendance.created_at', '>', Carbon::now()->subDays(40))->orderby('studentattendance.created_at', 'asc')->get();
        $Alldaysstudent = DB::table('studentattendance')->select(['a.status_name as title', 'a.color', DB::raw("date_format(studentattendance.created_at,'%Y-%m-%d') as start ")])->leftjoin('attendance_status as a', 'a.status', '=', 'studentattendance.attendance_status')->where('studentattendance.student_id', $targetStudent->id)->get();
        $allatendancestatus = DB::table('attendance_status')->get();

        $GroupFamily = Student::select(['student.*', 'a.academic_status'])->leftjoin('academic_status as a', 'a.academic_status_val', '=', 'student.academicStatus')->where('student.group', $targetStudent->group)->where('student.id', '!=', $targetStudent->id)->get();

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

        $Currency = Country::where('id', $targetStudent->country)->first();

        $Currency = ($Currency) ? $Currency->currency : '';

        $StudentLanguage = StudentLanguageLookup::where('student_id', $id)->get();
        $timezones = $this->timezones();
        $empName = Employee::where('employees.id', $targetStudent->teacher_id)->first();
        $teachername = ($empName) ? $empName->employeename : '';
        $student_day_val_arr = DB::table('student_days')->select(['day_no', 'student_day_no'])->where('student_id', $id)->get();
        $student_days = DB::table('student_days')->where('student_id', $id)->get();
        $reason = DB::table('reason')->get();
        $academicStatusArr = DB::table('academic_status')->get();

        $durationArr = DB::table('duration_tbl')->where('durationStatus', 1)->get();

        $teacherlist = Employee::select(['employees.*'])->where('employees.role_type', 'teacher')->get();

        $groupdata = Student::groupBy('group')->pluck('group');
        // $teacherdata = Employee::where('role_type' ,'teacher')->get();

        $teacherdata = User::select(['users.*', 'employees.employeename'])
            ->leftjoin('employees', 'employees.user_id', '=', 'users.id')->whereHas('roles', function ($q) {$q->where('name', 'teacher');})->get();

        $referalExist = "Not Added";
        $referallCheck = DB::table('teacherReferal')->where('referraStudentId', $id)->get();
        if (count($referallCheck) > 0) {
            $referalExist = "Added";
        }

        $this->setPageTitle('Student', 'Edit Student : ' . $targetStudent->studentname );
        return view('admin.student.edit', compact('referalExist', 'durationArr', 'GroupFamily', 'academicStatusArr', 'groupdata', 'teacherdata', 'Alldaysstudent', 'allatendancestatus', 'last40daysstudent', 'quranhifz', 'Subjectquran', 'SubjectQaida', 'SubjectHadeeth', 'SubjectLangauges', 'course', 'Memorizationdata', 'Fundamentalislam', 'Ethicsdata', 'targetStudent', 'teacherlist', 'reason', 'StudentLanguage', 'teachername', 'Country', 'City', 'Agencies', 'Language', 'Subject', 'timezones', 'Currency', 'User', 'student_days', 'student_day_val_arr'));

    }

    public function editnewform($id)
    {

        $targetStudent = Student::find($id);
        $User = User::where('id', $targetStudent->user_id)->first();
        $Country = Country::get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::whereIn('id', [9, 10, 11, 12])->get();
        $Subject = Subject::get();
        $City = City::where('CountryID', $targetStudent->country)->get();

        $Currency = Country::where('id', $targetStudent->country)->first()->currency;
        $StudentLanguage = StudentLanguageLookup::where('student_id', $id)->get();
        $timezones = $this->timezones();
        $teacher = Employee::select(['employees.*'])->where('employees.role_type', 'teacher')->get();
        $student_day_val_arr = DB::table('student_days')->select('day_no')->where('student_id', $id)->get();
        $student_days = DB::table('student_days')->where('student_id', $id)->get();

        $this->setPageTitle('Student', 'Edit Student : ' . $targetStudent->studentname);
        return view('admin.student.editnewform', compact('targetStudent', 'StudentLanguage', 'teacher', 'Country', 'City', 'Agencies', 'Language', 'Subject', 'timezones', 'Currency', 'User', 'student_days', 'student_day_val_arr'));

    }

    public function storeReplicaform(Request $request)
    {

        $rules = array(
            'studentid' => 'required|numeric',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

            $Studentreplica = Student::where('id', $request->studentid)->first();

            $user = new User();
            $user->email = 'student' . $this->getStudentGUIDnoHash() . '@sispn.com';
            $user->name = $Studentreplica->studentname . ' Replica';
            $user->password = Hash::make('12345');
            $user->role = 'student';
            $user->save();
            $user->assignRole('student');
            $userid = $user->id;

            $Student = new Student();
            $Student->user_id = $userid;
            $Student->studentname = $Studentreplica->studentname . ' Replica';
            $Student->country = $Studentreplica->country;
            $Student->fathername = $Studentreplica->fathername;
            $Student->studentemail = $Studentreplica->studentemail;
            $Student->contact_no = $Studentreplica->contact_no;
            $Student->detail = $Studentreplica->detail;
            $Student->group = $Studentreplica->group;
            $Student->whatsapp = $Studentreplica->whatsapp;
            $Student->skypid_1 = $Studentreplica->skypid_1;
            $Student->skypid_2 = $Studentreplica->skypid_2;
            $Student->age = $Studentreplica->age;
            $Student->gender = $Studentreplica->gender;
            $Student->city = $Studentreplica->city;
            $Student->timezone = $Studentreplica->timezone;
            $Student->joining_source = $Studentreplica->joining_source;
            $Student->agency_id = $Studentreplica->agency_id;
            $Student->ref_name = $Studentreplica->ref_name;
            $Student->ref_email = $Studentreplica->ref_email;
            $Student->payment_currency = $Studentreplica->payment_currency;
            $Student->duration = $Studentreplica->duration;
            $Student->joining_date = $Studentreplica->joining_date;
            $Student->class_type = $Studentreplica->class_type;
            $Student->created_by = auth()->id();
            $Student->teacher_assign_status = $Studentreplica->teacher_assign_status;
            $Student->teacheSchduledate = $Studentreplica->teacheSchduledate;
            $Student->teacheSchduletime = $request->teacheSchduletime;
            $Student->teacher_id = $Studentreplica->teacher_id;
            $Student->step_status = $Studentreplica->step_status;
            $teacherID = $Studentreplica->teacher_id;
            $Student->teacher_requirement = $Studentreplica->teacher_requirement;
            $Student->save();
            User::where('id', $userid)->update([
                'email' => 'student' . $Student->id . '@sispn.com',
            ]);

            // $Lesson = new Lesson();
            // $Lesson->student_id = $Student->id;
            // $Lesson->chapter = $request->chapter;
            // $Lesson->subject_id = $request->subject;
            // $Lesson->start_to_end = $request->startlesson;
            // $Lesson->average = $request->average;
            // $Lesson->page_to_from = $request->frompage;
            // $Lesson->ayah_line = $request->fromayah;
            // $Lesson->memorization = $request->memorization;
            // $Lesson->memorization_detail = $request->memorizationdetail;
            // $Lesson->accent_type = $request->accent_type;
            // $Lesson->save();

            $Lesson = new LessonNew();
            $Lesson->save();

            $langaugedata = StudentLanguageLookup::where('student_id', $request->studentid)->get();

            if (isset($langaugedata)) {
                if (count($langaugedata) > 0) {
                    foreach ($langaugedata as $key => $lang) {
                        $stdlanguage = new StudentLanguageLookup();
                        $stdlanguage->student_id = $Student->id;
                        $stdlanguage->language_id = $lang->language_id;
                        $stdlanguage->save();
                    }
                }
            }

            if (!$Student) {
                return response()->json(false);
            }
            return response()->json(true);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function days_name($val)
    {
        $day = '';
        switch ($val) {
            case 1:
                $day = 'Monday';
                break;
            case 2:
                $day = 'Tuesday';
                break;
            case 3:
                $day = 'Wednesday';
                break;
            case 4:
                $day = 'Thursday';
                break;
            case 5:
                $day = 'Friday';
                break;
            case 6:
                $day = 'Saturday';
                break;
            case 7:
                $day = 'Sunday';
                break;
        }

        return $day;
    }

    public function academic_status_name($val)
    {

        return DB::table('academic_status')->where('academic_status_val', $val)->first()->academic_status;

    }

    public function academic_status_name_old($val)
    {
        $status = '';
        switch ($val) {
            case 1:
                $status = 'Active';
                break;
            case 2:
                $status = 'Inactive';
                break;
            case 3:
                $status = 'Leave';
                break;
            case 4:
                $status = 'Close';
                break;
            case 5:
                $status = 'Rejected';
                break;
            case 6:
                $status = 'Pending';
                break;
            case 7:
                $status = 'Inprocess';
                break;
        }

        return $status;
    }

    public function updatenewform(Request $request)
    {
        $Student = new Student();
        $Student->studentname = $request->name;
        $Student->country = $request->country;
        $Student->fathername = $request->fathername;
        $Student->studentemail = $request->email;
        $Student->contact_no = $request->contact_no;
        $Student->detail = $request->detail;
        $Student->group = $request->groupno;
        $Student->whatsapp = $request->whatsApp;
        $Student->skypid_1 = $request->skype1;
        $Student->skypid_2 = $request->skype2;
        $Student->age = $request->age;
        $Student->gender = $request->gender;
        $Student->city = $request->city;
        $Student->timezone = $request->timezoneName;
        $Student->joining_source = $request->resource;
        $Student->agency_id = $request->marketingagencies;
        $Student->ref_name = $request->referencename;
        $Student->ref_email = $request->referenceemail;
        $Student->payment_currency = $request->currencysymbol;
        $Student->duration = $request->duration;
        $Student->class_type = $request->classtype;
        $Student->academicStatus = $request->academicStatus;

        $Student->teacher_assign_status = $request->teacherassign;
        if ($request->teacherassign == 2) {
            $Student->teacheSchduledate = $request->teacherscduledate;
            $Student->teacheSchduletime = Carbon::createFromFormat('g:i a', $request->teacherscduletime);
            $Student->step_status = 4;
            $teacherID = 0;
        } else {
            $Student->teacher_id = $request->teacherid;
            $Student->step_status = 5;

            $teacherID = $request->teacherid;
        }
        $Student->teacher_requirement = $request->teacherrequirement;
        $Student->created_by = auth()->id();
        $Student->exists = true;
        $Student->id = $request->id;
        $Student->save();

        StudentLanguageLookup::where('student_id', $request->id)->delete();

        if (isset($request->language)) {
            if (count($request->language) > 0) {
                foreach ($request->language as $key => $lang) {
                    $stdlanguage = new StudentLanguageLookup();
                    $stdlanguage->student_id = $request->id;
                    $stdlanguage->language_id = $lang;
                    $stdlanguage->save();
                }
            }
        }

        $days = $request->days;
        $localtimeday = $request->localtimeday;
        $studenttimeday = $request->studenttimeday;
        $localtime = $request->localtime;
        $studenttime = $request->studenttime;
        DB::table('student_days')->where('student_id', $Student->id)->delete();
        $daysarray = array();
        foreach ($days as $key => $val) {
            // date("H:i:s", strtotime($studenttime[$key]))
            $data = array(
                'day_name' => $this->days_name($localtimeday[$key]),
                'day_no' => $localtimeday[$key],
                'student_day_name' => $this->days_name($studenttimeday[$key]),
                'student_day_no' => $studenttimeday[$key],
                'local_time' => Carbon::createFromFormat('g:i a', $localtime[$key]),
                'local_time_text' => $localtime[$key],
                'student_time' => Carbon::createFromFormat('g:i a', $studenttime[$key]),
                'student_time_text' => $studenttime[$key],
                'teacher_id' => $teacherID,
                'student_id' => $Student->id,
                'day_duration' => $request->duration,
            );

            $daysarray[] = $data;
        }
        DB::table('student_days')->insert($daysarray);

        return response()->json([
            'success' => 'Student Update successfully',
            'alert' => 'success',
            'daysarray' => $daysarray,
        ]);

    }

    public function checkAttendanceTime($localtime, $localtimeday, $studenttime, $studenttimeday, $duration, $Studentid, $teacherID, $isTafseer)
    {

        $attendancetime = $localtime;
        $currentTime = Carbon::now()->format('g:i a');

        $to_time = strtotime($currentTime);
        $from_time = strtotime($attendancetime);

        $diff = $from_time - $to_time;
        // $result = ($diff < 0)? 'Late! '.$diff : 'Right time! '.$diff;

        $currentday = Carbon::now()->dayOfWeekIso;
        if ($currentday == $localtimeday) {

            $start_date = new DateTime($currentTime);
            $since_start = $start_date->diff(new DateTime($attendancetime));

            $cond = $since_start->i > $duration;
            // if (($diff > 0) && $diff >= 300) {
            if (true) {
                $getPackage = RegisterPackage::where("student_id", $Studentid)->first();
                $packageID = 0;
                if (!empty($getPackage)) {
                    $packageID = $getPackage->package_id;
                }

                $resdelete = StudentAttendance::where('student_id', $Studentid)->where('attendance_status', 9)->whereDate('created_at', Carbon::today())->delete();
                if ($resdelete) {
                    $arrr = [
                        'teacher_id' => $teacherID,
                        'student_id' => $Studentid,
                        'day' => $localtimeday,
                        'day_name' => $this->days_name($localtimeday),
                        'student_day' => $studenttimeday,
                        'student_day_name' => $this->days_name($studenttimeday),
                        'attdendance_time' => $localtime,
                        'attendance_time_text' => Carbon::createFromFormat('g:i a', $localtime)->format('g:i A'),
                        "package_id" => $packageID,
                        'duration' => $duration,
                        "package_id" => 0,
                        'attendance_status' => 9,
                        'attendance_type' => 1,
                        'attendance_date_time' => Carbon::now()->toDateString().' '.Carbon::createFromFormat('g:i A', $localtime)->format('H:i:s'),
                        'created_by' => 1,
                        'isTafseer' => $isTafseer,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    StudentAttendance::insert($arrr);
                } else {

                    if (($diff > 0) && $diff >= 60) {
                        $rescount = StudentAttendance::where('student_id', $Studentid)->count();
                        if ($rescount == 0) {

                            $getPackage = RegisterPackage::where("student_id", $Studentid)->first();
                            $packageID = 0;
                            if (!empty($getPackage)) {
                                $packageID = $getPackage->package_id;
                            }

                            $arrr = [
                                'teacher_id' => $teacherID,
                                'student_id' => $Studentid,
                                'day' => $localtimeday,
                                'day_name' => $this->days_name($localtimeday),
                                'student_day' => $studenttimeday,
                                'student_day_name' => $this->days_name($studenttimeday),
                                'attdendance_time' => $localtime,
                                'attendance_time_text' => Carbon::createFromFormat('g:i a', $localtime)->format('g:i A'),
                                "package_id" => $packageID,
                                'duration' => $duration,
                                "package_id" => 0,
                                'attendance_status' => 9,
                                'attendance_type' => 1,
                                'attendance_date_time' => Carbon::now()->toDateString().' '.Carbon::createFromFormat('g:i A', $localtime)->format('H:i:s'),
                                'created_by' => 1,
                                'isTafseer' => $isTafseer,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];

                            StudentAttendance::insert($arrr);
                        }else{
                            $arrr = [
                                'teacher_id' => $teacherID,
                                'student_id' => $Studentid,
                                'day' => $localtimeday,
                                'day_name' => $this->days_name($localtimeday),
                                'student_day' => $studenttimeday,
                                'student_day_name' => $this->days_name($studenttimeday),
                                'attdendance_time' => $localtime,
                                'attendance_time_text' => Carbon::createFromFormat('g:i a', $localtime)->format('g:i A'),
                                "package_id" => $packageID,
                                'duration' => $duration,
                                "package_id" => 0,
                                'attendance_status' => 9,
                                'attendance_type' => 1,
                                'attendance_date_time' => Carbon::now()->toDateString().' '.Carbon::createFromFormat('g:i A', $localtime)->format('H:i:s'),
                                'created_by' => 1,
                                'isTafseer' => $isTafseer,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
        
                            StudentAttendance::insert($arrr);
                        }
                    }

                }

            }

        }

    }

    public function update(Request $request)
    {

        $oldstdrecord = DB::table('student')->where('id', $request->id)->first();

        $Student = new Student();
        $Student->studentname = $request->name;
        $Student->country = $request->country;
        $Student->fathername = $request->fathername;
        $Student->studentemail = $request->email;
        $Student->studentemail2 = $request->studentemail2;
        $Student->billingemail = $request->billingemail;
        $Student->contact_no = $request->contact_no;
        $Student->detail = $request->detail;
        $Student->group = $request->groupno;
        $Student->whatsapp = $request->whatsApp;
        $Student->skypid_1 = $request->skype1;
        $Student->skypid_2 = $request->skype2;
        $Student->age = $request->age;
        $Student->gender = $request->gender;
        $Student->city = $request->city;
        $Student->timezone = $request->timezoneName;
        $Student->joining_source = $request->resource;
        $Student->agency_id = $request->marketingagencies;
        $Student->ref_name = $request->referencename;
        $Student->ref_email = $request->referenceemail;
        $Student->ref_group = $request->referencegroup;
        $Student->payment_currency = $request->currencysymbol;
        $Student->duration = $request->duration;
        $Student->class_type = $request->classtype;
        if ($request->academicStatus != $request->oldacademicStatus) {
            $Student->academicStatus = $request->academicStatus;
        }
        $Student->academicStatus = $request->academicStatus;
        $Student->created_by = auth()->id();
        $Student->teacher_assign_type = $request->teacherassigntype;
        $Student->teacher_assign_status = $request->teacherassign;
        $Student->dob = $request->dob;
        if ($request->resource == 2) {

            if ($request->referralGenerateOrNot == 1) {

                if ($request->referencegroup) {

                    $referencegroup = $request->referencegroup;

                    $ReferralStudetn = DB::table('student')->where('group', $referencegroup)->where('id', '!=', $request->id)->where('academicStatus', 1)->get();
                    if (count($ReferralStudetn) > 0) {

                        DB::table('teacherReferal')->where('referraStudentId', $request->id)->delete();

                        $totalReferStudent = count($ReferralStudetn);
                        $amount = 2000 / $totalReferStudent;
                        $data = array();
                        foreach ($ReferralStudetn as $valreferal) {
                            $data[] = [
                                'referraStudentId' => $request->id,
                                'referraGroup' => $request->groupno,
                                'studentID' => $valreferal->id,
                                'teacherID' => $valreferal->teacher_id,
                                'groupno' => $valreferal->group,
                                'amount' => $amount,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'created_by' => Auth::user()->id,
                            ];
                        }
                        DB::table('teacherReferal')->insert($data);
                    }
                }

            }

        }

        if ($request->teacherassign == 2) {
            $Student->teacheSchduledate = $request->teacherscduledate;
            $Student->teacheSchduletime = Carbon::createFromFormat('g:i a', $request->teacherscduletime);
            $Student->step_status = 4;
            $teacherID = 0;
            $Student->teacher_id = $teacherID;
        } else {
            $Student->teacher_id = $request->teacherid;
            $Student->step_status = ($request->academicStatus == 6) ? 1 : 5;

            $teacherID = $request->teacherid;
        }
        $Student->teacher_requirement = $request->teacherrequirement;
        $Student->isTafseer = $request->isTafseer;
        $Student->exists = true;
        $Student->id = $request->id;
        $Student->save();

        StudentLanguageLookup::where('student_id', $request->id)->delete();

        if (isset($request->language)) {
            if (count($request->language) > 0) {
                foreach ($request->language as $key => $lang) {
                    $stdlanguage = new StudentLanguageLookup();
                    $stdlanguage->student_id = $request->id;
                    $stdlanguage->language_id = $lang;
                    $stdlanguage->save();
                }
            }
        }

        $days = $request->days;
        $localtimeday = $request->localtimeday;
        $studenttimeday = $request->studenttimeday;
        $localtime = $request->localtime;
        $studenttime = $request->studenttime;
        $daysarray = array();
        $daysexist = '';

        $student_dayarryDB = DB::table('student_days')->where('student_id', $Student->id)->pluck('student_day_no')->toArray();
        $student_olddaytimearryDB = DB::table('student_days')->where('student_id', $Student->id)->pluck('local_time_text')->toArray();

        $OLDstudent_dayarry = DB::table('student_days')->where('student_id', $Student->id)->get();
        DB::table('student_days')->where('student_id', $Student->id)->delete();
        if (isset($days)) {
            if (count($days) > 0) {
                $weekday = $weekend = 0;
                foreach ($days as $key => $val) {
                    // date("H:i:s", strtotime($studenttime[$key]))

                    if ($request->academicStatus == 1 || $request->academicStatus == 8) {
                        $this->checkAttendanceTime($localtime[$key], $localtimeday[$key], $studenttime[$key], $studenttimeday[$key], $request->duration, $Student->id, $teacherID, $request->isTafseer);
                    }
                    $data = array(
                        'day_name' => $this->days_name($localtimeday[$key]),
                        'day_no' => $localtimeday[$key],
                        'student_day_name' => $this->days_name($studenttimeday[$key]),
                        'student_day_no' => $studenttimeday[$key],
                        'local_time' => Carbon::createFromFormat('g:i a', $localtime[$key]),
                        'End_local_Time' => Carbon::createFromFormat('g:i a', $localtime[$key])->addMinutes($request->duration),
                        'local_time_text' => $localtime[$key],
                        'student_time' => Carbon::createFromFormat('g:i a', $studenttime[$key]),
                        'student_time_text' => $studenttime[$key],
                        'teacher_id' => $teacherID,
                        'student_id' => $Student->id,
                        'day_duration' => $request->duration,
                    );
                    $daysarray[] = $data;
                    if ($studenttimeday[$key] == 6 || $studenttimeday[$key] == 7) {
                        $weekend++;
                    } else {
                        $weekday++;

                        // $daysarray[] = $data;
                    }
                }
                DB::table('student_days')->insert($daysarray);

          

            }
        }

        if ($request->academicStatus != $request->oldacademicStatus) {

           
            DB::table('academicstatuschange')->
                insert([
                'teacher_id' => ($request->oldteacher) ? $request->oldteacher : $request->teacherid,
                'student_id' => $request->id,
                'previousStatus' => $request->oldacademicStatus,
                'status' => $request->academicStatus,
                'reason_id' => $request->reason,
                'description' => $request->reasondetail,
                'created_by' => auth()->id(),
            ]);

            // if($request->academicStatus == 1 || $request->academicStatus == 2  || $request->academicStatus == 3 || $request->academicStatus == 4 ){

           
        }
        if ($request->academicStatus == 6) {

            if ($request->trial_started_date) {
                DB::table('student')->where('id', $Student->id)->update([
                    'trial_started_date' => date('Y-m-d'),
                ]);
            }

        }

        if ($request->academicStatus == 1 and $request->oldacademicStatus == 6) {
            DB::table('student')->where('id', $Student->id)->update([
                'trial_started_date' => date('Y-m-d'),
            ]);
        }

        if ($request->oldteacher != $request->teacherid) {
            DB::table('teacherchange')->
                insert([
                'teacher_id' => ($request->oldteacher) ? $request->oldteacher : '',
                'newteacher_id' => ($request->teacherid) ? $request->teacherid : '',
                'student_id' => $request->id,
                'reason_id' => $request->teacherreason,
                'description' => $request->teacherreasondetail,
                'created_by' => auth()->id(),
            ]);

            if ($request->teacherassigntype == 2) {
                DB::table('studentReassignNewToOldTeacher')->where('studentid', $request->id)->update(['status' => 0]);
                DB::table('studentReassignNewToOldTeacher')->
                    insert([
                    'oldTeacherId' => $request->oldteacher,
                    'newTeacherId' => $request->teacherid,
                    'studentid' => $request->id,
                    'reassignDate' => date('Y-m-d', strtotime($request->reAssignStudenToOldTeacher)),
                    'reAssigntime' => Carbon::createFromFormat('g:i a', $request->reAssignStudenToOldTeachertime),
                    'temporaryAssignType' => $request->teachertemporaryassigntype,
                    'status' => 1,

                ]);

            }

         

        }
        return response()->json([
            'success' => 'Student Update successfully',
            'alert' => 'success',
            '$studenttimeday' => $studenttimeday,
            '$student_dayarryDB' => $student_dayarryDB,
            '$daysexist' => $daysexist,
        ]);

    }

    public function daystablegenerateFortask($OLDstudent_dayarry, $Newstudent_dayarry)
    {

        $olddaytable = '<div class="row"><div class="col-md-12">';

        if (count($OLDstudent_dayarry) > 0) {

            $olddaytable .= "<h3>Old Package Days</h3><hr/><br/>";
            $olddaytable .= '<div style="overflow-x:auto;"><table style="font-size:22px !important;text-align:center !important">';
            $olddaytable .= '<tr>';
            $olddaytable .= '<td>';
            $olddaytable .= '<table class="table-bordered">';
            $olddaytable .= '<tr><td>&nbsp;Days</td></tr>';
            $olddaytable .= '<tr><td>Student</td></tr>';
            $olddaytable .= '</table>';
            $olddaytable .= '</td>';
            foreach ($OLDstudent_dayarry as $index => $val) {

                $olddaytable .= '<td>';
                $olddaytable .= '<table class="table-bordered">';
                $olddaytable .= '<tr><td>' . $val->student_day_name . '</td></tr>';
                $olddaytable .= '<tr><td>' . $val->student_time_text . '</td></tr>';
                $olddaytable .= '</table>';
                $olddaytable .= '</td>';

            }
            $olddaytable .= '</tr>';
            $olddaytable .= '</table><div/><hr/><br/>';

        }

        if (count($OLDstudent_dayarry) > 0) {

            $olddaytable .= "<h3>New Package Days</h3><hr/><br/>";

        } else {
            $olddaytable .= "<h3>Package Days</h3><hr/><br/>";
        }
        $olddaytable .= '<div style="overflow-x:auto;"><table style="font-size:22px !important;text-align:center !important">';
        $olddaytable .= '<tr>';
        $olddaytable .= '<td>';
        $olddaytable .= '<table class="table-bordered">';
        $olddaytable .= '<tr><td>&nbsp;Days</td></tr>';
        $olddaytable .= '<tr><td>Student</td></tr>';
        $olddaytable .= '</table>';
        $olddaytable .= '</td>';
        foreach ($Newstudent_dayarry as $index => $val) {

            $olddaytable .= '<td>';
            $olddaytable .= '<table class="table-bordered">';
            $olddaytable .= '<tr><td>' . $val->student_day_name . '</td></tr>';
            $olddaytable .= '<tr><td>' . $val->student_time_text . '</td></tr>';
            $olddaytable .= '</table>';
            $olddaytable .= '</td>';

        }
        $olddaytable .= '</tr>';
        $olddaytable .= '</table></div></div></div>';

        return $olddaytable;

    }

    public function SendFcmNOtification($senderId, $recieverID, $title, $Description, $action_id, $notificationtype, $route)
    {

        $data = User::where('id', $recieverID)->first();
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

    public function generateTaskFoStudent($taskCreatedBy, $tasksubject, $studentid, $group, $taskDescription, $assignuserToArray, $fcmDescription, $taskrelateID, $notificationtype,
        $taskCompleteddate = null, $taskCompletedtime = null
    ) {

        $task = new Task();
        $task->assignUserid = $taskCreatedBy;
        $task->taskName = $tasksubject;
        $task->isAttachment = null;
        $task->isImportant = 1;
        $task->multi_student = $studentid;
        $task->multi_student_group = $group;
        $task->task_type = 1;
        $task->task_assign_type = 2;
        $task->taskDescription = $taskDescription;
        $task->taskCompleteddate = ($taskCompleteddate) ? $taskCompleteddate : date('Y-m-d');
        $task->taskCompletedtime = ($taskCompletedtime) ? $taskCompletedtime : date('Y-m-d');
        $task->firsttaskCompleteddate = ($taskCompleteddate) ? $taskCompleteddate : date('Y-m-d');
        $task->firsttaskCompletedtime = ($taskCompletedtime) ? $taskCompletedtime : date('Y-m-d');
        $task->created_by = $taskCreatedBy;
        $task->save();

        $assignerdata = $assignuserToArray;
        foreach ($assignerdata as $val) {
            $taskassign = new taskassign();
            $taskassign->taskId = $task->id;
            $taskassign->assignTo = $val;
            $taskassign->assignFrom = $taskCreatedBy;
            $taskassign->save();
        }

        $user = User::whereIn('id', $assignerdata)->get();
        $daarr = [];
        foreach ($user as $data) {

            // $datanotification[]  = array(
            //     'title' => $tasksubject,
            //     'body' => 'You Have a New Task',
            //     'targetid' => $task->id,
            //     'anchorroute' => route('admin.task.detail',$task->id),
            //  );

            $route = route('admin.task.detail', $task->id);
            $user_id = $data->id;
            $noti = new FcmNotification();
            $noti->sender_user_id = $taskCreatedBy;
            $noti->route = $route;
            $noti->title = $tasksubject;
            $noti->text = $fcmDescription;
            $noti->user_id = $user_id;
            $noti->action_id = $taskrelateID;
            $noti->notificationtype = $notificationtype;
            $noti->save();
            $token = $data->fcm_token;
            if ($token) {
                $noti->toSingleDevice($token, $user_id, $tasksubject, $fcmDescription, null, $route);
            }

            //     $daarr[] = array(
            //     'id' => $data->id,
            //     'name' => $data->name,
            //     'role' => $data->role,
            //  );
            // \Notification::send($data ,  new TaskNotifications($datanotification,$data->id));

        }

    }

    public function getTaskTitle($tasktype, $id)
    {

        $ret = '';

        if ($tasktype == 1) {
            $ret = 'Student ' . Student::where('id', $id)->first()->studentname . ' Package has been Changed';
        } else if ($tasktype == 2) {

            $ret = 'Student ' . Student::where('id', $id)->first()->studentname . ' Remove Your Student List';
        } else if ($tasktype == 3) {

            $ret = 'You Have a New  Student ' . Student::where('id', $id)->first()->studentname;
        } else {
            $ret = 'Student ' . Student::where('id', $id)->first()->studentname . ' Time has been Changed';
        }

        return $ret;

    }

    public function teacherFeedbackSave(Request $request)
    {

        $rules = array(
            'description' => 'required|max:191',
            'studentid' => 'required|max:191',
            'teacherid' => 'required|max:191',
        );
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }
        try {

            $feedback = DB::table('feedbackaboutteacher')->insert([
                'teacher_id' => $request->teacherid,
                'student_id' => $request->studentid,
                'feedback' => $request->description,
                'question1' => $request->ratingquestion1,
                'question2' => $request->ratingquestion2,
                'question3' => $request->ratingquestion3,
                'question4' => $request->ratingquestion4,
                'question5' => $request->ratingquestion5,

            ]);

            $std = new Student();
            $std->feedbackstatus = 1;
            $std->exists = true;
            $std->id = $request->studentid;
            $std->save();

            if (!$feedback) {
                return response()->json([
                    'success' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Feedback Save successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function BillingStatusSave(Request $request)
    {

        $std = new Student();
        $std->billing_status = $request->status;
        $std->billing_started_date = date('Y-m-d h:i:s');
        $std->exists = true;
        $std->id = $request->studentid;
        $std->save();

        return response()->json([
            'success' => 1,
        ]);

    }

    public function AcademicStatusSave(Request $request)
    {
        $std = new Student();
        $std->academicStatus = $request->status;
        $std->exists = true;
        $std->id = $request->studentid;
        $std->save();

        return response()->json([
            'success' => 1,
        ]);
    }

    public function getStudentDetail(Request $request)
    {

        $Student = Student::Select(['student.*', 'a.agencyname', 'cities.CityName'])
            ->leftjoin('advertisement_agencies as a', 'a.id', '=', 'student.agency_id')
            ->leftjoin('cities', 'student.city', '=', 'cities.id')
            ->where('student.id', $request->id)->first();
        $languages = StudentLanguageLookup::Select(['student_language_lookups.*', 'l.languagename'])->leftjoin('languages as l', 'l.id', '=', 'student_language_lookups.language_id')->where('student_language_lookups.student_id', $request->id)->get();
        $days = DB::table('student_days')->where('student_id', $request->id)->get();

        return response()->json([
            'success' => 1,
            'languages' => $languages,
            'days' => $days,
            'Student' => $Student,
        ]);
    }

    public function setStudentRecoveryclass(Request $request)
    {
        $classdata = DB::table('studentattendance')->Select(['studentattendance.*', 'atd.status_name', DB::raw('DATE_FORMAT(created_at,"%d-%m-%Y") as date'), DB::raw('DATE_FORMAT(attdendance_time,"%l:%i %p") as classtime')
            , DB::raw('DATE_FORMAT(created_at,"%a") as day'),
        ])->leftjoin('attendance_status as atd', 'atd.status', '=', 'studentattendance.attendance_status')

            ->whereRaw("DATE_FORMAT(created_at,'%d-%m-%Y') = DATE_FORMAT('$request->date','%d-%m-%Y')")
            ->where('student_id', $request->studentid)->where('studentattendance.attendance_type', '!=', 2)->where('studentattendance.attendance_status', '!=', 1)->get();
        return response()->json([
            'success' => 1,
            'classdata' => $classdata,
        ]);
    }

    public function SchduleStudentRecoveryclass(Request $request)
    {

        $rules = array(
            'recoveryclassTeacher' => 'required',
            'student_id' => 'required',
            'attendance_id' => 'required',
            'recoveryclasstime' => 'required',
            'recoveryclassDate' => 'required',
            'recoveryclasspayment' => 'required',
            'recoveryclassattendIssue' => 'required',
            'comment' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $attendanceStatus = ($request->recoveryclasspayment == 1) ? 3 : 9;
            // if($request->recoveryclasspayment  == 1){
            $studentdata = Student::select('timezone', 'isTafseer')->find($request->student_id);

            $converttime = Converttimezone($request->recoveryclassDate . ' ' . $request->recoveryclasstime, 'Asia/Tashkent', $studentdata->timezone);
            $recoveryclasstime24 = date("H:i:s", strtotime($request->recoveryclasstime));
            $arrr = [
                'teacher_id' => $request->recoveryclassTeacher,
                'student_id' => $request->student_id,
                'day' => $this->full_days_name_no(Carbon::parse($request->recoveryclassDate)->format('l')),
                'day_name' => Carbon::parse($request->recoveryclassDate)->format('l'),
                'student_day' => $this->full_days_name_no(Carbon::parse($converttime)->format('l')),
                'student_day_name' => Carbon::parse($converttime)->format('l'),
                'attdendance_time' => date("H:i:s", strtotime($request->recoveryclasstime)),
                'attendance_time_text' => $request->recoveryclasstime,
                'duration' => $request->duration,
                'attendance_status' => 9,
                'attendance_type' => 3,
                'attendance_date_time' => $request->recoveryclassDate . ' ' . $recoveryclasstime24,
                'created_by' => 1,
                'isTafseer' => $studentdata->isTafseer,
                'created_at' => $request->recoveryclassDate . ' ' . $recoveryclasstime24,
                'updated_at' => $request->recoveryclassDate . ' ' . $recoveryclasstime24,
            ];
            // 'updated_at' => Carbon::now()->toTimeString(),

            $attendance_id = DB::table('studentattendance')->insertGetId($arrr);
            DB::table('studentattendance')->where('id', $request->attendance_id)->update(['attendance_type' => 2, 'attendance_status' => $attendanceStatus]);
            // return $arrr;

            // }else{
            //     $attendance_id =   $request->attendance_id;
            //     DB::table('studentattendance')->where('id',$request->attendance_id)->update(['attendance_type' => 3]);
            // }
            $studentSchd = DB::table('recovery_class')->insert([
                'attendancid' => $attendance_id,
                'recoveryteacherid' => $request->recoveryclassTeacher,
                'currentTeacherid' => $request->currentteacherid,
                'studentid' => $request->student_id,
                'day' => Carbon::parse($request->recoveryclassDate)->format('l'),
                'time' => Carbon::createFromFormat('g:i a', $request->recoveryclasstime),
                'date' => date('Y-m-d', strtotime($request->recoveryclassDate)),
                'payment_type' => $request->recoveryclasspayment,
                'issue_type' => $request->recoveryclassattendIssue,
                'comment' => $request->comment,
            ]);

            if (!$studentSchd) {
                return response()->json([
                    'success' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Student Recovery  Schdule Successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function saveStudentCommentForm(Request $request)
    {

        $rules = array(
            'comment' => 'required',
            'id' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $studentSchd = DB::table('student_comment_history')->insert([
                'studentId' => $request->id,
                'comment' => $request->comment,
                'created_by' => auth()->id(),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (!$studentSchd) {
                return response()->json([
                    'success' => 'Something Went Wrong.',
                    'alert' => 'error',
                ]);
            }
            return response()->json([
                'success' => 'Comment Save Successfully',
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function savedeductionstatus(Request $request)
    {

        $rules = array(
            'status' => 'required',
            'attendanceID' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $status = 1;
            $statusText = "Dedcution Add Successfully";
            if ($request->status == 1) {
                $status = 2;
                $statusText = "Dedcution Remove Successfully";
            }

            $studentSchd = DB::table('studentattendance')->where('id', $request->attendanceID)->update(['isDeduct' => $status]);

            return response()->json([
                'msg' => $statusText,
                'alert' => 'success',
            ]);

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
        }

    }

    public function LoadFcmNotificationBytype(Request $request)
    {

        if ($request->ajax()) {
            $id = Auth::user()->id;
            $noti = new FcmNotification();

            $tasknoti = $noti->allNotificationByType($id, ['task']);
            $StudentUpdatenoti = $noti->allNotificationByType($id, ['StudentUpdate', 'comment']);
            $taskcount = $noti->NumberAlertByType($id, ['task']);
            $StudentUpdatecount = $noti->NumberAlertByType($id, ['StudentUpdate', 'comment']);

            $democount = $noti->NumberAlertByType($id, ['DemoStudent', 'StudentTailComplete']);
            $demoStudentnoti = $noti->allNotificationByType($id, ['DemoStudent', 'StudentTailComplete']);

            return response()->json([
                'StudentUpdatenoti' => $StudentUpdatenoti,
                'tasknoti' => $tasknoti,
                'taskcount' => $taskcount,
                'StudentUpdatecount' => $StudentUpdatecount,
                'democount' => $democount,
                'demoStudentnoti' => $demoStudentnoti,
            ]);
        }

    }

    public function LoadFcmNotification(Request $request)
    {

        if ($request->ajax()) {
            $id = Auth::user()->id;
            $noti = new FcmNotification();
            $notification = $noti->Allnotification($id);
            return view('admin.FcmNotification.notification', compact('notification'));
        }

    }

    public function ReadFcmNotification(Request $request)
    {

        if ($request->ajax()) {

            $id = Auth::user()->id;

            FcmNotification::where('id', $request->id)->update(['read_at' => date('Y-m-d H:i:s')]);
            $noti = new FcmNotification();

            return response()->json([
                'success' => 'Update',
                'alert' => 'success',
                'taskcount' => $noti->NumberAlertByType($id, ['task']),
                'StudentUpdatecount' => $noti->NumberAlertByType($id, ['StudentUpdate', 'comment']),
                'democount' => $noti->NumberAlertByType($id, ['DemoStudent', 'StudentTailComplete']),
            ]);
        }

    }

    public function uploadstudent()
    {
        return view('admin.student.uploader');
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }

            }
            fclose($handle);
        }

        return $data;
    }

    public function uploadFile(Request $request)
    {

        if ($request->input('submit') != null) {

            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if (in_array(strtolower($extension), $valid_extension)) {

                // Check file size
                if ($fileSize <= $maxFileSize) {

                    // File upload location
                    $location = 'uploads';

                    // Upload file
                    $file->move($location, $filename);

                    // Import CSV to Database
                    $filepath = public_path($location . "/" . $filename);

                    // Reading file
                    //   $file = fopen($filepath,"r");

                    //   $importData_arr = array();
                    //   $i = 0;

                    //   while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    //      $num = count($filedata );

                    //      // Skip first row (Remove below comment if you want to skip the first row)
                    //      /*if($i == 0){
                    //         $i++;
                    //         continue;
                    //      }*/
                    //      for ($c=0; $c < $num; $c++) {
                    //         $importData_arr[$i][] = $filedata [$c];
                    //      }
                    //      $i++;
                    //   }
                    //   fclose($file);

                    $customerArr = $this->csvToArray($filepath);

                    //   dd($customerArr);
                    //   die();

                    $insertData = [];

                    try {
                        for ($i = 0; $i < count($customerArr); $i++) {

                            $insertData[] = array(
                                "group" => $customerArr[$i]['group'],
                                "name" => $customerArr[$i]['Name'],
                                "gender" => $this->gender($customerArr[$i]['gender']),
                                "email" => $customerArr[$i]['Email'],
                                "Age" => $customerArr[$i]['Age'],
                                "Father" => $customerArr[$i]['Father'],
                                "Ref" => $customerArr[$i]['Ref'],
                                "Style" => $customerArr[$i]['Style'],
                                "Book" => $customerArr[$i]['Book'],
                                "studenttime" => $customerArr[$i]['Time'],
                                "pakistantime" => $customerArr[$i]['PK T'],
                                "Days" => $customerArr[$i]['Days'],
                                "Country" => $this->getCountry($customerArr[$i]['Country']),
                                "City" => $customerArr[$i]['City'],
                                "Demo" => $customerArr[$i]['Demo'],
                                "Trial" => $customerArr[$i]['Trial'],
                                "Status" => $customerArr[$i]['Status'],
                                "Teacher" => $customerArr[$i]['Teacher'],
                                "Skype" => $customerArr[$i]['Skype'],
                                "Skype2" => $customerArr[$i]['Skype2'],
                                "Phone" => $customerArr[$i]['Phone'],
                                "Note" => $customerArr[$i]['Note'],
                                "OldTeacher" => $customerArr[$i]['OldTeacher'],
                                "LessonStatus" => $customerArr[$i]['LessonStatus'],
                            );

                            $user = new User();
                            $user->email = 'student' . $this->getStudentGUIDnoHash() . '@sispn.com';
                            $user->name = $customerArr[$i]['Name'];
                            $user->password = Hash::make('12345');
                            $user->role = 'student';
                            $user->save();
                            $user->assignRole('student');
                            $userid = $user->id;

                            $text = 'Style : ' . $customerArr[$i]['Style'] . ' Book : ' . $customerArr[$i]['Book'] . ' studenttime : ' . $customerArr[$i]['Time'] . 'pakistantime : ' . $customerArr[$i]['PK T']
                                . ' Days ' . $customerArr[$i]['Days'] . ' City ' . $customerArr[$i]['City'] . ' Demo ' . $customerArr[$i]['Demo'] . ' Trial ' . $customerArr[$i]['Trial'] . ' Status ' . $customerArr[$i]['Status']
                                . ' Note ' . $customerArr[$i]['Note'] . ' Note ' . $customerArr[$i]['Note'] . ' OldTeacher ' . $customerArr[$i]['OldTeacher'] . ' LessonStatus ' . $customerArr[$i]['LessonStatus'];

                            $Student = new Student();
                            $Student->user_id = $userid;
                            $Student->studentname = $customerArr[$i]['Name'];
                            $Student->studentemail = $customerArr[$i]['Email'];
                            $Student->country = $this->getCountry($customerArr[$i]['Country']);
                            $Student->fathername = $customerArr[$i]['Father'];
                            $Student->studentemail = $customerArr[$i]['Email'];
                            $Student->contact_no = $customerArr[$i]['Phone'];
                            $Student->detail = nl2br($text);
                            $Student->group = '1' . $customerArr[$i]['group'];
                            $Student->whatsapp = $customerArr[$i]['Phone'];
                            $Student->skypid_1 = $customerArr[$i]['Skype'];
                            $Student->skypid_2 = $customerArr[$i]['Skype2'];
                            $Student->age = $customerArr[$i]['Age'];
                            $Student->gender = $this->gender($customerArr[$i]['gender']);
                            $Student->step_status = 1;
                            $Student->academicStatus = strtolower($this->getStatus($customerArr[$i]['Status']));

                            $Student->joining_date = date('Y-m-d');
                            $Student->class_type = 1;
                            $Student->save();

                            User::where('id', $userid)->update([
                                'email' => 'student' . $Student->id . '@sispn.com',
                            ]);

                            $languge = explode("/", $customerArr[$i]['Language']);
                            if (isset($languge)) {
                                if (count($languge) > 0) {
                                    foreach ($languge as $key => $lang) {
                                        $stdlanguage = new StudentLanguageLookup();
                                        $stdlanguage->student_id = $Student->id;
                                        $stdlanguage->language_id = $this->getLanguageID($lang);
                                        $stdlanguage->save();
                                    }
                                }
                            }

                            //   foreach($languge as $index => $val){

                            //       $languageID =   $this->getLanguageID($val);

                            //             // $insertData[] =   $val;
                            //   }

                        }

                    } catch (Exception $e) {
                        return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
                    } catch (\Illuminate\Database\QueryException $ex) {
                        return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
                    }

                    // Insert to MySQL database
                    //   foreach($customerArr as $index => $importData_arr){

                    //     $insertData[] = array(
                    //       "group"=>$importData_arr['name'],
                    //     //   "name"=>$importData[$index]->name,
                    //     //   "gender"=>$importData[$index]->gender,
                    //     //   "email"=>$importData[$index]->email
                    //       );
                    //     // Page::insertData($insertData);

                    //   }

                    //   dd($insertData);
                    //   die();

                    Session::flash('message', 'Import Successful.');
                } else {
                    Session::flash('message', 'File too large. File must be less than 2MB.');
                }

            } else {
                Session::flash('message', 'Invalid File Extension.');
            }

        }

        // Redirect to index
        return redirect()->action('PagesController@index');
    }

    public function gender($param)
    {

        if ($param == 'female' || $param == 'Female') {
            return 2;
        } else {
            return 1;
        }
    }

    public function getteacher($username)
    {
        if ($username) {
            $employee = Employee::Select(['employees.id'])->leftjoin('users', 'employees.user_id', '=', 'users.id')->where('name', $username)->first();
            if ($employee) {
                return $employee->id;
            } else {
                return 0;
            }

        } else {
            return 0;
        }
    }

    public function getCountry($param)
    {

        if ($param) {
            $country = Country::Select(['id'])->where('CountryName', 'LIKE', "%{$param}%")->first();
            if ($country) {
                return $country->id;
            } else {
                $country = Country::Select(['id'])->where('CountryShortName', 'LIKE', "%{$param}%")->first();
                return ($country) ? $country->id : 0;
            }

        } else {
            return 0;
        }

        // return $param;
    }

    public function getCity($param, $cid)
    {

        if ($param) {
            $city = City::Select(['id'])->where('CityName', 'LIKE', "%{$param}%")->where('CountryID', $cid)->first();
            return ($city) ? $city->id : City::Select(['id'])->where('CountryID', $cid)->first();
        } else {

            $city = City::Select(['id'])->where('CountryID', $cid)->first();

            return ($city) ? $city->id : 0;
        }

        // return $param;
    }

    public function getLanguageID($param)
    {

        if ($param) {
            $languages = Language::Select(['id'])->where('languagename', 'LIKE', "%{$param}%")->first();
            return ($languages) ? $languages->id : 0;
        } else {
            return 0;
        }

        // return $param;
    }

    public function getStatus($param)
    {

        $stats = '';
        if ($param == "active" || $param == "Active") {

            $stats = 1;

        } else if ($param == "inactive" || $param == "Inactive") {
            $stats = 2;
        } else if ($param == "leave" || $param == "Leave") {
            $stats = 3;
        } else if ($param == "closed" || $param == "Closed" || $param == "close") {
            $stats = 4;
        } else if ($param == "rejected" || $param == "Rejected" || $param == "reject") {
            $stats = 5;
        } else if ($param == "Completed") {
            $stats = 7;
        } else {
            $stats = 6;
        }

        return $stats;
    }

    // public function  getteacher($param){

    //     if($param){
    //          $user_id = User::Select(['id'])->where('name',$param)->first()->id;
    //          $Employee =   Employee::Select(['id'])->where('CountryID',$user_id)->first();
    //         return ($Employee) ? $Employee->id : 0 ;
    //     }else{
    //         return 0;
    //     }

    //     // return $param;
    // }

    public function full_days_name_no($val)
    {
        $day = '';
        switch ($val) {
            case 'Monday':
                $day = '1';
                break;
            case 'Tuesday':
                $day = '2';
                break;
            case 'Wednesday':
                $day = '3';
                break;
            case 'Thursday':
                $day = '4';
                break;
            case 'Friday':
                $day = '5';
                break;
            case 'Saturday':
                $day = '6';
                break;
            case 'Sunday':
                $day = '7';
                break;
        }

        return $day;
    }

    public function days_name_new($val)
    {
        $day = '';
        switch ($val) {
            case 'Mon':
                $day = 'Monday';
                break;
            case 'Tue':
                $day = 'Tuesday';
                break;
            case 'Tu':
                $day = 'Tuesday';
                break;
            case 'Wed':
                $day = 'Wednesday';
                break;
            case 'Thu':
                $day = 'Thursday';
                break;
            case 'Th':
                $day = 'Thursday';
                break;
            case 'Fri':
                $day = 'Friday';
                break;
            case 'Sat':
                $day = 'Saturday';
                break;
            case 'Sun':
                $day = 'Sunday';
                break;
        }

        return $day;
    }
    public function days_name_no($val)
    {
        $day = '';
        switch ($val) {
            case 'Mon':
                $day = '1';
                break;
            case 'Tue':
                $day = '2';
                break;
            case 'Tu':
                $day = '2';
                break;
            case 'Wed':
                $day = '3';
                break;
            case 'Thu':
                $day = '4';
                break;
            case 'Th':
                $day = '4';
                break;
            case 'Fri':
                $day = '5';
                break;
            case 'Sat':
                $day = '6';
                break;
            case 'Sun':
                $day = '7';
                break;
        }

        return $day;
    }

    public function uploadFile_newdata(Request $request)
    {

        if ($request->input('submit') != null) {

            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Valid File Extensions
            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if (in_array(strtolower($extension), $valid_extension)) {

                // Check file size
                if ($fileSize <= $maxFileSize) {

                    $location = 'uploads';
                    $file->move($location, $filename);
                    $filepath = public_path($location . "/" . $filename);

                    $customerArr = $this->csvToArray($filepath);

                    //   dd($customerArr);
                    //   die();

                    $insertData = [];

                    try {
                        for ($i = 0; $i < count($customerArr); $i++) {

                            $cid = $this->getCountry($customerArr[$i]['Country']);

                            $insertData[$i][] = array(
                                "group" => $customerArr[$i]['group'],
                                "name" => $customerArr[$i]['Name'],
                                "gender" => $this->gender($customerArr[$i]['gender']),
                                "email" => $customerArr[$i]['Email'],
                                "Age" => $customerArr[$i]['Age'],
                                "Father" => $customerArr[$i]['Father'],
                                "Ref" => $customerArr[$i]['Ref'],
                                "Style" => $customerArr[$i]['Style'],
                                "Book" => $customerArr[$i]['Book'],
                                "studenttime" => $customerArr[$i]['StudentTime'],
                                "pakistantime" => $customerArr[$i]['PK T'],
                                "Days" => $customerArr[$i]['Days'],
                                "Country" => $cid,
                                "Country_name" => $customerArr[$i]['Country'],
                                "City" => $this->getCity($customerArr[$i]['City'], $cid),
                                "City_name" => $customerArr[$i]['City'],
                                "Demo" => $customerArr[$i]['Demo'],
                                "Trial" => $customerArr[$i]['Trial'],
                                "Status" => $customerArr[$i]['Status'],
                                "Teacher" => $customerArr[$i]['Teacher'],
                                "Skype" => $customerArr[$i]['Skype'],
                                "Skype2" => $customerArr[$i]['Skype2'],
                                "Phone" => $customerArr[$i]['Phone'],
                                "Note" => $customerArr[$i]['Note'],
                                "OldTeacher" => $customerArr[$i]['OldTeacher'],
                                "LessonStatus" => $customerArr[$i]['LessonStatus'],
                                "Teacher" => $this->getTeacher($customerArr[$i]['Teacher']),
                                "Timezone" => ($customerArr[$i]['Time Zone']) ? $customerArr[$i]['Time Zone'] : "Europe/London",
                            );

                            $teacherID = $this->getTeacher($customerArr[$i]['Teacher']);
                            $user = new User();
                            $user->email = 'student' . $this->getStudentGUIDnoHash() . '@sispn.com';
                            $user->name = $customerArr[$i]['Name'];
                            $user->password = Hash::make('12345');
                            $user->role = 'student';
                            $user->save();
                            $user->assignRole('student');
                            $userid = $user->id;

                            $text = 'Style : ' . $customerArr[$i]['Style'] . ' Book : ' . $customerArr[$i]['Book'] . ' studenttime : ' . $customerArr[$i]['StudentTime'] . 'pakistantime : ' . $customerArr[$i]['PK T']
                                . ' Days ' . $customerArr[$i]['Days'] . ' City ' . $customerArr[$i]['City'] . ' Demo ' . $customerArr[$i]['Demo'] . ' Trial ' . $customerArr[$i]['Trial'] . ' Status ' . $customerArr[$i]['Status']
                                . ' Note ' . $customerArr[$i]['Note'] . ' Note ' . $customerArr[$i]['Note'] . ' OldTeacher ' . $customerArr[$i]['OldTeacher'] . ' LessonStatus ' . $customerArr[$i]['LessonStatus'];

                            $Student = new Student();
                            $Student->user_id = $userid;
                            $Student->studentname = $customerArr[$i]['Name'];
                            $Student->studentemail = $customerArr[$i]['Email'];
                            $Student->country = $this->getCountry($customerArr[$i]['Country']);
                            $Student->city = $this->getCity($customerArr[$i]['City'], $cid);
                            $Student->fathername = $customerArr[$i]['Father'];
                            $Student->studentemail = $customerArr[$i]['Email'];
                            $Student->contact_no = $customerArr[$i]['Phone'];
                            $Student->detail = nl2br($text);
                            $Student->group = '1' . $customerArr[$i]['group'];
                            $Student->whatsapp = $customerArr[$i]['Phone'];
                            $Student->skypid_1 = $customerArr[$i]['Skype'];
                            $Student->skypid_2 = $customerArr[$i]['Skype2'];
                            $Student->age = $customerArr[$i]['Age'];
                            $Student->joining_source = 1;
                            $Student->agency_id = 1;
                            $Student->gender = $this->gender($customerArr[$i]['gender']);
                            $Student->step_status = 1;
                            $Student->academicStatus = strtolower($this->getStatus($customerArr[$i]['Status']));
                            $Student->timezone = ($customerArr[$i]['Time Zone']) ? $customerArr[$i]['Time Zone'] : "Europe/London";
                            $Student->teacher_id = $teacherID;

                            $Student->joining_date = date('Y-m-d');
                            $Student->class_type = 1;
                            $Student->save();

                            User::where('id', $userid)->update([
                                'email' => 'student' . $Student->id . '@sispn.com',
                            ]);

                            $languge = explode("/", $customerArr[$i]['Language']);
                            if (isset($languge)) {
                                if (count($languge) > 0) {
                                    foreach ($languge as $key => $lang) {
                                        $stdlanguage = new StudentLanguageLookup();
                                        $stdlanguage->student_id = $Student->id;
                                        $stdlanguage->language_id = $this->getLanguageID($lang);
                                        $stdlanguage->save();

                                        $insertData[$i]['languages'][] = $this->getLanguageID($lang);
                                    }
                                }
                            }

                            if ($this->getStatus($customerArr[$i]['Status']) == 1) {

                                $localtimeday = explode(",", $customerArr[$i]['teacherDays']);
                                $studenttimeday = explode(",", $customerArr[$i]['Days']);
                                $localtime = $customerArr[$i]['PK T'];
                                $studenttime = $customerArr[$i]['StudentTime'];
                                $daysarray = array();

                                if (isset($localtimeday)) {
                                    if (count($localtimeday) > 0) {

                                        foreach ($localtimeday as $key => $val) {
                                            // date("H:i:s", strtotime($studenttime[$key]))
                                            // $data = array(
                                            //     'day_name' => $this->days_name_new($localtimeday[$key]),
                                            //     'day_no' => $localtimeday[$key],
                                            //     'student_day_name' => $this->days_name_new($studenttimeday[$key]),
                                            //     'student_day_no' => $studenttimeday[$key],
                                            //     'local_time' => Carbon::createFromFormat('g:i a', $localtime[$key]),
                                            //     'local_time_text' => $localtime[$key],
                                            //     'student_time' => Carbon::createFromFormat('g:i a', $studenttime[$key]),
                                            //     'student_time_text' => $studenttime[$key],
                                            //      'teacher_id' => $teacherID,
                                            //     'student_id' => $Student->id,
                                            //      'day_duration' => $request->duration,
                                            // );

                                            $data = array(
                                                'student_id' => $Student->id,
                                                'day_name' => ($localtimeday[$key]) ? $this->days_name_new($localtimeday[$key]) : 'not found',
                                                'day_no' => ($this->days_name_no($localtimeday[$key])) ? $this->days_name_no($localtimeday[$key]) : 'not found',
                                                'student_day_name' => (isset($studenttimeday[$key])) ? $this->days_name_new($studenttimeday[$key]) : 'not found',
                                                'student_day_no' => (isset($studenttimeday[$key])) ? ($this->days_name_no($studenttimeday[$key])) ? $this->days_name_no($studenttimeday[$key]) : 'not found' : '',
                                                'local_time' => (isset($localtime)) ? ($localtime) ? Carbon::createFromFormat('g:i a', $localtime) : 'not found' : '',
                                                'local_time_text' => (isset($localtime)) ? ($localtime) ? $localtime : 'not found' : '',
                                                'student_time' => (isset($studenttime)) ? ($studenttime) ? Carbon::createFromFormat('g:i a', $studenttime) : 'not found' : '',
                                                'student_time_text' => (isset($studenttime)) ? ($studenttime) ? $studenttime : 'not found' : '',
                                                'teacher_id' => $teacherID,
                                                'day_duration' => 30,
                                            );

                                            $insertData[$i]['student_days'][] = $data;

                                            $daysarray[] = $data;
                                        }
                                        DB::table('student_days')->insert($daysarray);

                                    }
                                }
                            }

                            //   foreach($languge as $index => $val){

                            //       $languageID =   $this->getLanguageID($val);

                            //             // $insertData[] =   $val;
                            //   }

                        }

                        // echo '<pre>';
                        // echo print_r($insertData);
                        // echo '</pre>';
                        // die();

                    } catch (Exception $e) {
                        return response()->json(['success' => 0, 'error' => $e->getMessage()], 500);
                    } catch (\Illuminate\Database\QueryException $ex) {
                        return response()->json(['success' => 0, 'error' => $ex->getMessage()], 500);
                    }

                    // Insert to MySQL database
                    //   foreach($customerArr as $index => $importData_arr){

                    //     $insertData[] = array(
                    //       "group"=>$importData_arr['name'],
                    //     //   "name"=>$importData[$index]->name,
                    //     //   "gender"=>$importData[$index]->gender,
                    //     //   "email"=>$importData[$index]->email
                    //       );
                    //     // Page::insertData($insertData);

                    //   }

                    //   dd($insertData);
                    //   die();

                    Session::flash('message', 'Import Successful.');
                } else {
                    Session::flash('message', 'File too large. File must be less than 2MB.');
                }

            } else {
                Session::flash('message', 'Invalid File Extension.');
            }

        }

        // Redirect to index
        return redirect()->action('PagesController@index');
    }

}

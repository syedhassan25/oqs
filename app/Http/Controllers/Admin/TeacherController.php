<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\models\AdvertisementAgencies;
use App\models\City;
use App\models\complainAboutTeacher;
use App\models\Country;
use App\models\Custom;
use App\models\Employee;
use App\models\EmployeeLanguageLookup;
use App\models\EmployeeSkillsLookup;
use App\models\Employee_leave;
use App\models\Language;
use App\models\Skill;
use App\models\Student;
use App\models\Teacherattendance;
use App\models\TeacherChangeHistory;
use App\models\User;
use Auth;
use Carbon\Carbon;
use Config;
use DateTime;
use DateTimeZone;
use DB;
use Hash;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;

class TeacherController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function studentNonActive()
    {
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        $this->setPageTitle('Non Active Student', 'List  of all  Non Active Student');
        return view('admin.student.nonactivestudent', compact('Employee'));
    }

    public function saveComplainAboutTeacherForm(Request $request)
    {

        $rules = array(
            'complain' => 'required',
            'id' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $studentSchd = complainAboutTeacher::insert([
                'employee_id' => $request->id,
                'comment' => $request->complain,
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

    public function getComplainAboutTeacherforms(Request $request)
    {
        $Student = complainAboutTeacher::select(['complain_about_teachers.*', 'usercreator.name as creatorname', 'users.name'])
            ->leftjoin('users as usercreator', 'usercreator.id', '=', 'complain_about_teachers.created_by')
            ->leftjoin('users', 'users.id', '=', 'complain_about_teachers.employee_id');
        $Student->where('complain_about_teachers.employee_id', $request->id)
            ->orderby('complain_about_teachers.created_at', 'desc');

        return Datatables::of($Student)->make(true);

    }

    public function get_teacher_complain_forms(Request $request)
    {

        $userid = Employee::where('id', $request->id)->first()->user_id;

        $complain = DB::table('complain')->select(['complain.*'])->where('sender_user_id', $userid);
        return Datatables::of($complain)

        //   ->addColumn('action', function ($complain) {

        //       $ret =  '<button data-id="'.$complain->id.'" class="btn btn-primary btneditcomplain">Reply</button>' ;

        //       return $ret;

        //   })
            ->addColumn('reciever', function ($complain) {

                $ret = ($complain->reciver_type == 1) ? "Section Incharge" : 'Team';

                return $ret;

            })

            ->rawColumns(['reciever'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_student_forms($groupno, $teacherID, $status)
    {

        $Student = Student::select(['student.*', 'countries.CountryName', 'employees.employeename'])
            ->selectRaw('(CASE WHEN student.class_type = 1 THEN "Trail" ELSE "Regular" END) as class_status')
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');
        $Student->where('student.academicStatus', $status);

        if ($teacherID) {
            $Student->where('student.teacher_id', $teacherID);
        }

        if ($groupno) {
            $Student->where('student.group', $groupno);
        }

        $Student->orderby('student.id', 'desc');

        return Datatables::of($Student)
            ->addColumn('action', function ($Student) {

                $ret = '';
                $ret .= $Student->academic_status_name->academic_status;;
                return $ret;

            })
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                return $ret;

            })
            ->addColumn('empprofile', function ($Student) {

                $ret = '';
                if ($Student->teacher_id) {
                    $editurl = ($Student->teacher_id) ? route('admin.teacher.edit', $Student->teacher_id) : '#';
                    $schurl = ($Student->teacher_id) ? route('admin.teacher.student.weekly.schedule.calender', $Student->teacher_id) : '#';
                    $ret = '';
                    $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->employeename . '</a> | <a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $schurl . '">schdule</a>';
                }

                return $ret;

            })
            ->addColumn('detail', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->id);
                }

                $ret = '';
                $ret .= '<button  class="btnstudentdetail btn" title="Detail" style="cursor:pointer"  data-id="' . $Student->id . '"><i class="fa fa-eye"></i></button >&nbsp;|&nbsp;<button  class="btnstudentcommentmodal btn" title="Comments" style="cursor:pointer" href="#"   data-id="' . $Student->id . '"><i class="fa fa-comment"></i></button >&nbsp;|&nbsp;<button  class="btnscduleDemo btn" title="Schdule Demo" style="cursor:pointer" href="#" data-zone="' . $Student->zone . '"    data-id="' . $Student->id . '"><i class="fa fa-play"></i></button >';
                return $ret;

            })
            ->addColumn('statusdescrition', function ($Student) {

                //   return $Student->last_reason->description;;

                return isset($Student->last_reason) ? $Student->last_reason->description : "";;

            })
            ->addColumn('statusreason', function ($Student) {

                return isset($Student->last_reason) ? $Student->last_reason->reason : "";;
                // return $Student->last_reason->reason;;

            })
            ->addColumn('created_atNew', function ($Student) {

                return isset($Student->last_reason) ? $Student->last_reason->created_at : "";;
                // return $Student->last_reason->created_at;;

            })

            ->rawColumns(['action', 'studentprofile', 'detail', 'empprofile', 'statusdescrition', 'statusreason', 'created_atNew'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_student_active_form(Request $request)
    {
        $teacherID = $request->teacherid;
        $groupno = $request->group;
        return $this->get_student_forms($groupno, $teacherID, 1);
    }
    public function get_student_inactive_form(Request $request)
    {
        $teacherID = $request->teacherid;
        $groupno = $request->group;
        return $this->get_student_forms($groupno, $teacherID, 2);
    }
    public function get_student_close_form(Request $request)
    {
        $teacherID = $request->teacherid;
        $groupno = $request->group;
        return $this->get_student_forms($groupno, $teacherID, 3);
    }
    public function get_student_leave_form(Request $request)
    {

        $teacherID = $request->teacherid;
        $groupno = $request->group;
        return $this->get_student_forms($groupno, $teacherID, 4);
    }

    public function studentreferralhistory_forms(Request $request)
    {
        $stdid = $request->teacherid;
        $group = $request->group;
        $Student = DB::table('teacherReferal')
            ->select(['teacherReferal.*', 'student.academicStatus', 'student.studentname', 'referrBystudent.studentname as referrStudentName', 'employees.employeename', DB::raw('FLOOR(teacherReferal.amount) as roundamount'), DB::raw("date_format(teacherReferal.created_at,'%d-%m-%Y %h:%i %p') as createt_at_new")])
            ->leftjoin('student', 'student.id', '=', 'teacherReferal.referraStudentId')
            ->leftjoin('employees', 'employees.id', '=', 'teacherReferal.teacherID')
            ->leftjoin('student as referrBystudent', 'referrBystudent.id', '=', 'teacherReferal.studentID');
        if ($stdid) {
            $Student->where('teacherReferal.teacherID', $stdid);
        }
        if ($group) {
            $Student->where('teacherReferal.referraGroup', $group);
        }
        $Student->orderby('teacherReferal.created_at', 'desc');

        return Datatables::of($Student)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->referraStudentId);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('studentprofilerefferel', function ($Student) {

                $editurl = '';
                if (isset($Student->studentID)) {
                    $editurl = route('admin.student.edit', $Student->studentID);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->referrStudentName . '</a>';
                // }

                return $ret;

            })
            ->addColumn('paidType', function ($Student) {

                $ret = '';
                if ($Student->paidStatus == "unPaid") {
                    $ret .= '<input type="date" class="paiddate" value="" />&nbsp;&nbsp;<Button data-id="' . $Student->id . '" class="btn btn-primary paiddatebtn">Update</Button>';
                }

                return $ret;

            })
            ->addColumn('statustext', function ($Student) {

                return $this->academic_status_name($Student->academicStatus);

            })

            ->rawColumns(['studentprofile', 'paidType', 'day', 'studentprofilerefferel', 'statustext'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function referralpaidTeacher(Request $request)
    {
        DB::table('teacherReferal')->where('id', $request->id)->update(['paiddate' => $request->paiddate]);

        return response()->json(['msg' => "Successfully Update Paid date"]);
    }

    public function referralTeacher()
    {
        $this->setPageTitle('Student Referral History', 'Student Referral History By Teacher');
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        return view('admin.teacher.referral', compact('Employee'));
    }

    public function studentTransferhistory()
    {
        $this->setPageTitle('Student Transfer History', 'Student Transfer History By Teacher');
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        $academicStatusArr = DB::table('academic_status')->get();
        return view('admin.teacher.studentTransferHistoryByTeacher', compact('Employee', 'academicStatusArr'));
    }

    public function studentTransferhistory_forms(Request $request)
    {
        $stdid = $request->teacherid;
        $group = $request->group;
        $Student = DB::table('teacherchange')->select(['teacherchange.*', 'studentdays.*', 'student.studentname', 'student.group', 'reason.reason', 'oldteacher.employeename as oldteachername', 'newteacher.employeename as newteachername', DB::raw("date_format(date_add(teacherchange.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")])
            ->join('employees as oldteacher', 'oldteacher.id', '=', 'teacherchange.teacher_id')
            ->join('employees as newteacher', 'newteacher.id', '=', 'teacherchange.newteacher_id')
            ->leftjoin('reason', 'reason.id', '=', 'teacherchange.reason_id')
            ->leftjoin('student', 'student.id', '=', 'teacherchange.student_id')
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id as stdid FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.stdid');
                });
        if ($stdid) {
            $Student->where('oldteacher.id', $stdid)
                ->orwhere('newteacher.id', $stdid);
        }
        if ($group) {
            $Student->where('student.group', $group);
        }
        $Student->orderby('teacherchange.created_at', 'desc');

        return Datatables::of($Student)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->stdid);
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
            ->rawColumns(['studentprofile', 'day'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function acdemichistoryDatatable(Request $request)
    {

        $teacheridid = $request->teacherid;
        $group = $request->group;
        $status = $request->status;
        $Previousstatus = $request->Previousstatus;
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $timeZoneChangeEuropeStatus = Config::get('app.timeChangeEuropeStatus');

        if ($timeZoneChangeEuropeStatus) {

            $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'student.studentname', 'student.group', 'users.name as creatorname', 'employees.employeename', 'reason.reason', DB::raw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d %h:%i %p') as created_new")])
                ->leftjoin('employees', 'employees.id', '=', 'academicstatuschange.teacher_id')
                ->leftjoin('reason', 'reason.id', '=', 'academicstatuschange.reason_id')
                ->leftjoin('users', 'users.id', '=', 'academicstatuschange.created_by')
                ->leftjoin('student', 'student.id', '=', 'academicstatuschange.student_id');
            if ($teacheridid) {
                $Student->where('academicstatuschange.teacher_id', $teacheridid);
            }
            if ($group) {
                $Student->where('student.group', $group);
            }
            if ($status) {
                $Student->where('academicstatuschange.status', $status);
            }
            if ($Previousstatus) {
                $Student->where('academicstatuschange.previousStatus', $Previousstatus);
            }
            if (!empty($start_date) && !empty($end_date)) {
                // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

                $start_date = date($start_date);
                $end_date = date($end_date);

                $Student->whereRaw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");

            }
            $Student->orderby('academicstatuschange.created_at', 'desc');

        } else {

            $Student = DB::table('academicstatuschange')->select(['academicstatuschange.*', 'student.studentname', 'student.group', 'users.name as creatorname', 'employees.employeename', 'reason.reason', DB::raw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 600 MINUTE),'%Y-%m-%d %h:%i %p') as created_new")])
                ->leftjoin('employees', 'employees.id', '=', 'academicstatuschange.teacher_id')
                ->leftjoin('reason', 'reason.id', '=', 'academicstatuschange.reason_id')
                ->leftjoin('users', 'users.id', '=', 'academicstatuschange.created_by')
                ->leftjoin('student', 'student.id', '=', 'academicstatuschange.student_id');
            if ($teacheridid) {
                $Student->where('academicstatuschange.teacher_id', $teacheridid);
            }
            if ($group) {
                $Student->where('student.group', $group);
            }
            if ($status) {
                $Student->where('academicstatuschange.status', $status);
            }
            if ($Previousstatus) {
                $Student->where('academicstatuschange.previousStatus', $Previousstatus);
            }
            if (!empty($start_date) && !empty($end_date)) {
                // $Class->whereBetween('studentattendance.created_at', [date($start_date), date($end_date)]);

                $start_date = date($start_date);
                $end_date = date($end_date);

                $start_date = date($start_date);
                $end_date = date($end_date);

                $Student->whereRaw("DATE_FORMAT(DATE_ADD(academicstatuschange.created_at,INTERVAL 600 MINUTE),'%Y-%m-%d') BETWEEN '$start_date' AND '$end_date'");

            }
            $Student->orderby('academicstatuschange.created_at', 'desc');

        }

        return Datatables::of($Student)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->student_id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('statustext', function ($Student) {

                return $this->academic_status_name($Student->status);

            })
            ->addColumn('previosstatustext', function ($Student) {

                return ($Student->previousStatus != 0) ? $this->academic_status_name($Student->previousStatus) : '';

            })
            ->rawColumns(['statustext', 'previosstatustext', 'studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_all_days_history_bystudent(Request $request)
    {

        $teacheridid = $request->teacherid;
        $group = $request->group;

        $daysHistory = DB::table('studentDayshistory')->select(['studentDayshistory.*', 'student.studentname', 'student.group', 'users.name as creatorname', 'employees.employeename', 'employees.id as employeeid'
            , DB::raw("date_format(date_add(studentDayshistory.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new"),
        ])
            ->leftjoin('student', 'studentDayshistory.student_id', '=', 'student.id')
            ->leftjoin('employees', 'employees.id', '=', 'studentDayshistory.teacher_id')
            ->leftjoin('users', 'users.id', '=', 'studentDayshistory.created_by');
        if ($teacheridid) {
            $daysHistory->where('studentDayshistory.teacher_id', $teacheridid);
        }
        if ($group) {
            $daysHistory->where('student.group', $group);
        }

        $daysHistory->orderby('studentDayshistory.created_at', 'desc');

        return Datatables::of($daysHistory)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->student_id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="_blank" rel="noopener noreferrer" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
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
            ->rawColumns(['teacherprofile', 'day', 'studentprofile'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function oldStudentTeacher()
    {
        $this->setPageTitle('Old Student History', 'Old Student  History By Teacher');
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        return view('admin.teacher.teacherOldStudent', compact('Employee'));
    }

    public function oldStudentTeacher_forms(Request $request)
    {
        $stdid = $request->teacherid;
        $group = $request->group;
        $Student = DB::table('teacherchange')->select(['teacherchange.*', 'studentdays.*', 'student.studentname', 'student.group', 'reason.reason', 'oldteacher.employeename as oldteachername', DB::raw("date_format(date_add(teacherchange.created_at,INTERVAL +11 HOUR),'%d-%m-%Y %h:%i %p') as createt_at_new")])
            ->join('employees as oldteacher', 'oldteacher.id', '=', 'teacherchange.teacher_id')
            ->leftjoin('reason', 'reason.id', '=', 'teacherchange.reason_id')
            ->leftjoin('student', 'student.id', '=', 'teacherchange.student_id')
            ->join(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id as stdid FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.stdid');
                });
        if ($stdid) {
            $Student->where('oldteacher.id', $stdid);
        }
        if ($group) {
            $Student->where('student.group', $group);
        }
        $Student->orderby('teacherchange.created_at', 'desc');

        return Datatables::of($Student)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = '';
                if (isset($Student->id)) {
                    $editurl = route('admin.student.edit', $Student->stdid);
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
            ->rawColumns(['studentprofile', 'day'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function academic_status_name($val)
    {

        return DB::table('academic_status')->where('academic_status_val', $val)->first()->academic_status;

    }

    public function getteacherbyGroup(Request $request)
    {

        $group = $request->group;
        $query = "";
        if ($group) {
            $query = " AND student.group = '$group'";
        }

        $teacherdata = DB::select("SELECT employees.employeename,employees.id FROM `student` INNER JOIN  employees on employees.id =  student.teacher_id  WHERE student.academicStatus = 1  $query  GROUP BY employees.id");
        return response()->json($teacherdata);

    }

    public function createattendance()
    {
        $this->setPageTitle('Attendance', 'Teacher Attendance Save');
        $Employee = Employee::Select(['employees.*', 'users.email'])
            ->selectRaw('(CASE WHEN employees.gender = 1 THEN "Male" ELSE "Female" END) as gender_type')
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->where('users.status', '1')
            ->where('employees.role_type', 'teacher')->get();
        return view('admin.teacher.attendancecreate', compact('Employee'));
    }

    public function saveattendance(Request $request)
    {

        $rules = array(
            'attendanceDate' => 'required',
            'teacher_id' => 'required',
            'attendanceStatus' => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
                'test' => 1,
            ]);
        }

        // DB::beginTransaction();

        // dd($request);

        try {

            $rescheckattendance = DB::table('teacherattendance')
                ->whereRaw("DATE_FORMAT(teacherattendance.attendance_date,'%d-%m-%Y') = DATE_FORMAT('$request->attendanceDate','%d-%m-%Y')")
                ->get();

            if (count($rescheckattendance) == 0) {
                $counteachid = $request->teacher_id;
                $attendanceStatus = $request->attendanceStatus;

                $arrr = [];
                foreach ($counteachid as $index => $val) {
                    $arrr[] = [
                        'teacher_id' => $val,
                        'attendance_status' => $attendanceStatus[$index],
                        'attendance_date' => $request->attendanceDate,
                        'created_by' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    // DB::table('teachertsest')->insert(['test' => $attendanceStatus[$index]]);

                    // DB::insert('insert into teachertsest (test) values (?)', array('Dayle'));

                    //       $teach  = new Teacherattendance();
                    //   $teach->teacher_id = 1;
                    //   $teach->attendance_status = 1;
                    //   $teach->attendance_date = $request->attendanceDate;
                    //   $teach->created_by = Auth::user()->id;
                    //   $teach->save();

                }



                DB::table('teacherattendance')->insert($arrr);

                return response()->json([
                    'Success' => 'true',
                    'msg' => 'Attendance Save Successfully',
                ]);

            } else {
                return response()->json([
                    'Success' => 'true',
                    'msg' => 'Attendance ALready Save On This date',
                ]);
            }

            // DB::commit();

        } catch (\Exception $e) {
            return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        }
    }

    public function attendancelist()
    {
        $this->setPageTitle('Teacher', 'Teacher Attendance List');
        $Employee = Employee::where('employees.role_type', 'teacher')->get();
        return view('admin.teacher.attendancelist', compact('Employee'));
    }

    public function get_emp_attendance_forms(Request $request)
    {
        $status = $request->status;
        $teacherID = $request->teacherId;
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $Employee = Teacherattendance::Select(['employees.*', 'users.email', 'teacherattendance.id as attendanceid', 'teacherattendance.id as attendanceid', 'teacherattendance.attendance_status'])
            ->selectRaw('(CASE WHEN employees.gender = 1 THEN "Male" ELSE "Female" END) as gender_type')
            ->leftjoin('employees', 'employees.id', '=', 'teacherattendance.teacher_id')
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->where('employees.role_type', 'teacher');

        if ($status) {
            $Employee->where('teacherattendance.attendance_status', $status);
        }
        if ($teacherID) {
            $Employee->where('teacherattendance.teacher_id', $teacherID);
        }
        if (!empty($start_date) && !empty($end_date)) {

            $start_date = Carbon::parse($start_date)->format('Y-m-d');

            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            $Employee->whereRaw("date_format(teacherattendance.attendance_date,'%Y-%m-%d') between '$start_date' and '$end_date'");

        } else {
            $Employee->whereDate('teacherattendance.attendance_date', Carbon::today());
        }

        return Datatables::of($Employee)
            ->addColumn('action', function ($Employee) {

                $ret = "";
                $arrayenum = array(
                    'Pending',
                    'Present',
                    'Absent',
                    'Leave',
                );

                $ret .= '<select required class="form-control attendancedrp" data-status="' . $Employee->attendance_status . '" name="attendanceStatus' . $Employee->attendanceid . '" id="attendanceStatus-' . $Employee->attendanceid . '">';

                foreach ($arrayenum as $index => $val) {

                    $value = $index;

                    $sel = ($Employee->attendance_status == $value) ? 'selected' : '';

                    $ret .= '<option data-id="' . $Employee->attendanceid . '" ' . $sel . ' value="' . $value . '">' . $val . '</option>';
                }

                $ret .= '</select>';

                return $ret;

            })
            ->rawColumns(['action'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function updateaAttendance(Request $request)
    {
        try {

            $rules = array(
                'id' => 'required|numeric',
                'status' => ['required', 'regex:(0|1|2|3)'],
            );

            $error = Validator::make($request->all(), $rules);
            if ($error->fails()) {
                return response()->json([
                    'error' => $error->errors()->getMessageBag(),
                ]);
            }

            $id = $request->id;

            $res = DB::table('teacherattendance')->where('id', $id)->update(['attendance_status' => $request->status]);

            return response()->json(['success' => 1], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => 2, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 1, 'error' => $ex->getMessage()], 500);
        }
    }

    public function schduleCalender()
    {
        $this->setPageTitle('Schdule', 'Student weekly Schdule');
        $Employee = Employee::Select(['employees.*'])->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->where('users.status', 1)->where('employees.role_type', 'teacher')->get();
        return view('admin.teacher.studentscdulecalender', compact('Employee'));
    }
    public function LoadscduleCalenderByTeacher($teacherid)
    {
        $scduledata = $this->Studentscdule($teacherid);
        // return view('admin.teacher.studentscdulecalenderPartial',compact('scduledata'))->render();
        return $scduledata;
    }
    public function schduleCalenderNewbyID($id)
    {
        $this->setPageTitle('Schdule', 'Student weekly Schdule');
        $scduledata = $this->LoadscduleCalenderByTeacher($id);

        // return $scduledata;
        $Employee = Employee::Select(['employees.*'])->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->where('users.status', 1)->where('employees.role_type', 'teacher')->get();
        return view('admin.teacher.newstudentWeeklyscdule', compact('Employee', 'scduledata', 'id'));
    }

    public function OldStudentscdule($id)
    {

        $data = [];
        $groupdata = [];
        for ($d = 0; $d <= 6; $d++) {

            $daynum = $d + 1;

            $res = DB::table('student_days')->select(['student_days.*', 'student.studentname', 'student.studentname', 'student.group', 'countries.CountryName'])
                ->leftjoin('student', 'student_days.student_id', '=', 'student.id')
                ->leftjoin('countries', 'student.country', '=', 'countries.id')
                ->where('student_days.teacher_id', $id)->where('student_days.day_no', $daynum)
                ->whereRaw("(student.academicStatus = 1 || student.academicStatus = 8 )")
                ->orderby('student_days.local_time', 'asc')->limit(1)->get();

            if (count($res) > 0) {

                foreach ($res as $index => $val) {
                    $duration = $val->day_duration;
                    $addduration = strval("+$duration minutes");
                    $start = DATE("h:ia", STRTOTIME($val->local_time));
                    $slot = strtotime($addduration, strtotime($val->local_time));

                    // $groupcolor  = $this->random_color_part();

                    $groupcolor = $this->randomColor(150, 255);
                    if (isset($groupdata[$val->group])) {

                        $groupcolor = $groupdata[$val->group];

                        // $groupcolor =  'found';
                    } else {
                        $groupdata[$val->group] = $groupcolor;

                        // $groupcolor = "not found";
                    }

                    $end = date('h:ia', $slot);

                    $studentstart = DATE("h:ia", STRTOTIME($val->student_time));
                    $studentslot = strtotime($addduration, strtotime($val->student_time));
                    $studentend = date('h:ia', $studentslot);

                    //  if($val->student_id == 506){
                    //      $start =  DATE("h:ia", STRTOTIME($val->student_time_text));
                    //     $slot = strtotime($addduration, strtotime($val->student_time_text));
                    //      $end = date('h:ia', $slot);
                    //  }

                    //               start: '2:00am',
                    //   end: '2:30am',
                    //   title: 'A black period',
                    //   backgroundColor: '#000',
                    //   borderColor: '#000',
                    //   textColor: '#fff'

                    $restime = "";
                    $time24 = strtotime('24:00:00');
                    $starttime = DATE("H:i:s", STRTOTIME($val->local_time));
                    $starttimenew = STRTOTIME($val->local_time);
                    if ($starttime <= $time24) {
                        if ($slot >= $time24) {

                            if ($starttimenew < $slot) {
                                $starttimenew += 24 * 60 * 60;
                            }
                            //   $restime =  ($starttimenew - $slot) / 60;

                            $date = date('Y-m-d');
                            $localtime = $val->local_time;
                            $localtimedate = date('Y-m-d H:i:s', strtotime("$date $localtime"));
                            $localtimedatennew = date('Y-m-d H:i:s', strtotime($addduration, strtotime($localtimedate)));
                            $localtimedate = date('Y-m-d', strtotime($localtimedate));
                            $localtimedatennew = date('Y-m-d', strtotime($localtimedatennew));

                            //     if($duration == 60){

                            //         $divisionval = 0;
                            //     $divisionval  =  (int)round($duration/2);

                            //     $divisionval =  strval("+$divisionval minutes");
                            //     $slot1 = strtotime($divisionval, strtotime($val->local_time));
                            //     $slot2 = strtotime($divisionval, $slot1);

                            //      $class = array(
                            //          '$localtimedate' => $localtimedate,
                            //          '$localtimedatennew' => $localtimedatennew,
                            //         'restime' => $divisionval,
                            //         'startnew' => STRTOTIME($val->local_time),
                            //         'endnew' => $slot,
                            //         'start' => date('h:ia', STRTOTIME($val->local_time)),
                            //         'end' => date('h:ia', $slot1),
                            //         'title' =>  substr($this->clean($val->studentname), 0, 15).' '.$val->group,
                            //         'backgroundColor' => $groupcolor,
                            //         'borderColor' => '#000',
                            //         'textColor' => '#000',
                            //         'studentid' => $val->student_id,
                            //         'group' => $val->group,
                            //         'CountryName' => $val->CountryName,
                            //         );

                            //   $data[$d]['day'] = $d;
                            //   $data[$d]['periods'][] = $class;

                            //     //day change then work this condition
                            //     $newday = $d;
                            //     if ($localtimedatennew > $localtimedate) {

                            //       if($newday == 6){
                            //           $newday = 0;
                            //       }
                            //       else if($newday < 6){
                            //           $newday  = $newday + 1;
                            //       }

                            //     }
                            //     else if($localtimedatennew < $localtimedate){
                            //                 if($newday == 0){
                            //                   $newday  =  6 ;
                            //               }else{
                            //                   $newday =  $newday - 1;
                            //               }
                            //     }

                            //     $class = array(
                            //         'restime' => $restime,
                            //         'startnew' => STRTOTIME($val->local_time),
                            //         'endnew' => $slot,
                            //         'start' => date('h:ia', $slot1),
                            //         'end' => date('h:ia', $slot2),
                            //         'title' =>  substr($this->clean($val->studentname), 0, 15).' '.$val->group,
                            //         'backgroundColor' => $groupcolor,
                            //         'borderColor' => '#000',
                            //         'textColor' => '#000',
                            //         'studentid' => $val->student_id,
                            //         'group' => $val->group,
                            //         'CountryName' => $val->CountryName,
                            //         );

                            //   $data[$newday]['day'] = $newday;
                            //   $data[$newday]['periods'][] = $class;

                            //     }
                            //     else{

                            $class = array(
                                'restime' => $restime,
                                'startnew' => STRTOTIME($val->local_time),
                                'endnew' => $slot,
                                'start' => $start,
                                'end' => $end,
                                'title' => substr($this->clean($val->studentname), 0, 15) . ' ' . $val->group,
                                'backgroundColor' => $groupcolor,
                                'borderColor' => '#000',
                                'textColor' => '#000',
                                'studentid' => $val->student_id,
                                'group' => $val->group,
                                'CountryName' => $val->CountryName,
                                'studentTime' => $studentstart . ' ' . $studentend,
                            );

                            $data[$d]['day'] = $d;
                            $data[$d]['periods'][] = $class;

                            // }

                        } else {
                            $restime = "no";

                            $class = array(
                                'restime' => $restime,
                                'startnew' => STRTOTIME($val->local_time),
                                'endnew' => $slot,
                                'start' => $start,
                                'end' => $end,
                                'title' => substr($this->clean($val->studentname), 0, 15) . ' ' . $val->group,
                                'backgroundColor' => $groupcolor,
                                'borderColor' => '#000',
                                'textColor' => '#000',
                                'studentid' => $val->student_id,
                                'group' => $val->group,
                                'CountryName' => $val->CountryName,
                                'studentTime' => $studentstart . ' ' . $studentend,
                            );

                            $data[$d]['day'] = $d;
                            $data[$d]['periods'][] = $class;

                        }
                    }

                    //   $data[$d]['periods']['group'] = $groupdata;

                }

            } else {

                $class = array(

                    'start' => '12:10 am',
                    'end' => '12:10 am',
                    'title' => 'none',
                    'backgroundColor' => '#DCF7E6',
                    'borderColor' => '#000',
                    'textColor' => '#000',
                    'studentid' => 0,
                    'group' => 0,
                    'CountryName' => 'no',
                    'studentTime' => '',
                );

                $data[$d]['day'] = $d;
                $data[$d]['periods'][] = $class;
            }

        }

        return $data;

    }

    public function Studentscdule($id)
    {

        $data = [];
        $groupdata = [];
        for ($d = 0; $d <= 6; $d++) {

            $daynum = $d + 1;

            $res = DB::table('student_days')->select(['student_days.*', 'student.studentname', 'student.studentname', 'student.group', 'countries.CountryName'])
                ->leftjoin('student', 'student_days.student_id', '=', 'student.id')
                ->leftjoin('countries', 'student.country', '=', 'countries.id')
                ->where('student_days.teacher_id', $id)->where('student_days.day_no', $daynum)
                ->whereRaw("(student.academicStatus = 1 || student.academicStatus = 8 )")
                ->orderby('student_days.local_time', 'asc')->get();

            if (count($res) > 0) {

                foreach ($res as $index => $val) {
                    $duration = $val->day_duration;
                    $addduration = strval("+$duration minutes");
                    $start = DATE("h:ia", STRTOTIME($val->local_time));
                    $slot = strtotime($addduration, strtotime($val->local_time));

                    // $groupcolor  = $this->random_color_part();

                    $groupcolor = $this->randomColor(150, 255);
                    if (isset($groupdata[$val->group])) {

                        $groupcolor = $groupdata[$val->group];

                        // $groupcolor =  'found';
                    } else {
                        $groupdata[$val->group] = $groupcolor;

                        // $groupcolor = "not found";
                    }

                    $end = date('h:ia', $slot);

                    $studentstart = DATE("h:ia", STRTOTIME($val->student_time));
                    $studentslot = strtotime($addduration, strtotime($val->student_time));
                    $studentend = date('h:ia', $studentslot);

                   

                    $restime = "";
                    $time24 = strtotime('24:00:00');
                    $starttime = DATE("H:i:s", STRTOTIME($val->local_time));
                    $starttimenew = STRTOTIME($val->local_time);
                    if ($starttime <= $time24) {
                        

                            if ($starttimenew < $slot) {
                                $starttimenew += 24 * 60 * 60;
                            }
                            //   $restime =  ($starttimenew - $slot) / 60;

                            $date = date('Y-m-d');
                            $localtime = $val->local_time;
                            $localtimedate = date('Y-m-d H:i:s', strtotime("$date $localtime"));
                            $localtimedatennew = date('Y-m-d H:i:s', strtotime($addduration, strtotime($localtimedate)));
                            $localtimedate = date('Y-m-d', strtotime($localtimedate));
                            $localtimedatennew = date('Y-m-d', strtotime($localtimedatennew));

                            if($daynum == 1){
                                $currentday = date( 'd-m-Y', strtotime( 'monday this week' ) );
                            }elseif($daynum == 2){
                                $currentday = date( 'd-m-Y', strtotime( 'tuesday this week' ) );
                            }
                            elseif($daynum == 3){
                                $currentday = date( 'd-m-Y', strtotime( 'thursday this week' ) );
                            }
                            elseif($daynum == 4){
                                $currentday = date( 'd-m-Y', strtotime( 'wednesday this week' ) );
                            }
                            elseif($daynum == 5){
                                $currentday = date( 'd-m-Y', strtotime( 'friday this week' ) );
                            }
                            elseif($daynum == 6){
                                $currentday = date( 'd-m-Y', strtotime( 'saturday this week' ) );
                            }
                            elseif($daynum == 7){
                                $currentday = date( 'd-m-Y', strtotime( 'sunday this week' ) );
                            }
                            
                            
                           


                            $class = array(
                                'id' => $val->student_id.'-'.$daynum,
                                'restime' => $restime,
                                'startnew' => STRTOTIME($val->local_time),
                                'endnew' => $slot,
                                'start' => $currentday.' '.date("H:i:s", strtotime($start)),
                                'end' => $currentday.' '.date("H:i:s", strtotime($end)),
                                'title' => substr($this->clean($val->studentname), 0, 5) . ' ' . $val->group,
                                'backgroundColor' => $groupcolor,
                                'borderColor' => '#000',
                                'textColor' => '#000',
                                'studentid' => $val->student_id,
                                'group' => $val->group,
                                'CountryName' => $val->CountryName,
                                'studentTime' => $studentstart . ' ' . $studentend,
                                'studentid' => $val->student_id
                            );

                            
                            $data[] = $class;

                          

                        
                    }

                    //   $data[$d]['periods']['group'] = $groupdata;

                }

            } else {

                // $class = array(

                //     'start' => '12:10 am',
                //     'end' => '12:10 am',
                //     'title' => 'none',
                //     'backgroundColor' => '#DCF7E6',
                //     'borderColor' => '#000',
                //     'textColor' => '#000',
                //     'studentid' => 0,
                //     'group' => 0,
                //     'CountryName' => 'no',
                //     'studentTime' => '',
                // );

                // $data[$d]['day'] = $d;
                // $data[$d]['periods'][] = $class;
            }

        }

        return $data;

    }

    public function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function random_color_part()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function randomColor($minVal = 0, $maxVal = 255)
    {

        // Make sure the parameters will result in valid colours
        $minVal = $minVal < 0 || $minVal > 255 ? 0 : $minVal;
        $maxVal = $maxVal < 0 || $maxVal > 255 ? 255 : $maxVal;

        // Generate 3 values
        $r = mt_rand($minVal, $maxVal);
        $g = mt_rand($minVal, $maxVal);
        $b = mt_rand($minVal, $maxVal);

        // Return a hex colour ID string
        return sprintf('#%02X%02X%02X', $r, $g, $b);

    }

    public function checkUserNameAvailability(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where('name', $request->username)->get();
            if ($user->count()) {
                return response()->json(false);
            }
            return response()->json(true);

        }

    }

    public function checkEmailAvailability(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where('email', $request->email)->get();
            if ($user->count()) {
                return response()->json(false);
            }
            return response()->json(true);

        }

    }

    public function index()
    {
        $this->setPageTitle('Teachers', 'List  of all Teachers');
        return view('admin.teacher.index');
    }

    public function calcualteaverage($q1, $q2, $q3, $q4, $q5)
    {

        $values = array($q1, $q2, $q3, $q4, $q5);

        $average = array_sum($values) / count($values);

        return $average;
    }

    public function get_student_feedback_forms(Request $request)
    {

        $stdid = $request->id;

        $Student = DB::table('feedbackaboutteacher')->select(['feedbackaboutteacher.*', 'student.studentname'])
            ->leftjoin('student', 'student.id', '=', 'feedbackaboutteacher.student_id')
            ->where('feedbackaboutteacher.teacher_id', $stdid);

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

    public function get_students_by_teacher_forms(Request $request)
    {

        $Student = Student::with(['first_attendance' => function ($query) use ($request) {
            return $query->where('teacher_id', $request->id);
        }])->select(['student.*', 'academic_status.academic_status', 'countries.CountryName'])
            ->selectRaw('(CASE WHEN student.class_type = 1 THEN "Trail" ELSE "Regular" END) as class_status')
            ->leftjoin('academic_status', 'academic_status.academic_status_val', '=', 'student.academicStatus')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        $Student->where('student.step_status', 5)->where('student.teacher_id', $request->id)->where('student.academicStatus', 1);

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="__window" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('attendancehistoryclick', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button type="button" class="btn btn-primary btnattendancehisotoryclick" data-id="' . $Student->id . '" >View Attendance</button>';
                // }

                return $ret;

            })
            ->addColumn('first_attendance_date', function ($Student) {

                $ret = '';
                if ($Student->first_attendance) {
                    $date = Carbon::parse($Student->first_attendance->created_at);
                    $ret .= $date->format('d-m-Y');
                }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'attendancehistoryclick', 'first_attendance_date'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
    public function get_students_by_teacher_leave_forms(Request $request)
    {

        $Student = Student::with(['first_attendance' => function ($query) use ($request) {
            return $query->where('teacher_id', $request->id);
        }])->select(['student.*', 'academic_status.academic_status', 'countries.CountryName'])
            ->selectRaw('(CASE WHEN student.class_type = 1 THEN "Trail" ELSE "Regular" END) as class_status')
            ->leftjoin('academic_status', 'academic_status.academic_status_val', '=', 'student.academicStatus')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        $Student->where('student.step_status', 5)->where('student.teacher_id', $request->id)->where('student.academicStatus', 3);

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="__window" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('attendancehistoryclick', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button type="button" class="btn btn-primary btnattendancehisotoryclick" data-id="' . $Student->id . '" >View Attendance</button>';
                // }

                return $ret;

            })
            ->addColumn('first_attendance_date', function ($Student) {

                $ret = '';
                if ($Student->first_attendance) {
                    $date = Carbon::parse($Student->first_attendance->created_at);
                    $ret .= $date->format('d-m-Y');
                }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'attendancehistoryclick', 'first_attendance_date'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
    public function get_students_by_teacher_otherstatus_forms(Request $request)
    {

        $Student = Student::with(['last_attendance' => function ($query) use ($request) {
            return $query->where('teacher_id', $request->id);
        }, 'first_attendance' => function ($query) use ($request) {
            return $query->where('teacher_id', $request->id);
        }])->select(['student.*', 'academic_status.academic_status', 'countries.CountryName'])
            ->selectRaw('(CASE WHEN student.class_type = 1 THEN "Trail" ELSE "Regular" END) as class_status')
            ->leftjoin('academic_status', 'academic_status.academic_status_val', '=', 'student.academicStatus')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        $Student->where('student.step_status', 5)->where('student.teacher_id', $request->id)->where('student.academicStatus', '!=', 1)->where('student.academicStatus', '!=', 3);

        return Datatables::of($Student)

            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="__window" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('attendancehistoryclick', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button type="button" class="btn btn-primary btnattendancehisotoryclick" data-id="' . $Student->id . '" >View Attendance</button>';
                // }

                return $ret;

            })
            ->addColumn('last_attendance_date', function ($Student) {

                $ret = '';
                if ($Student->last_attendance) {
                    $date = Carbon::parse($Student->last_attendance->created_at);
                    $ret .= $date->format('d-m-Y');
                }

                return $ret;

            })
            ->addColumn('first_attendance_date', function ($Student) {

                $ret = '';
                if ($Student->first_attendance) {
                    $date = Carbon::parse($Student->first_attendance->created_at);
                    $ret .= $date->format('d-m-Y');
                }

                return $ret;

            })

            ->addColumn('reasontype', function ($Student) {

                $ret = '';
                if ($Student->last_reason) {
                    $ret .= $Student->last_reason->reason;
                }

                return $ret;

            })
            ->addColumn('reasondescription', function ($Student) {

                $ret = '';
                if ($Student->last_reason) {
                    $ret .= $Student->last_reason->description;
                }

                return $ret;

            })

            ->rawColumns(['studentprofile', 'attendancehistoryclick', 'last_attendance_date', 'first_attendance_date'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function get_past_students_by_teacher_forms(Request $request)
    {

        $Student = TeacherChangeHistory
            ::with(['last_attendance' => function ($query) use ($request) {
                return $query->where('teacher_id', $request->id);
            }, 'first_attendance' => function ($query) use ($request) {
                return $query->where('teacher_id', $request->id);
            }])
            ->select(['teacherchange.*', 'academic_status.academic_status', 'employees.employeename', 'reason.reason', 'student.studentname', 'student.group'])
            ->selectRaw('(CASE WHEN student.class_type = 1 THEN "Trail" ELSE "Regular" END) as class_status')
            ->leftjoin('student', 'student.id', '=', 'teacherchange.student_id')
            ->leftjoin('employees', 'employees.id', '=', 'teacherchange.newteacher_id')
            ->leftjoin('reason', 'reason.id', '=', 'teacherchange.reason_id')
            ->leftjoin('academic_status', 'academic_status.academic_status_val', '=', 'student.academicStatus')
            ->where('teacherchange.teacher_id', $request->id);

        return Datatables::of($Student)
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.edit', $Student->student_id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a style="color:blue" target="__window" href="' . $editurl . '" >' . $Student->studentname . '</a>';
                // }

                return $ret;

            })
            ->addColumn('attendancehistoryclick', function ($Student) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button type="button" class="btn btn-primary btnattendancehisotoryclick" data-id="' . $Student->student_id . '" >View Attendance</button>';
                // }

                return $ret;

            })
            ->addColumn('last_attendance_date', function ($Student) {

                $ret = '';
                if ($Student->last_attendance) {
                    $date = Carbon::parse($Student->last_attendance->created_at);
                    $ret .= $date->format('d-m-Y');
                }

                return $ret;

            })
            ->addColumn('first_attendance_date', function ($Student) {

                $ret = '';
                if ($Student->first_attendance) {
                    $date = Carbon::parse($Student->first_attendance->created_at);
                    $ret .= $date->format('d-m-Y');
                }

                return $ret;

            })
            ->rawColumns(['studentprofile', 'attendancehistoryclick', 'last_attendance_date', 'first_attendance_date'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function get_emp_forms(Request $request)
    {

        $Employee = Employee::select(['employees.*', 'countries.CountryName', 'cities.CityName', 'users.email'])
            ->selectRaw('(CASE WHEN employees.gender = 1 THEN "Male" ELSE "Female" END) as gendertxt')
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->leftjoin('countries', 'employees.country_id', '=', 'countries.id')
            ->leftjoin('cities', 'cities.id', '=', 'employees.city_id')
            ->leftjoin('employee_language_lookups as ell', 'ell.employee_id', '=', 'employees.id')
            ->leftjoin('languages as l', 'l.id', '=', 'ell.language_id')
            ->where('employees.role_type', 'teacher');
        if ($request->status) {
            $Employee->where('users.status', $request->status);
        }
        $Employee->groupBy('employees.id');

        return Datatables::of($Employee)
            ->addColumn('action', function ($Employee) {

                $editurl = route('admin.teacher.edit', $Employee->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a class="btn btn-primary"  href="' . $editurl . '" >Edit</a>  <button class="btn btn-primary view_employee" data-id="' . $Employee->id . '"  >View</button> &nbsp;&nbsp; <button data-id="' . $Employee->id . '"  class="btn btn-primary btnteachercomplainmodal">complain</button>';
                // }

                return $ret;

            })
            ->addColumn('anyDeskcolumn', function ($Employee) {

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<p style="cursor:pointer;color:green" class="CopyAnydesckClass">' . $Employee->anyDesk . '</p>';
                // }

                return $ret;

            })
            ->rawColumns(['action', 'anyDeskcolumn'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $Country = Country::get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::get();
        $Skill = Skill::get();
        $document_names = DB::table('document_name')->get();

        $this->setPageTitle('Create Teacher', '');
        return view('admin.teacher.create', compact('Country', 'Language', 'Agencies', 'Skill', 'document_names'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'username' => 'required|max:191|unique:users,name',
            'email' => 'required|string|email|max:191|unique:users',
            'name' => 'required|max:191',
            'fname' => 'required|max:191',
            'resource' => 'required|max:191',
            'age' => 'required|max:191',
            'language.*' => 'required',
            'gender' => 'required|max:191',
            'maritalStatus' => 'required|max:191',
            'country' => 'required|max:191',
            'city' => 'required|max:191',
            'contactno' => 'required|max:191',
            'whatsappno' => 'required|max:191',
            'cardno' => 'required|max:191',
            'personalskype' => 'required|max:191',
            'currentaddress' => 'required',
            'permanentaddress' => 'required',
            'status' => 'required',

        );

        $validate['password'] = 'required|same:confirmpassword';
        $validate['confirmpassword'] = 'required';

        if ($request->resource == 2) {
            $rules['referencename'] = 'required';
            $rules['referenceemail'] = 'required';
        }
        if ($request->resource == 1) {
            $rules['marketingagencies'] = 'required';
        }

        $rules['skills.*'] = 'required';
        $rules['contractduration'] = 'required|max:191';
        $rules['experience'] = 'required|max:191';
        $rules['qualification'] = 'required|max:191';

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
                'test' => 1,
            ]);
        }

        DB::beginTransaction();

        // dd($request);

        try {

            $User = new User();
            $User->email = $request->email;
            $User->name = $request->username;
            $password = Hash::make($request->password);
            $User->password = $password;
            $User->password_text = $request->password;
            $User->status = $request->status;
            $User->role = 'teacher';
            $User->save();
            $User->assignRole('teacher');

            $genderval = ($request->gender == 1) ? 1 : 2;
            $employee = new Employee();
            $employee->user_id = $User->id;
            $employee->employeename = $request->name;
            $employee->employeefathername = $request->fname;
            $employee->resource_type = $request->resource;
            $employee->age = $request->age;
            $employee->anyDesk = $request->anyDesk;
            $employee->maritalStatus = $request->maritalStatus;
            $employee->gender = $genderval;
            $employee->country_id = $request->country;
            $employee->city_id = $request->city;

            $employee->contact_no_2 = $request->contactno2;
            $employee->contact_no = $request->contactno;
            $employee->whatsapp = $request->whatsappno;
            $employee->personalEmail = $request->personalEmail;
            $employee->identity_card_no = $request->cardno;
            $employee->personal_skype = $request->personalskype;
            $employee->current_address = $request->currentaddress;
            $employee->permanent_address = $request->permanentaddress;
            $employee->contract_duration = $request->contractduration;
            $employee->experience = $request->experience;
            $employee->qualification = $request->qualification;
            $employee->comment = $request->comment;
            $employee->role_type = 'teacher';
            if ($request->resource == 2) {
                $employee->resource_name = $request->referencename;
                $employee->resource_email = $request->referenceemail;
            }
            if ($request->resource == 1) {
                $employee->resource_agency_id = $request->marketingagencies;
            }
            $employee->save();

            if (count($request->language) > 0) {
                foreach ($request->language as $key => $lang) {
                    $emplanguage = new EmployeeLanguageLookup();
                    $emplanguage->employee_id = $employee->id;
                    $emplanguage->language_id = $lang;
                    $emplanguage->save();
                }
            }

            if (count($request->skills) > 0) {
                foreach ($request->skills as $key => $ski) {
                    $empskills = new EmployeeSkillsLookup();
                    $empskills->employee_id = $employee->id;
                    $empskills->skill_id = $ski;
                    $empskills->save();
                }
            }

            if ($request->documentname) {
                if (count($request->documentname) > 0) {
                    $dcumentarr = [];
                    $documentIsubmittext = $request->documentIsubmittext;
                    $documentcomment = $request->documentcomment;
                    foreach ($request->documentname as $key => $document) {
                        $dcumentarr[] = array(
                            'teacher_id' => $employee->id,
                            'document_name_id' => $document,
                            'received' => $documentIsubmittext[$key],
                            'comment' => $documentcomment[$key],
                            'created_by' => auth()->user()->id,
                        );
                    }

                    DB::table('teacher_documents')->insert($dcumentarr);
                }
            }

            $employeeno = $employee->id . '' . rand(100, 2) . '-' . date("Y");
            DB::table('employees')->where('id', $employee->id)->update(['employee_no' => $employeeno]);

            DB::commit();

            //      return $request;
            // die();

            return response()->json([
                'Success' => 'true', 'msg' => 'Save Successfully',
                'redirect' => route('admin.teacher.index'),
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetTeacher = Employee::find($id);
        $Country = Country::get();
        $City = City::where('CountryID', $targetTeacher->country_id)->get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::get();
        $Skill = Skill::get();
        $User = User::find($targetTeacher->user_id);

        $LanguageLookup = EmployeeLanguageLookup::where('employee_id', $id)->get();
        $SkillsLookup = EmployeeSkillsLookup::where('employee_id', $id)->get();
        $totalleave = Employee_leave::select(['employee_id', DB::raw("SUM(DATEDIFF(holiday_end_date,holiday_date )+1) AS TotalLeaveDays"), DB::raw('YEAR(created_at) year')])->where('employee_id', $id)->groupBy('employee_id', 'year')->get();

        // return $totalleave;

        $this->setPageTitle('Edit Teacher', 'Teacher : ' . $targetTeacher->employeename);
        return view('admin.teacher.edit', compact('totalleave', 'targetTeacher', 'LanguageLookup', 'SkillsLookup', 'User', 'Country', 'City', 'Language', 'Agencies', 'Skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'name' => 'required|max:191',
            'fname' => 'required|max:191',
            'resource' => 'required|max:191',
            'age' => 'required|max:191',
            'language.*' => 'required',
            'gender' => 'required|max:191',
            'maritalStatus' => 'required|max:191',
            'country' => 'required|max:191',
            'city' => 'required|max:191',
            'contactno' => 'required|max:191',
            'whatsappno' => 'required|max:191',
            'cardno' => 'required|max:191',
            'personalskype' => 'required|max:191',
            'currentaddress' => 'required',
            'permanentaddress' => 'required',
            'status' => 'required',

        );

        if ($request->password) {
            $validate['password'] = 'required|same:confirmpassword';
            $validate['confirmpassword'] = 'required';
        }
        if ($request->resource == 2) {
            $rules['referencename'] = 'required';
            $rules['referenceemail'] = 'required';
        }
        if ($request->resource == 1) {
            $rules['marketingagencies'] = 'required';
        }

        $rules['skills.*'] = 'required';
        $rules['contractduration'] = 'required|max:191';
        $rules['experience'] = 'required|max:191';
        $rules['qualification'] = 'required|max:191';

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
                'test' => 1,
            ]);
        }

        DB::beginTransaction();

        // dd($request);

        try {

            $User = new User();
            if ($request->password) {
                $password = Hash::make($request->password);
                $User->password = $password;
                $User->password_text = $request->password;
            }
            $User->status = $request->status;
            $User->exists = true;
            $User->id = $request->userid;
            $User->save();

            $genderval = ($request->gender == 1) ? 1 : 2;
            $employee = new Employee();
            $employee->user_id = $User->id;
            $employee->employeename = $request->name;
            $employee->employeefathername = $request->fname;
            $employee->resource_type = $request->resource;
            $employee->age = $request->age;
            $employee->personalEmail = $request->personalEmail;
            $employee->gender = $genderval;
            $employee->country_id = $request->country;
            $employee->city_id = $request->city;
            $employee->maritalStatus = $request->maritalStatus;
            $employee->contact_no_2 = $request->contactno2;
            $employee->contact_no = $request->contactno;
            $employee->whatsapp = $request->whatsappno;
            $employee->identity_card_no = $request->cardno;
            $employee->personal_skype = $request->personalskype;
            $employee->current_address = $request->currentaddress;
            $employee->permanent_address = $request->permanentaddress;
            $employee->contract_duration = $request->contractduration;
            $employee->experience = $request->experience;
            $employee->qualification = $request->qualification;
            $employee->comment = $request->comment;
            $employee->increment_percentage = $request->increment_percentage;
            $employee->salary = $request->salary;
            $employee->salaryStatus = $request->salaryStatus;
            $employee->anyDesk = $request->anyDesk;

            $employee->BeneficiaryName = $request->BeneficiaryName;
            $employee->AccountNo = $request->AccountNo;
            $employee->Bankcode = $request->Bankcode;
            $employee->BankName = $request->BankName;
            $employee->branchCode = $request->branchCode;
            $employee->branchName = $request->branchName;
            $employee->salarypass = $request->salarypass;

            if ($request->resource == 2) {
                $employee->resource_name = $request->referencename;
                $employee->resource_email = $request->referenceemail;
            }
            if ($request->resource == 1) {
                $employee->resource_agency_id = $request->marketingagencies;
            }
            $employee->exists = true;
            $employee->id = $request->employee_id;
            $employee->save();

            EmployeeLanguageLookup::where('employee_id', $request->employee_id)->delete();
            if (count($request->language) > 0) {
                foreach ($request->language as $key => $lang) {
                    $emplanguage = new EmployeeLanguageLookup();
                    $emplanguage->employee_id = $employee->id;
                    $emplanguage->language_id = $lang;
                    $emplanguage->save();
                }
            }
            EmployeeSkillsLookup::where('employee_id', $request->employee_id)->delete();
            if (count($request->skills) > 0) {
                foreach ($request->skills as $key => $ski) {
                    $empskills = new EmployeeSkillsLookup();
                    $empskills->employee_id = $employee->id;
                    $empskills->skill_id = $ski;
                    $empskills->save();
                }
            }

            DB::commit();
            return response()->json([
                'Success' => 'true', 'msg' => 'Save Successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function GetTimeByteachers($id)
    {

        $dayno = ["1", "3", "5"];
        $daytime = ["11:30 PM", "11:30 PM", "11:30 PM"];
        $duration = 15;

        $daysweek = [0, 1, 2, 3, 4, 5, 6];

        $data = [];
        for ($d = 0; $d <= 6; $d++) {

            $durationtime = [10, 15, 20, 30, 45, 60];

            $time = [];
            $dayno = $d + 1;

            $query = "SELECT teacher_id, student_id ,student_time,student_time_text,local_Time,day_duration FROM student_days WHERE
                        teacher_id = $id   and  day_no = $dayno  order by local_Time asc ";
            $res = DB::select($query);

            if (count($res) > 0) {

                foreach ($res as $val) {

                    $selectedTime = date('h:i', strtotime($val->local_Time));
                    $endTime = strtotime("+$val->day_duration minutes", strtotime($selectedTime));

                    $class = array(
                        'start' => date('h:i', strtotime($val->local_Time)),
                        'end' => date('h:i', $endTime),
                        'status' => 'booked',
                        'dayname' => $this->days_name($dayno),
                        'day' => $d,
                        'duration' => $val->day_duration,
                        'studentid' => $val->student_id,
                    );

                    $time[] = $class;

                }

                $data[$d][] = $time;

            }

        }

        return $data;
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

    public function searchFreeTimefuncTestDev(Request $request)
    {

        $rules = array(
            'day' => 'required|max:191',
            'daytime' => 'required|max:191',
            'duration' => 'required|max:191',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
                'test' => 1,
            ]);
        }

        // try{
        $dayno = $request->day;
        $daytime = $request->daytime;

        //old proceudre
        //  $duration = ($request->duration) ? ($request->duration) - 1 : 0;

        $duration = $request->duration;
        $country = $request->country;
        $language = $request->language;

        $Employee = Employee::Select(['employees.*'])
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->leftjoin('employee_language_lookups', 'employees.id', '=', 'employee_language_lookups.employee_id');
        if ($country) {
            $Employee->where('employees.country_id', $country);
        }
        if ($language) {

            $Employee->where('employee_language_lookups.language_id', $language);

            //   $language =  implode(', ', $language);

            //   $Employee->whereIn('employee_language_lookups.language_id',$language);

            //   $Employee->where(function($query) use($language){
            //     foreach($language as $keyword) {
            //         $query->orWhere('employee_language_lookups.language_id', $keyword);
            //     }
            // });

            // foreach($language as $keyword) {
            // $Employee->Where('employee_language_lookups.language_id', $keyword);

            //   $Employee->whereRaw("FIND_IN_SET('$keyword',employee_language_lookups.language_id)");

            // }

        }
        $Employee->groupBy('employees.id')->where('users.status', '1')->where('employees.role_type', 'teacher');
        $Employee = $Employee->get();
        $searchtime = [];
        $freeteacher = [];
        foreach ($Employee as $empindex => $val) {

            //   DB::table('employee_allowances')->insert([
            //       'employee_id' => $val->id ,
            //       'allowance_id' => 4 ,
            //       'type' => 1,
            //       'amount' => 2000 ,
            //       'created_by' =>8964 ,
            //       ]);

            $checkval = false;
            foreach ($dayno as $dayindex => $dayval) {

                $daynoinner = $dayval;
                $daytimeinner = $daytime[$dayindex];

                $CustomFunc = new Custom();
                $returndata = $CustomFunc->freeTeacherTimeSearchByModelTestversion($daynoinner, $daytimeinner, $duration, $val);

                if ($returndata == false) {
                    unset($searchtime[$empindex]);

                    $checkval = false;
                    break;
                } else {
                    //  $searchtime[$empindex][$dayindex][] = $returndata;

                    $checkval = true;

                    $searchtime[$empindex][$dayindex][] = $returndata;
                }

            }

            if ($checkval) {
                $freeteacher[] = array('teacher_id' => $val->id, 'teachername' => $val->employeename);
            }

        }

        return response()->json(['success' => 1, 'dayno' => $dayno, 'daytime' => $daytime, 'freeteacher' => $freeteacher, '$returndata' => $returndata]);

        // return response()->json([$searchtime]);

        // } catch (\Exception $e) {
        //     return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        // } catch (\Illuminate\Database\QueryException $ex) {
        //     return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        // }

    }
    public function searchFreeTimeattendancecreate(Request $request)
    {

        $rules = array(
            'day' => 'required|max:191',
            'daytime' => 'required|max:191',
            'duration' => 'required|max:191',
            'studentid' => 'required|max:191',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
                'test' => 1,
            ]);
        }

        // try{
        $dayno = $request->day;
        $daytime = $request->daytime;

        //old proceudre
        //  $duration = ($request->duration) ? ($request->duration) - 1 : 0;

        $duration = $request->duration;
        $country = $request->country;
        $language = $request->language;

        return response()->json(['success' => 1, 'dayno' => $dayno, 'daytime' => $daytime, 'freeteacher' => $freeteacher, '$returndata' => $returndata]);

        // return response()->json([$searchtime]);

        // } catch (\Exception $e) {
        //     return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        // } catch (\Illuminate\Database\QueryException $ex) {
        //     return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        // }

    }

    public function searchFreeTimefunc(Request $request)
    {

        $rules = array(
            'day' => 'required|max:191',
            'daytime' => 'required|max:191',
            'duration' => 'required|max:191',
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
                'test' => 1,
            ]);
        }

        // try{
        $dayno = $request->day;
        $daytime = $request->daytime;

        //old proceudre
        //  $duration = ($request->duration) ? ($request->duration) - 1 : 0;

        $duration = $request->duration;
        $country = $request->country;
        $language = $request->language;

        $Employee = Employee::Select(['employees.*'])
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->leftjoin('employee_language_lookups', 'employees.id', '=', 'employee_language_lookups.employee_id');
        if ($country) {
            $Employee->where('employees.country_id', $country);
        }
        if ($language) {

            $Employee->where('employee_language_lookups.language_id', $language);

            //   $language =  implode(', ', $language);

            //   $Employee->whereIn('employee_language_lookups.language_id',$language);

            //   $Employee->where(function($query) use($language){
            //     foreach($language as $keyword) {
            //         $query->orWhere('employee_language_lookups.language_id', $keyword);
            //     }
            // });

            // foreach($language as $keyword) {
            // $Employee->Where('employee_language_lookups.language_id', $keyword);

            //   $Employee->whereRaw("FIND_IN_SET('$keyword',employee_language_lookups.language_id)");

            // }

        }
        $Employee->groupBy('employees.id')->where('users.status', '1')->where('employees.role_type', 'teacher');
        $Employee = $Employee->get();
        $searchtime = [];
        $freeteacher = [];
        foreach ($Employee as $empindex => $val) {

            //   DB::table('employee_allowances')->insert([
            //       'employee_id' => $val->id ,
            //       'allowance_id' => 4 ,
            //       'type' => 1,
            //       'amount' => 2000 ,
            //       'created_by' =>8964 ,
            //       ]);

            $checkval = false;
            foreach ($dayno as $dayindex => $dayval) {

                $daynoinner = $dayval;
                $daytimeinner = $daytime[$dayindex];

                $CustomFunc = new Custom();
                $returndata = $CustomFunc->freeTeacherTimeSearchByModel($daynoinner, $daytimeinner, $duration, $val);

                if ($returndata == false) {
                    unset($searchtime[$empindex]);

                    $checkval = false;
                    break;
                } else {
                    //  $searchtime[$empindex][$dayindex][] = $returndata;

                    $checkval = true;

                    $searchtime[$empindex][$dayindex][] = $returndata;
                }

            }

            if ($checkval) {
                $freeteacher[] = array('teacher_id' => $val->id, 'teachername' => $val->employeename);
            }

        }

        return response()->json(['success' => 1, 'dayno' => $dayno, 'daytime' => $daytime, 'freeteacher' => $freeteacher, '$returndata' => $returndata]);

        // return response()->json([$searchtime]);

        // } catch (\Exception $e) {
        //     return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        // } catch (\Illuminate\Database\QueryException $ex) {
        //     return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        // }

    }

    public function getTeachersTime_nnn()
    {

        $dayno = date('w');
        $data = [];
        $counter = 0;

        $time = mktime(0, 0, 0, 1, 1);
        $j = 0;
        for ($i = 0; $i < 86400; $i += 1800) {
            //   echo date('g:i a', $time + $i).'--'.date('g:i a', $time + $i + 1800);

            $addduration = 30;
            // $daytimming  = DATE("H:i",STRTOTIME(date('g:i a', $time + $i + 1740)));

            $end = DATE("H:i", STRTOTIME(date('g:i a', $time + $i + 1740)));
            $start = DATE("H:i", STRTOTIME(date('g:i a', $time + $i)));

            //  $slot = strtotime($addduration, STRTOTIME($daytimming));
            //  $end = date('H:i', $slot);

            // echo DATE("H:i", STRTOTIME(date('g:i a', $time + $i))).'--'.$daytimming.'--------';
            //   '<br/>';

            $timearr = [];

            $query = "SELECT  count(student_days.id) as totalclass ,student_days.teacher_id,student_days.day_name,student_days.day_no ,student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days inner join student on student_days.student_id = student.id
                    WHERE student_days.day_no = $dayno AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)
                    and DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                    BETWEEN DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                    AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$end'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                   group by student_days.local_Time  ORDER BY `local_time_text` DESC";
            $res = DB::select($query);

            $counter += count($res);
            if (count($res) > 0) {

                foreach ($res as $val) {

                    $selectedTime = date('h:i', strtotime($val->local_Time));
                    $endTime = strtotime("+$val->day_duration minutes", strtotime($selectedTime));

                    $class = array(
                        'start' => date('h:i', strtotime($val->local_Time)),
                        'end' => date('h:i', $endTime),
                        'status' => 'booked',
                        'dayname' => $this->days_name($dayno),
                        'day' => date('l'),
                        'duration' => $val->day_duration,
                        'studentid' => $val->student_id,
                        'teacher_id' => $val->teacher_id,
                        'local_time_text' => $val->local_time_text,
                        'i' => $j,
                        'totalclass' => $val->totalclass,
                    );

                    $timearr[] = $class;

                }

                $data[$j]['record'][] = $timearr;
                $data[$j]['total'] = count($res);
                $data[$j]['start'] = date('g:i a', strtotime($start));
                $data[$j]['end'] = date('g:i a', strtotime("+1 minutes", strtotime($end)));

            } else {

                $data[$j]['record'][] = $timearr;
                $data[$j]['total'] = 0;
                $data[$j]['start'] = date('g:i a', strtotime($start));
                $data[$j]['end'] = date('g:i a', strtotime("+1 minutes", strtotime($end)));

            }

            $j += 1;

        }
        return $data;

    }

    public function getTeachersTimefunction()
    {

        $dayno = date('w');
        $data = [];
        $wholedata = [];
        $groupdata = [];
        $counter = 0;
        $totaldayclass = [];

        for ($d = 0; $d <= 6; $d++) {

            $daynum = $d + 1;

            $time = mktime(0, 0, 0, 1, 1);

            $j = 0;
            $sumclass = 0;
            for ($i = 0; $i < 86400; $i += 1800) {
                //   echo date('g:i a', $time + $i).'--'.date('g:i a', $time + $i + 1800);

                $addduration = 30;
                // $daytimming  = DATE("H:i",STRTOTIME(date('g:i a', $time + $i + 1740)));

                $end = DATE("H:i", STRTOTIME(date('g:i a', $time + $i + 1740)));
                $start = DATE("H:i", STRTOTIME(date('g:i a', $time + $i)));

                //  $slot = strtotime($addduration, STRTOTIME($daytimming));
                //  $end = date('H:i', $slot);

                // echo DATE("H:i", STRTOTIME(date('g:i a', $time + $i))).'--'.$daytimming.'--------';
                //   '<br/>';

                $timearr = [];

                $query = "SELECT  count(student_days.id) as totalclass,student_days.teacher_id,student_days.day_name,student_days.day_no ,student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days
                        inner join
                        student on student_days.student_id = student.id
                        WHERE student_days.day_no = $daynum AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)
                        and DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        BETWEEN DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$end'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                       group by student_days.local_Time  ORDER BY `local_time_text` DESC";
                $res = DB::select($query);

                $counter += count($res);
                if (count($res) > 0) {

                    foreach ($res as $val) {

                        $selectedTime = date('h:i', strtotime($val->local_Time));
                        $endTime = strtotime("+$val->day_duration minutes", strtotime($selectedTime));

                        $groupcolor = $this->randomColor(150, 255);
                        if (isset($groupdata[$val->totalclass])) {

                            $groupcolor = $groupdata[$val->totalclass];

                            // $groupcolor =  'found';
                        } else {
                            $groupdata[$val->totalclass] = $groupcolor;

                            // $groupcolor = "not found";
                        }

                        $sumclass += $val->totalclass;

                        $class = array(
                            // 'start' => date('h:i', strtotime($val->local_Time)),
                            // 'end' => date('h:i', $endTime),
                            // 'status' => 'booked',
                            // 'dayname' => $this->days_name($dayno),
                            // 'day' => date('l'),
                            // 'duration' => $val->day_duration,
                            // 'studentid' => $val->student_id,
                            // 'teacher_id' => $val->teacher_id,
                            //  'local_time_text' => $val->local_time_text,
                            //  'i' => $j,
                            //  'totalclass' => $val->totalclass

                            'start' => date('g:i a', strtotime($start)),
                            'end' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                            'title' => $val->totalclass . ' Classes',
                            'backgroundColor' => $groupcolor,
                            'borderColor' => '#fff',
                            'textColor' => '#fff',
                            'studentid' => 0,
                            'group' => 0,
                            'CountryName' => 'no',
                            'startFull' => date('g:i a', strtotime($start)),
                            'endFull' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                            'dayno' => $daynum,
                        );

                        $timearr[] = $class;

                    }

                    //   $data[$d]['record'][] = $timearr;
                    //   $data[$d]['total'] = count($res);
                    //   $data[$d]['start'] = date('g:i a',strtotime($start));
                    //   $data[$d]['end'] = date('g:i a',strtotime("+1 minutes", strtotime($end)));

                    $data[$d]['day'] = $d;
                    $data[$d]['periods'][] = $class;

                } else {

                    $class = array(

                        'start' => '12:10 am',
                        'end' => '12:10 am',
                        'title' => $val->totalclass,
                        'backgroundColor' => '#ccc',
                        'borderColor' => '#000',
                        'textColor' => '#000',
                        'studentid' => 0,
                        'group' => 0,
                        'CountryName' => 'no',
                        'startFull' => '12:10 am',
                        'endFull' => '12:10 am',
                        'dayno' => $daynum,
                    );

                    $data[$d]['day'] = $d;
                    $data[$d]['periods'][] = $class;

                    //   $data[$d]['record'][] = $timearr;
                    //   $data[$d]['total'] = 0;
                    //   $data[$d]['start'] = date('g:i a',strtotime($start));
                    //   $data[$d]['end'] = date('g:i a',strtotime("+1 minutes", strtotime($end)));

                }

                $j += 1;

            }

            $totaldayclass[$d] = $sumclass;

        }

        $wholedata = array(
            'totaldayclass' => $totaldayclass,
            'data' => $data,
        );
        return $wholedata;

    }
    public function getTeachersTime()
    {

        $this->setPageTitle('Weekly Schedule', '');
        $scduledata = $this->getTeachersTimefunction()['data'];
        $totaldayclass = $this->getTeachersTimefunction()['totaldayclass'];
        return view('admin.teacher.weeklyschdulecalender', compact('scduledata', 'totaldayclass'));

    }

    public function getTeachersByHourTime(Request $request)
    {

        $dayno = date('w');
        $data = [];
        $groupdata = [];
        $counter = 0;

        $addduration = 30;

        $endTime = strtotime("-1 minutes", STRTOTIME($request->endtime));
        $end = DATE("H:i", STRTOTIME(date('g:i a', $endTime)));
        $start = DATE("H:i", STRTOTIME(date('g:i a', STRTOTIME($request->starttime))));
        $daynum = $request->dayno;

        $timearr = [];

        $query = "SELECT  student_days.teacher_id,student.studentname,employees.employeename,student_days.day_name,student_days.day_no ,student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days inner join student on student_days.student_id = student.id
                         inner join
                        employees
                        on employees.id  = student_days.teacher_id
                        WHERE student_days.day_no = $daynum AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)
                        and DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        BETWEEN DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$end'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                         AND  employees.role_type = 'teacher'
                        ORDER BY `local_time_text` DESC";
        $res = DB::select($query);

        $counter += count($res);
        if (count($res) > 0) {

            foreach ($res as $val) {

                $selectedTime = date('h:i', strtotime($val->local_Time));
                $endTime = strtotime("+$val->day_duration minutes", strtotime($selectedTime));

                $class = array(

                    'start' => date('h:i', strtotime($val->local_Time)),
                    'end' => date('h:i', $endTime),
                    'borderColor' => '#fff',
                    'textColor' => '#fff',
                    'studentid' => 0,
                    'group' => 0,
                    'CountryName' => 'no',
                    'startFull' => date('g:i a', strtotime($start)),
                    'endFull' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                    'dayno' => $daynum,
                    'employeename' => $val->employeename,
                    'studentname' => $val->studentname,
                    'duration' => $val->day_duration,
                );

                $data[] = $class;

            }

        }

        return $data;

    }

    public function viewEmployeesShort(Request $request)
    {

        if ($request->ajax()) {
            $emp_id = $request->id;
            $searchResult = DB::select("SELECT e.* FROM employees e inner join roles r on e.role_type = r.name inner join users u on u.id = e.user_id where e.id = '$emp_id'");
            if (count($searchResult) > 0) {
                $empdata = $searchResult[0];
                $allowances = DB::select("SELECT ea.*,a.allowance as aname ,aty.allowance_name  as aType FROM employee_allowances ea inner join allowances a on a.id = ea.allowance_id  inner join allowance_type aty  on aty.allowance_type_val =  ea.type where ea.employee_id=" . $emp_id . " order by ea.type asc,date(ea.effective_date) asc, a.allowance asc");
                $deductions = DB::select("SELECT ea.*,d.deduction as dname,aty.allowance_name  as aType FROM employee_deductions ea inner join deductions d on d.id = ea.deduction_id  inner join allowance_type aty  on aty.allowance_type_val =  ea.type  where ea.employee_id=" . $emp_id . " order by ea.type asc,date(ea.effective_date) asc, d.deduction asc");

                return view('admin.custom.view_employee', compact('empdata', 'allowances', 'deductions'));

            } else {

                return response()->json(false);
            }

        }

    }
    public function viewAddEmployeesAllowance(Request $request)
    {

        if ($request->ajax()) {
            $searchResult = DB::select("SELECT * FROM allowances order by allowance asc");
            if (count($searchResult) > 0) {
                $allowance = $searchResult;

                $allowanceType = DB::table('allowance_type')->get();

                return view('admin.custom.manage_employee_allowances', compact('allowance', 'allowanceType'));

            } else {

                return response()->json(false);
            }

        }

    }

    public function viewAddEmployeesDeduction(Request $request)
    {

        if ($request->ajax()) {
            $emp_id = $request->id;
            $searchResult = DB::select("SELECT * FROM deductions order by deduction asc");
            if (count($searchResult) > 0) {
                $deduction = $searchResult;
                $allowanceType = DB::table('allowance_type')->get();

                return view('admin.custom.manage_employee_deductions', compact('deduction', 'allowanceType'));

            } else {

                return response()->json(false);
            }

        }

    }

    public function deleteEmployeesAllowance(Request $request)
    {
        if ($request->ajax()) {
            DB::table('employee_allowances')->where('id', $request->id)->delete();
            return response()->json(true);
        }
    }

    public function deleteEmployeesDeduction(Request $request)
    {
        if ($request->ajax()) {
            DB::table('employee_deductions')->where('id', $request->id)->delete();
            return response()->json(true);
        }
    }

    public function saveEmployeesAllowance(Request $request)
    {

        $rules = [
            'allowance_id.*' => "required",
            'type.*' => "required",
            'amount.*' => "required",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $response = [];

        try {

            if (isset($request->allowance_id) && isset($request->type) > 0 && isset($request->type)) {

                if (count($request->allowance_id) > 0 && count($request->type) > 0 && count($request->type) > 0) {

                    $allowance = $request->allowance_id;
                    $type = $request->type;
                    $amount = $request->amount;
                    $effective_date = $request->effective_date;

                    $arrdata = [];
                    foreach ($allowance as $index => $val) {

                        //   $data = [];

                        $data = array(
                            'employee_id' => $request->employee_id,
                            'allowance_id' => $allowance[$index],
                            'type' => $type[$index],
                            'amount' => $amount[$index],
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );

                        // $data[$index]['employee_id'] =  $request->employee_id;
                        // $data[$index]['allowance_id'] =  $allowance[$index];
                        // $data[$index]['type'] =  $type[$index];
                        // $data[$index]['amount'] =  $amount[$index];
                        // $data[$index]['created_by'] =  Auth::user()->id;
                        // $data[$index]['created_at'] =  date('Y-m-d H:i:s');
                        // $data[$index]['updated_at'] =  date('Y-m-d H:i:s');

                        if ($type[$index] == 3) {

                            if ($effective_date[$index] != "") {
                                $data['effective_date'] = $effective_date[$index];
                            }

                        }

                        $arrdata[] = $data;

                        DB::table('employee_allowances')->insert($data);
                    }

                    return response()->json(true);
                } else {
                    return response()->json(false);
                }

            } else {
                return response()->json("Please Must Fill Record");
            }

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage(), 'responseCode' => 404, 'responseMessage' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage(), 'responseCode' => 404, 'responseMessage' => $e->getMessage()], 500);
        }
    }

    public function saveEmployeesDeduction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'deduction_id.*' => "required",
            'type.*' => "required",
            'amount.*' => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $response = [];
        try {

            if (isset($request->deduction_id) && isset($request->type) > 0 && isset($request->amount)) {

                if (count($request->deduction_id) > 0 && count($request->type) > 0 && count($request->amount) > 0) {

                    $deduction = $request->deduction_id;
                    $type = $request->type;
                    $amount = $request->amount;
                    $effective_date = $request->effective_date;

                    $arrdata = [];
                    foreach ($deduction as $index => $val) {

                        //   $data = [];

                        $data = array(
                            'employee_id' => $request->employee_id,
                            'deduction_id' => $deduction[$index],
                            'type' => $type[$index],
                            'amount' => $amount[$index],
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );

                        if ($type[$index] == 3) {

                            if ($effective_date[$index] != "") {
                                $data['effective_date'] = $effective_date[$index];
                            }

                        }

                        $arrdata[] = $data;

                        DB::table('employee_deductions')->insert($data);
                    }

                    return response()->json(true);
                } else {
                    return response()->json(false);
                }

            } else {
                return response()->json("Please Must Fill Record");
            }

        } catch (Exception $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage(), 'responseCode' => 404, 'responseMessage' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['success' => 0, 'error' => $e->getMessage(), 'responseCode' => 404, 'responseMessage' => $e->getMessage()], 500);
        }
    }

    public function getFreeTeachersTimeFull()
    {

        $daysName = array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        );

        $dayno = date('w');
        $data = [];
        $wholedata = [];
        $groupdata = [];
        $counter = 0;
        $totaldayclass = [];

        $Employee = Employee::Select(['employees.*'])->leftjoin('users', 'users.id', '=', 'employees.user_id')->groupBy('employees.id')->where('users.status', '1')->where('employees.role_type', 'teacher')->get();

        $searchtime = [];
        $freeteacher = [];
        foreach ($Employee as $empindex => $empval) {

            for ($d = 0; $d <= 6; $d++) {

                $daynum = $d + 1;

                $time = mktime(0, 0, 0, 1, 1);

                $j = 0;
                $sumclass = 0;
                //   for ($i = 0; $i < 86400; $i += 1800) {

                for ($i = 75600; $i < 86400; $i += 1800) {

                    //   echo date('g:i a', $time + $i).'--'.date('g:i a', $time + $i + 1800);

                    $addduration = 30;
                    // $daytimming  = DATE("H:i",STRTOTIME(date('g:i a', $time + $i + 1740)));

                    $end = DATE("H:i", STRTOTIME(date('g:i a', $time + $i + 1740)));
                    $start = DATE("H:i", STRTOTIME(date('g:i a', $time + $i)));

                    //  $slot = strtotime($addduration, STRTOTIME($daytimming));
                    //  $end = date('H:i', $slot);

                    // echo DATE("H:i", STRTOTIME(date('g:i a', $time + $i))).'--'.$daytimming.'--------';
                    //   '<br/>';

                    $timearr = [];

                    $query = "SELECT  count(student_days.id) as totalclass,student_days.teacher_id,student_days.day_name,student_days.day_no ,student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days
                        inner join
                        student on student_days.student_id = student.id
                        WHERE student.teacher_id ='$empval->id' and student_days.day_no = $daynum AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)
                        and DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        BETWEEN DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$end'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                       group by student_days.local_Time  ORDER BY `local_time_text` DESC";
                    $res = DB::select($query);

                    $counter += count($res);
                    if (count($res) > 0) {

                        foreach ($res as $val) {

                            $selectedTime = date('h:i', strtotime($val->local_Time));
                            $endTime = strtotime("+$val->day_duration minutes", strtotime($selectedTime));

                            $groupcolor = $this->randomColor(150, 255);
                            if (isset($groupdata[$val->totalclass])) {

                                $groupcolor = $groupdata[$val->totalclass];

                                // $groupcolor =  'found';
                            } else {
                                $groupdata[$val->totalclass] = $groupcolor;

                                // $groupcolor = "not found";
                            }

                            $sumclass += $val->totalclass;

                            $class = array(
                                // 'start' => date('h:i', strtotime($val->local_Time)),
                                // 'end' => date('h:i', $endTime),
                                // 'status' => 'booked',
                                // 'dayname' => $this->days_name($dayno),
                                // 'day' => date('l'),
                                // 'duration' => $val->day_duration,
                                // 'studentid' => $val->student_id,
                                // 'teacher_id' => $val->teacher_id,
                                //  'local_time_text' => $val->local_time_text,
                                //  'i' => $j,
                                //  'totalclass' => $val->totalclass

                                'start' => date('g:i a', strtotime($start)),
                                'end' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                                'title' => $val->totalclass . ' Classes',
                                'backgroundColor' => $groupcolor,
                                'borderColor' => '#fff',
                                'textColor' => '#fff',
                                'studentid' => 0,
                                'group' => 0,
                                'CountryName' => 'no',
                                'startFull' => date('g:i a', strtotime($start)),
                                'endFull' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                                'dayno' => $daynum,
                                'startSec' => $i,
                                'endSec' => $i + 1800,
                            );

                            $timearr[] = $class;

                        }

                        //   $data[$d]['record'][] = $timearr;
                        //   $data[$d]['total'] = count($res);
                        //   $data[$d]['start'] = date('g:i a',strtotime($start));
                        //   $data[$d]['end'] = date('g:i a',strtotime("+1 minutes", strtotime($end)));

                        // $data[$empval->employeename][$d]['day'] = $d;
                        $data[$empval->employeename][$daysName[$daynum]][date('g:i a', strtotime($start))] = "Booked Time";

                    } else {

                        $class = array(

                            'start' => date('g:i a', strtotime($start)),
                            'end' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                            'title' => 'free Time',
                            'backgroundColor' => '#ccc',
                            'borderColor' => '#000',
                            'textColor' => '#000',
                            'studentid' => 0,
                            'group' => 0,
                            'CountryName' => 'no',
                            'startFull' => date('g:i a', strtotime($start)),
                            'endFull' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                            'dayno' => $daynum,
                            'startSec' => $i,
                            'endSec' => $i + 1800,
                        );

                        //   $data[$empval->employeename]['day'] = $d;
                        $data[$empval->employeename][$daysName[$daynum]][date('g:i a', strtotime($start))] = "Free Time";

                        //   $data[$d]['record'][] = $timearr;
                        //   $data[$d]['total'] = 0;
                        //   $data[$d]['start'] = date('g:i a',strtotime($start));
                        //   $data[$d]['end'] = date('g:i a',strtotime("+1 minutes", strtotime($end)));

                    }

                    $j += 1;

                }

                $totaldayclass[$d] = $sumclass;

            }
        }

        $wholedata = array(
            'data' => $data,
        );
        return $data;

    }

    public function getFreeTeachersTime(Request $request)
    {

        $daystype = $request->daystype;
        //   if($daystype == "weekdays"){
        //         $daysName = array(
        //             1 => 'Monday',
        //             2 => 'Tuesday',
        //             3 => 'Wednesday',
        //             4 => 'Thursday',
        //             5 => 'Friday',
        //         );
        //         $dayno = [1,2,3,4,5];
        //     }
        //     else if($daystype == "weekenddays"){

        //          $daysName = array(
        //             1 => 'Saturday',
        //             2 => 'Sunday'
        //         );
        //          $dayno = [6,7];

        //     }else{
        //         $daysName = array(
        //             1 => 'Monday',
        //             2 => 'Tuesday',
        //             3 => 'Wednesday',
        //             4 => 'Thursday',
        //             5 => 'Friday',
        //             6 => 'Saturday',
        //             7 => 'Sunday'
        //         );
        //          $dayno = [1,2,3,4,5,6,7];
        //     }

        if ($daystype == "weekdays") {
            $daysName = array(
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
            );
            $dayno = [1, 2, 3, 4, 5];
        } else if ($daystype == "secweekdays") {
            $daysName = array(
                1 => 'Tuesday',
                2 => 'Wednesday',
                3 => 'Thursday',
                4 => 'Friday',
                5 => 'Saturday',
            );
            $dayno = [2, 3, 4, 5, 6];
        } else if ($daystype == "weekenddays") {

            $daysName = array(
                1 => 'Saturday',
                2 => 'Sunday',
            );
            $dayno = [6, 7];

        } else if ($daystype == "secweekenddays") {

            $daysName = array(
                1 => 'Sunday',
                2 => 'Monday',
            );
            $dayno = [7, 1];

        } else {
            $daysName = array(
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday',
            );
            $dayno = [1, 2, 3, 4, 5, 6, 7];
        }

        $daytime = [$request->studenttimeclass, $request->studenttimeclass, $request->studenttimeclass, $request->studenttimeclass, $request->studenttimeclass, $request->studenttimeclass, $request->studenttimeclass];

        $duration = 30;
        $country = $request->country;
        $language = $request->language;

        $Employee = Employee::Select(['employees.*'])
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->leftjoin('employee_language_lookups', 'employees.id', '=', 'employee_language_lookups.employee_id');
        if ($country) {
            $Employee->where('employees.country_id', $country);
        }
        if ($language) {
            $Employee->where('employee_language_lookups.language_id', $language);
        }
        $Employee->groupBy('employees.id')->where('users.status', '1')->where('employees.role_type', 'teacher');
        $Employee = $Employee->get();
        $searchtime = [];
        $freeteacher = [];
        $groupdata = [];
        foreach ($Employee as $empindex => $val) {

            $checkval = false;
            foreach ($dayno as $dayindex => $dayval) {

                $daynoinner = $dayval;
                $daytimeinner = $daytime[$dayindex];
                $start = DATE("H:i", STRTOTIME($daytimeinner));
                $CustomFunc = new Custom();
                $returndata = $CustomFunc->freeTeacherTimeSearchByModelTestversion($daynoinner, $daytimeinner, $duration, $val);
                $daynum = $dayindex + 1;
                $groupcolor = $this->randomColor(150, 255);
                if (isset($groupdata[$val->id])) {
                    $groupcolor = $groupdata[$val->id];
                } else {
                    $groupdata[$val->id] = $groupcolor;
                }
                if ($returndata == false) {
                    $searchtime[$daysName[$daynum]][date('g:i a', strtotime($start))][] = array('day' => $daysName[$daynum], 'teacher_id' => $val->id, 'teachername' => $val->employeename, 'Time' => 'Booked', 'color' => '#FF281B');
                } else {
                    $searchtime[$daysName[$daynum]][date('g:i a', strtotime($start))][] = array('day' => $daysName[$daynum], 'teacher_id' => $val->id, 'teachername' => $val->employeename, 'Time' => 'Available', 'color' => '#00FF00');
                }

            }

        }

        //  $newdata = [];
        //  foreach($searchtime as $data){
        //      $newdata[] =  $data;
        //  }

        return response()->json($searchtime);

    }

    public function FreeTeachersavailabiltiyTime(Request $request)
    {
        $timezones = $this->timezones();
        $Language = Language::get();
        $Country = Country::get();
        $this->setPageTitle('Teacher Availability', 'Teacher Availability');
        return view('admin.teacher.teacherAvailabilityCheck', compact('timezones', 'Language', 'Country'));
    }

    public function getFreeTeachersTimeWholeAcademic(Request $request)
    {
        $timezones = $this->timezones();
        $this->setPageTitle('Teacher Academic Availability', 'Teacher  Academic Availability');
        return view('admin.teacher.academicfreetime', compact('timezones'));
    }

    public function getFreeTeachersTimeWholeOLD()
    {

        $daysName = array(
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        );

        $dayno = date('w');
        $data = [];
        $wholedata = [];
        $groupdata = [];
        $counter = 0;
        $totaldayclass = [];

        $Employee = Employee::Select(['employees.*'])->leftjoin('users', 'users.id', '=', 'employees.user_id')->groupBy('employees.id')->where('users.status', '1')->where('employees.role_type', 'teacher')->get();

        $searchtime = [];
        $freeteacher = [];
        foreach ($Employee as $empindex => $empval) {

            $time = mktime(0, 0, 0, 1, 1);

            //   for ($i = 0; $i < 86400; $i += 1800) {

            for ($i = 75600; $i < 86400; $i += 1800) {

                for ($d = 0; $d <= 6; $d++) {

                    $daynum = $d + 1;

                    //   echo date('g:i a', $time + $i).'--'.date('g:i a', $time + $i + 1800);

                    // $addduration = 30;
                    // $daytimming  = DATE("H:i",STRTOTIME(date('g:i a', $time + $i + 1740)));

                    $end = DATE("H:i", STRTOTIME(date('g:i a', $time + $i + 1740)));
                    $start = DATE("H:i", STRTOTIME(date('g:i a', $time + $i)));

                    //  $slot = strtotime($addduration, STRTOTIME($daytimming));
                    //  $end = date('H:i', $slot);

                    // echo DATE("H:i", STRTOTIME(date('g:i a', $time + $i))).'--'.$daytimming.'--------';
                    //   '<br/>';

                    $timearr = [];

                    $query = "SELECT  count(student_days.id) as totalclass,student_days.teacher_id,student_days.day_name,student_days.day_no ,student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days
                        inner join
                        student on student_days.student_id = student.id
                        WHERE student.teacher_id ='$empval->id' and student_days.day_no = $daynum AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)
                        and DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        BETWEEN DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                        AND DATE_FORMAT(DATE_ADD(CONCAT(DATE_FORMAT(DATE_ADD(now(),INTERVAL +600 MINUTE),'%Y-%m-%d'),' ','$end'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')
                       group by student_days.local_Time  ORDER BY `local_time_text` DESC";
                    $res = DB::select($query);

                    $counter += count($res);
                    if (count($res) > 0) {

                        foreach ($res as $val) {

                            $selectedTime = date('h:i', strtotime($val->local_Time));
                            $endTime = strtotime("+$val->day_duration minutes", strtotime($selectedTime));

                            $groupcolor = $this->randomColor(150, 255);
                            if (isset($groupdata[$val->totalclass])) {

                                $groupcolor = $groupdata[$val->totalclass];

                                // $groupcolor =  'found';
                            } else {
                                $groupdata[$val->totalclass] = $groupcolor;

                                // $groupcolor = "not found";
                            }

                            $class = array(
                                'start' => date('g:i a', strtotime($start)),
                                'end' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                                'startFull' => date('g:i a', strtotime($start)),
                                'endFull' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                                'dayno' => $daynum,
                            );

                            $timearr[] = $class;

                        }

                        $data[$empval->employeename][date('g:i a', strtotime($start))][$daysName[$daynum]] = "Booked Time";

                    } else {

                        $class = array(

                            'start' => date('g:i a', strtotime($start)),
                            'end' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                            'title' => 'free Time',
                            'backgroundColor' => '#ccc',
                            'borderColor' => '#000',
                            'textColor' => '#000',
                            'studentid' => 0,
                            'group' => 0,
                            'CountryName' => 'no',
                            'startFull' => date('g:i a', strtotime($start)),
                            'endFull' => date('g:i a', strtotime("+1 minutes", strtotime($end))),
                            'dayno' => $daynum,
                            'startSec' => $i,
                            'endSec' => $i + 1800,
                        );

                        //   $data[$empval->employeename]['day'] = $d;
                        $data[$empval->employeename][date('g:i a', strtotime($start))][$daysName[$daynum]] = "Free Time";
                        //  if($data[$empval->employeename][$daysName[$daynum]][date('g:i a',strtotime($start))]){
                        //      $data[$empval->employeename][$daysName[$daynum]][date('g:i a',strtotime($start))][] = "Free Time";
                        //  }

                        //   $data[$d]['record'][] = $timearr;
                        //   $data[$d]['total'] = 0;
                        //   $data[$d]['start'] = date('g:i a',strtotime($start));
                        //   $data[$d]['end'] = date('g:i a',strtotime("+1 minutes", strtotime($end)));

                    }

                }

            }
        }

        return $data;

    }

    public function getFreeTeachersTimeWholeacademictime(Request $request)
    {

        // $Timesdata = $this->getTimeSlot(30, '20:00', '24:00');

        //  return $Timesdata = $this->SplitTime("2018-05-12 20:00", "2018-05-12 24:00", "30");
        //  die();

        $starttime = date("H:i:s", strtotime($request->studenttimeclass));
        $endtime = date("H:i:s", strtotime($request->endstudenttimeclass));

        $Timesdata = $this->SplitTime("2018-05-12 " . $starttime, "2018-05-12 " . $endtime, "30");

        $daystype = $request->daystype;
        $duration = $request->duration;

        //   return $endtime;

        // $Timesdata = ['9:00 pm','9:30 pm'];
        $newtimedata = [];
        foreach ($Timesdata as $index => $datatime) {
            $newtimedata[$datatime] = [];
        }
        // return $newtimedata;
        $searchtimedata = [];
        foreach ($Timesdata as $dataval) {
            $searchtimedata[$dataval] = $this->innerwholeacademin($dataval, $daystype, $duration);
        }

        return response()->json(['availtime' => $searchtimedata, "slots" => $newtimedata, "newslots" => $newtimedata, "slotsfreeteacher" => $newtimedata]);

    }

    public function innerwholeacademin($studenttimeclass, $daystype, $duration)
    {

        if ($daystype == "weekdays") {
            $daysName = array(
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
            );
            $dayno = [1, 2, 3, 4, 5];
        } else if ($daystype == "secweekdays") {
            $daysName = array(
                1 => 'Tuesday',
                2 => 'Wednesday',
                3 => 'Thursday',
                4 => 'Friday',
                5 => 'Saturday',
            );
            $dayno = [2, 3, 4, 5, 6];
        } else if ($daystype == "weekenddays") {

            $daysName = array(
                1 => 'Saturday',
                2 => 'Sunday',
            );
            $dayno = [6, 7];

        } else if ($daystype == "secweekenddays") {

            $daysName = array(
                1 => 'Sunday',
                2 => 'Monday',
            );
            $dayno = [7, 1];

        } else {
            $daysName = array(
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                7 => 'Sunday',
            );
            $dayno = [1, 2, 3, 4, 5, 6, 7];
        }

        $daytime = [$studenttimeclass, $studenttimeclass, $studenttimeclass, $studenttimeclass, $studenttimeclass, $studenttimeclass, $studenttimeclass];

        $duration = $duration;

        $Employee = Employee::Select(['employees.*'])
            ->leftjoin('users', 'users.id', '=', 'employees.user_id');
        $Employee->groupBy('employees.id')->where('users.status', '1')->where('employees.role_type', 'teacher');
        $Employee = $Employee->get();
        $searchtime = [];
        $freeteacher = [];
        $groupdata = [];
        foreach ($Employee as $empindex => $val) {

            $checkval = false;
            foreach ($dayno as $dayindex => $dayval) {

                $daynoinner = $dayval;
                $daytimeinner = $daytime[$dayindex];
                $start = DATE("H:i", STRTOTIME($daytimeinner));
                $CustomFunc = new Custom();
                $returndata = $CustomFunc->freeTeacherTimeSearchByModelTestversion($daynoinner, $daytimeinner, $duration, $val);
                // $returndata =  $CustomFunc->freeTeacherTimeSearchByWholeacademic($daynoinner,$daytimeinner,$duration,$val);

                $daynum = $dayindex + 1;
                $groupcolor = $this->randomColor(150, 255);
                if (isset($groupdata[$val->id])) {
                    $groupcolor = $groupdata[$val->id];
                } else {
                    $groupdata[$val->id] = $groupcolor;
                }
                if ($returndata == false) {
                    // $searchtime[$daysName[$daynum]][date('g:i a',strtotime($start))][] = array('day' => $daysName[$daynum],'teacher_id' => $val->id,'teachername' => $val->employeename , 'Time' => 'booked', 'color' => $groupcolor);

                    $searchtime[$val->employeename][$daysName[$daynum]] = array('day' => $daysName[$daynum], 'teacher_id' => $val->id, 'teachername' => $val->employeename, 'Time' => 'booked', 'color' => $groupcolor);
                } else {
                    // $searchtime[$daysName[$daynum]][date('g:i a',strtotime($start))][]  = array('day' => $daysName[$daynum],'teacher_id' => $val->id,'teachername' => $val->employeename , 'Time' => 'Available','color' => 'Green');

                    $searchtime[$val->employeename][$daysName[$daynum]] = array('day' => $daysName[$daynum], 'teacher_id' => $val->id, 'teachername' => $val->employeename, 'Time' => 'Available', 'color' => 'Green');
                }

            }

        }

        return $searchtime;

    }

    public function getTimeSlot($duration, $start, $end)
    {

        $start = new DateTime($start);
        $end = new DateTime($end);
        $start_time = $start->format('g:i a');
        $end_time = $end->format('g:i a');
        $i = 0;
        while (strtotime($start_time) <= strtotime($end_time)) {
            $start = $start_time;
            $end = date('g:i a', strtotime('+' . $duration . ' minutes', strtotime($start_time)));
            $start_time = date('g:i a', strtotime('+' . $duration . ' minutes', strtotime($start_time)));

            // if(strtotime($start_time) <= strtotime($end_time)){
            $time[$i] = $start;

            // }
            $i++;
        }
        return $time;
    }

    public function SplitTime($StartTime, $EndTime, $Duration = "60")
    {
        $ReturnArray = array(); // Define output
        $StartTime = strtotime($StartTime); //Get Timestamp
        $EndTime = strtotime($EndTime); //Get Timestamp

        $AddMins = $Duration * 60;

        while ($StartTime <= $EndTime) //Run loop
        {
            $ReturnArray[] = date("g:i a", $StartTime);
            $StartTime += $AddMins; //Endtime check
        }
        return $ReturnArray;
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

}

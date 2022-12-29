<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\models\AdvertisementAgencies;
use App\models\City;
use App\models\Country;
use App\models\Employee;
use App\models\EmployeeLanguageLookup;
use App\models\EmployeeSkillsLookup;
use App\models\Employee_leave;
use App\models\Language;
use App\models\ParentLanguageLookup;
use App\models\Parents;
use App\models\Skill;
use App\models\Student;
use App\models\Teacherattendance;
use App\models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Yajra\Datatables\Datatables;
use Auth;

class EmployeesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function TestingRelationship()
    {
        //  dd(Employee::with(['students.TeacherChangeHistory','students.AcademicStatusHistory'])->limit(3)->get());

        //   return Student::with('studentdays')->first();

        // $id = 103;
        // $testr5  =  Employee::with([
        //     'students' => function ($query) {
        //       $query->select('*');
        //     },
        //     'students.TeacherChangeHistory' => function ($query) {
        //         $query->select('*');
        //     },
        //     'students.AcademicStatusHistory' => function ($query) {
        //         $query->select('*');
        //     },
        //      'students.AcademicStatusHistory.teacher' => function ($query) {
        //         $query->select('*');
        //     },
        //      'students.attendance' => function ($query) {
        //         $query->select('*');
        //     }
        // ])
        // // ->whereHas('students', function($query) use ($id){
        // //             $query->where('id',$id);
        // //         })
        // ->limit(3)
        // ->get();

        // dd($testr5);

        $std = Student::with('language')->groupBy('group')->get();

        foreach ($std as $val) {

            if ($val->group) {
                $existparent = Parents::where('groupno', $val->group)->get();
                if (count($existparent) == 0) {
                    $user = new User();
                    $user->email = 'parent' . $val->group . '@sispn.com';
                    $user->name = ($val->fathername) ? $val->fathername : 'No Name';
                    $user->password = Hash::make('12345');
                    $user->role = 'parent';
                    $user->save();
                    $user->assignRole('parent');
                    $userid = $user->id;

                    $resource_type = ($val->joining_source) ? $val->joining_source : 1;
                    $genderval = 1;
                    $employee = new Parents();
                    $employee->user_id = $user->id;
                    $employee->name = $val->fathername;
                    $employee->fathername = 'none';
                    $employee->resource_type = $resource_type;
                    $employee->age = 0;
                    $employee->gender = $genderval;
                    $employee->country_id = $val->country;
                    $employee->city_id = $val->city;
                    $employee->groupno = $val->group;
                    $employee->contact_no_2 = $val->contact_no;
                    $employee->contact_no = '0000';
                    $employee->whatsapp = ($val->whatsapp) ? $val->whatsapp : 'none';
                    $employee->identity_card_no = '0000';
                    $employee->personal_skype = ($val->skypid_1) ? $val->skypid_1 : 'none';
                    $employee->current_address = 'no';
                    $employee->permanent_address = 'no';
                    $employee->comment = 'no';

                    if ($resource_type == 2) {
                        $employee->resource_name = ($val->ref_name) ? $val->ref_name : 'none';
                        $employee->resource_email = ($val->ref_email) ? $val->ref_email : 'none@gmail.com';
                    }
                    if ($resource_type == 1) {
                        $employee->resource_agency_id = ($val->agency_id) ? $val->agency_id : '1';
                    }
                    $employee->save();

                    if (isset($val->language)) {
                        if (count($val->language) > 0) {
                            foreach ($val->language as $key => $lang) {
                                $emplanguage = new ParentLanguageLookup();
                                $emplanguage->parent_id = $employee->id;
                                $emplanguage->language_id = $lang->id;
                                $emplanguage->save();
                            }
                        }

                    }
                }
            }

        }

        // dd($std);

    }

    public function employeeattendance()
    {
        $this->setPageTitle('Attendance', 'Employee Attendance Save');
        $Employee = Employee::Select(['employees.*', 'users.email'])
            ->selectRaw('(CASE WHEN employees.gender = 1 THEN "Male" ELSE "Female" END) as gender_type')
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->where('users.status', '1')
            ->where('employees.role_type', '!=', 'teacher')->get();
        return view('admin.employee.attendancecreate', compact('Employee'));
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
        $this->setPageTitle('Employee', 'Employee Attendance List');
        $Employee = Employee::Select(['employees.*', 'users.email'])
            ->selectRaw('(CASE WHEN employees.gender = 1 THEN "Male" ELSE "Female" END) as gender_type')
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->where('users.status', '1')
            ->where('employees.role_type', '!=', 'teacher')->get();

        return view('admin.employee.attendancelist', compact('Employee'));
    }

    public function get_emp_attendance_forms(Request $request)
    {
        $status = $request->status;
        $teacherID = $request->teacherId;
        $start_date = $request->startdate;
        $end_date = $request->enddate;

        $Employee = Teacherattendance::Select(['employees.*', 'users.email', 'teacherattendance.attendance_date', 'teacherattendance.id as attendanceid', 'teacherattendance.id as attendanceid', 'teacherattendance.attendance_status','availuser.name as availattendancename'])
            ->selectRaw('(CASE WHEN employees.gender = 1 THEN "Male" ELSE "Female" END) as gender_type')
            ->selectRaw("DATE_FORMAT(teacherattendance.avail_time, '%Y-%m-%d %r') as attendance_avail_time")
            ->leftjoin('employees', 'employees.id', '=', 'teacherattendance.teacher_id')
            ->leftjoin('users', 'users.id', '=', 'employees.user_id')
            ->leftjoin('users as availuser', 'availuser.id', '=', 'teacherattendance.created_by')
            ->where('users.status', '1')
            ->where('employees.role_type', '!=', 'teacher');

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

                if ($Employee->attendance_status != 1) {
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
                }else{
                    $ret .= 'Present';
                }

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

            $res = DB::table('teacherattendance')->where('id', $id)->update([ 'created_by' => Auth::user()->id,'attendance_status' => $request->status, 'avail_time' => Carbon::now()]);

            return response()->json(['success' => 1], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => 2, 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 1, 'error' => $ex->getMessage()], 500);
        }
    }

    public function delete_leave(Request $request)
    {

        $id = $request->id;
        $empleave = Employee_leave::findorfail($id);
        $empleave->delete();
        return 1;

    }

    public function Leave_forms_View()
    {
        $Employee = Employee::get();
        $this->setPageTitle('Employee Leave', 'List  of all Leave');
        return view('admin.employee.leave', compact('Employee'));
    }

    public function store_leave(Request $request)
    {
        $rules = array(
            'leaveemployee' => 'required|max:191',
            'leaveType' => 'required|max:191',
            'LeaveDate' => 'required|max:191',
            'EndLeaveDate' => 'required|max:191',
            'levecomments' => 'required|max:191',

        );
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
            $employee = new Employee_leave();
            $employee->employee_id = $request->leaveemployee;
            $employee->holiday_type = $request->leaveType;
            $employee->holiday_date = $request->LeaveDate;
            $employee->holiday_end_date = $request->EndLeaveDate;
            $employee->holiday_comments = $request->levecomments;
            if ($request->id) {
                $employee->exists = true;
                $employee->id = $request->id;
            }
            $employee->save();

            DB::commit();
            return response()->json([
                'Success' => 'true', 'msg' => 'Save Successfully']);

        } catch (\Exception $e) {
            return response()->json(['success' => 2, 'Error' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => 1, 'Error' => $ex->getMessage()], 500);
        }
    }
    public function get_emp_leave_forms(Request $request)
    {
        $Employee = Employee_leave::select(['employee_leaves.*', 'employees.employeename', 'employees.role_type'])
            ->leftjoin('employees', 'employee_leaves.employee_id', '=', 'employees.id');
        if ($request->empid) {
            $Employee->where('employee_leaves.employee_id', $request->empid);
        }
        if ($request->id) {
            $Employee->where('employee_leaves.employee_id', $request->id);
        }

        return Datatables::of($Employee)
            ->addColumn('action', function ($Employee) {

                $editurl = route('admin.employee.edit', $Employee->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<button type="button" class="btn btn-primary edit_employee_leaveclass"  data-leaveemployee="' . $Employee->employee_id . '" data-leaveType="' . $Employee->holiday_type . '"  data-EndLeaveDate="' . $Employee->holiday_end_date . '"  data-LeaveDate="' . $Employee->holiday_date . '" data-levecomments="' . $Employee->holiday_comments . '" data-id="' . $Employee->id . '"  >Edit</button>&nbsp;&nbsp;|&nbsp;&nbsp;<button class="btn btn-danger btndeleteemployeeleave" data-id="' . $Employee->id . '" >Delete</button>';
                // }

                return $ret;

            })
            ->addColumn('empprofile', function ($Employee) {

                $editurl = route('admin.teacher.edit', $Employee->employee_id);
                if ($Employee->role_type != "teacher") {
                    $editurl = route('admin.employee.edit', $Employee->employee_id);
                }

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a class="btn" href="' . $editurl . '" >' . $Employee->employeename . '</a>';
                // }

                return $ret;

            })

            ->addColumn('leavedays', function ($Employee) {

                $datestart = new Carbon($Employee->holiday_date);
                $dateend = new Carbon($Employee->holiday_end_date);
                $ret = $datestart->diffInDays($dateend) + 1;
                return $ret;

            })

            ->rawColumns(['action', 'empprofile', 'leavedays'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function index()
    {
        $this->setPageTitle('Employee', 'List  of all Employee');
        return view('admin.employee.index');
    }

    public function get_emp_forms()
    {

        $Employee = Employee::select(['employees.*', 'countries.CountryName', 'cities.CityName', DB::raw('GROUP_CONCAT(l.languagename)')])
            ->leftjoin('countries', 'employees.country_id', '=', 'countries.id')
            ->leftjoin('cities', 'cities.id', '=', 'employees.city_id')
            ->leftjoin('employee_language_lookups as ell', 'ell.employee_id', '=', 'employees.id')
            ->leftjoin('languages as l', 'l.id', '=', 'ell.language_id')
            ->where('employees.role_type', '!=', 'teacher')
            ->groupBy('employees.id');

        return Datatables::of($Employee)
            ->addColumn('action', function ($Employee) {

                $editurl = route('admin.employee.edit', $Employee->id);

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .= '<a class="btn btn-primary" href="' . $editurl . '" >Edit</a> <button class="btn btn-primary view_employee" data-id="' . $Employee->id . '"  >View</button>';
                // }

                return $ret;

            })

            ->rawColumns(['action'])
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        // $totalleave =   Employee_leave::select([DB::raw("SUM(DATEDIFF(holiday_end_date,holiday_date )+1) AS TotalLeaveDays")])->where('id',$id)->groupBy('employee_id')->get();

        $this->setPageTitle('Edit Employee', 'Employee : ' . $targetTeacher->employeename);
        return view('admin.employee.edit', compact('targetTeacher', 'LanguageLookup', 'SkillsLookup', 'User', 'Country', 'City', 'Language', 'Agencies', 'Skill'));
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

            $employee->BeneficiaryName = $request->BeneficiaryName;
            $employee->AccountNo = $request->AccountNo;
            $employee->Bankcode = $request->Bankcode;
            $employee->BankName = $request->BankName;
            $employee->branchCode = $request->branchCode;
            $employee->branchName = $request->branchName;

            if ($request->resource == 2) {
                $employee->resource_name = $request->referencename;
                $employee->resource_email = $request->referenceemail;
            }
            if ($request->resource == 1) {
                $employee->resource_agency_id = $request->marketingagencies;
            }
            $employee->exists = true;
            $employee->id = $request->id;
            $employee->save();

            EmployeeLanguageLookup::where('employee_id', $request->id)->delete();
            if (isset($request->language)) {
                if (count($request->language) > 0) {
                    foreach ($request->language as $key => $lang) {
                        $emplanguage = new EmployeeLanguageLookup();
                        $emplanguage->employee_id = $employee->id;
                        $emplanguage->language_id = $lang;
                        $emplanguage->save();
                    }
                }

            }
            EmployeeSkillsLookup::where('employee_id', $request->id)->delete();
            if (isset($request->skills)) {
                if (count($request->skills) > 0) {
                    foreach ($request->skills as $key => $ski) {
                        $empskills = new EmployeeSkillsLookup();
                        $empskills->employee_id = $employee->id;
                        $empskills->skill_id = $ski;
                        $empskills->save();
                    }
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
}

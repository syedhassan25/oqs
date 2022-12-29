<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\BaseController;
use App\models\Employee;
use App\models\EmployeesCreditPartial;
use App\models\PayrollItems;
use App\models\User;
use Auth;
use Carbon\Carbon;
use Datatables;
use DB;
use Illuminate\Http\Request;
use Validator;

class GeneralController extends BaseController
{

    public function rules()
    {
        $this->setPageTitle('Rules', 'View All Rules');
        return view('admin.teacherpanel.rules.index');
    }
    public function salary()
    {
        $this->setPageTitle('Salary', 'View All Salary');
        return view('admin.teacherpanel.salary.index');
    }

    public function addConcernPayrol(Request $request)
    {

        $id = $request->id;
        $comment = $request->comment;

        DB::table('payroll_concern_history')->insert([
            'payrollItemsId' => $id,
            'comment' => $comment,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['Success' => 'true']);

    }

    public function Concern_Payrol_forms(Request $request)
    {
        $id = $request->id;
        $Payroll = DB::table('payroll_concern_history')->select(['users.name', 'payroll_concern_history.*'])
            ->leftjoin('users', 'payroll_concern_history.created_by', '=', 'users.id')
            ->where('payrollItemsId', $id)->orderby('payroll_concern_history.created_at', 'desc');
        return Datatables::of($Payroll)->make(true);
    }

    public function detail_payroll_forms(Request $request)
    {

        $teacherId = Employee::where('user_id', Auth::user()->id)->first()->id;

        $Payroll = DB::table('payroll_items')->select(['employees.employeename', 'employees.employee_no', 'payroll.date_from', 'payroll.date_to', 'payroll.type', 'payroll_items.*'])
            ->leftjoin('employees', 'employees.id', '=', 'payroll_items.employee_id')
            ->leftjoin('payroll', 'payroll.id', '=', 'payroll_items.payroll_id')
            ->where('employees.id', $teacherId)
            ->where('payroll_items.isPublished', 1)->orderBy('payroll_items.payroll_id', 'desc')->get();

        return Datatables::of($Payroll)
            ->addColumn('action', function ($Payroll) {

                $ret = '<a class="btn btn-primary btn-outline-primary" href="' . route('teacherpanel.salary.detail.payroll.slip', $Payroll->id) . '">View</a>';
                return $ret;

            })
            ->addColumn('type', function ($Payroll) {

                $ret = '<a class="btn btn-primary btn-outline-primary" href="' . route('teacherpanel.salary.detail.payroll.slip', $Payroll->id) . '">View</a>';
                return $ret;

            })
            ->rawColumns(['action', 'salaryStatus'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }

    public function searchForId($id, $array, $istafseer)
    {
        foreach ($array as $key => $val) {
            if ($val->day === $id && $istafseer == 0) {
                return $val->amount;
            } else if ($val->day === $id && $istafseer == 1) {
                return $val->tafeerAmount;
            }
        }
        return null;
    }

    public function payroll_detail_slip(Request $request)
    {
        $id = $request->id;
        $teacherdata = Employee::where('user_id', Auth::user()->id)->first();
        if ($teacherdata) {
            $teacherId = $teacherdata->id;
        } else {
            $teacherId = '';
        }

        $slipdata = DB::table('payroll_items')->where('id', $id)->where('payroll_items.employee_id', $teacherId)->first();
        if (!$slipdata) {
            return 'Not Found';
        }

        $payroll = DB::table('payroll')->where('id', $slipdata->payroll_id)->first();
        $employees = DB::table('employees')->where('id', $slipdata->employee_id)->first();
        $allpayrolldata = PayrollItems::with('payrollparent')->where('isPublished', 1)->where('employee_id', $slipdata->employee_id)->get();

        $classes_bonus = DB::table('classes_bonus')->get()->toArray();
        $weekdayssalary = DB::Select("SELECT * FROM ClassPerSalaryAmount");
        foreach ($weekdayssalary as $index => $studentdaysrow) {
            $weekdayssalary[] = $studentdaysrow;
        }

        $allowance = json_decode($slipdata->allowances, true);
        $deductions = json_decode($slipdata->deductions, true);
        $extraAllowance = json_decode($slipdata->extraAllowance, true);
        $extradeduction = json_decode($slipdata->extradeduction, true);
        $totalClassesdata = json_decode($slipdata->totalSumClasses, true);
        $totalclasess_json = json_decode($slipdata->clasess_json, true);
        $goodWorkAmounttotal = 0;

        $totaldaysEarn = [];

        if($totalclasess_json){
             $weekend = 0;
             $weekday = 0;

             $increPerSal  = $slipdata->incrementPerclassPercentage;
             foreach($totalclasess_json as $classesinnerdata){

                $studentnorow = $classesinnerdata['student_day'];
                $durationWise = 1;
                $studenttafseer = $classesinnerdata['isTafseer'];
                if ($classesinnerdata['duration'] == 60) {
                    $durationWise = 2;
                }

                $incrementPerclass = 0;
                if ($increPerSal != 0) {
                    $incrementPerclass = ($this->searchForId((int) $studentnorow, $weekdayssalary, $studenttafseer) * $durationWise) * $increPerSal / 100;
                }

                if($classesinnerdata['student_day']  == 6 || $classesinnerdata['student_day'] == 7){
                    $weekend += ($this->searchForId((int) $studentnorow, $weekdayssalary, $studenttafseer) * $durationWise) + $incrementPerclass;
                }else{
                    $weekday += ($this->searchForId((int) $studentnorow, $weekdayssalary, $studenttafseer) * $durationWise) + $incrementPerclass;

                }
             }
             $totaldaysEarn['weekend'] = $weekend;
             $totaldaysEarn['weekday'] = $weekday;
            
        }

        $totalClassget = 0;
        $totalLateattendance = 0;
        $totalLessonNoAd = 0;
        foreach ($totalClassesdata as $key => $value) {

            $totalClassget += (int) $value['totalAttendance'];
            $totalLateattendance += (int) $value['lateattendancePerclass'];
            $totalLessonNoAd += (int) $value['studentLessonNoAdd'];

        }

        $totalClassesCount = $totalClassget;
        $classesbonusArr = [];
        foreach ($classes_bonus as $index => $studentdaysrow) {
            $classesbonusArr[$studentdaysrow->weeklyClasses] = $studentdaysrow;
        }

        $ClasseBonusdata = $this->GetClassBonus($totalClassesCount, $classesbonusArr);
        if ($ClasseBonusdata) {
            $slipdata->net += $ClasseBonusdata->classesBonus;
            $tolallateAttendanceAmount = 0;
            $totalLessonNoAdAmount = 0;
            if ($ClasseBonusdata->classesBonus >= 400) {
                $tolallateAttendanceAmount = $totalLateattendance * 3;
                //$totalLessonNoAdAmount  = $totalLessonNoAd * 3;
            } else {
                $tolallateAttendanceAmount = $totalLateattendance * 2.5;
                //$totalLessonNoAdAmount  = $totalLessonNoAd * 2.5;
            }

            $desductAmounttotal = $totalLessonNoAdAmount + $tolallateAttendanceAmount;
            $goodWorkAmounttotal = round($ClasseBonusdata->goodWorkBonus - $desductAmounttotal);
            $slipdata->net += $goodWorkAmounttotal;
        }

        $allowancedata = [];
        $deductiondata = [];

        foreach ($allowance as $key => $value) {

            $allowancename = DB::table('allowances')->where('id', $value['aid'])->first()->allowance;

            $allowancedata[$key]['allowance'] = $allowancename;
            $allowancedata[$key]['amount'] = $value['amount'];

        }
        foreach ($deductions as $key => $value) {

            $deductionname = DB::table('deductions')->where('id', $value['did'])->first()->deduction;

            $deductiondata[$key]['deduction'] = $deductionname;
            $deductiondata[$key]['amount'] = $value['amount'];

        }

        if (isset($extraAllowance)) {
            foreach ($extraAllowance as $key => $value) {

                $slipdata->net += $value;

            }
        }
        if (isset($extradeduction)) {
            foreach ($extradeduction as $key => $value) {

                $slipdata->net -= $value;

            }
        }

        $creditarray = array();
        $empcreditres = EmployeesCreditPartial::select(['employees_credit_partial.no_partial', 'employees_credit.id as credit_id', 'employees_credit_partial.id as partial_id', 'employees_credit_partial.partial_amount', 'employees_credit.type'])
            ->leftjoin('employees_credit', 'employees_credit.id', '=', 'employees_credit_partial.employess_credit_id')
            ->where('employees_credit_partial.isPaid', 'paid')->where('employees_credit_partial.approval', 'Approved')->where('employees_credit.employee_id', $slipdata->employee_id)->whereBetween('employees_credit_partial.salaryDate', [$payroll->date_from, $payroll->date_to])->get();

        foreach ($empcreditres as $inCred => $datacredit) {

            $creditarray[$inCred][] = $datacredit;
            //  $creditamount  = ceil($datacredit->partial_amount);
            //  $net -= $creditamount;
            //  $totalcreditamount += $creditamount;
        }

        $salaryInwords = $this->convertNumberToWord($slipdata->net);

        $this->setPageTitle('Payroll Slip', 'Payroll Slip');
        return view('admin.teacherpanel.salary.payrollslip', compact('totaldaysEarn','teacherdata', 'allpayrolldata', 'creditarray', 'extradeduction', 'extraAllowance', 'goodWorkAmounttotal', 'slipdata', 'payroll', 'employees', 'allowancedata', 'deductiondata', 'salaryInwords', 'totalClassesdata', 'classes_bonus', 'ClasseBonusdata'));

    }

    public function GetClassBonus($class, $bonusessArray)
    {
        if ($class >= 100 && $class < 200) {
            return $bonusessArray[100];
        } else if ($class >= 200 && $class < 300) {
            return $bonusessArray[200];
        } else if ($class >= 300 && $class < 400) {
            return $bonusessArray[300];
        } else if ($class >= 400 && $class < 500) {
            return $bonusessArray[400];
        } else if ($class > 500) {
            return $bonusessArray[500];
        } else {
            return 0;
        }
    }

    public function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen',
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion',
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    public function improvement()
    {
        $this->setPageTitle('Improvement', 'View All Improvement');
        return view('admin.teacherpanel.improvement.index');
    }

    public function payroll_slip_password()
    {
        $this->setPageTitle('Payroll Password Reset', 'Password Reset');
        return view('admin.teacherpanel.salary.generatepassword');
    }

    public function paswword_Generate(Request $request)
    {

        $this->validate($request, [
            'oldpassword' => 'required',
            'newpassword' => 'required|min:5|max:8|same:confirm-password|different:oldpassword',
            'confirm-password' => 'required',
        ]);

        $user = Employee::where('user_id', Auth::user()->id)->firstOrFail();

        if ($user) {

            if ($request->oldpassword == $user->salarypass) {
                // $Employee::->fill([
                //  'salarypass' => $request->newpassword
                //  ])->save();

                $emp = new Employee();
                $emp->salarypass = $request->newpassword;
                $emp->exists = true;
                $emp->id = $user->id;
                $emp->save();

                return $this->responseRedirectBack('Salary Password changed.', 'success', false, false);

            } else {

                return $this->responseRedirectBack('Your Old Password does not match.', 'success', false, false);
            }

            return $this->responseRedirectBack('Error occurred while deleting Package.', 'success', false, false);
        }
        return $this->responseRedirect('User Not Found', 'error', true, true);

    }

    public function paswword_validate(Request $request)
    {

       

        $rules = array(
            'pass' => 'required'
        );

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json([
                'error' => $error->errors()->getMessageBag(),
            ]);
        }

        try {

            $user = Employee::where('user_id', Auth::user()->id)->where('salarypass', $request->pass)->first();

            if ($user) {

                if ($request->pass == $user->salarypass) {
                    // $Employee::->fill([
                    //  'salarypass' => $request->newpassword
                    //  ])->save();

                    return response()->json(['success' => true, 'msg' => "Password Authenticated Successfully"], 200);

                } else {

                    return response()->json(['success' => true, 'msg' => "Invalid Password"], 200);
                }

                return response()->json(['success' => true, 'msg' => "User Not Found"], 200);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['success' => false, 'msg' => $ex->getMessage()], 500);
        }

    }
}

<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\Datatables\Datatables;
use DB;
use App\models\Language;
use App\models\AdvertisementAgencies;
use App\models\City;
use App\models\Country;
use Spatie\Permission\Models\Role;
use App\models\Skill;
use App\models\ParentLanguageLookup;
use App\models\Student;
use App\models\User;
use App\models\ChangeInDueDateHistory;
use Validator;
use Illuminate\Support\Facades\Hash;

class ParentsController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Parent', 'List  of all Parentst');
        return view('admin.parent.index');
    }
     public function create()
    {
       
        $Country = Country::get();
        // $City = City::get();
        $City = [];
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::get();
        $this->setPageTitle('Parent', 'Create Parent : ');
        return view('admin.parent.create', compact('Country','City','Language','Agencies'));
    }


    public function get_par_forms(){
        // $parent = Parents::select(['parents.*'])
        // ->leftjoin('countries','countries.id' , ' = ' , 'parents.country_id')
        // ->leftjoin('cities','cities.id' , ' = ' , 'parents.city_id')
        // ->leftjoin('parent_language_lookups','parent_language_lookups.parent_id' , ' = ' , 'parents.parent_id')->get();

        $parent = Parents::with(['getCity','getCountry'])->select(['parents.*'])
         ->groupBy('parents.id');
         return Datatables::of($parent)
         ->addColumn('action', function ($parent) {

          
            $editurl = route('admin.parent.edit',$parent->id);
           
            $ret = '';
            // if (Gate::allows('user-edit'))
            // {
                $ret .= '<a class="btn btn-primary" href="'.$editurl.'" >Edit</a>';
            // }

            return $ret;
           
        })

        ->addColumn('countrycol', function ($parent) {

          
          
           
            $ret = '';
            // if (Gate::allows('user-edit'))
            // {
                $ret .= ($parent->getCountry)?$parent->getCountry->CountryName:'';
            // }

            return $ret;
           
        })

        ->addColumn('citycol', function ($parent) {

          
            
           
            $ret = '';
            // if (Gate::allows('user-edit'))
            // {
              $ret .= ($parent->getCity)?$parent->getCity->CityName:"";
            // }

            return $ret;
           
        })

        ->rawColumns(['action','countrycol','citycol'])
         ->editColumn('id', 'ID: {{$id}}')
         ->make(true);


       
    }

    public function edit($id)
    {
        $targetParent= Parents::find($id);
        $Country = Country::get();
        // $City = City::get();
        $City = City::where('CountryID',$targetParent->country_id)->get();
        $Language = Language::get();
        $Agencies = AdvertisementAgencies::get();
        $User = User::find($targetParent->user_id);
        $LanguageLookup = ParentLanguageLookup::where('parent_id', $id)->get();
        $this->setPageTitle('Parent', 'Edit Parent : ' . $targetParent->name);
        return view('admin.parent.edit', compact('LanguageLookup','targetParent','User','Country','City','Language','Agencies'));
    }
    
    
    
     public function get_student_schdule_forms(Request $request)
    {
        
       
      
       $groupno = Parents::where('id',$request->id)->first()->groupno;
     
        $Student = Student::with('CurrentAcademicStatus')->select(['student.academicStatus','student.group','student.studentname','student.id','student.duration', 'countries.CountryName', 'employees.employeename', 'studentdays.*'])
            ->selectRaw('GROUP_CONCAT(DISTINCT(l.languagename))  as languages')
            ->selectRaw('(CASE
        WHEN student.class_type = 1 THEN "Trial"
        ELSE "Regular"
    END) as class_status')
            ->leftjoin(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->leftjoin('student_language_lookups as sll', 'student.id', '=', 'sll.student_id')
            ->leftjoin('languages as l', 'l.id', '=', 'sll.language_id')
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id');

        $Student->where('student.group', $groupno);
        // $Student->where('student.academicStatus', 1);
        // $Student->where('student.step_status', 5);
        $Student->groupBy('student.id');

        return Datatables::of($Student)
            
            ->addColumn('studentprofile', function ($Student) {

                $editurl = route('admin.student.detail',$Student->id);
                

                $ret = '';
                // if (Gate::allows('user-edit'))
                // {
                $ret .=  '<a href="'.$editurl.'">'.$Student->studentname.'</a>' ;
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

                    $studentdaysss = (isset($studentdays[$index]))?($studentdays[$index] != "") ? substr($studentdays[$index], 0, 3) : 'no' :'no';
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

                $editurl = route('admin.student.edit',$Student->id);
                

                $ret = '';
             
                $ret .=  '<a class="btn btn-primary" href="'.$editurl.'">view</a>' ;
                

                return $ret;

            })
             ->addColumn('status', function ($Student) {

               
                

                $ret = '';
             
                $ret .=  $Student->CurrentAcademicStatus->academic_status;
                

                return $ret;

            })


            ->rawColumns(['studentprofile','status', 'day','detail'])
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }
    
    
    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required|max:191',
            'username' => 'required|max:191|unique:users,name',
            'email' => 'required|string|email|max:191|unique:users',
            'fname' => 'required|max:191',
            'resource' => 'required|max:191',
            'age' => 'required|max:191',
            'language.*' => 'required',
            'gender' => 'required|max:191',
            'country' => 'required|max:191',
            'city' => 'required|max:191',
            'contactno' => 'required|max:191',
            'whatsappno' => 'required|max:191',
            'personalskype' => 'required|max:191',
            'currentaddress' => 'required',
            'permanentaddress' => 'required',
            'status' => 'required',
            'password' => 'required|same:confirmpassword',
            'confirmpassword' => 'required',
        );

        if ($request->resource == 2) {
            $rules['referencename'] = 'required';
            $rules['referenceemail'] = 'required';
        }
        if ($request->resource == 1) {
            $rules['marketingagencies'] = 'required';
        }



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
            $password = Hash::make($request->password);
            $User->password = $password;
            $User->name = $request->username;
            $User->email = $request->email;
            $User->password_text = $request->password;
            $User->status = $request->status;
            $User->save();

            $genderval = ($request->gender == 1) ? 1 : 2;
            $employee = new Parents();
            $employee->user_id = $User->id;
            $employee->name = $request->name;
            $employee->fathername = $request->fname;
            $employee->resource_type = $request->resource;
            $employee->age = $request->age;
            $employee->gender = $genderval;
            $employee->country_id = $request->country;
            $employee->city_id = $request->city;
            $employee->groupno  =  $request->groupno;
            $employee->contact_no_2 = $request->contactno2;
            $employee->contact_no = $request->contactno;
            $employee->whatsapp = $request->whatsappno;
            $employee->identity_card_no = $request->cardno;
            $employee->personal_skype = $request->personalskype;
            $employee->current_address = $request->currentaddress;
            $employee->permanent_address = $request->permanentaddress;
            $employee->comment = $request->comment;
            $employee->invoice_date = $request->invoice_due_date;

            if ($request->resource == 2) {
                $employee->resource_name = $request->referencename;
                $employee->resource_email = $request->referenceemail;
            }
            if ($request->resource == 1) {
                $employee->resource_agency_id = $request->marketingagencies;
            }
            $employee->save();
            ParentLanguageLookup::where('parent_id', $request->id)->delete();
            if (isset($request->language)) {
            if (count($request->language) > 0) {
                foreach ($request->language as $key => $lang) {
                    $emplanguage = new ParentLanguageLookup();
                    $emplanguage->parent_id = $employee->id;
                    $emplanguage->language_id = $lang;
                    $emplanguage->save();
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
    
    public function update(Request $request)
    {
        $rules = array(
            'name' => 'required|max:191',
            'fname' => 'required|max:191',
            'resource' => 'required|max:191',
            'age' => 'required|max:191',
            'language.*' => 'required',
            'gender' => 'required|max:191',
            'country' => 'required|max:191',
            'city' => 'required|max:191',
            'contactno' => 'required|max:191',
            'whatsappno' => 'required|max:191',
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
            $employee = new Parents();
            
            $getPreviousDate = Parents::where("id", $request->id)->first();
            ChangeInDueDateHistory::create([
                "group_no" => $request->groupno,
                "previous_date" => $getPreviousDate->invoice_date,
                "new_date" => $request->invoice_due_date,
            ]);
            $employee->user_id = $User->id;
            $employee->name = $request->name;
            $employee->fathername = $request->fname;
            $employee->resource_type = $request->resource;
            $employee->age = $request->age;
            $employee->gender = $genderval;
            $employee->country_id = $request->country;
            $employee->city_id = $request->city;
            $employee->groupno  =  $request->groupno;
            $employee->contact_no_2 = $request->contactno2;
            $employee->contact_no = $request->contactno;
            $employee->whatsapp = $request->whatsappno;
            $employee->identity_card_no = $request->cardno;
            $employee->personal_skype = $request->personalskype;
            $employee->current_address = $request->currentaddress;
            $employee->permanent_address = $request->permanentaddress;
            $employee->comment = $request->comment;
            $employee->invoice_date = $request->invoice_due_date;
            
    
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

            ParentLanguageLookup::where('parent_id', $request->id)->delete();
            if (isset($request->language)) {
            if (count($request->language) > 0) {
                foreach ($request->language as $key => $lang) {
                    $emplanguage = new ParentLanguageLookup();
                    $emplanguage->parent_id = $request->id;
                    $emplanguage->language_id = $lang;
                    $emplanguage->save();
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
    
    
}

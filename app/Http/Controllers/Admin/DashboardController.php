<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use App\models\AdvertisementAgencies;
use App\models\Employee;
use App\models\Student;
use DB;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        
        
         $Employee = Employee::where('employees.role_type', 'teacher')->get();
               $Studenttrail = DB::table('student')->where('academicStatus', 1)->where('class_type',1)->count('id');
               $StudentRegular = DB::table('student')->where('academicStatus', 1)->where('class_type',2)->count('id');
        
        
        
        $StudentActive = DB::table('student')->where('academicStatus', 1)->count('id'); 
        $StudentInactive = DB::table('student')->where('academicStatus', 2)->count('id'); 
        $StudentLeave = DB::table('student')->where('academicStatus', 3)->count('id'); 
        $Studentclose = DB::table('student')->where('academicStatus', 4)->count('id'); 
        $StudentPending = DB::table('student')->where('academicStatus', 6)->count('id'); 
        $StudentRejected = DB::table('student')->where('academicStatus', 5)->count('id'); 
        
        
        $StudentActivehistory = DB::table('academicstatuschange')->where('status', 1)->whereRaw("DATE_FORMAT(DATE_ADD(created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(now(),INTERVAL 660 MINUTE),'%Y-%m-%d')")->count('id'); 
        $StudentInactivehistory = DB::table('academicstatuschange')->where('status', 2)->whereRaw("DATE_FORMAT(DATE_ADD(created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(now(),INTERVAL 660 MINUTE),'%Y-%m-%d')")->count('id'); 
        $StudentLeavehistory = DB::table('academicstatuschange')->where('status', 3)->whereRaw("DATE_FORMAT(DATE_ADD(created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(now(),INTERVAL 660 MINUTE),'%Y-%m-%d')")->count('id'); 
        $Studentclosehistory = DB::table('academicstatuschange')->where('status', 4)->whereRaw("DATE_FORMAT(DATE_ADD(created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(now(),INTERVAL 660 MINUTE),'%Y-%m-%d')")->count('id'); 
        $StudentPendinghistory = DB::table('academicstatuschange')->where('status', 6)->whereRaw("DATE_FORMAT(DATE_ADD(created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(now(),INTERVAL 660 MINUTE),'%Y-%m-%d')")->count('id'); 
        $StudentRejectedhistory = DB::table('academicstatuschange')->where('status', 5)->whereRaw("DATE_FORMAT(DATE_ADD(created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') = DATE_FORMAT(DATE_ADD(now(),INTERVAL 660 MINUTE),'%Y-%m-%d')")->count('id'); 
       
        $Agencies = AdvertisementAgencies::whereIn('id', [9, 10, 11,12])->get();
        $reason = DB::table('reason')->get();
        
        
        $this->setPageTitle('Dashboard', 'View All Stats');
        return view('admin.dashboard.index',compact(
            'StudentActive',
            'StudentInactive',
            'StudentLeave',
            'Studentclose',
            'StudentPending',
            'StudentRejected',
            'StudentActivehistory',
            'StudentInactivehistory',
            'StudentLeavehistory',
            'Studentclosehistory',
            'StudentPendinghistory',
            'StudentRejectedhistory',
            'StudentRegular',
            'Studenttrail',
            'Agencies',
            'reason',
            'Employee'
            ));
    }
    
    public function getDashboardStats(Request $request){
        
            $start_date =  $request->start_date;
            $end_date =  $request->end_date;
            
              $agencies = '';
            
        
        //Start Active history data 
          $StudentActivehistoryagencyWise   = 
          DB::table('academicstatuschange  as asch')
          ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
          ->where('asch.status', 1);
          if($agencies){
              $StudentActivehistoryagencyWise->where('student.agency_id',$agencies);
           }else{
              $StudentActivehistoryagencyWise->whereIn('student.agency_id', [9, 10, 11,12]);
           }
           $StudentActivehistoryagencyWise->where('student.joining_source',1);
           $StudentActivehistoryagencyWise = $StudentActivehistoryagencyWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('student.agency_id')->get(); 
        
        
        
        
          $StudentActivehistoryareferWise = [];
        if($agencies  == ""){
          $StudentActivehistoryareferWise   = 
          DB::table('academicstatuschange  as asch')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->where('asch.status', 1);
          $StudentActivehistoryareferWise->where('student.joining_source',2);
          $StudentActivehistoryareferWise = $StudentActivehistoryareferWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->count('asch.id'); 
        
        }
        
           
           $StudentActivehistory = DB::table('academicstatuschange as asch')
           ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->where('asch.status', 1);
           if($agencies){
              $StudentActivehistory->where('student.agency_id',$agencies);
            }
           $StudentActivehistory = $StudentActivehistory->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('asch.student_id')->get(); 
           
           $StudentActivehistory   = count($StudentActivehistory);
            
     
     //End Active history data
     
     
     
      //Start InActive history data 
          $StudentInActivehistoryagencyWise   = 
          DB::table('academicstatuschange  as asch')
          ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
          
          ->where('asch.status', 2);
          if($agencies){
              $StudentInActivehistoryagencyWise->where('student.agency_id',$agencies);
           }else{
              $StudentInActivehistoryagencyWise->whereIn('student.agency_id', [9, 10, 11,12]);
           }
           $StudentInActivehistoryagencyWise->where('student.joining_source',1);
           $StudentInActivehistoryagencyWise = $StudentInActivehistoryagencyWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('student.agency_id')->get(); 
        
        
        
        
          $StudentInActivehistoryareferWise = [];
        if($agencies  == ""){
          $StudentInActivehistoryareferWise   = 
          DB::table('academicstatuschange  as asch')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->where('asch.status', 2);
          $StudentInActivehistoryareferWise->where('student.joining_source',2);
          $StudentInActivehistoryareferWise = $StudentInActivehistoryareferWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->count('asch.id'); 
        
        }
     
     
           $StudentInactivehistory = DB::table('academicstatuschange as asch')
           ->leftjoin('student', 'student.id', '=', 'asch.student_id');
             if($agencies){
              $StudentInactivehistory->where('student.agency_id',$agencies);
            }
          $StudentInactivehistory = $StudentInactivehistory->where('asch.status', 2)
           ->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
           ->count('asch.id'); 
           
           
           
          //End InActive history data  
           
           
            //Start Leave history data 
          $StudentLeavehistoryagencyWise   = 
          DB::table('academicstatuschange  as asch')
          ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
          ->where('asch.status', 3);
          if($agencies){
              $StudentLeavehistoryagencyWise->where('student.agency_id',$agencies);
           }else{
              $StudentLeavehistoryagencyWise->whereIn('student.agency_id', [9, 10, 11,12]);
           }
           $StudentLeavehistoryagencyWise->where('student.joining_source',1);
           $StudentLeavehistoryagencyWise = $StudentLeavehistoryagencyWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('student.agency_id')->get(); 
        
        
        
        
          $StudentLeavehistoryareferWise = [];
        if($agencies  == ""){
          $StudentLeavehistoryareferWise   = 
          DB::table('academicstatuschange  as asch')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->where('asch.status', 3);
          $StudentLeavehistoryareferWise->where('student.joining_source',2);
          $StudentLeavehistoryareferWise = $StudentLeavehistoryareferWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->count('asch.id'); 
        
        }
           
           $StudentLeavehistory = DB::table('academicstatuschange as asch')
            ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->where('asch.status', 3);
           if($agencies){
              $StudentLeavehistory->where('student.agency_id',$agencies);
            }
           $StudentLeavehistory = $StudentLeavehistory->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
           ->count('asch.id'); 
           
           
           //End Leave history data  
           
           
           
           
            //Start Close history data 
          $StudentClosehistoryagencyWise   = 
          DB::table('academicstatuschange  as asch')
          ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
          ->where('asch.status', 4);
          if($agencies){
              $StudentClosehistoryagencyWise->where('student.agency_id',$agencies);
           }else{
              $StudentClosehistoryagencyWise->whereIn('student.agency_id', [9, 10, 11,12]);
           }
           $StudentClosehistoryagencyWise->where('student.joining_source',1);
           $StudentClosehistoryagencyWise = $StudentClosehistoryagencyWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('student.agency_id')->get(); 
        
        
        
        
          $StudentClosehistoryareferWise = [];
        if($agencies  == ""){
          $StudentClosehistoryareferWise   = 
          DB::table('academicstatuschange  as asch')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->where('asch.status', 4);
          $StudentClosehistoryareferWise->where('student.joining_source',2);
          $StudentClosehistoryareferWise = $StudentClosehistoryareferWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->count('asch.id'); 
        
        }
           
           $Studentclosehistory = DB::table('academicstatuschange as asch')
            ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->where('asch.status', 4);
            if($agencies){
              $Studentclosehistory->where('student.agency_id',$agencies);
            }
           $Studentclosehistory = $Studentclosehistory->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
           ->count('asch.id'); 
           
           
           
            //End Close history data  
            
            
            
             //Start Pending history data 
          $StudentPendinghistoryagencyWise   = 
          DB::table('academicstatuschange  as asch')
          ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
          ->where('asch.status', 6);
          if($agencies){
              $StudentPendinghistoryagencyWise->where('student.agency_id',$agencies);
           }else{
              $StudentPendinghistoryagencyWise->whereIn('student.agency_id', [9, 10, 11,12]);
           }
           $StudentPendinghistoryagencyWise->where('student.joining_source',1);
           $StudentPendinghistoryagencyWise = $StudentPendinghistoryagencyWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('student.agency_id')->get(); 
        
        
        
        
          $StudentPendinghistoryareferWise = [];
        if($agencies  == ""){
          $StudentPendinghistoryareferWise   = 
          DB::table('academicstatuschange  as asch')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->where('asch.status', 6);
          $StudentPendinghistoryareferWise->where('student.joining_source',2);
          $StudentPendinghistoryareferWise = $StudentPendinghistoryareferWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->count('asch.id'); 
        
        }
           
           
           $StudentPendinghistory = DB::table('academicstatuschange as asch')
            ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->where('asch.status', 6);
            if($agencies){
              $StudentPendinghistory->where('student.agency_id',$agencies);
            }
           $StudentPendinghistory = $StudentPendinghistory->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
           ->count('asch.id'); 
           
           
            //End Pending history data 
           
           
           
              //Start Rejected history data 
          $StudentRejectedhistoryagencyWise   = 
          DB::table('academicstatuschange  as asch')
          ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
          ->where('asch.status', 5);
          if($agencies){
              $StudentRejectedhistoryagencyWise->where('student.agency_id',$agencies);
           }else{
              $StudentRejectedhistoryagencyWise->whereIn('student.agency_id', [9, 10, 11,12]);
           }
           $StudentRejectedhistoryagencyWise->where('student.joining_source',1);
           $StudentRejectedhistoryagencyWise = $StudentRejectedhistoryagencyWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('student.agency_id')->get(); 
        
        
        
        
          $StudentRejectedhistoryareferWise = [];
        if($agencies  == ""){
          $StudentRejectedhistoryareferWise   = 
          DB::table('academicstatuschange  as asch')
          ->leftjoin('student', 'student.id', '=', 'asch.student_id')
          ->where('asch.status', 5);
          $StudentRejectedhistoryareferWise->where('student.joining_source',2);
          $StudentRejectedhistoryareferWise = $StudentRejectedhistoryareferWise->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->count('asch.id'); 
        
        }
           
           
           $StudentRejectedhistory = DB::table('academicstatuschange as asch')
            ->leftjoin('student', 'student.id', '=', 'asch.student_id')
           ->where('asch.status', 5);
           if($agencies){
              $StudentRejectedhistory->where('student.agency_id',$agencies);
            }
           $StudentRejectedhistory  = $StudentRejectedhistory->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
           ->count('asch.id'); 
            
            //End Rejected history data 
            
            
           $resstatus = array('StudentActivehistory' => $StudentActivehistory,
            'StudentInactivehistory' => $StudentInactivehistory,
            'StudentLeavehistory' => $StudentLeavehistory,
            'Studentclosehistory' => $Studentclosehistory,
            'StudentPendinghistory' => $StudentPendinghistory,
            'StudentRejectedhistory' => $StudentRejectedhistory);
            
            
             $resstatusagencywise = array(
                 'StudentActivehistoryagencyWise' => $StudentActivehistoryagencyWise,'StudentActivehistoryareferWise' => $StudentActivehistoryareferWise,
                 'StudentInactivehistoryagencyWise' => $StudentInActivehistoryagencyWise,'StudentInactivehistoryareferWise' => $StudentInActivehistoryareferWise,
                 'StudentLeavehistoryagencyWise'   =>$StudentLeavehistoryagencyWise,'StudentLeavehistoryareferWise' =>$StudentLeavehistoryareferWise,
                 'StudentclosehistoryagencyWise' =>  $StudentClosehistoryagencyWise, 'StudentclosehistoryareferWise' => $StudentClosehistoryareferWise,
                 'StudentPendinghistoryagencyWise' => $StudentPendinghistoryagencyWise ,  'StudentPendinghistoryareferWise' => $StudentPendinghistoryareferWise,
                 'StudentRejectedhistoryagencyWise' =>   $StudentRejectedhistoryagencyWise, 'StudentRejectedhistoryareferWise'  => $StudentRejectedhistoryareferWise, 
                 );
            
            
            $statusdata =  array(1,2,3,4,6,5);
        
        
           return response()->json([
                'resstatus' => $resstatus,
                'resstatusagencywise' => $resstatusagencywise,
                'statusdata' => $statusdata,
                'start_date' => $start_date,
                'end_date' => $end_date,
             ]);
        
    }
    
    public function getdashboardStatsTest(Request $request){
        // $start_date =  "2022-01-17";
        // $end_date =  "2022-02-15";
         $start_date =  $request->start_date;
         $end_date =  $request->end_date;
         $status =  $request->status;
         $teacher_id  = $request->teacher_id;
          $alldata  = array();
         if($status  == 1){
              $agencies  = "";
        //  ->select(DB::raw('count(asch.id) as total'),'student.agency_id','advertisement_agencies.agencyname')
         $StudentActivehistory = DB::table('academicstatuschange as asch')
           ->leftjoin('student', 'student.id', '=', 'asch.student_id')
            ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
            ->select(DB::raw('count(asch.id) as total,asch.student_id as studentids,asch.teacher_id as teacherids'),'student.joining_source','advertisement_agencies.agencyname')
            ->where('asch.status', 1);
         if($agencies){
              $StudentActivehistory->where('student.agency_id',$agencies);
         }
         if($teacher_id){
              $StudentActivehistory->where('asch.teacher_id',$teacher_id);
         }
        $StudentActivehistory = $StudentActivehistory->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")->groupBy('asch.student_id')->get(); 
     
    //  return $StudentActivehistory;
     
         $datacounter =  array('total' => $StudentActivehistory->count(),'Web' => 0,'A Marketing' => 0,'B Marketing' => 0,'C Marketing' => 0,'referral' => 0);
         $studentarray = [];
         $teacharray = [];
         foreach($StudentActivehistory as $index => $data){
             $studentarray[] = $data->studentids;
             $teacharray[] = $data->teacherids;
             if($data->joining_source == 1){
                   $val = $datacounter[$data->agencyname];
                   $datacounter[$data->agencyname]  = $val+1;
             }else{
                    $val = $datacounter['referral']; 
                    $datacounter['referral']  =   $val+1;
             }
            
         }
         
        //  return $teacharray;
         
         
        //     $studentsdata = DB::table('student')->select(DB::raw('count(student.id) as total'),'student.academicStatus')
        //  ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')->whereIn('student.id', $studentarray)->groupBy('student.academicStatus')->get();
          
        //   return  $studentsdata;
         
         $studentsdata = DB::table('student')->select('student.id','student.studentname','student.academicStatus','academic_status.academic_status','student.joining_source','advertisement_agencies.agencyname')
         ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
         ->leftjoin('academic_status', 'academic_status.id', '=', 'student.academicStatus');
         if($teacher_id){
              $studentsdata->where('student.teacher_id',$teacher_id);
         }
         $studentsdata = $studentsdata->whereIn('student.id', $studentarray)->get();
         
          $datacounterstatus =  array('Web' => ['Active' => 0 ,'Close' => 0 ,'Leave' => 0,'InActive' => 0 ,'Pending' => 0 ,'Rejected' => 0,'Time Reserved' =>0],'A Marketing' => ['Active' => 0 ,'Close' => 0 ,'Leave' => 0,'InActive' => 0 ,'Pending' => 0 ,'Rejected' => 0,'Time Reserved' =>0],'B Marketing' => ['Active' => 0 ,'Close' => 0 ,'Leave' => 0,'InActive' => 0 ,'Pending' => 0 ,'Rejected' => 0,'Time Reserved' =>0],'C Marketing' => ['Active' => 0 ,'Close' => 0 ,'Leave' => 0,'InActive' => 0 ,'Pending' => 0 ,'Rejected' => 0,'Time Reserved' =>0],'referral' => ['Active' => 0 ,'Close' => 0 ,'Leave' => 0,'InActive' => 0 ,'Pending' => 0 ,'Rejected' => 0,'Time Reserved' =>0]);
          $datastatuswise = [];
          foreach($studentsdata as $index  => $stddata){
               if($stddata->joining_source == 1){
                     $val = $datacounterstatus[$stddata->agencyname][$stddata->academic_status];
                     $datacounterstatus[$stddata->agencyname][$stddata->academic_status]  =   $val+1;
               }
               else{
                    $val = $datacounterstatus['referral'][$stddata->academic_status]; 
                    $datacounterstatus['referral'][$stddata->academic_status]  =   $val+1;
             }
          }
          
          $StudentStarted = Student::select(['student.id','student.group','student.studentname', 'countries.CountryName','employees.employeename', 'studentdays.*','lastattendance.latestattendance', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +11 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')]);
           $StudentStarted->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
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
        $StudentStarted->whereIn('student.id', $studentarray);
        if($teacher_id){
              $StudentStarted->where('student.teacher_id',$teacher_id);
         }
        // $StudentStarted->where('student.academicStatus', 1);
        $StudentStarted->where('student.step_status', 5);
        $StudentStarted->groupBy('studentattendance.student_id');
        $StudentStarted->havingRaw('(sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) <  studentdays.Totalday  &&  totaldaycount <= 14 ) &&  sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END)  >=1 ');
        $StudentStarted   =  $StudentStarted->orderby('student.id', 'desc')->get();
        
        
        
        
        $StudentCompleted = Student::select(['student.id','student.studentname','student.group', 'countries.CountryName', 'studentdays.*', DB::raw('sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END) as attendancecount'), DB::raw('datediff(date_format(date_add(NOW(),INTERVAL +10 HOUR),"%Y-%m-%d"),lastattendance.latestattendance)  totaldaycount'), DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate')])
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

        // $StudentCompleted->where('student.academicStatus', 1);
         if($teacher_id){
              $StudentCompleted->where('student.teacher_id',$teacher_id);
         }
        $StudentCompleted->where('student.step_status', 5);
        $StudentCompleted->whereIn('student.id', $studentarray);
        // $StudentCompleted->whereRaw('(student.billing_status = 2 ||  student.feedbackstatus = 2)');
        $StudentCompleted->groupBy('studentattendance.student_id');
        // $Student->having(DB::raw('count(studentattendance.student_id) >=  studentdays.Totalday ||  studentdays.Totalday <= 20'));
        // $Student->having(DB::raw('count(studentattendance.student_id)'), '>=',DB::raw('studentdays.Totalday'));

        $StudentCompleted->havingRaw('sum(CASE WHEN (`studentattendance`.attendance_status = 1 || `studentattendance`.attendance_status = 8) then 1 ELSE 0 END) >=  studentdays.Totalday ||  totaldaycount > 14 ');
       $StudentCompleted = $StudentCompleted->orderby('student.id', 'desc')->get();
       
       
       
        $StudentPending = Student::select(['student.id','student.studentname', 'countries.CountryName','employees.employeename', DB::raw('DATE_FORMAT(student.created_at,"%d-%m-%Y") as joiningdate'), 'studentdays.*'])
            ->leftjoin('employees', 'employees.id', '=', 'student.teacher_id')
            ->leftjoin('countries', 'student.country', '=', 'countries.id')
            ->leftjoin(DB::raw('(SELECT GROUP_CONCAT(student_day_name) studentdays_name,GROUP_CONCAT(day_no) daynos,GROUP_CONCAT(day_name) days,GROUP_CONCAT(local_time_text) local_time_text,GROUP_CONCAT(student_time_text) student_time_text,student_id FROM `student_days` GROUP BY student_id ORDER by day_no asc) studentdays'),
                function ($join) {
                    $join->on('student.id', '=', 'studentdays.student_id');
                })
            ->leftjoin('studentattendance', 'studentattendance.student_id', '=', 'student.id');
        // $StudentPending->where('student.academicStatus', 1);
        // $StudentPending->where('student.step_status', 5);
         if($teacher_id){
              $StudentPending->where('student.teacher_id',$teacher_id);
         }
        $StudentPending->whereIn('student.id', $studentarray);
        $StudentPending->groupBy('student.id');
        $StudentPending->having(DB::raw(' sum(CASE WHEN `studentattendance`.attendance_status = 1 then 1 ELSE 0 END)'), '=', 0);
        $StudentPending = $StudentPending->orderby('student.id', 'desc')->get();
         
         
        // $alldata =   array('$datacounterstatus' => $datacounterstatus ,'$StudentPending' => $StudentPending ,'$StudentCompleted' => $StudentCompleted,'$StudentStarted' => $StudentStarted);
        
        
        
        $empdata = DB::table('academicstatuschange as asch')->select(DB::raw('count(asch.id) as total,employees.employeename,asch.teacher_id'))
        ->leftjoin('employees', 'employees.id', '=', 'asch.teacher_id')
        ->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
        ->whereIn('asch.student_id', $studentarray)
        ->where('asch.status', 1)
        ->where('asch.teacher_id','!=' ,0)->groupBy('asch.teacher_id')
        ->get();
        
        
        
        //   $empdata = DB::table('academicstatuschange as asch')
        //           ->leftjoin('employees', 'employees.id', '=', 'asch.teacher_id')
        //           ->leftjoin('student', 'student.id', '=', 'asch.student_id')
        //           ->leftjoin('advertisement_agencies', 'advertisement_agencies.id', '=', 'student.agency_id')
        //           ->select(DB::raw('count(asch.id) as total,asch.student_id as studentids,asch.teacher_id as teacherids'),'employees.employeename','student.joining_source','advertisement_agencies.agencyname')
        //           ->whereRaw("DATE_FORMAT(DATE_ADD(asch.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')")
        //           ->whereIn('asch.student_id', $studentarray)
        //           ->where('asch.teacher_id','!=' ,0)->groupBy('asch.teacher_id')
        //           ->get();
        
        
        
           $StudentTransfer = DB::table('teacherchange')->select(DB::raw('count(teacherchange.id) as totalstudent,oldteacher.employeename,teacherchange.teacher_id'))
            ->join('employees as oldteacher', 'oldteacher.id', '=', 'teacherchange.teacher_id');
            if($teacher_id){
                 $StudentTransfer->where('oldteacher.id', $teacher_id);
            }
            $StudentTransfer->whereIn('teacherchange.student_id', $studentarray);
            // $StudentTransfer->whereRaw("DATE_FORMAT(DATE_ADD(teacherchange.created_at,INTERVAL 660 MINUTE),'%Y-%m-%d') BETWEEN  DATE_FORMAT('$start_date','%Y-%m-%d')  AND DATE_FORMAT('$end_date','%Y-%m-%d')");
            $StudentTransfer = $StudentTransfer->get();
           
        
       $Employee = Employee::where('employees.role_type', 'teacher')->whereIn('id', $teacharray)->groupBy('id')->get();     
       
       $agencydata =  array('Web' => 9,'A Marketing' => 11,'B Marketing' => 10,'C Marketing' => 12,'referral' => 1);
       
       $traildata = array('StudentPendingTrial' => $StudentPending->count() ,'StudentCompletedTrial' => $StudentCompleted->count(),'StudentStartedTrial' => $StudentStarted->count());
       
       $alldata =   array('StudentTransfer'=>$StudentTransfer,'empdata' => $empdata,'Employee'=>$Employee,'agencydata' => $agencydata,'datacountermarketing' => $datacounter,'datacounterstatus' => $datacounterstatus ,'traildata' =>  $traildata);
        
      
         }
       
         
         return $alldata;
         
        //  $json_pretty = json_encode($alldata, JSON_PRETTY_PRINT);
        //  echo "<pre>".$json_pretty."<pre/>";
         
        //  return    $StudentCompleted;
        
        
    }
    
    public function getAllDaysInAMonth($year, $month, $day, $daysError = 3) {
    $dateString = 'first '.$day.' of '.$year.'-'.$month;

    if (!strtotime($dateString)) {
        throw new \Exception('"'.$dateString.'" is not a valid strtotime');
    }

    $startDay = new \DateTime($dateString);

    if ($startDay->format('j') > $daysError) {
        $startDay->modify('- 7 days');
    }

    $days = array();

    while ($startDay->format('Y-m') <= $year.'-'.str_pad($month, 2, 0, STR_PAD_LEFT)) {
        $days[] = clone($startDay);
        $startDay->modify('+ 7 days');
    }

    return $days;
}
    
    
    public function days_name_new($val)
     {
        $day = '';
        switch ($val) {
            case '1':
                $day = 'Monday';
                break;
            case '2':
                $day = 'Tuesday';
                break;
            case '3':
                $day = 'Wednesday';
                break;
            case '4':
                $day = 'Thursday';
                break;
            case '5':
                $day = 'Friday';
                break;
            case '6':
                $day = 'Saturday';
                break;
            case '7':
                $day = 'Sunday';
                break;
        }

        return $day;
    }
    
    
    public function getTotalClassess(Request $request){
        
        $date = $request->date;
        
        $orderdate = explode('-', $date);
        $month = $orderdate[0];
        $year   = $orderdate[1];

        
        // $year = "2021"; 
        // $month = 07;
        
        $dayarray = [];
        for ($d = 0; $d <= 6; $d++) {
            
            $daynum = $d + 1;
            
            $dayname  = $this->days_name_new($daynum);
            
            $studentsdata =  DB::table('student_days')->select(['student_days.*','student.studentname'])->leftjoin('student', 'student.id', '=', 'student_days.student_id')->where('student.academicStatus', 1)->where('student_days.day_no',$daynum)->where('student_days.day_duration',60)->get();
        
            $days = $this->getAllDaysInAMonth($year,$month,$dayname);
    
            $totalClass = 0 ;
            foreach($studentsdata as $data){
            
                  foreach ($days as $index => $day) {
            	
            	   if($day->format('m') == $month){
                    //  echo $day->format('D Y-m-d').'<br />';
                    
                     $totalClass++;
                    
                    // $dayarray[$dayname][$data->studentname][] = $day->format('D Y-m-d');
                    
                    
                }
                   
            }
            
            }
            $dayarray[$dayname]  = $totalClass;
            
            
            
            //  $totalClass30 = 0 ;
            //  $totalClass60 = 0 ;
            // foreach($studentsdata as $data){
            //       foreach ($days as $index => $day) {
            // 	   if($day->format('m') == $month){
            	       
            // 	       if($data->day_duration == 30){
            // 	           $totalClass30++;
            // 	       }else{
            // 	           $totalClass60++;
            // 	       }
            //       }
                   
            //      }
            
            // }
            // if($totalClass30 > 0){
            //     $dayarray[$dayname][30]  = $totalClass30;
            // }else{
            //     $dayarray[$dayname][60]  = $totalClass60;
            // }
            
           
            
            
            
        }
        
        
        $dayarray2 = [];
        for ($d = 0; $d <= 6; $d++) {
            
            $daynum = $d + 1;
            
            $dayname  = $this->days_name_new($daynum);
            
            $studentsdata =  DB::table('student_days')->select(['student_days.*','student.studentname'])->leftjoin('student', 'student.id', '=', 'student_days.student_id')->where('student.academicStatus', 1)->where('student_days.day_no',$daynum)->where('student_days.day_duration',30)->get();
        
            $days = $this->getAllDaysInAMonth($year,$month,$dayname);
    
            $totalClass = 0 ;
            foreach($studentsdata as $data){
            
                  foreach ($days as $index => $day) {
            	
            	   if($day->format('m') == $month){
                    //  echo $day->format('D Y-m-d').'<br />';
                    
                     $totalClass++;
                    
                    // $dayarray[$dayname][$data->studentname][] = $day->format('D Y-m-d');
                    
                    
                }
                   
            }
            
            }
            $dayarray2[$dayname]  = $totalClass;
            
            
            
            //  $totalClass30 = 0 ;
            //  $totalClass60 = 0 ;
            // foreach($studentsdata as $data){
            //       foreach ($days as $index => $day) {
            // 	   if($day->format('m') == $month){
            	       
            // 	       if($data->day_duration == 30){
            // 	           $totalClass30++;
            // 	       }else{
            // 	           $totalClass60++;
            // 	       }
            //       }
                   
            //      }
            
            // }
            // if($totalClass30 > 0){
            //     $dayarray[$dayname][30]  = $totalClass30;
            // }else{
            //     $dayarray[$dayname][60]  = $totalClass60;
            // }
            
           
            
            
            
        }
        
        
        return array(0=>$dayarray,1=>$dayarray2);
        
    }

}

<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\BaseController;
use DB;
class TeacherController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('Schedule', 'Students Schedule');
        $teacherid  = DB::table('employees')->where('user_id',auth()->user()->id)->first()->id;
        $scduledata = $this->Studentscdule($teacherid);
        return view('admin.teacherpanel.student.schdule',compact('scduledata'));
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
    
    public function oldStudentscdule($id){
        
           $data = [];
             for ($d = 0; $d <= 6; $d++) {
                 
                 $daynum = $d + 1;
                 
                $res  = DB::table('student_days')->select(['student_days.*','student.studentname','student.studentname','student.group'])->leftjoin('student', 'student_days.student_id', '=', 'student.id')
                 ->where('student_days.teacher_id',$id)->where('student_days.day_no',$id)->orderby('student_days.student_time','asc')->get();
                     
                     $data[$d][] = $daynum;
                 
                 
                 
                 
                 
                 
             }
        
      
        return $data;
        
    }
    
    
    public function Studentscdule($id){
        
           $data = [];
            $groupdata = [];
             for ($d = 0; $d <= 6; $d++) {
                 
                 $daynum = $d + 1;
                 
                  $res  = DB::table('student_days')->select(['student_days.*','student.studentname','student.studentname','student.group'])
                  ->leftjoin('student', 'student_days.student_id', '=', 'student.id')
                 ->where('student_days.teacher_id',$id)->where('student_days.day_no',$daynum)
                 ->whereRaw("(student.academicStatus = 1 || student.academicStatus = 8 )")
                 ->orderby('student_days.local_time','asc')->get();
                 
                  if(count($res) > 0){
                 foreach($res as $index => $val){
                        $duration = $val->day_duration;
                        $addduration =  strval("+$duration minutes");
                        $start =  DATE("h:ia", STRTOTIME($val->local_time));
                        $slot = strtotime($addduration, strtotime($val->local_time));
                        
                        // $groupcolor  = $this->random_color_part();
                        
                         $groupcolor  = $this->randomColor(150,255);
                         
                        if(isset($groupdata[$val->group])){
                            
                           $groupcolor =  $groupdata[$val->group];
                            
                            // $groupcolor =  'found';
                        }else{
                            $groupdata[$val->group] = $groupcolor;
                            
                            // $groupcolor = "not found";
                        }
                        
                        
                        $end = date('h:ia', $slot);
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
        
        
                       $class = array(
                                
                                'start' => $start,
                                'end' => $end,
                                'title' =>  substr($this->clean($val->studentname), 0, 15).' '.$val->group,
                                'backgroundColor' => $groupcolor,
                                'borderColor' => '#000',
                                'textColor' => '#000',
                                'studentid' => $val->student_id,
                                'group' => $val->group,
                                );
                     
                      $data[$d]['day'] = $d;
                      $data[$d]['periods'][] = $class;
                    //   $data[$d]['periods']['group'] = $groupdata;
                     
                     
                 }
             }else{
                    
                     $class = array(
                                
                                'start' => '12:10 am',
                                'end' => '12:10 am',
                                'title' =>  'none',
                                'backgroundColor' => '#DCF7E6',
                                'borderColor' => '#000',
                                'textColor' => '#fff',
                                'studentid' => 0,
                                'group' => 0,
                                );
                    
                  
                    
                       $data[$d]['day'] = $d;
                      $data[$d]['periods'][] = $class;
                }
                 
                 
                 
                 
                 
             }
        
      
        return $data;
        
    }
    
     function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}


  function randomColor($minVal = 0, $maxVal = 255)
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

    
    
    function random_color_part() {
     return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
}

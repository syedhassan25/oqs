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
    
    
    public function Studentscdule($id)
    {

        $data = [];
        $groupdata = [];
        for ($d = 0; $d <= 6; $d++) {

            $daynum = $d + 1;

            $res = DB::table('student_days')->select(['student_days.*', 'student.studentname', 'student.studentname', 'student.group', 'countries.CountryName','countries.CountryShortName'])
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
                                'title' => substr($this->clean($val->studentname), 0, 5) . ' ' . $val->group.'('.substr(($val->CountryShortName) ? $val->CountryShortName : $val->CountryName,0,5).')',
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

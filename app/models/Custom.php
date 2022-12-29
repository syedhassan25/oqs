<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Custom extends Model
{
    
    public function freeTeacherTimeSearchByWholeacademic($day,$daytimming,$duration,$teacher){

      
       $time = [];
       
       $start =  DATE("H:i", STRTOTIME($daytimming));
       $startMinute =  (int) DATE("i", STRTOTIME($daytimming));
          
        // if($start == '23:30'){
        //      $duration  =   $duration -1;
        //      $addduration =  strval("+$duration minutes");
        // }
        // else{
             $addduration =  strval("+$duration minutes");
        // } 
         
         $slot = strtotime($addduration, strtotime($daytimming));
         $end = date('H:i', $slot);
         
        
          
           $query = "select student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time from  student_days  inner join  student on student_days.student_id = student.id  where 
                     student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
                     ((DATE_FORMAT(student_days.local_Time, '%H:%i') <= DATE_FORMAT(student_days.End_local_Time, '%H:%i') and '$start' between DATE_FORMAT(student_days.local_Time, '%H:%i') and DATE_FORMAT(student_days.End_local_Time, '%H:%i'))or
                     (DATE_FORMAT(student_days.End_local_Time, '%H:%i') < DATE_FORMAT(student_days.local_Time, '%H:%i') and '$end' not between DATE_FORMAT(student_days.End_local_Time, '%H:%i') and DATE_FORMAT(student_days.local_Time, '%H:%i')))
                     AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)";
               
        
            
            
            
            
            $res = DB::select($query);
            $time['start'] = $start;
            $time['end'] = $end;
             $time['query'] = $query;
             
            //  return $query;
            if (count($res)) {
                return false;
            } else {
                 return true;
            }

          

       
    }
    
    public function freeTeacherTimeSearchByModelTestversion($day,$daytimming,$duration,$teacher){

      
       $time = [];
       
       $start =  DATE("H:i", STRTOTIME($daytimming));
       $startMinute =  (int) DATE("i", STRTOTIME($daytimming));
          
        // if($start == '23:30'){
        //      $duration  =   $duration -1;
        //      $addduration =  strval("+$duration minutes");
        // }
        // else{
             $addduration =  strval("+$duration minutes");
        // } 
         
         $slot = strtotime($addduration, strtotime($daytimming));
         $end = date('H:i', $slot);
         
        //  $query = "SELECT student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time  
        //  FROM student_days  inner join  student on student_days.student_id = student.id 
        //  WHERE 
        //  student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
        //  (DATE_FORMAT(student_days.local_Time, '%H:%i') >= '$start'  AND  DATE_FORMAT(student_days.local_Time, '%H:%i') < '$end' ) AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8) ";
            
        
        
        //  $query = "select student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time from  student_days  inner join  student on student_days.student_id = student.id  where 
        //  student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
        //  ((DATE_FORMAT(student_days.local_Time, '%H:%i') >= '$start' AND DATE_FORMAT(student_days.local_Time, '%H:%i') <= '$start' ) || (DATE_FORMAT(student_days.End_local_Time, '%H:%i') >= '$end' AND DATE_FORMAT(student_days.End_local_Time, '%H:%i') <= '$end' ) )";
          
          
           $query = "select student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time from  student_days  inner join  student on student_days.student_id = student.id  where 
         student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
         ((DATE_FORMAT(student_days.local_Time, '%H:%i') >= '$start' AND DATE_FORMAT(student_days.local_Time, '%H:%i') <= '$start' ) || ((DATE_FORMAT(student_days.local_Time, '%H:%i') >= '$start' AND DATE_FORMAT(student_days.local_Time, '%H:%i') <= '$start' ) || (DATE_FORMAT(student_days.End_local_Time, '%H:%i') >= '$end' AND DATE_FORMAT(student_days.End_local_Time, '%H:%i') <= '$end' ) ))  AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8)";
               
        
            
            
            
            
            $res = DB::select($query);
            $time['start'] = $start;
            $time['end'] = $end;
             $time['query'] = $query;
             
            //  return $query;
            if (count($res)) {
                return false;
            } else {
                 return true;
            }

          

       
    }
    
     public function freeTeacherTimeSearchByModel($day,$daytimming,$duration,$teacher){

      
       $time = [];
       
       $start =  DATE("H:i", STRTOTIME($daytimming));
       $startMinute =  (int) DATE("i", STRTOTIME($daytimming));
          
        if($start == '23:30'){
             $duration  =   $duration -1;
             $addduration =  strval("+$duration minutes");
        }
        else{
             $addduration =  strval("+$duration minutes");
        } 
         
         $slot = strtotime($addduration, strtotime($daytimming));
         $end = date('H:i', $slot);
         
         $query = "SELECT student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time  
         FROM student_days  inner join  student on student_days.student_id = student.id 
         WHERE 
         student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
         (DATE_FORMAT(student_days.local_Time, '%H:%i') >= '$start'  AND  DATE_FORMAT(student_days.local_Time, '%H:%i') < '$end' ) AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8) ";
            
            
            $res = DB::select($query);
            $time['start'] = $start;
            $time['end'] = $end;
             $time['query'] = $query;
             
            //  return $query;
            if (count($res)) {
                return false;
            } else {
               
                $starttimenew = $start;
                if($startMinute > 0 && $startMinute <30 ){
                         
                        $startMinute =  strval("-$startMinute minutes");
                        $slotnew  = strtotime($startMinute, strtotime($start));
                        $starttimenew = date('H:i', $slotnew);
                       
                       
                }
                if($startMinute > 30 && $startMinute < 60){
                        $startMinute =  strval("-$startMinute minutes");
                        $slotnew  = strtotime($startMinute, strtotime($start));
                        $starttimenew = date('H:i', $slotnew);
                }
                
                
                $duration = $duration - 1;
                
                            
                 $innerquery = "SELECT student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days 
                  inner join  student on student_days.student_id = student.id 
                  WHERE student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
                  DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')  BETWEEN  DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$starttimenew'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') AND DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$start'),INTERVAL +$duration MINUTE),'%Y-%m-%d %H:%i') AND (student.academicStatus = 1 || student.academicStatus = 7 || student.academicStatus = 8) limit 1";
             
                 
                //  return $innerquery;
                 
                 $innerres = DB::select($innerquery);
                if(count($innerres)) {
                    
                      return false;
                       
                } 
                
                 return true;
            }

          

       
    }
    
     public function freetimeserachBydayTimeDuration_old($day,$daytimming,$duration,$teacher){

      
       $time = [];
       
       
        //  $start = date('H:i', strtotime(date('Y-m-d H:i:s', $daytimming)));
        //  $slot = strtotime(date('Y-m-d H:i:s', $daytimming) . " +$duration minutes");
        //  $end = date('H:i', $slot);
         
         
      
          $start =  DATE("H:i", STRTOTIME($daytimming));
          $startMinute =  (int) DATE("i", STRTOTIME($daytimming));
          
         
        if($start == '23:30'){
             $duration  =   $duration -1;
             $addduration =  strval("+$duration minutes");
        }
        // else if($start >= '23:15'){
        //      $duration  =   $duration -1;
        //      $addduration =  strval("+$duration minutes");
        // }
        else{
             $addduration =  strval("+$duration minutes");
        } 
         
       
         
         $slot = strtotime($addduration, strtotime($daytimming));
         $end = date('H:i', $slot);
         
        //   $query = "SELECT teacher_id, student_id ,student_time,student_time_text,local_Time,local_time_text,day_duration FROM student_days WHERE
        //       teacher_id = $teacher->id   and day_no = $day and
        //     (DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') > DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')  
        //     AND
        //     DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') < DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$start'),INTERVAL +$duration MINUTE),'%Y-%m-%d %H:%i') ) limit 1";
         
         
         
        //     $data = [];

            $query = "SELECT student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time  
            FROM student_days  inner join  student on student_days.student_id = student.id 
            WHERE 
            student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
            (DATE_FORMAT(student_days.local_Time, '%H:%i') >= '$start'  AND  DATE_FORMAT(student_days.local_Time, '%H:%i') < '$end' ) AND student.academicStatus = 1 ";
            
            
            // $query = "SELECT teacher_id, student_id ,student_time,student_time_text,local_Time FROM student_days WHERE
            //   teacher_id = $teacher->id   and day_no = $day and
            // DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')  BETWEEN  DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') AND DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',local_Time),INTERVAL +$duration MINUTE),'%Y-%m-%d %H:%i')";
            
            $res = DB::select($query);
            $time['start'] = $start;
            $time['end'] = $end;
             $time['query'] = $query;
             
            //  return $query;
            if (count($res)) {
                // $time['status'] = 'booked';
                // $time['teachername'] = $teacher->employeename;
                // $time['teacherid'] = $teacher->id;
                // $time['dayno'] = $day;
                return false;
            } else {
                // $time['status'] = 'availiable';
                // $time['teachername'] = $teacher->employeename;
                // $time['teacherid'] = $teacher->id;
                // $time['dayno'] = $day;
                
                $starttimenew = $start;
                if($startMinute > 0 && $startMinute <30 ){
                         
                        $startMinute =  strval("-$startMinute minutes");
                        $slotnew  = strtotime($startMinute, strtotime($start));
                        $starttimenew = date('H:i', $slotnew);
                       
                       
                }
                if($startMinute > 30 && $startMinute < 60){
                        $startMinute =  strval("-$startMinute minutes");
                        $slotnew  = strtotime($startMinute, strtotime($start));
                        $starttimenew = date('H:i', $slotnew);
                }
                
                
                $duration = $duration - 1;
                
                //   $innerquery = "SELECT student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days 
                //   inner join  student on student_days.student_id = student.id 
                //   WHERE student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
                //   DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$start'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')  BETWEEN  DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') AND DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',student_days.local_Time),INTERVAL +$duration MINUTE),'%Y-%m-%d %H:%i') AND student.academicStatus = 1 limit 1";
                 
                 
                 $innerquery = "SELECT student_days.teacher_id, student_days.student_id ,student_days.student_time,student_days.student_time_text,student_days.local_Time,student_days.day_duration,student_days.local_time_text FROM student_days 
                  inner join  student on student_days.student_id = student.id 
                  WHERE student_days.teacher_id = $teacher->id   and student_days.day_no = $day and
                  DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ',student_days.local_Time),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i')  BETWEEN  DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$starttimenew'),INTERVAL +0 MINUTE),'%Y-%m-%d %H:%i') AND DATE_FORMAT(DATE_ADD(CONCAT(CURDATE(),' ','$start'),INTERVAL +$duration MINUTE),'%Y-%m-%d %H:%i') AND student.academicStatus = 1 limit 1";
             
                 
                //  return $innerquery;
                 
                 $innerres = DB::select($innerquery);
                if(count($innerres)) {
                    
                      return false;
                    
                    //      $from =   DATE("H:i", STRTOTIME($innerres[0]->local_time_text));
                    //      $stdduration = $innerres[0]->day_duration;
                    //      $addstdduration =  strval("+$stdduration minutes");
                    //      $slot = strtotime($addstdduration, STRTOTIME($innerres[0]->local_time_text));
                    //      $till = date('H:i', $slot);
                         
                    //     //  echo '$teacher->id'.$teacher->id.'$from '.$from.' $stdduration '.$stdduration.' $till '.$till.' $star t '.$start ;
                        
                    // if($stdduration !=  $duration){
                    //       if($this->TimeIsBetweenTwoTimes($from, $till, $start)){
                    //         return false;
                    //     }else{
                    //         return true;
                    //     }
                    // }    
                       
                } 
                
                 return true;
            }

          

       
    }
    
     public function TimeIsBetweenTwoTimes($from, $till, $input) {
    $f = DateTime::createFromFormat('H:i', $from);
    $t = DateTime::createFromFormat('H:i', $till);
    $i = DateTime::createFromFormat('H:i', $input);
    if ($f > $t) $t->modify('+1 day');
	return ($f <= $i && $i <= $t) || ($f <= $i->modify('+1 day') && $i <= $t);
}

     public function OLD_freeTimeSearch($id){
        //    $res =  DB::select('SELECT teacher_id, student_id ,student_time,student_time_text FROM student_days WHERE teacher_id = ? and day_no in (1,2,3)', [$id]);
        $time = [];
        $duration = "30";
        $start = "12:00AM";
        $end = "11:00PM";

        //    $end="11:00PM";

        $start = new DateTime($start);
        $end = new DateTime($end);
        $start_time = $start->format('H:i:s');
        $end_time = $end->format('H:i:s');
        $i = 0;

        while (strtotime($start_time) <= strtotime($end_time)) {
            $start = date('H:i', strtotime($start_time));
            $end = date('H:i', strtotime('+' . $duration . ' minutes', strtotime($start_time)));
            $start_time = date('H:i', strtotime('+' . $duration . ' minutes', strtotime($start_time)));
            $i++;
            // if(strtotime($start_time) <= strtotime($end_time)){
            $time[$i]['start'] = $start;
            $time[$i]['end'] = $end;
            // }

            // $query  =
            // "SELECT teacher_id, student_id ,student_time,student_time_text,local_Time FROM student_days WHERE teacher_id = $id and ((DATE_FORMAT(local_Time, '%H:%i:%s') >= DATE_FORMAT('$start', '%H:%i:%s') AND DATE_FORMAT(local_Time, '%H:%i:%s') <= DATE_FORMAT('$end', '%H:%i:%s'))) and day_no in (1,2,3)";

            $query = "SELECT teacher_id, student_id ,student_time,student_time_text,local_Time FROM student_days WHERE
         (DATE_FORMAT(local_Time, '%H:%i') = '$start'  AND  DATE_FORMAT(local_Time, '%H:%i') <= '$end' )";

            //    $time[$i]['query'] = $query;

            // $res =  DB::select("SELECT teacher_id, student_id ,student_time,student_time_text ,local_Time FROM student_days WHERE teacher_id = ?
            // and (DATE_FORMAT(local_Time, '%H:%i:%s') >= ? AND DATE_FORMAT($, '%H:%i:%s') <= ? )
            // and day_no in (1,2,3)", [$id,$start,$end]);

            $res = DB::select($query);

            if (count($res)) {
                $time[$i]['status'] = 'booked';
            } else {
                $time[$i]['status'] = 'availiable';
            }

            // //Here you need to write query and fetch data.
            // $todayDate = date('d-m-Y'); //Please check date format. It should be similar as your database date field format.
            // //please use data binding instead of contacting variable.
            // $selectQuery = "select `id` from `booking` where date = '.$todayDate.' and
            //     (( `booking_start_time` >= '.$start.' AND `booking_start_time` <= '.$start.' ) ||
            //     (`booking_close_time` >= '.$end.' AND `booking_close_time` <= '.$end.')) ";

            // // After, you need to exeucte this query and need to check query output. if it has records, then you need to show booked else available. as below
            // $result = mysqli_query($con, $selectQuery);

            // if ($result->num_rows) {
            //     $time[$i]['status'] = 'booked';
            // } else {
            //     $time[$i]['status'] = 'availiable';
            // }
        }

        return $time;
    }

     public function OLD_freetimeserachnew($id){

        
        $daysweek = [0,1,2,3,4,5,6];
        
       

        $data = [];
             for ($d = 0; $d <= 6; $d++) {
                 
                   $durationtime = [10,15,20,30,45,60];
                   for ($duraT = 0; $duraT < count($durationtime); $duraT++) {
                       
                       $duration = $durationtime[$duraT];
                       
                    $start_time = strtotime('2015-10-21 00:00:00');
                    $end_time = strtotime('2015-10-21 24:00:00');
                    $slot = strtotime(date('Y-m-d H:i:s', $start_time) . " +$duration minutes");
                 
                    $time = [];
                     $dayno =  $d+1;
                     
                    for ($i = 0; $slot <= $end_time; $i++) {
            
                        $start = date('H:i', $start_time);
                        $end = date('H:i', $slot);
            
                        $query = "SELECT teacher_id, student_id ,student_time,student_time_text,local_Time FROM student_days WHERE
                        teacher_id = $id   and  day_no = $dayno and
                        (DATE_FORMAT(local_Time, '%H:%i') >= '$start'  AND  DATE_FORMAT(local_Time, '%H:%i') < '$end' )";
                        $res = DB::select($query);
                       
                        if (count($res)) {
                            //  $time[$i]['start'] = $start;
                            //  $time[$i]['end'] = $end;
                            //  $time[$i]['status'] = 'booked';
                            //  $time[$i]['dayname'] = $this->days_name($dayno);
                            
                            
                            $class = array(
                                'start' => $start,
                                'end' => $end,
                                'status' => 'booked',
                                'dayname' => $this->days_name($dayno),
                                 'day' => $d,
                                  'day' => $d,
                                  'duration' =>$duration
                                );
                                
                                $time[] = $class;
                            
                            //   $time[]['start'] = $start;
                            //  $time[]['end'] = $end;
                            //  $time[]['status'] = 'booked';
                            //  $time[]['dayname'] = $this->days_name($dayno);
                        } 
                        
                        // else {
                        //     $time[$i]['status'] = 'availiable';
                        // }
            
                        
                        $start_time = $slot;
                        $slot = strtotime(date('Y-m-d H:i:s', $start_time) . " +$duration minutes");
                    }
                    
                    if($time){
                         $data[$d][] = $time;
                         
                         
                    }
                   
                  }
                    
             }

        return $data;
    }
    
    
    
     public function gettaskUrlRolebase($role,$id){
        $ret = '';
        // switch ($role) {
        //     case 'qcd-manager':
        //         $ret = url('qcdpanel/task/detail/'.$id);
        //       break;
        //     case 'incharge':
        //         $ret = url('sectioninchargepanel/task/detail/'.$id);
        //       break;
        //     case 'general-manager':
        //         $ret = url('generalmanagerpanel/task/detail/'.$id);
        //       break;
        //       case 'admission-officer':
        //         $ret = url('admissionpanel/task/detail/'.$id);
        //       break;
        //       case 'demonstration-officer':
        //         $ret = url('demonstrationpanel/task/detail/'.$id);
        //       break;
        //       case 'admin':
        //         $ret = url('admin/task/detail/'.$id);
        //       break;
        //     default:
        //     $ret = route('supervisorpanel.task.detail',$id);
        //   }
        //   return $ret;
        
        if($role == 'admission-officer'){
             $ret = route('admissionpanel.task.detail',$id);
        }
        else if($role == 'demonstration-officer'){
             $ret = route('demonstrationpanel.task.detail',$id);
        }
        else if($role == 'qcd-manager'){
             $ret = route('qualitycontrolpanel.task.detail',$id);
        }
        else if($role == 'supervisor-officer'){
             $ret = route('supervisorpanel.task.detail',$id);
        }
        else{
             $ret = route('admin.task.detail',$id);
        }
        
         return $ret;
    }
     
}

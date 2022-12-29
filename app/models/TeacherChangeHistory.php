<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

use App\models\StudentAttendance;
use App\models\AcademicStatusHistory;

class TeacherChangeHistory extends Model
{
    protected $table = "teacherchange";
    
    
    public function AcademicStatusHistory(){
         
        return $this->hasMany(AcademicStatusHistory::class,'student_id','student_id');
        
    }
    public function LastAcademicStatusHistory(){
         
         return $this->hasOne(AcademicStatusHistory::class,'student_id','student_id')->orderBy('created_at', 'desc');
        
    }
    public function FirstAcademicStatusHistory(){
         
        return $this->hasOne(AcademicStatusHistory::class,'student_id','student_id')->orderBy('created_at', 'asc');
        
    }
    
    public function attendance()
    {
    
        return  $this->hasMany(StudentAttendance::class,'student_id','student_id');
         
    }
    public function last_attendance()
    {
            return $this->hasOne(StudentAttendance::class,'student_id','student_id')->orderBy('created_at', 'desc');
    }
    public function first_attendance()
    {
            return $this->hasOne(StudentAttendance::class,'student_id','student_id')->orderBy('created_at', 'asc');
    }
    
    
}

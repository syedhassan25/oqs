<?php

namespace App\models;


use Illuminate\Database\Eloquent\Model;
use App\models\Employee;
use App\models\Package;
use App\models\Student;
use App\models\RecoveryClass;
use App\models\AttendanceStatus;
use App\models\LessonNew;

class StudentAttendance extends Model
{
    protected $table = "studentattendance";

    public function teacher(){
        return $this->hasOne(Employee::class,'id','teacher_id');
    }
    public function getteacher(){
        return $this->hasOne(Employee::class,'id','teacher_id');
    }
    public function recovery_class_record(){
         
        return $this->hasOne(RecoveryClass::class,'attendancid','id');
        
    }
    
    public function getPackage(){
        return $this->hasOne(Package::class, "id", "package_id");
    }

    public function getStudent(){
        return $this->hasOne(Student::class, 'id', "student_id");
    }
    public function getAttendanceStatus(){
        return $this->hasOne(AttendanceStatus::class, 'status', "attendance_status");
    }
    public function getLessonNew(){
        return $this->hasOne(LessonNew::class, 'attendance_id', "id");
    }


    
}

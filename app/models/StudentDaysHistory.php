<?php

namespace App\models;
use App\models\Employee;
use App\models\Student;

use Illuminate\Database\Eloquent\Model;

class StudentDaysHistory extends Model
{
    

    protected $table = "studentDayshistory";

    public function teacher(){
         
        return $this->hasOne(Employee::class,'id','teacher_id');
        
    }
    
    public function Student(){
         
        return $this->hasOne(Student::class,'id','student_id');
        
    }
    
    
    
     
}

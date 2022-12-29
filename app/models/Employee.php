<?php

namespace App\models;

use App\models\Student;
use App\models\TeacherReferal;
use App\models\User;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    

    protected $table = "employees";
    
     protected $appends = ['full_name','gender_type','teacher_referal'];
     
     
     function getFullNameAttribute() {
            return $this->employeename . ' ' . $this->employeefathername;
     }
     
     public function students() {
         
        return $this->hasMany(Student::class,'teacher_id','id');
        
    }
    public function user() {
         
        return $this->hasOne(User::class,'id','user_id');
        
    }
    
     public function getGenderTypeAttribute() {
          $type = "male";
         if($this->gender == 0){
             $type = "Female";
         }
       
       return $type;
        
    }
    
      public function getTeacherReferalAttribute() {
          $isExist = [];
          if(TeacherReferal::where('teacherID',$this->id)->first()){
              $isExist  = TeacherReferal::with('students')->where('teacherID',$this->id)->get();
          }
        
       
       return $isExist;
        
    }
    
    
    
}

<?php

namespace App\models;


use Illuminate\Database\Eloquent\Model;

class TeacherReferal extends Model
{
    

    protected $table = "teacherReferal";

     
      public function students() {
         
        return $this->hasMany(Student::class,'id','studentID');
        
    }
    
    
    
}

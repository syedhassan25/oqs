<?php

namespace App\models;
use App\models\Student;

use Illuminate\Database\Eloquent\Model;

class LessonNew extends Model
{
    protected $table = "student_lesson_new";
    protected $appends = ['informativecomment'];
    
     public function Student(){
         
        return $this->hasOne(Student::class,'id','student_id');
        
    }
    
    function getinformativecommentAttribute(){
         return Student::where('id',$this->student_id)->first()->lessoninformativecomment;
     }
}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Employee;

class AcademicStatusHistory extends Model
{
    protected $table = "academicstatuschange";
    
     public function teacher(){
         
        return $this->hasOne(Employee::class,'id','teacher_id');
        
    }
}

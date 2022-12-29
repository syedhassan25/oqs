<?php

namespace App\models;
use App\models\Employee;
use App\models\Student;

use Illuminate\Database\Eloquent\Model;

class RecoveryClass extends Model
{
    protected $table = "recovery_class";


    public function getStudent(){
         
        return $this->hasOne(Student::class,'id','studentid');
        
    }

    public function Currentteacher(){
         
        return $this->hasOne(Employee::class,'id','currentTeacherid');
        
    }

    public function Recoveryteacher(){
         
        return $this->hasOne(Employee::class,'id','recoveryteacherid');
        
    }
}

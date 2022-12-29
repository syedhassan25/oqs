<?php

namespace App\models;

use App\models\EmployeesCreditPartial;
use App\models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeesCredit extends Model
{
     protected $table = "employees_credit";
     
     public function partialcredits(){
         return $this->hasMany(EmployeesCreditPartial::class,'employess_credit_id','id');
     }
     public function Employee_data(){
        return $this->hasOne(Employee::class,'id','employee_id');
    }
     
}

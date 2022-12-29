<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\EmployeesCredit;

class EmployeesCreditPartial extends Model
{
     protected $table = "employees_credit_partial";
     
     
      public function employeecredits(){
         return $this->hasOne(EmployeesCredit::class,'id','employess_credit_id');
     }
}

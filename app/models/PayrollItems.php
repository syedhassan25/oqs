<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Payroll;

class PayrollItems extends Model
{
    protected $table = "payroll_items";
    
     public function payrollparent(){
         
        return $this->hasOne(Payroll::class,'id','payroll_id');
        
    }
}

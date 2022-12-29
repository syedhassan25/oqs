<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\PayrollItems;

class Payroll extends Model
{
      protected $table = "payroll";
      
      public function payItems(){
         
        return $this->hasMany(PayrollItems::class,'payroll_id','id');
        
    }
}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\models\Student;
use App\models\Package;
use App\models\Invoice;

class InvoiceItem extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];

    function getStudent(){
        return $this->hasOne(Student::class, 'id', 'student_id');
    }

    function getPackage(){
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    function getInvoice(){
        return $this->hasMany(Invoice::class, "id", "invoice_id");
    }
}

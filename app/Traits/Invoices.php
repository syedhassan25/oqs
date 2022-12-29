<?php

namespace App\Traits;
use App\models\RegisterPackage;
use App\models\StudentAttendance;

trait Invoices
{
    public function seedPackageInAttendance($student_id){
        $data = StudentAttendance::where([
            "package_id" => 0,
            "student_id" => $student_id,
        ])->chunk(1000, function($stAttendance){
            foreach ($stAttendance as $attendance)
            {
                //
                $getPackage = RegisterPackage::where("student_id", $attendance->student_id)->first();
                if(!empty($getPackage)){
                    StudentAttendance::where("id", $attendance->id)->update([
                        "package_id" => $getPackage->package_id
                    ]);
                }
            }
        });
    }
}
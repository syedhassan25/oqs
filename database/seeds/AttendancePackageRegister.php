<?php

use Illuminate\Database\Seeder;
use App\models\RegisterPackage;
use App\models\StudentAttendance;

class AttendancePackageRegister extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$data = StudentAttendance::where()->chunk(100, function($users)
        $data = StudentAttendance::where("package_id", 0)->chunk(5000, function($stAttendance){
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

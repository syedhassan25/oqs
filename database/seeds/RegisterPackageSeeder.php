<?php

use Illuminate\Database\Seeder;
use App\models\Student;
use App\models\RegisterPackage;
use App\models\Package;

class RegisterPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Student::with([
            "studentdays",
            'getCountry',
            'RegisterPackage'
        ])->whereDoesntHave("RegisterPackage")
        ->whereHas('studentdays')->chunk(200, function($students) {
            $result = [];
            $weekday = $weekend = 0;
            //dd($students);
            if(!empty($students)){
                foreach($students as $st){
                    if(!empty($st->studentdays)){
                        $ins = [];
                        foreach($st->studentdays as $stDays){
                            if($stDays->student_day_no == 6 || $stDays->student_day_no == 7){
                                $weekend++;
                            }else{
                                $weekday++;
                            }
                        }
                        if($weekday > 0){
                            $packageInfo = Package::where([
                                'days' => $weekday,
                            ])->where('currency', $st->getCountry->currency)
                            ->first();
                            if(empty($packageInfo)){
                                $packageInfo = Package::where([
                                    'days' => $weekday,
                                ])->where('currency', "USD")
                                ->first();
                            }
                            RegisterPackage::create([
                                "student_id" => $st->id,
                                'package_id' => (!empty($packageInfo)) ? $packageInfo->id : "error: ".$st->id,
                            ]);
                        }
                        if($weekend > 0){
                            $packageInfo = Package::where([
                                'days' => $weekend,
                            ])->where('currency', $st->getCountry->currency)
                            ->first();
                            if(empty($packageInfo)){
                                $packageInfo = Package::where([
                                    'days' => $weekend,
                                ])->where('currency', "USD")
                                ->first();
                            }
                            RegisterPackage::create([
                                "student_id" => $st->id,
                                'package_id' => (!empty($packageInfo)) ? $packageInfo->id : "error: ".$st->id,
                            ]);
                        }
                        $weekday = $weekend = 0;
                    }
                }
            }
        });
    }
}

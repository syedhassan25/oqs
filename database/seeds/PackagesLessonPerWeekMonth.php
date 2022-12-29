<?php

use Illuminate\Database\Seeder;
use App\models\Package;
class PackagesLessonPerWeekMonth extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1; $i<=5; $i++){
            Package::where("days", $i)->update([
                "lessons_per_week" => $i,
                "lessons_per_month" => $i * 4
            ]);
        }
    }
}

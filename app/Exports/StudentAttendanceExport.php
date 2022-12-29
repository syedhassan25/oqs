<?php

namespace App\Exports;

use App\models\StudentAttendance;
use App\models\AcademicStatus;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentAttendanceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return StudentAttendance::limit(5000)->get();
    // }

    public function view(): View
    {
        $start_date = '2022-06-01 00:00:00';
        $end_date = '2022-08-31 23:59:00';

        return view('admin.student.ExportStudentAttendance', [
            'StudentAttendance' => StudentAttendance::with(['getteacher','getStudent','getAttendanceStatus','getLessonNew'])
            ->whereRaw("date_format(studentattendance.attendance_date_time,'%Y-%m-%d %T') between '$start_date' and '$end_date'")
            ->orderBy('id','desc')->get()
        ]);
    }
}

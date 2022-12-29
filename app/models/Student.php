<?php

namespace App\models;

use Carbon\Carbon;

use App\models\StudentDays;
use App\models\Employee;
use App\models\Country;
use App\models\City;
use App\models\Language;
use App\models\StudentLanguageLookup;
use App\models\StudentAttendance;
use App\models\LessonNew;
use App\models\AcademicStatusHistory;
use App\models\RegisterPackage;
use App\models\TeacherChangeHistory;
use App\models\StudentDaysHistory;
use App\models\AcademicStatus;
use App\models\InvoiceItem;
use DB;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "student";
    protected $appends = ['full_name','calculated_age','student_conversion_name','academic_status_name','gender_type','last_reason'];
    

    public function getCalculatedAgeAttribute()
    {
        return Carbon::parse($this->dob)->age." Years";
    }

    public function studentdays(){
         
        return $this->hasMany(StudentDays::class,'student_id','id');
        
    }
    public function TeacherChangeHistory(){
         
        return $this->hasMany(TeacherChangeHistory::class,'student_id','id');
        
    }
    public function AcademicStatusHistory(){
         
        return $this->hasMany(AcademicStatusHistory::class,'student_id','id');
        
    }
    public function LastAcademicStatusHistory(){
         
         return $this->hasOne(AcademicStatusHistory::class,'student_id','id')->orderBy('created_at', 'desc');
        
    }
    public function FirstAcademicStatusHistory(){
         
        return $this->hasOne(AcademicStatusHistory::class,'student_id','id')->orderBy('created_at', 'asc');
        
    }
     public function CurrentAcademicStatus(){
         
        return $this->hasOne(AcademicStatus::class,'id','academicStatus');
        
    }
    
     public function teacher(){
         
        return $this->hasOne(Employee::class,'id','teacher_id');
        
    }
    
    public function getLastReasonAttribute(){
        return  DB::table('academicstatuschange')->select(['academicstatuschange.*','reason.reason'])->leftjoin('reason', 'reason.id', '=', 'academicstatuschange.reason_id')->where('student_id',$this->id)->latest()->first();
    }
    
    
    public function city(){
         
        return $this->hasOne(City::class,'id','city');
        
    }
    
    public function country(){
         
        return $this->hasOne(Country::class,'id','country');
        
    }

    public function getCountry(){
         
        return $this->hasOne(Country::class,'id','country');
        
    }
    
    public function language()
    {
        return $this->belongsToMany(Language::class,'student_language_lookups','student_id','language_id');
    }
    
     public function attendance()
    {
        
        //   return $this->hasMany(StudentAttendance::class,'student_id','id')->select([ 'teacher_id', 'student_id', 'day','student_day_name', 'day_name', 'attendance_date_time', 'duration','attendance_status' ])
        // ;
        
        return  $this->hasMany(StudentAttendance::class,'student_id','id');
         
    }
    
    
    public function last_attendance()
    {
            return $this->hasOne(StudentAttendance::class,'student_id','id')->orderBy('created_at', 'desc');
    }
    public function first_attendance()
    {
            return $this->hasOne(StudentAttendance::class,'student_id','id')->orderBy('created_at', 'asc');
    }
    

     public function lesson()
    {
        return $this->hasMany(LessonNew::class,'student_id','id');
    }
    
    
    //  function getLanguageNameAttribute() {
    //       return  StudentLanguageLookup::select(['l.*'])->leftjoin('languages as l', 'l.id', '=', 'student_language_lookups.language_id')->where('student_language_lookups.student_id',$this->id)->get();
            
    //  }
     
     function getAcademicStatusNameAttribute(){
         return DB::table('academic_status')->where('id',$this->academicStatus)->first();
     }
     
      function getGenderTypeAttribute(){
         return ($this->gender == 1)?'Male':'Female';
     }
     
     function getFullNameAttribute() {
            return $this->studentname . ' ' . $this->fathername;
            
            // return  $this->timezone;
     }
    
    
     function getStudentConversionNameAttribute() {
            // return $this->employeename . ' ' . $this->employeefathername;
            
            return  $this->timezone;
     }
     function RegisterPackage(){
         return $this->hasMany(RegisterPackage::class, "student_id", "id");
     }

     function getInvoiceItems(){
        return $this->hasMany(InvoiceItem::class, "student_id", "id");
     }
     function getDaysHistory(){
        return $this->hasMany(StudentDaysHistory::class, "student_id", "id");
     }
     
}

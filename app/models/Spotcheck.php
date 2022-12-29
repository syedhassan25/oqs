<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Spotcheck extends Model
{
   protected $table = "spotcheck";
   
   
   protected $fillable = [
        'teacher_id', 'student_id', 'groupno', 'classStartOnTime', 'classStartOnTimeText', 'introduction', 'introductionText', 'RevisionOfPreviousClass', 'RevisionOfPreviousClassText', 'newLesson', 'newLesonText', 'ethics', 'ethicsText', 'memorization', 'memorizationText', 'tajweed', 'tajweedText', 'islamicFundamental', 'islamicFundamentalText', 'englishFluency', 'englishFluencyText', 'appreciationStudent', 'appreciationStudentText', 'identifyMistakes', 'identifyMistakesText', 'tone', 'toneText', 'teacherResponsiveStudent', 'teacherResponsiveStudentText', 'closingClass', 'closingClassText', 'performance_level', 'status', 'created_by'
    ];
   
}

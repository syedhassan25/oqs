<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Teacherattendance extends Model
{
    protected $table = "teacherattendance";
    
    
    protected $fillable = [
  'teacher_id', 'attendance_date', 'attendance_status', 'created_by', 'created_at', 'updated_at'
];
    
}

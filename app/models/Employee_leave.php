<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee_leave extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}

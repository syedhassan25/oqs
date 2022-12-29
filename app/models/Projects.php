<?php

namespace App\models;
use App\models\User;
use App\models\projectTasksList;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = "projects_list";

    public function getUserManager() {
        return $this->hasOne(User::class,'id','manager_id');
    }
    public function getProjectTasks() {
        return $this->hasMany(projectTasksList::class,'id','project_id');
    }
}

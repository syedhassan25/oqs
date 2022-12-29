<?php

namespace App\models;
use App\models\Projects;
use App\models\projectTasksList;

use Illuminate\Database\Eloquent\Model;

class projectUsersProductivity extends Model
{
    protected $table = "project_users_productivity";

    public function getUser() {
        return $this->hasOne(User::class,'user_id','id');
    }
    public function getProjectTask() {
        return $this->hasOne(projectTasksList::class,'task_id','id');
    }
    public function getProject() {
        return $this->hasMany(Projects::class,'project_id','id');
    }
}

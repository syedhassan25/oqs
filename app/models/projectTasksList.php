<?php

namespace App\models;
use App\models\Projects;

use Illuminate\Database\Eloquent\Model;

class projectTasksList extends Model
{
    protected $table = "project_tasks_list";

    public function getProject() {
        return $this->hasOne(Projects::class,'project_id','id');
    }
}

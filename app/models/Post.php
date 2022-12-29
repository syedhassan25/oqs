<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\User;

class Post extends Model
{
    protected $table = "post";
    
    protected $appends = ['human_date'];
    
     function getHumanDateAttribute() {
            return $this->created_at->diffForHumans();
     }
     function CreatorName(){
           return $this->hasOne(User::class,'id','created_by');
     }
}

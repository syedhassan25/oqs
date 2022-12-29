<?php

namespace App\models;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\models\RegisterPackage;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];

    function getStudents(){
        return $this->hasMany(RegisterPackage::class, "package_id", "id");
    }
}

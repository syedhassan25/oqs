<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Package;
class RegisterPackage extends Model
{
    //
    protected $guarded = [];

    function getPackage(){
        return $this->hasOne(Package::class, 'id', 'package_id');
    }
}

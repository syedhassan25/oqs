<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Student;
use App\models\User;
use App\models\Invoice;
use App\models\Country;
use App\models\City;
use App\models\Language;

class Parents extends Model
{
    protected $guarded = [];

    public function students(){
        return $this->hasMany(Student::class,'group','groupno');   
    }

    public function getUser(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    function getInvoice(){
        return $this->hasOne(Invoice::class,'group_id','groupno')->latest();
    }
    function getInvoices(){
        return $this->hasMany(Invoice::class,'group_id','groupno')->latest();
    }
    function getStudents(){
        return $this->hasMany(Student::class,'group','groupno');   
    }


    public function getCity(){
         
        return $this->hasOne(City::class,'id','city_id');
        
    }
    
    public function getCountry(){
         
        return $this->hasOne(Country::class,'id','country_id');
        
    }

    public function getLanguage()
    {
        return $this->belongsToMany(Language::class,'parent_language_lookups','parent_id','language_id');
    }
}

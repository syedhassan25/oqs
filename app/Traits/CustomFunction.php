<?php

namespace App\Traits;

use App\models\Student;
use App\models\StudentAttendance;
use App\models\City;
use App\models\Country;

trait CustomFunction
{
    public function Studentgroupgenerator($group = null)
    {
        if ($group) {
            $data = Student::where('group', $group)->get();
            if (count($data) > 0) {
                $group = 1 + (int) $group;
                return $this->Studentgroupgenerator($group);
            } else {
                return $group;
            }
        } else {
            // $groupid = Student::latest()->first();

            $groupid = Student::orderby('group', 'desc')->first();
            if ($groupid) {
                // return 1 + (int) $groupid->group;

                $group = 1 + (int) $groupid->group;

                return $this->Studentgroupgenerator($group);
            } else {
                return rand(10000, 99999);
            }

        }
    }

    public function getStudentGUIDnoHash()
    {
        mt_srand((double) microtime() * 10000);
        $charid = md5(uniqid(rand(), true));
        $c = unpack("C*", $charid);
        $c = implode("", $c);

        return substr($c, 0, 20);
    }

    public function getCountry($param)
    {

        if ($param) {
            $country = Country::Select(['id'])->where('CountryName', 'LIKE', "%{$param}%")->first();
            if ($country) {
                return $country->id;
            } else {
                $country = Country::Select(['id'])->where('CountryShortName', 'LIKE', "%{$param}%")->first();
                return ($country) ? $country->id : 0;
            }

        } else {
            return 0;
        }

        // return $param;
    }

    public function getCity($param, $cid)
    {

        if ($param) {
            $city = City::Select(['id'])->where('CityName', 'LIKE', "%{$param}%");
                    if($cid){
                        $city->where('CountryID', $cid);
                    }          
            $city =  $city->first();
            return ($city) ? $city->id : City::Select(['id'])->where('CountryID', $cid)->first();
        } else {

            $city = City::Select(['id'])->where('CountryID', $cid)->first();

            return ($city) ? $city->id : 0;
        }

        // return $param;
    }

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%' . $value . '%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'like', '%' . $value . '%');
    }

}

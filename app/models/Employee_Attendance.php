<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Employee_Attendance extends Model
{
    protected $casts = [
        'check_out_time' => 'datetime',
        'check_in_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getDurationAttribute()
    {
        $in = Carbon::createFromFormat('H:i:s',$this->check_in_time);
	$out =  Carbon::createFromFormat('H:i:s',$this->check_out_time);

	return $in->diffAsCarbonInterval($out)->hours;
}

}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Parents;

class InvoiceBillingCycle extends Model
{
    //
    protected $guarded = [];

    function getParent(){
        return $this->hasOne(Parents::class, "groupno", "group_id");
    }
}

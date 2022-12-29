<?php

namespace App\models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\models\InvoiceItem;
use App\models\Parents;
use App\models\User;

class Invoice extends Model
{
    use SoftDeletes;
    //
    protected $guarded = [];

    function getInvoiceItems(){
        return $this->hasMany(InvoiceItem::class, "invoice_id", "id");
    }

    function getParent(){
        return $this->hasOne(Parents::class, 'groupno', 'group_id');
    }

    function getCreatedBy(){
        return $this->hasOne(User::class, "id", "created_by");
    }
}

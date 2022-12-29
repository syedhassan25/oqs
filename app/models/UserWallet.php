<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\UserWallet;

class UserWallet extends Model
{
    //
    protected $guarded = [];

    function getUserBalance($user_id){
        $inAmount = UserWallet::where([
            "user_id" => $user_id,
            "transaction_type" => "in"
        ])->sum('amount');

        $outAmount = UserWallet::where([
            "user_id" => $user_id,
            "transaction_type" => "out"
        ])->sum('amount');

        return $inAmount - $outAmount;
    }
}

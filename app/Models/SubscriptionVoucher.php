<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionVoucher extends Model
{
    protected $fillable=[
        'plan_id','voucher_code','voucher_name','status'
    ];
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

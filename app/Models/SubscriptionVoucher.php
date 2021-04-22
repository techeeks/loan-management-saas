<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionVoucher extends Model
{
    protected $fillable=[
        'company_id','plan_id','voucher_code','transcation_id',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPayment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'company_id',
        'loan_id',
        'payment_method_id',
        'transaction_reference',
        'payment_date',
        'payment_number',
        'amount',
        'notes',
        'private_notes',
    ]; 
    public function loan()
    {
        return $this->belongsTo(LoanRequest::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
    public function scopeFindByCompany($query, $company_id)
    {
        $query->where('company_id', $company_id);
    }
    public static function getNextPaymentNumber($company_id, $prefix)
    {
        // Get the last created order
        $payment = LoanPayment::findByCompany($company_id)->where('payment_number', 'LIKE', $prefix . '-%')
                    ->orderBy('created_at', 'desc')
                    ->first();
        if (!$payment) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = explode("-", $payment->payment_number);
            $number = $number[1];
        }
        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.

        return sprintf('%06d', intval($number) + 1);
    }

    /**
     * Set payment_num attribute
     *
     * @return int
     */
    public function getPaymentNumAttribute()
    {
        $position = $this->strposX($this->payment_number, "-", 1) + 1;
        return substr($this->payment_number, $position);
    }

    /**
     * Set payment_prefix attribute
     * 
     * @return string
     */
    public function getPaymentPrefixAttribute ()
    {
        return $this->id 
            ? explode("-", $this->payment_number)[0]
            : CompanySetting::getSetting('payment_prefix', $this->company_id);
    }

}

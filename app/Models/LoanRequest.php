<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanRequest extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'amount',
        'customer_id',
        'description',
        'company_id',
        'loan_date',
        'currency_id',
        'return_date',
        'status',
        'description',
        'reference_number'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($ecu) {
            $last_number = LoanRequest::max('id') + 1;
            $ecu->reference_number = 'LN' . '-' . str_pad(
                $last_number,
                6, // as per your requirement.
                '0',
                STR_PAD_LEFT
            );
        });
    }
    /**
     * Automatically cast attributes to given types
     * 
     * @var array
     */
  
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function scopeFindByCompany($query, $company_id)
    {
        $query->where('company_id', $company_id);
    }

}

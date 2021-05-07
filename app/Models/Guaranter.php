<?php

namespace App\Models;

use App\Traits\HasAddresses;
use Illuminate\Database\Eloquent\Model;

class Guaranter extends Model
{
    use HasAddresses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'phone',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

   
   
   
}

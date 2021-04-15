<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'precision',
        'thousand_separator',
        'decimal_separator',
        'swap_currency_symbol'
    ];

    /**
     * List Currencies for Select2 Javascript Library
     * 
     * @return collect
     */
    public static function getSelect2Array() {        
        $response = collect();
        foreach(self::all() as $currency){
            $response->push([
                'id' => $currency->id,
                'code' => $currency->code,
                'symbol' => $currency->symbol,
                'precision' => $currency->precision,
                'thousand_separator' => $currency->thousand_separator,
                'decimal_separator' => $currency->decimal_separator,
                'swap_currency_symbol' => $currency->swap_currency_symbol,
                'text' => "{$currency->code} - {$currency->name}"
            ]);
        }
        return $response;
    }
} 

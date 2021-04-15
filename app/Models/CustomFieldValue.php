<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomFieldValue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'custom_field_id',
        'company_id',
        'custom_field_valuable_type',
        'custom_field_valuable_id',
        'type',
        'string_answer',
        'number_answer',
        'boolean_answer',
        'date_time_answer',
        'date_answer',
        'time_answer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'default_answer'
    ];

    /**
     * Define Relation with Company Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Define Relation with CustomField Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function custom_field()
    {
        return $this->belongsTo(CustomField::class);
    }

    /**
     * Define Morph
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function custom_field_valuable()
    {
        return $this->morphTo();
    }

    /**
     * Set date_answer attribute
     * 
     * @return void
     */
    public function setDateAnswerAttribute($value)
    {
        if ($value && $value != null) {
            $this->attributes['date_answer'] = Carbon::createFromFormat('Y-m-d', $value);
        } else {
            $this->attributes['date_answer'] = null;
        }
    }

    /**
     * Set time_answer attribute
     * 
     * @return void
     */
    public function setTimeAnswerAttribute($value)
    {
        if ($value && $value != null) {
            $this->attributes['time_answer'] = date("H:i:s", strtotime($value));
        } else {
            $this->attributes['time_answer'] = null;
        }
    }

    /**
     * Set date_time_answer attribute
     * 
     * @return void
     */
    public function setDateTimeAnswerAttribute($value)
    {
        if ($value && $value != null) {
            $this->attributes['date_time_answer'] = Carbon::createFromFormat('Y-m-d H:i', $value);
        } else {
            $this->attributes['date_time_answer'] = null;
        }
    }

    /**
     * Get default_answer attribute
     * 
     * @return void
     */
    public function getDefaultAnswerAttribute()
    {
        $value_type = get_custom_field_value_key($this->type);

        return $this->$value_type;
    }
}

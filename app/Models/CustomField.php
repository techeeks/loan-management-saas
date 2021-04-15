<?php

namespace App\Models;

use App\Traits\UUIDTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use UUIDTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'model_type',
        'name',
        'label',
        'type',
        'placeholder',
        'is_required',
        'string_answer',
        'number_answer',
        'boolean_answer',
        'date_time_answer',
        'date_answer',
        'time_answer',
        'options',
        'order',
    ];

    /**
     * Automatically cast attributes to given types
     * 
     * @var array
     */
    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'order' => 'integer',
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
     * Define Relation with CustomFieldValue Model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function custom_field_values()
    {
        return $this->hasMany(CustomFieldValue::class);
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
     * Set options attribute
     * 
     * @return void
     */
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    /**
     * Get default_answer attribute
     * 
     * @return any
     */
    public function getDefaultAnswerAttribute()
    {
        $value_type = get_custom_field_value_key($this->type);

        return $this->$value_type;
    }

    /**
     * Scope a query to only include Customers of a given company.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param int $company_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByCompany($query, $company_id)
    {
        $query->where('company_id', $company_id);
    }

    /**
     * Scope a query to only include CustomFields of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param int $type
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereType($query, $type)
    {
        $query->where('model_type', $type);
    }
}

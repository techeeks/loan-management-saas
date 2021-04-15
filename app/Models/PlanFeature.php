<?php

namespace App\Models;

use App\Services\Period;
use App\Traits\BelongsToPlan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanFeature extends Model
{
    use BelongsToPlan;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'slug',
        'value',
        'resettable_period',
        'resettable_interval',
    ];

    /**
     * Automatically cast attributes to given types
     * 
     * @var array
     */
    protected $casts = [
        'plan_id' => 'integer',
        'slug' => 'string',
        'value' => 'string',
        'resettable_period' => 'integer',
        'resettable_interval' => 'string',
        'deleted_at' => 'datetime',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'plan_id' => 'required|integer|exists:plans,id',
        'slug' => 'required|alpha_dash|max:150|unique:plan_features,slug',
        'value' => 'required|string',
        'resettable_period' => 'sometimes|integer',
        'resettable_interval' => 'sometimes|in:hour,day,week,month',
    ];

    /**
     * The plan feature may have many subscription usage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usage(): HasMany
    {
        return $this->hasMany(PlanSubscriptionUsage::class, 'feature_id', 'id');
    }

    /**
     * Get feature's reset date.
     *
     * @param string $dateFrom
     *
     * @return \Carbon\Carbon
     */
    public function getResetDate(Carbon $dateFrom): Carbon
    {
        $period = new Period($this->resettable_interval, $this->resettable_period, $dateFrom ?? now());

        return $period->getEndDate();
    }
}
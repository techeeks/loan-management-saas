<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
        'price',
        'trial_period',
        'trial_interval',
        'invoice_period',
        'invoice_interval',
        'grace_period',
        'grace_interval',
        'prorate_day',
        'prorate_period',
        'prorate_extend_due',
        'active_subscribers_limit',
        'order',
    ];

    /**
     * Automatically cast attributes to given types
     * 
     * @var array
     */
    protected $casts = [
        'slug' => 'string',
        'is_active' => 'boolean',
        'price' => 'integer',
        'trial_period' => 'integer',
        'trial_interval' => 'string',
        'invoice_period' => 'integer',
        'invoice_interval' => 'string',
        'grace_period' => 'integer',
        'grace_interval' => 'string',
        'prorate_day' => 'integer',
        'prorate_period' => 'integer',
        'prorate_extend_due' => 'integer',
        'active_subscribers_limit' => 'integer',
        'deleted_at' => 'datetime',
        'order' => 'integer',
    ];

    /**
     * The plan may have many features.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function features(): HasMany
    {
        return $this->hasMany(PlanFeature::class, 'plan_id', 'id');
    }

    /**
     * The plan may have many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(PlanSubscription::class, 'plan_id', 'id');
    }

    /**
     * Create Plan Features
     *
     * @return void
     */
    public function addPlanFeatures($features): void
    {
        // Create new Plan Features
        foreach ($features as $feature => $value) {
            if ($feature === 'invoices_per_month' || $feature === 'estimates_per_month') {
                $this->features()->create(['slug' => $feature, 'value' => $value, 'resettable_period' => 1, 'resettable_interval' => 'month']);
            } else {
                $this->features()->create(['slug' => $feature, 'value' => $value]);
            }
        }
    }

    /**
     * Update Plan Features
     *
     * @return void
     */
    public function updatePlanFeatures($features): void
    {
        // Update new Plan Features
        foreach ($features as $feature => $value) {
            PlanFeature::where('plan_id', $this->id)->where('slug', $feature)->update(['value' => $value]);
        }
    }

    /**
     * Get Currency Attribute
     *
     * @return void
     */
    public function getCurrencyAttribute()
    {
        return get_system_setting('application_currency');
    }

    /**
     * Check if plan is free.
     *
     * @return bool
     */
    public function isFree(): bool
    {
        return (float) $this->price <= 0.00;
    }

    /**
     * Check if plan has trial.
     *
     * @return bool
     */
    public function hasTrial(): bool
    {
        return $this->trial_period && $this->trial_interval;
    }

    /**
     * Check if plan has grace.
     *
     * @return bool
     */
    public function hasGrace(): bool
    {
        return $this->grace_period && $this->grace_interval;
    }

    /**
     * Get plan feature by the given slug.
     *
     * @param string $featureSlug
     *
     * @return \App\Models\PlanFeature|null
     */
    public function getFeatureBySlug(string $featureSlug)
    {
        return $this->features()->where('slug', $featureSlug)->first();
    }

    /**
     * Activate the plan.
     *
     * @return $this
     */
    public function activate()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the plan.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);

        return $this;
    }

    /**
     * List Plans for Select2 Javascript Library
     * 
     * @return collect
     */
    public static function getSelect2Array() {        
        $response = collect();
        foreach(self::all() as $plan){
            $response->push([
                'id' => $plan->id,
                'text' => $plan->name
            ]);
        }
        return $response;
    }
}

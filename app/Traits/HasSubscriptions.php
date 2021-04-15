<?php

namespace App\Traits;

use App\Models\Plan;
use App\Models\PlanSubscription;
use App\Services\Period;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasSubscriptions
{
    /**
     * The user may have many subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(PlanSubscription::class);
    }

    /**
     * A model may have many active subscriptions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function activeSubscriptions(): Collection
    {
        return $this->subscriptions->reject->inactive();
    }

    /**
     * Get a subscription by slug.
     *
     * @param string $subscriptionSlug
     *
     * @return \App\Models\PlanSubscription|null
     */
    public function subscription(string $subscriptionSlug): ?PlanSubscription
    {
        return $this->subscriptions()->where('slug', $subscriptionSlug)->first();
    }

    /**
     * Get subscribed plans.
     *
     * @return \App\Models\PlanSubscription|null
     */
    public function subscribedPlans(): ?PlanSubscription
    {
        $planIds = $this->subscriptions->reject->inactive()->pluck('plan_id')->unique();

        return Plan::whereIn('id', $planIds)->get();
    }

    /**
     * Check if the user subscribed to the given plan.
     *
     * @param int $planId
     *
     * @return bool
     */
    public function subscribedTo($planId): bool
    {
        $subscription = $this->subscriptions()->where('plan_id', $planId)->first();

        return $subscription && $subscription->active();
    }

    /**
     * Subscribe user to a new plan.
     *
     * @param string           $subscription
     * @param \App\Models\Plan $plan
     *
     * @return \App\Models\PlanSubscription
     */
    public function newSubscription($subscription, Plan $plan, $dont_start = false): PlanSubscription
    {
        $trial = new Period($plan->trial_interval, $plan->trial_period, now());
        $period = new Period($plan->invoice_interval, $plan->invoice_period, $trial->getEndDate());

        return $this->subscriptions()->create([
            'name' => $subscription,
            'slug' => $subscription,
            'plan_id' => $plan->getKey(),
            'trial_ends_at' => $trial->getEndDate(),
            'starts_at' => $dont_start ? null : $period->getStartDate(),
            'ends_at' => $dont_start ? null : $period->getEndDate(),
        ]);
    }
}
<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SuperAdmin\Plan\Store;
use App\Http\Requests\SuperAdmin\Plan\Update;
use App\Models\Plan;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    /**
     * Display Super Admin Plans Page
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Plans
        $plans = QueryBuilder::for(Plan::class)
            ->oldest()
            ->paginate()
            ->appends(request()->query());

        return view('super_admin.plans.index', [
            'plans' => $plans
        ]);
    }

    /**
     * Display the Form for Creating New Plan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = new Plan();
 
        return view('super_admin.plans.create', [
            'plan' => $plan,
        ]);
    }

    /**
     * Store the plan in Database
     *
     * @param \App\Http\Requests\SuperAdmin\Plan\Store $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        // Slug
        $slug = Str::slug($request->name, '-');

        // Check slug
        if (Plan::where('slug', $slug)->exists()) {
            session()->flash('alert-danger', __('messages.plan_with_this_slug_already_exists'));
            return redirect()->route('super_admin.plans.create');
        };
 
        // Create new Plan
        $plan = Plan::create([
            'slug' => $slug,
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => true,
            'price' => $request->price,
            'invoice_period' => 1,
            'invoice_interval' => $request->invoice_interval, // month or year
            'trial_period' => $request->trial_period, // trial days
            'trial_interval' => 'day',
            'order' => $request->order ? $request->order : 0
        ]);

        // Create new Plan Features
        $plan->addPlanFeatures($request->features);

        session()->flash('alert-success', __('messages.plan_created'));
        return redirect()->route('super_admin.plans');
    } 


    /**
     * Display the Form for Editing Plan
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        
        // Fill model with old input
        if (!empty($request->old())) {
            $plan->fill($request->old());
        }

        return view('super_admin.plans.edit', [
            'plan' => $plan,
        ]);
    }

    /**
     * Update the Package in Database
     *
     * @param \App\Http\Requests\SuperAdmin\Plan\Update $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $plan = Plan::findOrFail($request->plan);

        // Update the Plan
        $plan->update($request->validated());
 
        // Create new Plan Features
        $plan->updatePlanFeatures($request->features);

        session()->flash('alert-success', __('messages.plan_updated'));
        return redirect()->route('super_admin.plans.edit', $plan->id);
    }

    /**
     * Delete the Package
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);

        // Delete Plan's Features from Database
        if ($plan->features()->exists()) {
            $plan->features()->delete();
        }

        // Delete Plan's Subscriptions from Database
        if ($plan->subscriptions()->exists()) {
            $plan->subscriptions()->delete();
        }

        // Delete plan
        $plan->delete();

        session()->flash('alert-success', __('messages.plan_deleted'));
        return redirect()->route('super_admin.plans');
    }
}

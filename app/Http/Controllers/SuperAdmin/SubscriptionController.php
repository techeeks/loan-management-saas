<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanSubscription;
use Spatie\QueryBuilder\QueryBuilder;

class SubscriptionController extends Controller
{
    /**
     * Display Super Admin Subscriptions Page
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Subscriptions
        $subscriptions = QueryBuilder::for(PlanSubscription::class)
            ->oldest()
            ->paginate()
            ->appends(request()->query());

        return view('super_admin.subscriptions.index', [
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * Cancel the subscription
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function cancel(Request $request)
    {
        $subscription = PlanSubscription::findOrFail($request->subscription);

        $subscription->cancel(true);

        session()->flash('alert-success', __('messages.subscription_cancelled'));
        return redirect()->route('super_admin.subscriptions');
    }
}

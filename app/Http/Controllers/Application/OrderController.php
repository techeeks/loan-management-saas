<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Plan;
use App\Models\SubscriptionVoucher;
use App\Models\SystemSetting;
use App\Services\Gateways\PaypalExpress;
use App\Services\Gateways\Razorpay;
use App\Services\Gateways\Stripe;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display Plans
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function plans()
    {
        return view('application.order.plans');
    }

    /**
     * Display Checkout
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        // Find plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Auth User & Company
        $user = $request->user();
        $currentCompany = $user->currentCompany();
 
        // If the plan is free subscribe user directly
        if ($plan->isFree()) {
            // First cancel current subscription if any
            if ($currentCompany->subscription('main')) {
                $currentCompany->subscription('main')->cancel(true);
            }

            // Create new subscription
            $currentCompany->newSubscription('main', $plan);

            // Redirect user to dashboard
            return redirect()->route('dashboard', ['company_uid' => $currentCompany->uid]);
        }

        // If plan has free trial subscribe user for a time of free trial interval
        $isSubscribedBefore = $currentCompany->subscriptions->isNotEmpty();
        if ($plan->hasTrial() & !$isSubscribedBefore) {
            // Create new subscription
            $currentCompany->newSubscription('main', $plan, true);

            // Redirect user to dashboard
            return redirect()->route('dashboard', ['company_uid' => $currentCompany->uid]);
        }

        // Razorpay Setting
        $razorpay_order = [];
        $razorpay_callbackUrl = '';
        $orderId = $currentCompany->id.strtoupper(str_replace('.', '', uniqid('', true)));
        if (SystemSetting::isRazorpayActive()) {
            // Get Razorpay Service
            $razorpay = new Razorpay(null, true);

            // Create Razorpay Order
            $razorpay_order = $razorpay->create([
                'receipt' => $orderId,
                'amount' => $plan->price,
                'currency' => $plan->currency
            ]);
 
            // Get callback url
            $razorpay_callbackUrl = route('order.payment.razorpay', ['plan' => $plan->slug, 'orderId' => $orderId]);
        }

        // Return checkout form
        return view('application.order.checkout', [
            'plan' => $plan,
            'orderId' => $orderId,
            'razorpay_order' => $razorpay_order,
            'razorpay_callbackUrl' => $razorpay_callbackUrl,
        ]);
    }

    public function AddVoucher(Request $request)
    {
      
        // Find plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Auth User & Company
        $user = $request->user();
        $currentCompany = $user->currentCompany();
 
        // If the plan is free subscribe user directly
      
            // First cancel current subscription if any

            // Redirect user to dashboard
            
        // Razorpay Setting
       
        $orderId = $currentCompany->id.strtoupper(str_replace('.', '', uniqid('', true)));
       
 
            // Get callback url
           
        // Return checkout form
        return view('application.order.voucher_checkout', [
            'plan' => $plan,
            'orderId' => $orderId,
        ]);
    }

    /**
     * Paypal Payment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */ 
    public function paypal(Request $request)
    {
        // Plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Get PaypalExpress Service (saas)
        $paypal = new PaypalExpress(null, true);
 
        // Make the Payment Request
        $response = $paypal->purchase([
            'amount' => $paypal->formatAmount($plan->price),
            'transactionId' => $request->orderId,
            'currency' => $plan->currency,
            'cancelUrl' => route('order.payment.paypal.completed', ['plan' => $plan->slug, 'orderId' => $request->orderId]),
            'returnUrl' => route('order.payment.paypal.completed', ['plan' => $plan->slug, 'orderId' => $request->orderId]),
        ]);

        // Redirect customer to Paypal website
        if ($response->isRedirect()) {
            $response->redirect();
        }
 
        // Something else happend, go back to invoice details
        session()->flash('alert-error', $response->getMessage());
        return redirect()->route('order.checkout', ['plan' => $plan->slug]);
    }

    /**
     * Paypal Complete Payment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */ 
    public function paypal_completed(Request $request)
    {
        // Plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Auth User & Company
        $user = $request->user();
        $currentCompany = $user->currentCompany();
 
        // Get PaypalExpress Service (saas)
        $paypal = new PaypalExpress(null, true);

        // Complete the Payment Request
        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($plan->price),
            'transactionId' => $request->orderId,
            'currency' => $plan->currency,
            'cancelUrl' => route('order.payment.paypal.completed', ['plan' => $plan->slug, 'orderId' => $request->orderId]),
            'returnUrl' => route('order.payment.paypal.completed', ['plan' => $plan->slug, 'orderId' => $request->orderId]),
        ]);
 
        // If payment was successful then save payment and return user to success page
        if ($response->isSuccessful()) {
            // Create and Save Payment to Database
            $order = Order::create([
                'company_id' => $currentCompany->id,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'card_number' => '',
                'card_exp_month' => '',
                'card_exp_year' => '',
                'price' => $plan->price,
                'currency' => $plan->currency,
                'transaction_id' => $response->getTransactionReference(),
                'payment_type' => 'PAYPAL',
                'payment_status' => 'COMPLETED',
                'order_id' => $request->orderId,
            ]);

            // Renew old one
            if ($currentCompany->subscription('main')) {
                $currentCompany->subscription('main')->changePlan($plan);
            } else {
                // or Create new subscription
                $currentCompany->newSubscription('main', $plan);
            }
     
            session()->flash('alert-success', __('messages.payment_successful', ['payment_number' => $request->orderId]));
            return redirect()->route('home');
        }

        // Something else happend, go back to invoice details
        session()->flash('alert-danger', $response->getMessage());
        return redirect()->route('order.checkout', ['plan' => $plan->slug]);
    }

    /**
     * Paypal Cancelled Payment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */ 
    public function paypal_cancelled(Request $request)
    {
        // Plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        session()->flash('alert-danger', __('messages.payment_cancelled_paypal'));
        return redirect()->route('order.checkout', ['plan' => $plan->slug]);
    }

    /**
     * Stripe Payment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */ 
    public function stripe(Request $request)
    {
        // Plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Auth User & Company
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // Get Stripe Service
        $stripe = new Stripe(null, true);
 
        // Make the Payment Request
        $response = $stripe->purchase([
            'amount' => $stripe->formatAmount($plan->price),
            'currency' => $plan->currency,
            'paymentMethod' => $request->paymentMethodId,
            'description' => $plan->description, 
            'returnUrl' => route('order.payment.stripe.completed', ['plan' => $plan->slug, 'orderId' => $request->orderId]),
            'confirm' => true,
        ]);

        // If payment was successful then save payment and return user to success page
        if ($response->isSuccessful()) {
            // Create and Save Payment to Database
            $order = Order::create([
                'company_id' => $currentCompany->id,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'card_number' => '',
                'card_exp_month' => '',
                'card_exp_year' => '',
                'price' => $plan->price,
                'currency' => $plan->currency,
                'transaction_id' => $response->getPaymentIntentReference(),
                'payment_type' => 'STRIPE',
                'payment_status' => 'COMPLETED',
                'order_id' => $request->orderId,
            ]);

            // Renew old one
            if ($currentCompany->subscription('main')) {
                $currentCompany->subscription('main')->changePlan($plan);
            } else {
                // or Create new subscription
                $currentCompany->newSubscription('main', $plan);
            }

            session()->flash('alert-success', __('messages.payment_successful', ['payment_number' => $request->orderId]));
            return redirect()->route('home');
        } 
        // If stripe needs additional redirect like 3d secure then redirect the customer
        else if ($response->isRedirect()) {
            $response->redirect();
        }
        
        // Something else happend, go back to invoice details
        session()->flash('alert-error', $response->getMessage());
        return redirect()->route('order.checkout', ['plan' => $plan->id]);
    }

    /**
     * Stripe Complete Payment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */ 
    public function stripe_completed(Request $request)
    {
        // Plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Auth User & Company
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // Get Stripe Service
        $stripe = new Stripe(null, true);

        // Complete the Payment Request
        $response = $stripe->complete([
            'paymentIntentReference' => $request->payment_intent,
            'returnUrl' => route('order.payment.stripe.completed', ['plan' => $plan->slug, 'orderId' => $request->orderId]),
        ]);
 
        // If payment was successful then save payment and return user to success page
        if ($response->isSuccessful()) {
            // Create and Save Payment to Database
            $order = Order::create([
                'company_id' => $currentCompany->id,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'card_number' => '',
                'card_exp_month' => '',
                'card_exp_year' => '',
                'price' => $plan->price,
                'currency' => $plan->currency,
                'transaction_id' => $response->getPaymentIntentReference(),
                'payment_type' => 'STRIPE',
                'payment_status' => 'COMPLETED',
                'order_id' => $request->orderId,
            ]);

            // Renew old one
            if ($currentCompany->subscription('main')) {
                $currentCompany->subscription('main')->changePlan($plan);
            } else {
                // or Create new subscription
                $currentCompany->newSubscription('main', $plan);
            }

            session()->flash('message-success', __('messages.payment_successful', ['payment_number' => $request->orderId]));
            return redirect()->route('home');
        }

        // Something else happend, go back to invoice details
        session()->flash('message-danger', $response->getMessage());
        return redirect()->route('order.checkout', ['plan' => $plan->id]);
    }
    public function voucher(Request $request)
    {
        $request->validate([
            'voucher_code'=>'required',
        ]);
        $plan = Plan::where('slug', $request->plan)->firstOrFail();
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $voucher=SubscriptionVoucher::where(['company_id'=>$currentCompany->id, 'plan_id' => $plan->id, 'voucher_code'=>$request->voucher_code,'status'=>"New"])->first();
        if($voucher){
            $order = Order::create([
                'company_id' => $currentCompany->id,
                'user_id' => $user->id,
                'plan_id' => $voucher->plan->id,
                'card_number' => '',
                'card_exp_month' => '',
                'card_exp_year' => '',
                'price' => $voucher->plan->price,
                'currency' =>$voucher->plan->currency,
                'transaction_id' => $voucher->transaction_id,
                'payment_type' => 'Voucher',
                'payment_status' => 'COMPLETED',
                'order_id' => $request->orderId,
            ]);
            if ($currentCompany->subscription('main')) {
                $currentCompany->subscription('main')->changePlan($voucher->plan);
            } else {
                $currentCompany->newSubscription('main', $voucher->plan);
            }
            $voucher->status="Used";
            $voucher->save();
            session()->flash('alert-success', __('messages.payment_successful', ['payment_number' => $request->orderId]));
            return redirect()->route('home');
        }
        else{
            // echo "exitt";exit;
            session()->flash('alert-danger', 'Invalid Voucher');
            return redirect()->route('order.add-voucher', ['company_uid' => $currentCompany->uid, 'plan' => $plan->slug]);
        }
          
    }

    /**
     * Razorpay Payment Callback
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */ 
    public function razorpay(Request $request)
    {
        // Plan
        $plan = Plan::where('slug', $request->plan)->firstOrFail();

        // Auth User & Company
        $user = $request->user();
        $currentCompany = $user->currentCompany();
 
        // Get Razorpay Service
        $razorpay = new Razorpay(null, true);

        // Check if the signature is correct or not
        $check = $razorpay->checkSignature($request->only('razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature'));
 
        // If payment was successful then save payment and return user to success page
        if ($check) {
            // Create and Save Payment to Database
            $order = Order::create([
                'company_id' => $currentCompany->id,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'card_number' => '',
                'card_exp_month' => '',
                'card_exp_year' => '',
                'price' => $plan->price,
                'currency' => $plan->currency,
                'transaction_id' => $request->razorpay_order_id,
                'payment_type' => 'RAZORPAY',
                'payment_status' => 'COMPLETED',
                'order_id' => $request->orderId,
            ]);

            // Renew old one
            if ($currentCompany->subscription('main')) {
                $currentCompany->subscription('main')->changePlan($plan);
            } else {
                // or Create new subscription
                $currentCompany->newSubscription('main', $plan);
            }

            session()->flash('message-success', __('messages.payment_successful', ['payment_number' => $request->orderId]));
            return redirect()->route('home');
        }

        // Something else happend, go back to invoice details
        session()->flash('message-danger', __('messages.error_while_proccessing_payment'));
        return redirect()->route('order.checkout', ['plan' => $plan->id]);
    }
}

<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\Application\Customer\Store;
use App\Http\Requests\Application\Customer\Update;
use App\Models\LoanRequest;
use Spatie\Activitylog\Models\Activity;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\Guaranter;

class CustomerController extends Controller
{
    /**
     * Display Customers Page
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // Get Customers by Company and Filters
        $customers = QueryBuilder::for(Customer::findByCompany($currentCompany->id))
            ->allowedFilters([
                AllowedFilter::partial('display_name'),
                AllowedFilter::partial('contact_name'),
                AllowedFilter::scope('has_unpaid'),
            ])
            ->oldest()
            ->paginate()
            ->appends(request()->query());

        return view('application.customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Display the Form for Creating New Customer
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = new Customer();
 
        return view('application.customers.create', [
            'customer' => $customer,
        ]);
    }

    /**
     * Store the Customer in Database
     *
     * @param \App\Http\Requests\Application\Customer\Store $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $allData=$request->all();
        
        
    
        $canAdd = $currentCompany->subscription('main')->canUseFeature('customers');
        if (!$canAdd) {
            session()->flash('alert-danger', __('messages.you_have_reached_the_limit'));
            return redirect()->route('customers', ['company_uid' => $currentCompany->uid]);
        }
        // Redirect back
        
        $gurantor=Guaranter::create(['display_name'=>$request->guarantor_name,'phone'=>$request->guarantor_phone,]);
        $guranterAddress=$request->input('gurantor');
        $guranterAddress["name"]=$gurantor->display_name;
        $gurantor->address('gurantor', $guranterAddress);
        // Create Customer and Store in Database
        $customer = Customer::create([
            'guarantor_id '=>1,
            'company_id' => $currentCompany->id,
            'display_name' => $request->display_name,
            'email' => $request->email,
            'phone' => $request->phone,
            ]);
            // echo $gurantor->id;exit;
            // echo '<pre>',print_r($customer);exit;
            
        // Set Customer's billing and shipping addresses
        $billing=$request->input('billing');
        $billing["name"]=$customer->display_name;
        $customer->address('billing', $billing);
       // $customer->address('shipping', $request->input('shipping'));

        // Add custom field values
        $customer->addCustomFields($request->custom_fields);

        // Record product 
        $currentCompany->subscription('main')->recordFeatureUsage('customers');

        session()->flash('alert-success', __('messages.customer_added'));
        return redirect()->route('customers.details', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]);
    } 

    /**
     * Display the Customer Details Page
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $customer = Customer::findOrFail($request->customer);
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $invoices = $customer->invoices()->orderBy('invoice_number')->paginate(50);
        $estimates = $customer->estimates()->orderBy('estimate_number')->paginate(50);
        $payments = $customer->payments()->orderBy('payment_number')->paginate(50);
        $activities = Activity::where('subject_id', $customer->id)->get();
        $loans=$customer->loans()->orderBy('created_at','DESC')->get();
        $totalDue=0;
        foreach($loans as $loan)
        {
            $totalDue+=$loan->amount-$loan->totalPaid($loan->id);
        }
        $totalDue=currencyFormat($totalDue,'$');
        $payments=DB::table('loan_requests')->join('loan_payments','loan_payments.loan_id','=','loan_requests.id')
        ->join('payment_methods','payment_methods.id','=','loan_payments.payment_method_id')
        ->join('currencies','currencies.id','=','loan_requests.currency_id')
        ->where('loan_requests.customer_id',$customer->id)->select('loan_requests.reference_number','loan_payments.*','payment_methods.name as payment_method','currencies.symbol as currency_code')->orderBy('created_at',"DESC")->get();
        // echo '<pre>',print_r($payments);exit;
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        return view('application.customers.details', [
            'customer' => $customer,
            'invoices' => $invoices,
            'estimates' => $estimates,
            'payments' => $payments,
            'activities' => $activities,
            'loans'=>$loans,
            'payments'=>$payments,
            'payment_prefix' => $payment_prefix,
            'totalDue'=>$totalDue,
        ]);
    }

    /**
     * Display the Form for Editing Customer
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $customer = Customer::findOrFail($request->customer);
        $gurantor=$customer->guarantor()->get();
        echo '<pre>',print_r($gurantor);exit;
        
        // Fill model with old input
        if (!empty($request->old())) {
            $customer->fill($request->old());
        }

        return view('application.customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the Customer in Database
     *
     * @param \App\Http\Requests\Application\Customer\Update $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        $customer = Customer::findOrFail($request->customer);

        // Update Customer in Database
        $customer->update([
            'display_name' => $request->display_name,
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'currency_id' => $request->currency_id,
            'vat_number' => $request->vat_number,
        ]);

        // Update Customer's billing and shipping addresses
        $customer->updateAddress('billing', $request->input('billing'));
       // $customer->updateAddress('shipping', $request->input('shipping'));

        // Update custom field values
        $customer->updateCustomFields($request->custom_fields);

        session()->flash('alert-success', __('messages.customer_updated'));
        return redirect()->route('customers.details', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]);
    }

    /**
     * Delete the Customer
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        
        $customer = Customer::findOrFail($request->customer);

        // If demo mode is active then block this action
        if (config('app.is_demo') && $customer->id === 2) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('customers.details', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]);
        };

        // Reduce feature
        $currentCompany->subscription('main')->reduceFeatureUsage('customers');

        // Delete Customer's Estimates from Database
        if ($customer->estimates()->exists()) {
            $customer->estimates()->delete();
        }

        // Delete Customer's Invoices from Database
        if ($customer->invoices()->exists()) {
            $customer->invoices()->delete();
        }

        // Delete Customer's Payments from Database
        if ($customer->payments()->exists()) {
            $customer->payments()->delete();
        }
 
        // Delete Customer's Addresses from Database
        if ($customer->addresses()->exists()) {
            $customer->addresses()->delete();
        }

        // Delete Customer from Database
        $customer->delete();

        session()->flash('alert-success', __('messages.customer_deleted'));
        return redirect()->route('customers', ['company_uid' => $currentCompany->uid]);
    }
}

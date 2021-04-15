<?php

namespace App\Http\Controllers\CustomerPortal;

use App\Events\InvoiceViewedEvent;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\Activitylog\Models\Activity;

class InvoiceController extends Controller
{
    /**
     * Display Customer Invoices Page
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentCustomer = Customer::findByUid($request->customer);

        // Get Invoices by Customer
        $query = $currentCustomer->invoices()->active()->orderBy('invoice_number')->getQuery();

        // Apply filters
        $invoices = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::partial('invoice_number'),
                AllowedFilter::scope('from'),
                AllowedFilter::scope('to'),
            ])
            ->paginate()
            ->appends(request()->query());

        return view('customer_portal.invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Display Invoice Details Page
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $invoice = Invoice::findByUid($request->invoice);
        $customer = $invoice->customer;

        // Check if it is already viewed or not
        $viewed = Activity::where('subject_id', $customer->id)->where('causer_id', $invoice->id)->where('description', 'viewed')->first();
        if (!$viewed) {
            // Log invoice viewed
            activity()->on($customer)->by($invoice)->log('viewed');

            // Dispatch InvoiceViewedEvent
            InvoiceViewedEvent::dispatch($invoice);
        }

        return view('customer_portal.invoices.details', [
            'invoice' => $invoice,
        ]);
    }
}

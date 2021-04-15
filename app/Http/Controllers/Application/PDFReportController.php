<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Services\PDFService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PDFReportController extends Controller
{
    /**
     * Get Customer Sales Report Pdf
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function customer_sales(Request $request)
    {
        $user = $request->user();
        $company = $user->currentCompany();

        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('invoice_color'));

        //Set report type
        $pdf->setType(__('messages.customer_sales_report'));

        // Hide Header
        $pdf->setHideHeader(true);

        // Set Title of Header
        $pdf->setHeaderTitle(__('messages.customer'));

        // Fetch Customers with Invoices
        $from = Carbon::createFromFormat('Y-m-d', isset($request->from) ? $request->from : Carbon::now()->format('Y-m-d'));
        $to = Carbon::createFromFormat('Y-m-d', isset($request->to) ? $request->to : Carbon::now()->addMonth()->format('Y-m-d'));

        //Set dates
        $pdf->setFromDate($from->isoFormat('MMMM Do YYYY'));
        $pdf->setToDate($to->isoFormat('MMMM Do YYYY'));
 
        $customers = Customer::with(['invoices' => function ($query) use ($from, $to) {
            $query->whereBetween(
                'invoice_date',
                [$from->format('Y-m-d'), $to->format('Y-m-d')]
            );
        }])->get();

        // Total Amount
        $totalAmount = 0;
        foreach ($customers as $customer) {
            $customerTotalAmount = 0;
            foreach ($customer->invoices as $invoice) {
                $customerTotalAmount += $invoice->total;
            }
            $customer->totalAmount = $customerTotalAmount;
            $totalAmount += $customerTotalAmount;

            // Add Report Items 
            $pdf->addReportItem($customer->display_name, __('messages.total_amount_of_invoices'), money($customerTotalAmount, $customer->currency_code)->format());
        }

        //Render or Download
        if($request->has('download')) {
            $pdf->render('CUSTOMER_SALES_REPORT.pdf', 'D');
        } else {
            $pdf->render('CUSTOMER_SALES_REPORT.pdf', 'I');
        }
    }

    /**
     * Get Product Sales Report Pdf
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function product_sales(Request $request)
    {
        $user = $request->user();
        $company = $user->currentCompany();

        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('invoice_color'));

        //Set report type
        $pdf->setType(__('messages.product_sales_report'));

        // Hide Header
        $pdf->setHideHeader(true);

        // Set Title of Header
        $pdf->setHeaderTitle(__('messages.product'));

        // Fetch Customers with Invoices
        $from = Carbon::createFromFormat('Y-m-d', isset($request->from) ? $request->from : Carbon::now()->format('Y-m-d'));
        $to = Carbon::createFromFormat('Y-m-d', isset($request->to) ? $request->to : Carbon::now()->addMonth()->format('Y-m-d'));

        //Set dates
        $pdf->setFromDate($from->isoFormat('MMMM Do YYYY'));
        $pdf->setToDate($to->isoFormat('MMMM Do YYYY'));

        // Products
        $products = Product::with(['invoice_items' => function ($query) use ($from, $to) {
            $query->whereHas('invoice', function ($query) use ($from, $to) {
                $query->whereBetween(
                    'invoice_date',
                    [$from->format('Y-m-d'), $to->format('Y-m-d')]
                );
            });
        }])->get();

        // Total Amount
        foreach ($products as $product) {
            // Add Report Items 
            $pdf->addReportItem($product->name, __('messages.total_amount_of_invoices'), money(collect($product->invoice_items)->sum('total'), $product->currency_code)->format());
        }

        //Render or Download
        if($request->has('download')) {
            $pdf->render('PRODUCT_SALES_REPORT.pdf', 'D');
        } else {
            $pdf->render('PRODUCT_SALES_REPORT.pdf', 'I');
        }
    }

    /**
     * Get Profit & Loss Report Pdf
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function profit_loss(Request $request)
    {
        $user = $request->user();
        $company = $user->currentCompany();

        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('invoice_color'));

        //Set report type
        $pdf->setType(__('messages.profit_loss_report'));

        // Hide Header
        $pdf->setHideHeader(true);

        // Set Title of Header
        $pdf->setHeaderTitle(__('messages.profit_loss'));

        // Fetch Customers with Invoices
        $from = Carbon::createFromFormat('Y-m-d', isset($request->from) ? $request->from : Carbon::now()->format('Y-m-d'));
        $to = Carbon::createFromFormat('Y-m-d', isset($request->to) ? $request->to : Carbon::now()->addMonth()->format('Y-m-d'));

        //Set dates
        $pdf->setFromDate($from->isoFormat('MMMM Do YYYY'));
        $pdf->setToDate($to->isoFormat('MMMM Do YYYY'));

        // Invoices
        $invoices_total = Invoice::from($from)->to($to)->paid()->sum('total');

        // Add Invoices as Profit
        $pdf->addReportItem(__('messages.profit'), null, money($invoices_total, $company->currency_code)->format());

        // Expense Categories
        $expense_categories = ExpenseCategory::with(['expenses' => function ($query) use ($from, $to) {
            $query->whereBetween(
                'expense_date',
                [$from->format('Y-m-d'), $to->format('Y-m-d')]
            );
        }])->get();

        // Total Expenses
        $total_loss = 0;
        foreach ($expense_categories as $expense_category) {
            // Add Report Items 
            $expense_category_total = collect($expense_category->expenses)->sum('amount');
            $total_loss += $expense_category_total;
            $pdf->addReportItem($expense_category->name, null, money($expense_category_total, $company->currency_code)->format());
        }
        
        // Total
        $pdf->addReportItem(__('messages.total_upperscored'), null, money($invoices_total - $total_loss, $company->currency_code)->format(), true);

        //Render or Download
        if($request->has('download')) {
            $pdf->render('PROFIT_LOSS_REPORT.pdf', 'D');
        } else {
            $pdf->render('PROFIT_LOSS_REPORT.pdf', 'I');
        }
    }

    /**
     * Get Profit & Expenses Pdf
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return pdf
     */
    public function expenses(Request $request)
    {
        $user = $request->user();
        $company = $user->currentCompany();

        //Create a new pdf instance
        $pdf = new PDFService("A4");

        //Set your logo
        $pdf->setLogo($company->avatar, 180, 100);

        //Set theme color
        $pdf->setColor($company->getSetting('invoice_color'));

        //Set report type
        $pdf->setType(__('messages.expense_report'));

        // Hide Header
        $pdf->setHideHeader(true);

        // Set Title of Header
        $pdf->setHeaderTitle(__('messages.expenses'));

        // Fetch Customers with Invoices
        $from = Carbon::createFromFormat('Y-m-d', isset($request->from) ? $request->from : Carbon::now()->format('Y-m-d'));
        $to = Carbon::createFromFormat('Y-m-d', isset($request->to) ? $request->to : Carbon::now()->addMonth()->format('Y-m-d'));

        //Set dates
        $pdf->setFromDate($from->isoFormat('MMMM Do YYYY'));
        $pdf->setToDate($to->isoFormat('MMMM Do YYYY'));

        // Expense Categories
        $expense_categories = ExpenseCategory::with(['expenses' => function ($query) use ($from, $to) {
            $query->whereBetween(
                'expense_date',
                [$from->format('Y-m-d'), $to->format('Y-m-d')]
            );
        }])->get();

        // Total Expenses
        $total_loss = 0;
        foreach ($expense_categories as $expense_category) {
            // Add Report Items 
            $expense_category_total = collect($expense_category->expenses)->sum('amount');
            $total_loss += $expense_category_total;
            $pdf->addReportItem($expense_category->name, null, money($expense_category_total, $company->currency_code)->format());
        }
        
        // Total
        $pdf->addReportItem(__('messages.total_upperscored'), null, money($total_loss, $company->currency_code)->format(), true);

        //Render or Download
        if($request->has('download')) {
            $pdf->render('EXPENSES_REPORT.pdf', 'D');
        } else {
            $pdf->render('EXPENSES_REPORT.pdf', 'I');
        }
    }
}

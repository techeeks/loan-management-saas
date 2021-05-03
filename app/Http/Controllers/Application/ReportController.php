<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\LoanRequest;
use Laravel\Ui\Presets\React;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Get Customer Sales Report
     * 
     * @return \Illuminate\Http\Response
     */
    public function customer_sales()
    {
        return view('application.reports.customer_sales');
    }

    /**
     * Get Product Sales Report
     *
     * @return \Illuminate\Http\Response
     */
    public function product_sales()
    {
        return view('application.reports.product_sales');
    }

    /**
     * Get Profit & Loss Report
     *
     * @return \Illuminate\Http\Response
     */
    public function profit_loss()
    {
        return view('application.reports.profit_loss');
    }

    /**
     * Get Expenses
     *
     * @return \Illuminate\Http\Response
     */
    public function expenses()
    {
        return view('application.reports.expenses');
    }

    public function paidLoans(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $query=LoanRequest::findByCompany($currentCompany->id)->where('status','Paid')->orderBy('id','DESC');
        // Query Invoices by Company and Tab

        // Apply Filters and Paginate
        $loans = QueryBuilder::for($query)
            ->paginate()
            ->appends(request()->query());
            return view('application.reports.paid_loans', [
                'loans' => $loans,
        ]);
    }

    public function overDueLoans(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $query=LoanRequest::findByCompany($currentCompany->id)->whereIn('status',['Pending','Overdue'])->orderBy('return_date','DESC');
        // Query Invoices by Company and Tab

        // Apply Filters and Paginate
        $loans = QueryBuilder::for($query)
            ->paginate()
            ->appends(request()->query());
            return view('application.reports.overdue_loans', [
                'loans' => $loans,
        ]);
    }
}

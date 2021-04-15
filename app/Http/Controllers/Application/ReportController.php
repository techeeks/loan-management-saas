<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;

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
}

<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\LoanPayment;
use App\Models\LoanRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display Dashboard Page
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // echo "dashboard";exit;
        $user = $request->user();
        $company = $user->currentCompany();
   
        // Dashboard Stats
        $customersCount = Customer::findByCompany($company->id)->count();
        $invoicesCount = Invoice::findByCompany($company->id)->count();
        $estimatesCount = Estimate::findByCompany($company->id)->count();
        $totalDueAmount = Invoice::findByCompany($company->id)->active()->sum('due_amount');
        $totalLoan=LoanRequest::where('company_id',$company->id)->sum('amount');
        $totalPayments=LoanPayment::where('company_id',$company->id)->sum('amount');
        $totalDueLoans=LoanRequest::where(['company_id'=>$company->id])->where('return_date','<',date('Y-m-d'))->count();
        $dueLoans=LoanRequest::where(['company_id'=>$company->id])->where('return_date','<',date('Y-m-d'))->orderBy('id','DESC')->take(10)->get();
        $paymentList=LoanPayment::findByCompany($company->id)->orderBy('id','DESC')->take(10)->get();

        // Due Invoices and Estimates
        $dueInvoices = Invoice::findByCompany($company->id)->active()->where('due_amount', '>', 0)->take(5)->latest()->get();
        $dueEstimates = Estimate::findByCompany($company->id)->active()->take(5)->latest('expiry_date')->get();

        // Financial Year Starts-Ends
        $financialYearStarts = $company->getSetting('financial_month_starts');
        $financialYearEnds = $company->getSetting('financial_month_ends');

        // Create Carbon Instances from Financial Year
        $dateStarts = Carbon::now()->month($financialYearStarts)->startOfMonth();
        $dateEnds = Carbon::now()->month($financialYearEnds)->endOfMonth();

        // if the date ends is smaller than date start, add one year to date ends
        if($dateEnds->lt($dateStarts)){
            $dateEnds->addYear(1)->endOfMonth();
        }

        // Create Period from given dates
        $period = CarbonPeriod::since($dateStarts)->months(1)->until($dateEnds);

        // Arrays for Expenses Chart
        $expense_stats_label = [];
        $expense_stats = [];
        $loan_stats=[];
        $payment_stats=[];

        // Iterate over the Date Period 
        foreach ($period as $date) {
            // Add month as label
            $month = $date->format('M');
            array_push($expense_stats_label, $month);

            // Add Expense amount for current month
            $expense = Expense::findByCompany($company->id)
                ->get(['amount', 'expense_date'])
                ->whereBetween('expense_date', [$date->format('Y-m-d'), $date->endOfMonth()->format('Y-m-d')])
                ->sum('amount');
                array_push($expense_stats, $expense/100);
            $loanPerMonth=LoanRequest::where('company_id',$company->id)
            ->whereMonth('loan_date',  $date->format('m'))
            ->whereYear('loan_date',$date->format('Y'))
            ->sum('amount');
             array_push($loan_stats, $loanPerMonth);
            $paymentPerMonth=LoanPayment::where('company_id',$company->id)->whereMonth('payment_date',  $date->format('m'))
            ->whereYear('payment_date',$date->format('Y'))
            ->sum('amount');
            array_push($payment_stats, $paymentPerMonth);

        }
        // echo '<pre>',print_r($loan_stats);exit;

        
        // return dashboard view with params
        return view('application.dashboard.index', [
            'customersCount' => $customersCount,
            'invoicesCount' => $invoicesCount,
            'estimatesCount' => $estimatesCount,
            'totalDueAmount' => $totalDueAmount,
            'dueInvoices' => $dueInvoices,
            'dueEstimates' => $dueEstimates,
            'expense_stats_label' => $expense_stats_label,
            'expense_stats' => $expense_stats,
            'currency_code' => $company->currency->code,
            'total_loan'=>$totalLoan,
            'total_payments'=>$totalPayments,
            'total_due'=>$totalDueLoans,
            'loan_per_month'=>$loan_stats,
            'payments_per_moth'=>$payment_stats,
            'due_loans'=>$dueLoans,
            'payments'=>$paymentList,
            'payment_prefix'=>$payment_prefix = $company->getSetting('payment_prefix'),
        ]);
    }
}

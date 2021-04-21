<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanPayment;
use App\Models\LoanRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Customer;

class LoanPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $query=LoanPayment::findByCompany($currentCompany->id)->orderBy('id','DESC');
        // Query Invoices by Company and Tab
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        // Apply Filters and Paginate
        $payments = QueryBuilder::for($query)
            ->paginate()
            ->appends(request()->query());
            return view('application.loan_payments.index', [
                'payments' => $payments,
                'payment_prefix'=>$payment_prefix,
        ]);
    }
    public function create(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // Get next Payment number if the auto generation option is enabled
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        $next_payment_number = LoanPayment::getNextPaymentNumber($currentCompany->id, $payment_prefix);


        // Create new Payment model and set estimate_number and company_id
        // so that we can use them in the form
        $payment = new LoanPayment();
        $payment->payment_number = $next_payment_number ?? 0;
        $payment->company_id = $currentCompany->id;
        $payment->loan_id=$request->loan_id;
        $loan=LoanRequest::find($request->loan_id);
        $payment->loan_amount=$loan->amount;
        $paymentDetails=LoanPayment::where('loan_id',$request->loan_id)->sum('amount');
        if($paymentDetails){
            $payment->loan_amount=$payment->loan_amount-$paymentDetails;
        }
        return view('application.loan_payments.create', [
            'payment' => $payment
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'payment_number' => 'required',
            'payment_method_id' => 'required',
            'amount'=>'required|numeric|min:1',
            'transaction_reference'=>'required',
            'payment_date'=>'required|date',
        ]);
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $data=$request->all();
        $data["company_id"]=$currentCompany->id;
        $data["loan_id"]=$request->loan_id;
        $payment=LoanPayment::create($data);
        $loan=LoanRequest::find($request->loan_id);
        $paymentDetails=LoanPayment::where('loan_id',$request->loan_id)->sum('amount');
        if($paymentDetails){
           
           if($loan->amount-$paymentDetails==0)
           {
                $loan->status="Paid";
                $loan->save();
           }
        }
        // exit;
        session()->flash('alert-success', __('messages.payment_added'));
        return redirect()->route('loan.payments', ['company_uid' => $currentCompany->uid]);
    }
}

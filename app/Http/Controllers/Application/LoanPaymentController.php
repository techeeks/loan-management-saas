<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanPayment;
use App\Models\LoanRequest;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mails\PaymentToCustomer;
use Illuminate\Support\Facades\File;;

class LoanPaymentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $query=LoanPayment::query();
        $customers=Customer::all()->sortBy('display_name');
        $loans=LoanRequest::all()->sortByDesc('id');
        // Query Invoices by Company and Tab
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        // Apply Filters and Paginate
        if(isset($request->customer) && !empty($request->customer))
        {
            $cust=$request->customer;
            $query->whereHas('loans',function($q) use ($cust){
                $q->where('customer_id',$cust);
            });
        }
        if(isset($request->from_date) && !empty($request->from_date))
        {
            $query->where('payment_date','>=',$request->from_date);
        }
        if(isset($request->to_date) && !empty($request->to_date))
        {
            $query->where('payment_date','<=',$request->to_date);
        }
        if(isset($request->loan) && !empty($request->loan))
        {
            $query->where('loan_id','=',$request->loan);
        }
        $query->orderBy('id',"DESC");
        $payments = QueryBuilder::for($query)
            ->paginate()
            ->appends(request()->query());
        // echo '<pre>',print_r($payments);exit;
            return view('application.loan_payments.index', [
                'payments' => $payments,
                'payment_prefix'=>$payment_prefix,
                'currentCompany'=>$currentCompany,
                'customers'=>$customers,
                'loans'=>$loans,
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
            'payment_date'=>'required|date',
        ]);
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $data=$request->all();
        $data["company_id"]=$currentCompany->id;
        $data["loan_id"]=$request->loan_id;
        $payment=LoanPayment::create($data);
        $loan=LoanRequest::find($request->loan_id);
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        $paymentDetails=LoanPayment::where('loan_id',$request->loan_id)->sum('amount');
        if($paymentDetails){
           
           if($loan->amount-$paymentDetails==0)
           {
                $loan->status="Paid";
                $loan->save();
           }
        }
        // exit;
        return redirect()->route('loan.payments', ['company_uid' => $currentCompany->uid]);
    }
    public function detail(Request $request)
    {
        $payment=LoanPayment::find($request->payment);
        return view('application.loan_payments.details', [
            'payment' => $payment
        ]);
    }
    public function sendEmail(Request $request)
    {
        $payment=LoanPayment::find($request->payment);
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $payment_prefix = $currentCompany->getSetting('payment_prefix');
        $path=public_path('uploads/receipts/'. $payment_prefix.'-'.$payment->payment_number.''.Str::random(5).'.pdf');
        // echo $payment->loan->customer->email;exit;
        try {
            Mail::to($payment->loan->customer->email)->send(new PaymentToCustomer($payment,$path));
            File::delete($path);
            session()->flash('alert-success', __('messages.payment_added'));
        } catch (\Throwable $th) {
            session()->flash('alert-danger','Payment Created Successfully '. __('messages.email_could_not_sent').' '. $th->getMessage());
        }
        File::delete($path);
        return redirect()->route('loan.payments', ['company_uid' => $currentCompany->uid]);
    }
}

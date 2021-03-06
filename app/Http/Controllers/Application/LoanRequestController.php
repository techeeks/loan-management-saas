<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Mails\InvoiceToCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Mails\LoanToCustomer;
use App\Models\Customer;
use App\Models\LoanRequest;
use Illuminate\Support\Str;


class LoanRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $query=LoanRequest::query();
        $customers=Customer::all();
        $query->where('company_id',$currentCompany->id);
        if(isset($request->customer) && !empty($request->customer))
        {
            $query->where('customer_id',$request->customer);
        }
        if(isset($request->from_date) && !empty($request->from_date))
        {
            $query->where('loan_date','>=',$request->from_date);
        }
        if(isset($request->to_date) && !empty($request->to_date))
        {
            $query->where('loan_date','<=',$request->to_date);
        }
        if(isset($request->status) && !empty($request->status))
        {
            $query->where('status','=',$request->status);
        }
        $query->orderBy('id',"DESC");
        $loans = QueryBuilder::for($query)
            ->paginate()
            ->appends(request()->query());
            return view('application.loan_requests.index', [
                'loans' => $loans,
                'customers'=>$customers,
        ]);
    }

    public function add(Request $request)
    {
        $user = $request->user();  
        $currentCompany = $user->currentCompany(); 
        $customers=  $currentCompany->customers;
        return view('application.loan_requests.add',compact('customers'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();  
        $currentCompany = $user->currentCompany();

        $loan = LoanRequest::findOrFail($request->id);
        $customers=  $currentCompany->customers;
        return view('application.loan_requests.edit',compact('customers','loan'));
    }
    public function update(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $request->validate([
            'customer_id' => 'required',
            'currency_id' => 'required',
            'amount'=>'required|numeric',
            'loan_date'=>'required|date',
            'return_date'=>'required|date|after:loan_date',
            'status'=>'required',
            'description'=>'required'
        ]);
        $data=$request->all();
        $loan=LoanRequest::find($request->id);
        $loan->update($data);
        session()->flash('alert-success', __('messages.loan_updated'));
        return redirect()->route('loan.requests', ['company_uid' => $currentCompany->uid]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'currency_id' => 'required',
            'amount'=>'required|numeric',
            'loan_date'=>'required|date',
            'return_date'=>'required|date|after:loan_date',
            'description'=>'required'
        ]);
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $data=$request->all();
        $data["company_id"]=$currentCompany->id;
        $data["status"]="Pending";
        $loan=LoanRequest::create($data);
        session()->flash('alert-success', __('messages.loan_added'));
        return redirect()->route('loan.requests', ['company_uid' => $currentCompany->uid]);
    }
    public function delete(Request $request)
    {
        $loan=LoanRequest::where('id',$request->id)->delete();
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        session()->flash('alert-success', __('messages.loan_deleted'));
        return redirect()->route('loan.requests', ['company_uid' => $currentCompany->uid]);
    }
    public function detail(Request $request)
    {
        echo $request->loan;
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $loan=LoanRequest::find($request->loan); 
        return view('application.loan_requests.detail',compact('loan'));
    }
    public function sentEmail(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $loan=LoanRequest::find($request->loan); 
        $path=public_path('uploads/receipts/'.$loan->reference_number.''.Str::random(5).'.pdf');
        try {
            Mail::to($loan->customer->email)->send(new LoanToCustomer($loan,$path));
            session()->flash('alert-success', "Email Sent Successfully");
        } catch (\Throwable $th) {
            
            session()->flash('alert-danger',__('messages.email_could_not_sent').' '. $th->getMessage());
        }
        unlink($path);
        return redirect()->route('loan.requests', ['company_uid' => $currentCompany->uid]);
    }
}

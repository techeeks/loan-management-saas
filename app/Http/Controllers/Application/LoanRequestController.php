<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Mails\InvoiceToCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Customer;
use App\Models\LoanRequest;


class LoanRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        $query=LoanRequest::findByCompany($currentCompany->id)->orderBy('id','DESC');
        // Query Invoices by Company and Tab

        // Apply Filters and Paginate
        $loans = QueryBuilder::for($query)
            ->paginate()
            ->appends(request()->query());
            return view('application.loan_requests.index', [
                'loans' => $loans,
        ]);
    }
    public function add()
    {
        $customers=Customer::all()->sortByDesc('id');
        return view('application.loan_requests.add',compact('customers'));
    }
    public function edit(Request $request)
    {
        $user = $request->user();

        $currentCompany = $user->currentCompany();
        $loan=LoanRequest::findOrFail($request->id);
        $customers=Customer::all()->sortByDesc('id');
        // echo '<pre>',print_r($loan);exit;
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
}

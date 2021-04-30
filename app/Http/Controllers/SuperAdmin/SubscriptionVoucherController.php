<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\SubscriptionVoucher;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;
use App\Models\Company;

class SubscriptionVoucherController extends Controller
{
    public function index()
    {
        $vouchers = QueryBuilder::for(SubscriptionVoucher::class)
            ->oldest()
            ->paginate()
            ->appends(request()->query());
        return view('super_admin.vouchers.index', [
            'vouchers' => $vouchers,
        ]);
    }
    public function add()
    {
        $companies=Company::all();
        $plans= Plan::all();
        $voucher = new SubscriptionVoucher();
        return view('super_admin.vouchers.create', [
            'voucher' => $voucher,
            'companies'=>$companies,
            'plans'=>$plans,
        ]); 
    }
    public function store(Request $request)
    {
        $tid=Str::of(bin2hex(random_bytes(3)))->upper();
        // $request->voucher_code=$tid;
        $request->validate([
            'company_id'=>'required',
            // 'voucher_code'=>'required|unique:subscription_vouchers,voucher_code',
            'transcation_id'=>'required|unique:subscription_vouchers,transcation_id',
            'plan_id'=>'required',
        ]);
        $data=$request->all();
        $data["voucher_code"]=$tid;
        $voucher=SubscriptionVoucher::create($data);
        session()->flash('alert-success', __('messages.voucher_created'));
        return redirect()->route('super_admin.vouchers');
    }
    public function edit($voucher)
    {
        $voucher=SubscriptionVoucher::find($voucher);
        $companies=Company::all();
        $plans= Plan::all();
        return view('super_admin.vouchers.edit', [
            'voucher' => $voucher,
            'companies'=>$companies,
            'plans'=>$plans,
        ]); 
    }
    public function update(Request $request,$voucher)
    {
        $request->validate([
            'company_id'=>'required',
            'transcation_id'=>'required|unique:subscription_vouchers,transcation_id,'.$voucher,
            'plan_id'=>'required',
        ]);
        $data=$request->all();
        $voucher=SubscriptionVoucher::find($voucher);
        $update=$voucher->update($data);
        session()->flash('alert-success', __('messages.voucher_updated'));
        return redirect()->route('super_admin.vouchers');
    }
    public function delete($voucher)
    {
        $voucher=SubscriptionVoucher::find($voucher);
        $voucher->delete();
        session()->flash('alert-success', __('messages.voucher_deleted'));
        return redirect()->route('super_admin.vouchers');
    }
}
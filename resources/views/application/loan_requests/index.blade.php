@extends('layouts.app', ['page' => 'Loans'])

@section('title', __('messages.loans'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.loans') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.loans') }}</h1>
        </div>
        <a href="{{ route('loan.requests.create', ['company_uid' => $currentCompany->uid]) }}" class="btn btn-success ml-3">
            <i class="material-icons">add</i> 
            {{ __('messages.create_loan_request') }}
        </a>
    </div>
@endsection

@section('content')
<form name="LoanRequestForm" id="LoanRequestForm" action="{{ route('loan.requests', ['company_uid' => $currentCompany->uid]) }}" method="GET">
    @include('layouts._form_errors')
   
    
    <div class="card card-form">
        <div class="row no-gutters card-form__body card-body bg-white">
            <div class="col-md-4 pr-4 pl-4">
                <div class="form-group">
                    <label for="customer_id">{{ __('messages.customer') }}</label>
                    <select  name="customer" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="customer" required>
                        <option disabled selected>{{ __('messages.select_customer') }}</option>
                        
                        @foreach($customers as $customer)
                            <option {{ Request::has('customer') && $customer->id==Request::get('customer')?'selected':'' }} value="{{ $customer->id }}">{{ $customer->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4 pl-4">
                <div class="form-group">
                    <label for="from_date">{{ __('messages.from_date') }}</label>
                    <input name="from_date" type="text" class="form-control input" data-toggle="flatpickr" data-flatpickr-default-date="{{  Request::get('from_date') }}"  required>
                </div>
            </div>
            <div class="col-md-4 pl-4">
                <div class="form-group">
                    <label for="to_date">{{ __('messages.to_date') }}</label>
                    <input name="to_date" type="text" class="form-control input"  data-toggle="flatpickr" data-flatpickr-default-date="{{  Request::get('to_date') }}"  required>
                </div>
            </div>
            <div class="col-md-4 pr-4 pl-4">
                <div class="form-group">
                    <label for="status">{{ __('messages.status') }}</label>
                    <select  name="status" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="status" required>
                        <option disabled selected>{{ __('messages.status') }}</option>
                            <option {{  "Pending"==Request::get('status')?'selected':'' }} value="Pending">Pending</option>
                            <option {{ "Overdue"==Request::get('status')?'selected':'' }} value="Overdue">Overdue</option>
                            <option {{  "Paid"==Request::get('status')?'selected':'' }} value="Paid">Paid</option>
                    </select>
                </div>
            </div>
    
            <div class="col-12 text-center float-right mt-3">
                <button type="submit" class="btn btn-primary save_form_button">{{ __('messages.search') }}</button>
                <a href="{{route('loan.requests', ['company_uid' => $currentCompany->uid]) }}" class="btn btn-danger">{{ __('messages.reset_filters') }}</a>
            </div>
        </div>
    </div>
    
</form>
    <div class="card">
       
        @if($loans->count() > 0)
    <div class="table-responsive">
        <table class="table table-xl mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th>{{ __('messages.reference_number') }}</th>
                    <th>{{ __('messages.customer') }}</th>
                   
                    <th>{{ __('messages.amount') }}</th>
                    <th>{{ __('messages.amount_paid') }}</th>
                    <th>{{ __('messages.balance') }}</th>
                    <th>{{ __('messages.loan_date') }}</th>
                    <th>{{ __('messages.return_date') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th class="w-50px">{{ __('messages.view') }}</th>
                </tr>
            </thead>
            <tbody class="list" id="loans">
                @foreach ($loans as $loan)
                    <tr>
                        <td>
                            {{ $loan->reference_number }}
                        </td>
                        <td>
                            {{ $loan->customer->display_name}}
                        </td>
                       
                        <td>
                            {{ currencyFormat($loan->amount, $loan->currency->symbol) }}
                        </td>
                        <td>
                            {{ currencyFormat($loan->totalPaid($loan->id), $loan->currency->symbol)}}
                        </td>
                        <td>
                            {{ currencyFormat($loan->amount-$loan->totalPaid($loan->id), $loan->currency->symbol)}}
                        </td>
                        <td>
                            {{ $loan->loan_date}}
                        </td>
                        <td>
                            {{ $loan->return_date}}
                        </td>
                        <td>
                            @if($loan->status!="Overdue" && $loan->status!="Paid")
                                @if(strtotime(date('Y-m-d'))>strtotime($loan->return_date))
                                    @php 
                                        $loan->overdue();
                                        $loan->status="Overdue";
                                    @endphp
                                @endif
                            @endif
                            @if($loan->status == 'Pending')
                            <div class="badge badge-warning fs-0-9rem">
                                {{ $loan->status }}
                            </div>
                            @elseif($loan->status == 'Overdue')
                            <div class="badge badge-danger fs-0-9rem">
                                {{ $loan->status }}
                            </div>
                            @elseif($loan->status == 'Paid')
                            <div class="badge badge-success fs-0-9rem">
                                {{ $loan->status }}
                            </div>
                            @endif
                        </td>
                        <td class="h6  d-inline-flex">
                           
                          
                            <a href="{{ route('loan.requests.details', ['loan' => $loan->id,'company_uid' => $currentCompany->uid]) }}" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a>
                            
                            @if($loan->status!="Paid")
                            
                            <a href="{{ route('loan.requests.edit', ['id' => $loan->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">edit</i>
                            </a>
                            <a href="{{ route('loan.requests.delete', ['id' => $loan->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">delete</i>
                            </a>
                            <a href="{{ route('loan.payments.create', ['loan_id' => $loan->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">payment</i>
                            </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $loans->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">description</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">No Record Found</p>
    </div>
@endif
    </div>
@endsection

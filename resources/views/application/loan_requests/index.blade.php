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

    <div class="card">
       
        @if($loans->count() > 0)
    <div class="table-responsive">
        <table class="table table-xl mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th>{{ __('messages.reference_number') }}</th>
                    <th>{{ __('messages.customer') }}</th>
                   
                    <th>{{ __('messages.amount') }}</th>
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
                            {{ $loan->loan_date}}
                        </td>
                        <td>
                            {{ $loan->return_date}}
                        </td>
                        <td>
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
                            <a href="{{ route('loan.requests.edit', ['id' => $loan->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">edit</i>
                            </a>
                            <a href="{{ route('loan.requests.delete', ['id' => $loan->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">delete</i>
                            </a>
                            @if($loan->status!="Paid")
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

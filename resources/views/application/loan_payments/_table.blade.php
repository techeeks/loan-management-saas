@if($payments->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th>{{ __('messages.payment_#') }}</th>
                    <th>{{ __('messages.reference_number') }}</th>
                    <th>{{ __('messages.date') }}</th>
                    <th>{{ __('messages.payment_type') }}</th>
                    <th>{{ __('messages.amount') }}</th>
                </tr>
            </thead>
            <tbody class="list" id="payments">
                @foreach ($payments as $payment)
                    <tr>
                        <td>
                            {{ $payment_prefix.'-'.$payment->payment_number }}
                        </td>
                        <td>
                            {{ $payment->loan->reference_number }}
                        </td>
                        <td>
                            {{ $payment->payment_date }}
                        </td>
                        <td>
                            {{ $payment->payment_method->name ?? "-"}}
                        </td>
                        <td>
                            {{ currencyFormat($payment->amount, $payment->loan->currency->symbol) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $payments->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">payment</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">{{ __('messages.no_payments_yet') }}</p>
    </div>
@endif
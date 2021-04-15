<div class="table-responsive mb-4" data-toggle="gateways">
    <table class="table table-xl mb-0 thead-border-top-0 table-striped">
        <thead>
            <tr>
                <th>{{ __('messages.name') }}</th> 
                <th>{{ __('messages.status') }}</th> 
                <th class="text-right">{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody class="list" id="gateways">
            <tr>
                <td class="h6">
                    <a href="{{ route('settings.payment.gateway.edit', ['company_uid' => $currentCompany->uid, 'gateway' => 'paypal']) }}">
                        <strong class="h6">
                            {{ __('messages.paypal') }}
                        </strong>
                    </a>
                </td>
                <td class="h6">
                    <div class="badge badge-danger fs-0-9-rem">
                        {{ __('messages.disabled') }}
                    </div>
                </td>
                <td class="h6 text-right">
                    <a href="{{ route('settings.payment.gateway.edit', ['company_uid' => $currentCompany->uid, 'gateway' => 'paypal']) }}" class="btn text-primary">
                        <i class="material-icons icon-16pt">edit</i>
                        {{ __('messages.edit') }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="h6">
                    <a href="{{ route('settings.payment.gateway.edit', ['company_uid' => $currentCompany->uid, 'gateway' => 'stripe']) }}">
                        <strong class="h6">
                            {{ __('messages.stripe') }}
                        </strong>
                    </a>
                </td>
                <td class="h6">
                    <div class="badge badge-danger fs-0-9-rem">
                        {{ __('messages.disabled') }}
                    </div>
                </td>
                <td class="h6 text-right">
                    <a href="{{ route('settings.payment.gateway.edit', ['company_uid' => $currentCompany->uid, 'gateway' => 'stripe']) }}" class="btn text-primary">
                        <i class="material-icons icon-16pt">edit</i>
                        {{ __('messages.edit') }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="h6">
                    <a href="{{ route('settings.payment.gateway.edit', ['company_uid' => $currentCompany->uid, 'gateway' => 'razorpay']) }}">
                        <strong class="h6">
                            {{ __('messages.razorpay') }}
                        </strong>
                    </a>
                </td>
                <td class="h6">
                    <div class="badge badge-danger fs-0-9-rem">
                        {{ __('messages.disabled') }}
                    </div>
                </td>
                <td class="h6 text-right">
                    <a href="{{ route('settings.payment.gateway.edit', ['company_uid' => $currentCompany->uid, 'gateway' => 'razorpay']) }}" class="btn text-primary">
                        <i class="material-icons icon-16pt">edit</i>
                        {{ __('messages.edit') }}
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
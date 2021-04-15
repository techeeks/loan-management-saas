@if($plans->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th class="w-30px" class="text-center">{{ __('messages.#id') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.invoice_interval') }}</th>
                    <th>{{ __('messages.trial_period') }}</th>
                    <th class="text-center width: 120px;">{{ __('messages.created_at') }}</th>
                    <th class="w-50px">{{ __('messages.edit') }}</th>
                </tr> 
            </thead>
            <tbody class="list" id="plans">
                @foreach ($plans as $plan)
                    <tr>
                        <td>
                            <a href="{{ route('super_admin.plans.edit', $plan->id) }}" class="badge">#{{ $plan->id }}</a>
                        </td>
                        <td> 
                            <a href="{{ route('super_admin.plans.edit', $plan->id) }}" class="mb-0">{{ $plan->name }}</a>
                        </td>
                        <td> 
                            <p class="mb-0">{{ money($plan->price, $plan->currency) }}</p>
                        </td>
                        <td>
                            <p class="mb-0 text-uppercase">{{ __('messages.'.$plan->invoice_interval) }}</p>
                        </td>
                        <td>
                            <p class="mb-0">{{ $plan->trial_period }} {{ __('messages.days') }}</p>
                        </td>
                        <td class="text-center"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> {{ $plan->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('super_admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $plans->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">account_box</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">{{ __('messages.no_plans_yet') }}</p>
    </div>
@endif
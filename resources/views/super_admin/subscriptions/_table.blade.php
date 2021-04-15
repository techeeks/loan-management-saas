@if($subscriptions->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th class="w-30px" class="text-center">{{ __('messages.#id') }}</th>
                    <th>{{ __('messages.company') }}</th>
                    <th>{{ __('messages.owner') }}</th>
                    <th>{{ __('messages.plan') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th class="text-center">{{ __('messages.subscribed_at') }}</th>
                    <th class="text-right">{{ __('messages.cancel_subscription') }}</th>
                </tr> 
            </thead> 
            <tbody class="list" id="subscriptions">
                @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>
                            <div class="badge">#{{ $subscription->id }}</div>
                        </td>
                        <td> 
                            <p class="mb-0">{{ $subscription->company->name }}</p>
                        </td>
                        <td> 
                            <a class="mb-0" href="{{ route('super_admin.users.edit', $subscription->company->owner->id) }}">{{ $subscription->company->owner->full_name }}</a>
                        </td>
                        <td>
                            <a class="mb-0" href="{{ route('super_admin.plans.edit', $subscription->plan->id) }}">{{ $subscription->plan->name }}</a>
                        </td>
                        <td>
                            {!! $subscription->html_status !!}
                        </td>
                        <td class="text-center"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> {{ $subscription->created_at->format('Y-m-d') }}</td>
                        <td class="text-right"><a href="{{ route('super_admin.subscriptions.cancel', $subscription->id) }}" class="btn btn-sm btn-link delete-confirm"><i class="material-icons icon-16pt">close</i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $subscriptions->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">account_box</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">{{ __('messages.no_subscriptions_yet') }}</p>
    </div>
@endif
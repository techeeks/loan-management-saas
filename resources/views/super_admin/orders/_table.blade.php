@if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th class="w-30px" class="text-center">{{ __('messages.order_id') }}</th>
                    <th>{{ __('messages.transaction_id') }}</th>
                    <th>{{ __('messages.user') }}</th>
                    <th>{{ __('messages.plan') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.payment_type') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                </tr> 
            </thead> 
            <tbody class="list" id="orders">
                @foreach ($orders as $order)
                    <tr>
                        <td>
                            <p class="mb-0">{{ $order->order_id }}</p>
                        </td>
                        <td>
                            <p class="mb-0">{{ $order->transaction_id }}</p>
                        </td>
                        <td>
                            @if($order->company)
                                <a class="mb-0" href="{{ route('super_admin.users.edit', $order->company->owner->id) }}">{{ $order->company->owner->full_name }}</a>
                            @else
                                <a class="mb-0">-</a>
                            @endif
                        </td>
                        <td>
                            @if($order->plan)
                                <a class="mb-0" href="{{ route('super_admin.plans.edit', $order->plan->id) }}">{{ $order->plan->name ?? '-' }}</a>
                            @else
                                <a class="mb-0">-</a>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0">{{ money($order->price, $order->currency) }}</p>
                        </td>
                        <td>
                            {{ $order->payment_type }} 
                        </td>
                        <td class="text-center"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> {{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(method_exists($orders, 'links'))
        <div class="row card-body pagination-light justify-content-center text-center">
            {{ $orders->links() }}
        </div>
    @endif
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">account_box</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">{{ __('messages.no_orders_yet') }}</p>
    </div>
@endif
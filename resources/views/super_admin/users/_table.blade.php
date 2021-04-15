@if($users->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th class="w-30px" class="text-center">{{ __('messages.#id') }}</th>
                    <th>{{ __('messages.company') }}</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.subscribed_to') }}</th>
                    <th>{{ __('messages.role') }}</th>
                    <th class="text-center width: 120px;">{{ __('messages.created_at') }}</th>
                    <th class="w-50px">{{ __('messages.edit') }}</th>
                </tr> 
            </thead>
            <tbody class="list" id="users">
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="badge">#{{ $user->id }}</div>
                        </td>
                        <td> 
                            <p class="mb-0">{{ $user->currentCompany()->name }}</p>
                        </td>
                        <td>
                            <p class="mb-0">{{ $user->full_name }}</p>
                        </td>
                        <td>
                            <p class="mb-0">{{ $user->email }}</p>
                        </td>
                        <td>
                            @if($user->currentSubscriptionPlan())
                                <a class="mb-0" href="{{ route('super_admin.plans.edit', $user->currentSubscriptionPlan()->id) }}">{{ $user->currentSubscriptionPlan()->name }}</a>
                            @else
                                <a class="mb-0">-</a>
                            @endif
                        </td>
                        <td>
                            @if($user->hasRole('super_admin'))
                                <p class="mb-0">{{ __('messages.super_admin') }}</p>
                            @elseif($user->hasRole('admin'))
                                <p class="mb-0">{{ __('messages.admin') }}</p>
                            @elseif($user->hasRole('staff'))
                                <p class="mb-0">{{ __('messages.staff') }}</p>
                            @endif
                        </td>
                        <td class="text-center"><i class="material-icons icon-16pt text-muted-light mr-1">today</i> {{ $user->created_at->format('Y-m-d') }}</td>
                        <td><a href="{{ route('super_admin.users.edit', $user->id) }}" class="btn btn-sm btn-link"><i class="material-icons icon-16pt">arrow_forward</i></a> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $users->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">account_box</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">{{ __('messages.no_users_yet') }}</p>
    </div>
@endif
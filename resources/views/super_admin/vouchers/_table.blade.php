@if($vouchers->count() > 0)
    <div class="table-responsive">
        <table class="table mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th>{{ __('messages.voucher_name') }}</th>
                    <th>{{ __('messages.plan') }}</th>
                    <th>{{ __('messages.voucher_code') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th class="w-50px">Action</th>
                </tr> 
            </thead>
            <tbody class="list" id="vouchers">
                @foreach ($vouchers as $voucher)
                    <tr>
                        <td> 
                            {{$voucher->voucher_name}}
                        </td>
                        <td> 
                            {{$voucher->plan->name}}
                        </td>
                        
                        <td>
                            {{$voucher->voucher_code}}
                        </td>
                        <td>
                            @if($voucher->status == 'New')
                            <div class="badge badge-success fs-0-9rem">
                                {{ $voucher->status }}
                            </div>
                     
                        @else
                            <div class="badge badge-danger fs-0-9rem">
                                {{ $voucher->status }}
                            </div>
                        @endif
                        </td>
                        <td class="d-inline-flex">
                            <a href="{{ route('super_admin.vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">edit</i>
                            </a>
                            <a href="{{ route('super_admin.vouchers.delete', $voucher->id) }}" class="btn btn-sm btn-link">
                                <i class="material-icons icon-16pt">delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $vouchers->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">database</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">No Record Found</p>
    </div>
@endif
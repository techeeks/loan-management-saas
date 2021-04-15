@if($custom_fields->count() > 0)
    <div class="table-responsive" data-toggle="lists">
        <table class="table table-xl mb-0 thead-border-top-0 table-striped">
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th> 
                    <th>{{ __('messages.label') }}</th>
                    <th>{{ __('messages.model') }}</th>
                    <th>{{ __('messages.type') }}</th>
                    <th>{{ __('messages.required') }}</th>
                    <th class="w-30">{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody class="list" id="custom_fields">
                @foreach($custom_fields as $custom_field)
                    <tr>
                        <td class="h6">
                            <a href="{{ route('settings.custom_fields.edit', ['custom_field' => $custom_field->id, 'company_uid' => $currentCompany->uid]) }}">
                                <strong class="h6">
                                    {{ $custom_field->name }}
                                </strong>
                            </a>
                        </td>
                        <td class="h6">
                            {{ $custom_field->label }}
                        </td>
                        <td class="h6">
                            {{ __('messages.'.strtolower(str_replace("App\Models\\", "", $custom_field->model_type))) }}
                        </td>
                        <td class="h6">
                            {{ $custom_field->type }}
                        </td>
                        <td class="h6">
                            {{ $custom_field->is_required ? __('messages.yes') : __('messages.no') }}
                        </td>
                        <td class="h6">
                            <a href="{{ route('settings.custom_fields.edit', ['custom_field' => $custom_field->id, 'company_uid' => $currentCompany->uid]) }}" class="btn text-primary">
                                <i class="material-icons icon-16pt">edit</i>
                                {{ __('messages.edit') }}
                            </a>
                            <a href="{{ route('settings.custom_fields.delete', ['custom_field' => $custom_field->id, 'company_uid' => $currentCompany->uid]) }}" class="btn text-danger delete-confirm">
                                <i class="material-icons icon-16pt">delete</i>
                                {{ __('messages.delete') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row card-body pagination-light justify-content-center text-center">
        {{ $custom_fields->links() }}
    </div>
@else
    <div class="row justify-content-center card-body pb-0 pt-5">
        <i class="material-icons fs-64px">text_fields</i>
    </div>
    <div class="row justify-content-center card-body pb-5">
        <p class="h4">{{ __('messages.no_custom_fields_yet') }}</p>
    </div>
@endif
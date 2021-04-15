@if($custom_field->type === 'Input')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="text" class="form-control" value="{{ $model->getCustomFieldValue($custom_field->id) }}" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@elseif($custom_field->type === 'TextArea')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <textarea name="custom_fields[{{$custom_field->uid}}]" class="form-control" placeholder="{{ $custom_field->placeholder }}">{{ $model->getCustomFieldValue($custom_field->id) }}</textarea>
        </div>
    </div>
@elseif($custom_field->type === 'Phone')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="tel" class="form-control" value="{{ $model->getCustomFieldValue($custom_field->id) }}" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@elseif($custom_field->type === 'Url')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="url" class="form-control" value="{{ $model->getCustomFieldValue($custom_field->id) }}" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@elseif($custom_field->type === 'Number')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="number" class="form-control" value="{{ $model->getCustomFieldValue($custom_field->id) }}" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@elseif($custom_field->type === 'Dropdown')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <select id="custom_fields[{{$custom_field->uid}}]" name="custom_fields[{{$custom_field->uid}}]" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="custom_fields[{{$custom_field->uid}}]">
                <option selected value="null">{{ __('messages.please_select') }}</option>
                @if(is_array($custom_field->options))
                    @foreach($custom_field->options as $option)
                        <option value="{{ $option }}" {{ $model->getCustomFieldValue($custom_field->id) === $option ? 'selected=""' : '' }}>{{ $option }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
@elseif($custom_field->type === 'Switch')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="checkbox" class="form-control" {{ $model->getCustomFieldValue($custom_field->id) ? 'checked=""' : '' }}>
        </div>
    </div>
@elseif($custom_field->type === 'Date')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="text" class="form-control" data-toggle="flatpickr" data-flatpickr-default-date="{{ $model->getCustomFieldValue($custom_field->id) }}" data-flatpickr-date-format="Y-m-d" data-flatpickr-alt-format="Y-m-d" readonly="readonly" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@elseif($custom_field->type === 'Time')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="text" class="form-control" data-toggle="flatpickr" data-flatpickr-default-date="{{ $model->getCustomFieldValue($custom_field->id) }}" data-flatpickr-date-format="H:i" data-flatpickr-alt-format="H:i" data-flatpickr-no-calendar="true" data-flatpickr-enable-time="true" readonly="readonly" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@elseif($custom_field->type === 'DateTime')
    <div class="col-12">
        <div class="form-group">
            <label for="custom_fields[{{$custom_field->uid}}]">{{ $custom_field->label }}</label>
            <input name="custom_fields[{{$custom_field->uid}}]" type="text" class="form-control" data-toggle="flatpickr" data-flatpickr-default-date="{{ $model->getCustomFieldValue($custom_field->id) }}" data-flatpickr-date-format="Y-m-d H:i" data-flatpickr-alt-format="Y-m-d H:i" data-flatpickr-enable-time="true" readonly="readonly" placeholder="{{ $custom_field->placeholder }}">
        </div>
    </div>
@endif
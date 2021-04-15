<div class="row">
    <div class="col">
        <div class="form-group required">
            <label for="name">{{ __('messages.name') }}</label>
            <input name="name" type="text" class="form-control" placeholder="{{ __('messages.name') }}" value="{{ $custom_field->name }}" required>
        </div>
    </div>
    <div class="col">
        <div class="form-group required">
            <label for="label">{{ __('messages.label') }}</label>
            <input name="label" type="text" class="form-control" placeholder="{{ __('messages.label') }}" value="{{ $custom_field->label }}" required>
        </div>
    </div>
</div>
 
<div class="row">
    <div class="col">
        <div class="form-group required">
            <label for="model_type">{{ __('messages.model') }}</label>
            <select name="model_type"  class="form-control" required>
                <option value="App\Models\Customer" {{ $custom_field->model_type === "App\Models\Customer" ? 'selected=""' : ''}}>{{ __('messages.customer') }}</option>
                <option value="App\Models\Invoice"  {{ $custom_field->model_type === "App\Models\Invoice" ? 'selected=""' : ''}}>{{ __('messages.invoice') }}</option>
                <option value="App\Models\Estimate" {{ $custom_field->model_type === "App\Models\Estimate" ? 'selected=""' : ''}}>{{ __('messages.estimate') }}</option>
                <option value="App\Models\Payment"  {{ $custom_field->model_type === "App\Models\Payment" ? 'selected=""' : ''}}>{{ __('messages.payment') }}</option>
                <option value="App\Models\Expense"  {{ $custom_field->model_type === "App\Models\Expense" ? 'selected=""' : ''}}>{{ __('messages.expense') }}</option>
                <option value="App\Models\Product"  {{ $custom_field->model_type === "App\Models\Product" ? 'selected=""' : ''}}>{{ __('messages.product') }}</option>
                <option value="App\Models\Vendor"  {{ $custom_field->model_type === "App\Models\Vendor" ? 'selected=""' : ''}}>{{ __('messages.vendor') }}</option>
            </select>
        </div>
    </div> 
    <div class="col">
        <div class="form-group required">
            <label for="is_required">{{ __('messages.required') }}</label>
            <select name="is_required"  class="form-control" required>
                <option value="0" {{ !$custom_field->is_required ? 'selected=""' : ''}}>{{ __('messages.no') }}</option>
                <option value="1" {{ $custom_field->is_required ? 'selected=""' : ''}}>{{ __('messages.yes') }}</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group required">
            <label for="type">{{ __('messages.type') }}</label>
            <select id="customFieldType" name="type" class="form-control" required>
                <option value="Input"    {{ $custom_field->type === "Input" ? 'selected=""' : ''}}>{{ __('messages.text') }}</option>
                <option value="TextArea" {{ $custom_field->type === "TextArea" ? 'selected=""' : ''}}>{{ __('messages.textarea') }}</option>
                <option value="Phone"    {{ $custom_field->type === "Phone" ? 'selected=""' : ''}}>{{ __('messages.phone') }}</option>
                <option value="Url"      {{ $custom_field->type === "Url" ? 'selected=""' : ''}}>{{ __('messages.url') }}</option>
                <option value="Number"   {{ $custom_field->type === "Number" ? 'selected=""' : ''}}>{{ __('messages.number') }}</option>
                <option value="Dropdown" {{ $custom_field->type === "Dropdown" ? 'selected=""' : ''}}>{{ __('messages.select') }}</option>
                <option value="Switch"   {{ $custom_field->type === "Switch" ? 'selected=""' : ''}}>{{ __('messages.checkbox') }}</option>
                <option value="Date"     {{ $custom_field->type === "Date" ? 'selected=""' : ''}}>{{ __('messages.date') }}</option>
                <option value="Time"     {{ $custom_field->type === "Time" ? 'selected=""' : ''}}>{{ __('messages.time') }}</option>
                <option value="DateTime" {{ $custom_field->type === "DateTime" ? 'selected=""' : ''}}>{{ __('messages.datetime') }}</option>
            </select>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label for="default_value">{{ __('messages.default_value') }}</label>
            <input id="defaultValueInput" name="default_value" type="text" class="form-control" placeholder="{{ __('messages.default_value') }}" value="{{ $custom_field->default_value }}">
        </div>
    </div>
</div>

<div class="row options-container" style="display: none">
    @if(is_array($custom_field->options))
        @foreach ($custom_field->options as $option)
            <div class="option-row col-12">
                <div class="input-group mb-3">
                    <input type="text" name="options[]" class="form-control m-input" value="{{ $option }}" autocomplete="off">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger removeOption">x</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <div class="col-12">
        <div class="form-group">
            <button id="addOption" type="button" class="btn btn-info">{{ __('messages.add_option') }}</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            <label for="placeholder">{{ __('messages.placeholder') }}</label>
            <input name="placeholder" type="text" class="form-control" placeholder="{{ __('messages.placeholder') }}" value="{{ $custom_field->placeholder }}">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="order">{{ __('messages.order') }}</label>
            <input name="order" type="number" class="form-control" placeholder="{{ __('messages.order') }}" value="{{ $custom_field->order }}">
        </div>
    </div>
</div>
 
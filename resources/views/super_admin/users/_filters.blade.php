<form action="" method="GET">
    <div class="card card-form d-flex flex-column flex-sm-row">
        <div class="card-form__body card-body-form-group flex">
            <div class="row">
                <div class="col-sm-auto">
                    <div class="form-group">
                        <label for="filter[first_name]">{{ __('messages.first_name') }}</label>
                        <input name="filter[first_name]" type="text" class="form-control" value="{{ isset(Request::get("filter")['first_name']) ? Request::get("filter")['first_name'] : '' }}" placeholder="{{ __('messages.search') }}">
                    </div>
                </div>
                <div class="col-sm-auto">
                    <div class="form-group">
                        <label for="filter[email]">{{ __('messages.email') }}</label>
                        <input name="filter[email]" type="text" class="form-control" value="{{ isset(Request::get("filter")['email']) ? Request::get("filter")['email'] : '' }}" placeholder="{{ __('messages.search') }}">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('super_admin.users') }}">{{ __('messages.clear_filters') }}</a>
                </div>
            </div>
        </div>
        <button type="submit" class="btn bg-white border-left border-top border-top-sm-0 rounded-top-0 rounded-top-sm rounded-left-sm-0">
            <i class="material-icons text-primary icon-20pt">refresh</i>
            {{ __('messages.filter') }}
        </button>
    </div>
</form>
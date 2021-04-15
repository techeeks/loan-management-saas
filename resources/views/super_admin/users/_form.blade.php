<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.user_information') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>{{ __('messages.profile_image') }}</label><br>
                        <input id="avatar" name="avatar" class="d-none" type="file" onchange="changePreview(this);">
                        <label for="avatar">
                            <div class="media align-items-center">
                                <div class="mr-3">
                                    <div class="avatar avatar-xl">
                                        <img id="file-prev" src="{{ $user->avatar }}" class="avatar-img rounded">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <a class="btn btn-sm btn-light choose-button">{{ __('messages.choose_photo') }}</a>
                                </div>
                            </div>
                        </label> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="first_name">{{ __('messages.first_name') }}</label>
                        <input name="first_name" type="text" class="form-control" placeholder="{{ __('messages.first_name') }}" value="{{ $user->first_name }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group required">
                        <label for="last_name">{{ __('messages.last_name') }}</label>
                        <input name="last_name" type="text" class="form-control" placeholder="{{ __('messages.last_name') }}" value="{{ $user->last_name }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="email">{{ __('messages.email') }}</label>
                        <input name="email" type="email" class="form-control" placeholder="{{ __('messages.email') }}" value="{{ $user->email }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="phone">{{ __('messages.phone') }}</label>
                        <input name="phone" type="text" class="form-control" placeholder="{{ __('messages.phone') }}" value="{{ $user->phone }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group {{ $user->id == null ? 'required' : '' }}">
                        <label for="password">{{ __('messages.password') }}</label>
                        <input name="password" type="password" class="form-control" placeholder="{{ __('messages.password') }}" {{ $user->id == null ? 'required' : '' }}>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group {{ $user->id == null ? 'required' : '' }}">
                        <label for="password_confirmation">{{ __('messages.confirm_password') }}</label>
                        <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('messages.confirm_password') }}" {{ $user->id == null ? 'required' : '' }}>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="company_name">{{ __('messages.company_name') }}</label>
                        <input name="company_name" type="text" class="form-control" placeholder="{{ __('messages.company_name') }}" value="{{ isset($user->currentCompany()->name) ? $user->currentCompany()->name : '' }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="role">{{ __('messages.role') }}</label>
                        <select name="role"  class="form-control" required>
                            <option value="staff" {{ $user->hasRole('staff') ? 'selected=""' : ''}}>{{ __('messages.staff') }}</option>
                            <option value="admin" {{ $user->hasRole('admin') ? 'selected=""' : ''}}>{{ __('messages.admin') }}</option>
                            <option value="super_admin" {{ $user->hasRole('super_admin') ? 'selected=""' : ''}}>{{ __('messages.super_admin') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="plan_id">{{ __('messages.plans') }}</label> 
                        <select name="plan_id" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="plan_id">
                            <option selected value="">{{ __('messages.no_plan') }}</option>
                            @foreach(get_all_plans_available() as $option)
                                <option value="{{ $option['id'] }}" {{ $user->subscribedTo($option['id']) ? 'selected=""' : ''}}>{{ $option['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> 

            <div class="form-group text-center mt-5">
                <button type="submit" class="btn btn-primary">{{ __('messages.save_user') }}</button>
            </div>
        </div>
    </div>
</div>

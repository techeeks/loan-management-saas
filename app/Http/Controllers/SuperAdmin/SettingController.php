<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemSetting;

class SettingController extends Controller
{
    /**
     * Display Edit Application Settings Page
     *
     * @return \Illuminate\Http\Response
     */
    public function application()
    {
        return view('super_admin.settings.application');
    }

    /**
     * Update Application Settings
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function application_update(Request $request)
    {
        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.settings.application');
        };

        // Validate
        $request->validate([
            'application_name' => 'required|string|max:140',
            'application_currency' => 'required|string',
            'meta_description' => 'required|string|max:200',
            'meta_keywords' => 'required|string|max:200',
        ]);

        // Update settings
        SystemSetting::setSetting('application_name', $request->application_name);
        SystemSetting::setSetting('application_currency', $request->application_currency);
        SystemSetting::setSetting('meta_description', $request->meta_description);
        SystemSetting::setSetting('meta_keywords', $request->meta_keywords);

        // Update favicon
        if($request->favicon) {
            $request->validate(['favicon' => 'required|image|mimes:png,jpg|max:2048']);
            $path = $request->favicon->storeAs('favicons', 'favicon.'.$request->favicon->getClientOriginalExtension(), 'public_dir');
            SystemSetting::setSetting('application_favicon', '/uploads/'.$path);
        }

        // Update logo
        if ($request->logo) {
            $request->validate(['logo' => 'required|image|mimes:png,jpg|max:2048']);
            $path = $request->logo->storeAs('logo', 'logo.'.$request->logo->getClientOriginalExtension(), 'public_dir');
            SystemSetting::setSetting('application_logo', '/uploads/'.$path);
        }
 
        session()->flash('alert-success', __('messages.application_settings_updated'));
        return redirect()->route('super_admin.settings.application');
    }

    /**
     * Display Edit Mail Settings Page
     *
     * @return \Illuminate\Http\Response
     */
    public function mail()
    {
        return view('super_admin.settings.mail');
    }

    /**
     * Update Mail Settings
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function mail_update(Request $request)
    {
        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.settings.mail');
        };

        // Validate
        $request->validate([
            'mail_driver' => 'required|string|max:50',
            'mail_host' => 'required|string|max:50',
            'mail_port' => 'required|string|max:50',
            'mail_username' => 'nullable|string|max:50',
            'mail_password' => 'nullable|string|max:50',
            'mail_from_address' => 'required|string|max:50',
            'mail_from_name' => 'required|string|max:50',
            'mail_encryption' => 'required|string|max:50',
        ]);

        $env = [
            'MAIL_DRIVER' => $request->mail_driver,
            'MAIL_HOST' => $request->mail_host,
            'MAIL_PORT' => $request->mail_port,
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->mail_password,
            'MAIL_ENCRYPTION' => $request->mail_encryption,
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            'MAIL_FROM_NAME' => $request->mail_from_name,
        ]; 

        // Update settings
        if (SystemSetting::setEnvironmentValue($env)) {
            session()->flash('alert-success', __('messages.mail_settings_updated'));
        } else {
            session()->flash('alert-danger', __('messages.something_went_wrong'));
        }

        return redirect()->route('super_admin.settings.mail');
    }

    /**
     * Display Edit Payment Settings Page
     *
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        return view('super_admin.settings.payment');
    }

    /**
     * Update Payment Settings
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function payment_update(Request $request)
    {
        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.settings.payment');
        };

        // Validate
        $validated = $request->validate([
            'stripe_public_key' => 'nullable|string',
            'stripe_secret_key' => 'nullable|string',
            'stripe_test_mode' => 'nullable|boolean',
            'stripe_active' => 'nullable|boolean',
            'paypal_username' => 'nullable|string',
            'paypal_password' => 'nullable|string',
            'paypal_signature' => 'nullable|string',
            'paypal_test_mode' => 'nullable|boolean',
            'paypal_active' => 'nullable|boolean',
            'razorpay_id' => 'nullable|string',
            'razorpay_secret_key' => 'nullable|string',
            'razorpay_test_mode' => 'nullable|boolean',
            'razorpay_active' => 'nullable|boolean',
        ]);

        // Update each settings
        foreach ($validated as $key => $value) {
            if (!$value) continue;
            SystemSetting::setSetting($key, $value);
        }

        session()->flash('alert-success', __('messages.payment_settings_updated'));
        return redirect()->route('super_admin.settings.payment');
    }
}

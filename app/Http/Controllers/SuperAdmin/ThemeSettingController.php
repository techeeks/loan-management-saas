<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThemeSetting;

class ThemeSettingController extends Controller
{
    /**
     * Display Edit Theme Settings Page
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('themes.'.$request->theme.'.settings');
    }

    /**
     * Update Theme Settings
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $theme = $request->theme;

        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.settings.theme', $theme);
        };

        // Set settings
        foreach ($request->except('_token') as $key => $value) {
            ThemeSetting::setSetting($theme, $key, $value);
        }
 
        session()->flash('alert-success', __('messages.theme_settings_updated'));
        return redirect()->route('super_admin.settings.theme', $theme);
    }
}

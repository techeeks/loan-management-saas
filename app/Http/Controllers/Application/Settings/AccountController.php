<?php

namespace App\Http\Controllers\Application\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Settings\Account\Update;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display Account Settings Page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.settings.account.index');
    }

    /**
     * Update the Account of Current Authenticated User
     *
     * @param \App\Http\Requests\Application\Settings\Account\Update $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('settings.account', ['company_uid' => $currentCompany->uid]);
        };

        // Update User
        $validated = $request->validated();
        unset($validated['password']);
        $user->update($validated);

        // If Password fields are filled
        if ($request->old_password  && $request->new_password) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        // Upload and save avatar
        if ($request->avatar) {
            $request->validate(['avatar' => 'required|image|mimes:png,jpg|max:2048']);
            $path = $request->avatar->storeAs('avatars', 'avatar-'. $user->id .'.'.$request->avatar->getClientOriginalExtension(), 'public_dir');
            $user->setSetting('avatar', '/uploads/'.$path);
        }

        session()->flash('alert-success', __('messages.account_updated'));
        return redirect()->route('settings.account', ['company_uid' => $currentCompany->uid]);
    }
}

<?php

namespace App\Http\Controllers\Application\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Settings\Company\Update;
use App\Models\CompanySetting;

class CompanyController extends Controller
{
    /**
     * Display Company Settings Page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('application.settings.company.index');
    }
 
    /**
     * Update the Company
     *
     * @param \App\Http\Requests\Application\Settings\Company\Update $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();
        
        // Update Company
        $currentCompany->update($request->validated()); 

        // Update Company Address
        $address = $request->input('billing');
        $address['name'] = $currentCompany->name;
        $currentCompany->updateAddress('billing', $address);

        // Update Company Logo
        if ($request->avatar) {
            $request->validate(['avatar' => 'required|image|mimes:png,jpg|max:2048']);
            $path = $request->avatar->storeAs('company_logos', 'logo-'. $currentCompany->id .'.'.$request->avatar->getClientOriginalExtension(), 'public_dir');
            CompanySetting::setSetting('avatar', '/uploads/'.$path, $currentCompany->id);
        }

        session()->flash('alert-success', __('messages.company_updated'));
        return redirect()->route('settings.company', ['company_uid' => $currentCompany->uid]);
    }
}

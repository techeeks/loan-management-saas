<?php

namespace App\Http\Controllers\Application\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\Settings\CustomField\Store;
use App\Http\Requests\Application\Settings\CustomField\Update;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    /**
     * Display Custom Field Settings Page
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // Get Custom Field by Company
        $custom_fields = CustomField::findByCompany($currentCompany->id)->latest()->paginate(15);

        return view('application.settings.custom_field.index', [
            'custom_fields' => $custom_fields,
        ]);
    }
 
    /**
     * Display the Form for Creating New Custom Field
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $custom_field = new CustomField();

        // Fill model with old input
        if (!empty($request->old())) {
            $custom_field->fill($request->old());
        }

        return view('application.settings.custom_field.create', [
            'custom_field' => $custom_field,
        ]);
    }
 
    /**
     * Store the Custom Field in Database
     *
     * @param  \App\Http\Requests\Application\Settings\CustomField\Store  $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        // Create Custom Field and Store in Database
        $data = $request->validated();
        $data[get_custom_field_value_key($request->type)] = $request->default_value;
        $data['company_id'] = $currentCompany->id;
        CustomField::create($data);

        session()->flash('alert-success', __('messages.custom_field_created'));
        return redirect()->route('settings.custom_fields', ['company_uid' => $currentCompany->uid]);
    }

    /**
     * Display the Form for Editing Custom Field
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $custom_field = CustomField::findOrFail($request->custom_field);
 
        return view('application.settings.custom_field.edit', [
            'custom_field' => $custom_field,
        ]);
    }

    /**
     * Update the Custom Field
     *
     * @param  \App\Http\Requests\Application\Settings\CustomField\Update $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        $custom_field = CustomField::findOrFail($request->custom_field);

        // Update Custom Field in Database
        $data = $request->validated();
        $data[get_custom_field_value_key($request->type)] = $request->default_value ?? null;
        $custom_field->update($data);

        session()->flash('alert-success', __('messages.custom_field_updated'));
        return redirect()->route('settings.custom_fields', ['company_uid' => $currentCompany->uid]);
    }

    /**
     * Delete the Custom Field
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->currentCompany();

        $custom_field = CustomField::findOrFail($request->custom_field);
        
        // Check if the CustomField is already in use
        if ($custom_field->custom_field_values()->exists()) {
            session()->flash('alert-error', __('messages.custom_field_is_in_use'));
            return redirect()->route('settings.custom_fields', ['company_uid' => $currentCompany->uid]);
        }

        // Delete Custom Field from Database
        $custom_field->delete();
         
        session()->flash('alert-success', __('messages.custom_field_deleted'));
        return redirect()->route('settings.custom_fields', ['company_uid' => $currentCompany->uid]);
    }
}

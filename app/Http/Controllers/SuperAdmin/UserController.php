<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SuperAdmin\User\Update;
use App\Http\Requests\SuperAdmin\User\Store;
use App\Models\Company;
use App\Models\Plan;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    /**
     * Display Super Admin Users Page
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get Users and Filters
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::partial('first_name'),
                AllowedFilter::partial('email'),
            ])
            ->oldest()
            ->paginate()
            ->appends(request()->query());

        return view('super_admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Display the Form for Creating User
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = new User();
 
        // Fill model with old input
        if (!empty($request->old())) {
            $user->fill($request->old());
        }

        return view('super_admin.users.create', [
            'user' => $user,
        ]);
    }

    /**
     * Store the User in Database
     *
     * @param \App\Http\Requests\SuperAdmin\User\Store $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.users');
        };

        // Create new Member
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Assign User Role
        $user->assignRole($request->role);

        // Create Company
        $company = Company::create([
            'name' => $request->company_name,
            'owner_id' => $user->id,
        ]);

        // Attach User to Company
        $user->attachCompany($company);

        // Subscribe plan
        if ($request->plan_id) {
            $plan = Plan::findOrFail($request->plan_id);
            $company->newSubscription('main', $plan);
        }

        // Upload and save avatar
        if ($request->avatar) {
            $request->validate(['avatar' => 'required|image|mimes:png,jpg|max:2048']);
            $path = $request->avatar->storeAs('avatars', 'avatar-'. $user->id .'.'.$request->avatar->getClientOriginalExtension(), 'public_dir');
            $user->setSetting('avatar', '/uploads/'.$path);
        }

        session()->flash('alert-success', __('messages.user_created'));
        return redirect()->route('super_admin.users');
    }

    /**
     * Display the Form for Editing User
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::findOrFail($request->user);
        
        // Fill model with old input
        if (!empty($request->old())) {
            $user->fill($request->old());
        }

        return view('super_admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the User in Database
     *
     * @param \App\Http\Requests\SuperAdmin\User\Update $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $user = User::findOrFail($request->user);
        $userCompany = $user->currentCompany();

        // If demo mode is active then block this action
        if (config('app.is_demo')) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.users');
        };

        // Update the Member
        $validated = $request->validated();
        unset($validated['password']);
        unset($validated['password_confirmation']);
        $user->update($validated);

        // If Password fields are filled
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Update Company Name
        $userCompany->name = $request->company_name;
        $userCompany->save();

        // Sync member role
        $user->syncRoles([$request->role]);

        // Subscribe or Change plan
        if ($request->plan_id) {
            $plan = Plan::findOrFail($request->plan_id);

            // If already in the plan
            if ($userCompany->subscription('main') != null) {
                $userCompany->subscription('main')->changePlan($plan);
            } else {
                $userCompany->newSubscription('main', $plan);
            }
        } else {
            // Remove plan if user subscribed to a plan
            if ($userCompany->subscription('main') != null) {
                $userCompany->subscription('main')->cancel(true);
            } 
        }

        // Upload and save avatar
        if ($request->avatar) {
            $request->validate(['avatar' => 'required|image|mimes:png,jpg|max:2048']);
            $path = $request->avatar->storeAs('avatars', 'avatar-'. $user->id .'.'.$request->avatar->getClientOriginalExtension(), 'public_dir');
            $user->setSetting('avatar', '/uploads/'.$path);
        }

        session()->flash('alert-success', __('messages.user_updated'));
        return redirect()->route('super_admin.users.edit', $user->id);
    }

    /**
     * Delete the User
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        // Find User
        $user = User::findOrFail($request->user);

        // If demo mode is active then block this action
        if (config('app.is_demo') && $user->id === 1) {
            session()->flash('alert-danger', __('messages.action_blocked_in_demo'));
            return redirect()->route('super_admin.users');
        };

        // Delete All
        $user->currentCompany()->deleteAll();

        session()->flash('alert-success', __('messages.user_deleted'));
        return redirect()->route('super_admin.users');
    }
}

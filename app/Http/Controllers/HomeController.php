<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // If user is authenticated
        if ($user) {
            if ($user->hasRole('super_admin')) {
                return redirect()->route('super_admin.dashboard');
            }

            $currentCompany = $user->currentCompany();
            return redirect()->route('dashboard', ['company_uid' => $currentCompany->uid]);
        }

        $theme = SystemSetting::getSetting('theme');

        return view('themes.'.$theme.'.home');
    } 
}

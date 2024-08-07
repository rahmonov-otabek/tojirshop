<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;

class SettingsController extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSetting::first();
        return view('admin.settings.index', compact('generalSettings'));
    }

    public function generalSettinsUpdate(Request $request)
    {
        $request->validate([ 
            'site_name' => ['required', 'max:200'],
            'layout' => ['required', 'max:200'],
            'contact_email' => ['required', 'max:200'],
            'currency_name' => ['required', 'max:200'],
            'currency_icon' => ['required', 'max:200'],
            'time_zone' => ['required', 'max:200'],
        ]);
  
        GeneralSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $request->site_name,
                'layout' => $request->layout,
                'contact_email' => $request->contact_email,
                'currency_name' => $request->currency_name,
                'currency_icon' => $request->currency_icon,
                'time_zone' => $request->time_zone,
            ]
        );

        toastr('Updated Successfully!', 'success');

        return redirect()->back();
    }
}

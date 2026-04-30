<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        if ($request->hasFile('school_logo')) {
            $path = $request->file('school_logo')->store('school', 'public');
            Setting::where('key', 'school_logo')->update(['value' => $path]);
        }

        foreach ($data as $key => $value) {
            if ($key != 'school_logo') {
                Setting::where('key', $key)->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'School settings updated successfully.');
    }
}

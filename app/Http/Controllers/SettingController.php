<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $title = 'Konfigurasi Website';
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting', 'title'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $setting = Setting::first();
        if ($request->hasFile('logo')) {
            $destination = public_path('storage\\' . $setting->logo);
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $filename = $request->file('logo')->store('images', 'public');
            $setting->logo = $filename;
            $setting->site_name = $request->site_name;
            $setting->keyword = $request->keyword;
            $setting->email = $request->email;
            $setting->phone = $request->phone;
            $setting->address = $request->address;
            $setting->description = $request->description;
            $setting->ig = $request->ig;
            $setting->fb = $request->fb;
            $setting->yt = $request->yt;
            $setting->save();
        } else {
            $filename = null;
            $setting->site_name = $request->site_name;
            $setting->keyword = $request->keyword;
            $setting->email = $request->email;
            $setting->phone = $request->phone;
            $setting->address = $request->address;
            $setting->description = $request->description;
            $setting->ig = $request->ig;
            $setting->fb = $request->fb;
            $setting->yt = $request->yt;
            $setting->save();
        }
        return response()->json(['success' => 'Data berhasil diubah!']);
    }
}

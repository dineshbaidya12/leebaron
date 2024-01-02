<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    public function generalSetting()
    {
        // $generalSetting = GeneralSetting::find(1) ?? [];
        $generalSetting = GeneralSetting::first() ?? [];
        return view('admin.general-setting', compact('generalSetting'));
        // dd($generalSetting->toArray());
    }

    public function generelSettingAction(Request $request)
    {
        try {
            $user = Auth::user();
            $rules = [
                'site_title' => 'required',
                'site_url' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $errMsg = '<ul>';
                foreach ($errors as $err) {
                    $errMsg .= '<li>' . $err . '</li>';
                }
                $errMsg .= '</ul>';
                return redirect()->back()->with('error', $errMsg);
            }

            $generalSetting = GeneralSetting::find(1);
            if ($generalSetting) {
                $updated = $generalSetting->update([
                    'site_title' => $request->site_title,
                    'site_url' => $request->site_url,
                    'meta_descriptions' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords,
                    'admin_logo' => 'mimes:jpg, jpeg, png',
                    'fevicon_icon' => 'mimes:jpg, jpeg, png, io',
                ]);

                if ($request->hasFile('admin_logo')) {
                    if ($generalSetting->admin_logo != '') {
                        $previousAdminLogo = $generalSetting->admin_logo;
                        if (Storage::disk('public')->exists('general_setting/' . $previousAdminLogo)) {
                            Storage::disk('public')->delete('general_setting/' . $previousAdminLogo);
                        }
                    }
                    $image = $request->file('admin_logo');
                    $filename = 'admin_logo' . '.' . $image->getClientOriginalExtension();
                    $storagePath = 'public/general_setting/';
                    $path = $storagePath . $filename;
                    Storage::put($path, file_get_contents($image));
                    GeneralSetting::where('id', 1)->update(['admin_logo' => $filename]);
                }

                if ($request->hasFile('fevicon_icon')) {
                    if ($generalSetting->admin_logo != '') {
                        $previousAdminLogo = $generalSetting->favicon;
                        if (Storage::disk('public')->exists('general_setting/' . $previousAdminLogo)) {
                            Storage::disk('public')->delete('general_setting/' . $previousAdminLogo);
                        }
                    }
                    $image = $request->file('fevicon_icon');
                    $filename = 'fevicon' . '.' . $image->getClientOriginalExtension();
                    $storagePath = 'public/general_setting/';
                    $path = $storagePath . $filename;
                    Storage::put($path, file_get_contents($image));
                    GeneralSetting::where('id', 1)->update(['favicon' => $filename]);
                }

                if ($updated) {
                    return redirect()->back()->with('success', 'General Setting Updated Successfully.');
                } else {
                    return redirect()->back()->with('error', 'Something Went Wrong.');
                }
            } else {
                GeneralSetting::insert([
                    'site_title' => $request->site_title,
                    'site_url' => $request->site_url,
                    'meta_descriptions' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords
                ]);
                return redirect()->back()->with('success', 'General Setting added Successfully.');
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err . '.');
        }
    }
}

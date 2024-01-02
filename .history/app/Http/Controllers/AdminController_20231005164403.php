<?php

namespace App\Http\Controllers;


use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');
    }

    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'role' => 'admin',
            'email' => $request->email,
            'password' => $request->password,
        ];

        
        $remember = $request->has('remember-me');
        dd($request->has('remember-me'));

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Login credentials do not match.');
        }
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function pages()
    {
        return view('admin.pages');
    }

    public function generalSetting()
    {
        $generalSetting = GeneralSetting::find(1);
        return view('admin.general-setting', compact('generalSetting'));
    }

    public function generelSettingAction(Request $request)
    {
        try {
            $generalSetting = GeneralSetting::find(1);
            if ($generalSetting) {
                $updated = $generalSetting->update([
                    'site_title' => $request->site_title,
                    'site_url' => $request->site_url,
                    'meta_descriptions' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords
                ]);
                if ($updated) {
                    return redirect()->back()->with('success', 'General Setting Updated Successfully.');
                } else {
                    return redirect()->back()->with('error', 'Something Went Wrong.');
                }
            } else {
                return redirect()->back()->with('error', 'General Setting not found.');
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err . '.');
        }
    }

    public function adminProfile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function accountUpdate(Request $request)
    {
        try {
            $user = Auth::user();
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'required|min:5',
            ];

            if ($request->email != $user->email) {
                $rules['email'] = 'required|email|unique:users,email';
            } else {
                $rules['email'] = 'required|email';
            }

            if ($request->hasFile('profile_picture')) {
                $rules['profile_picture'] = 'image|mimes:jpg,jpeg,png|max:4000';
            }

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

            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $filename = $user->first_name . '_' . $user->id . '_profile_picture_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = public_path('admin/uploads/profile_pictures/' . $filename);
                $croppedImage = Image::make($image)->fit(200, 200);
                $croppedImage->save($path);
                if ($user->profile_picture != '') {
                    if (file_exists('admin/uploads/profile_pictures/' . $user->profile_picture)) {
                        unlink('admin/uploads/profile_pictures/' . $user->profile_picture);
                    }
                }
                User::where('id', $user->id)->update(['profile_picture' => $filename]);
            }

            User::where('id', $user->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'name' => $request->first_name . ' ' . $request->last_name, 'email' => $request->email, 'plain_pass' => $request->password, 'password' => Hash::make($request->password)]);

            return redirect()->back()->with('success', 'Profile Upodated Successfully!');







        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err . '.');
        }
    }
}

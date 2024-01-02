<?php

namespace App\Http\Controllers\adminController;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/admin-login');
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
        // dd($request->has('remember-me'));

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Login credentials do not match.');
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
                'profile_picture' => 'image|mimes:jpg,jpeg,png|max:5000'
            ];

            if ($request->email != $user->email) {
                $rules['email'] = 'required|email|unique:users,email';
            } else {
                $rules['email'] = 'required|email';
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
                $storagePath = 'public/profile_picture/';
                $path = $storagePath . $filename;
                $croppedImage = Image::make($image)->fit(200, 200);
                Storage::put($path, $croppedImage->encode());
                if ($user->profile_picture != '') {
                    if (Storage::disk('public')->exists('profile_picture/' . $user->profile_picture)) {
                        Storage::disk('public')->delete('profile_picture/' . $user->profile_picture);
                    }
                }
                User::where('id', $user->id)->update(['profile_picture' => $filename]);
            }
            User::where('id', $user->id)->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'name' => $request->first_name . ' ' . $request->last_name, 'email' => $request->email, 'plain_pass' => $request->password, 'password' => Hash::make($request->password)]);
            return redirect()->back()->with('success', 'Profile Updated Successfully!');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err . '.');
        }
    }
}

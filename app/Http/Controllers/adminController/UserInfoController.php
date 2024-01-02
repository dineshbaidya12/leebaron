<?php

namespace App\Http\Controllers\adminController;

use App\Exports\Testing;
use App\Exports\UserExports;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Newsletter;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Writer;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserInfoController extends Controller
{
    public function users()
    {
        $users = User::where('users.role', 'user')->join('users_info', 'users_info.user_id', 'users.id')->get();
        return view('admin.users', compact('users'));
    }

    public function addUser()
    {
        $isEdit = false;
        $country = Country::get();
        $cusNos = UserInfo::select('customer_no')->get()->toArray();
        $cusNosJson = json_encode($cusNos);
        $isNewsLetter = false;
        return view('admin.add-edit-user', compact('isEdit', 'country', 'cusNosJson', 'isNewsLetter'));
    }

    public function modifyUser($id)
    {
        $isEdit = true;
        $user = User::where('users.id', $id)->where('users.role', 'user')->join('users_info', 'users_info.user_id', 'users.id')->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not exist');
        }
        if ($user == '' || $user->toArray() == []) {
            return redirect()->back()->with('error', 'User not exist');
        }
        // dd($user->toArray());
        $country = Country::get();
        $cusNos = UserInfo::select('customer_no')->where('user_id', '!=', $id)->get()->toArray();

        $cusNosJson = json_encode($cusNos);
        $newsLetter = Newsletter::where('email', $user->email)->count();
        $isNewsLetter = $newsLetter > 0 ? true : false;
        return view('admin.add-edit-user', compact('isEdit', 'user', 'country', 'cusNosJson', 'isNewsLetter'));
    }

    public function userAction(Request $request)
    {
        try {
            // dd($request->toArray());
            $rules = [
                'editId' => 'required|numeric',
                'email' => 'required|email',
                'password' => 'required',
                'fname' => 'required',
                'lname' => 'required',
                'address1' => 'required',
                'city' => 'required',
                'country' => 'required|numeric',
                'state' => 'required',
                'postcode' => 'required',
                'phone' => 'required',
                'showroom' => 'required|in:USNY,DKCO,SWST,HKCH,CATO',
                'status' => 'required|in:active,inactive,waiting',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $isEmailExist = User::where('email', $request->email)->count();

            if ($isEmailExist > 0) {
                if ($request->editId !== 0) {
                    $userPastInfo = User::select('email')->where('id', $request->editId)->first();
                    if ($request->email !== $userPastInfo->email) {
                        return redirect()->back()->with('error', 'Email Already Exist');
                    }
                } else {
                    return redirect()->back()->with('error', 'Email Already Exist');
                }
            }

            $isCustomerNoExist = UserInfo::where('customer_no', $request->customerno)->count();
            if ($isCustomerNoExist > 0) {
                if ($request->customerno !== '' || $request->customerno !== null) {
                    if ($request->editId !== 0) {
                        $userPastInfo = UserInfo::select('customer_no')->where('user_id', $request->editId)->first();
                        if ($request->customerno !== $userPastInfo->customer_no) {
                            return redirect()->back()->with('error', 'Customer Number Should Empty or Unique');
                        }
                    } else {
                        return redirect()->back()->with('error', 'Customer Number Should Empty or Unique');
                    }
                }
            }


            $userData = User::find($request->editId) ?? new User();
            $userData->first_name = $request->fname;
            $userData->last_name = $request->lname;
            $userData->name =  $request->fname . ' ' . $request->lname;
            $userData->role = 'user';
            $userData->email = $request->email;
            $userData->plain_pass = $request->password;
            $userData->password = password_hash($request->password, PASSWORD_DEFAULT);
            $userData->save();


            $userInfo = UserInfo::where('user_id', $request->editId)->first();
            if (!$userInfo) {
                $userInfo = new UserInfo();
            }
            $userInfo->user_id = $userData->id;
            $userInfo->address1 = $request->address1;
            $userInfo->address2 = $request->address2 ?? '';
            $userInfo->city = $request->city;
            $userInfo->country = $request->country;
            $userInfo->state = $request->state;
            $userInfo->postcode = $request->postcode;
            $userInfo->phone = $request->phone;
            $userInfo->fax = $request->fax ?? '';
            $userInfo->status = $request->status;
            $userInfo->showroom = $request->showroom;
            $userInfo->customer_no = strtoupper(trim($request->customerno)) ?? '';
            $userInfo->joined_date = date('Y-m-d');
            $userInfo->save();

            $newsLetter = Newsletter::where('email', $request->email)->first();
            if ($request->newsletter) {
                if (!$newsLetter) {
                    $newsLetter = new Newsletter();
                }
                $newsLetter->name = $userData->name;
                $newsLetter->email = $userData->email;
                $newsLetter->status = 'active';
                $newsLetter->save();
            } else {
                if ($newsLetter) {
                    $newsLetter->status = 'inactive';
                    $newsLetter->save();
                }
            }

            $res = $request->editId == 0 ? 'Added' : 'Updated';
            return redirect()->route('users')->with('success', 'User ' . $res . ' Successfully.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong' . $err);
        }
    }

    public function changeUserStatus(Request $request)
    {
        try {
            $userInfo = UserInfo::where('user_id', $request->id)->first();
            if ($userInfo) {
                if ($request->status == 'active') {
                    UserInfo::where('user_id', $request->id)->update(['status' => 'inactive']);
                } else {
                    UserInfo::where('user_id', $request->id)->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'User status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'User Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'messege' => 'User Not Found']);
            }

            $user = User::find($request->id);
            if (!$user) {
                return response()->json(['status' => false, 'messege' => 'User Not Found']);
            }
            $user->delete();
            $userInfo = UserInfo::where('user_id', $user->id)->first();
            if ($userInfo) {
                $userInfo->delete();
            }
            return response()->json(['status' => true, 'messege' => 'User deleted successfully.']);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function exportUser()
    {
        return view('admin.export-user');
    }

    public function exportUserAction(Request $request)
    {
        try {
            // dd($request->toArray());
            if ($request->download_all) {
                $users = User::where('users.role', 'user')->join('users_info', 'users_info.user_id', 'users.id')->join('countries', 'countries.id', 'users_info.country')->select('users_info.user_id', 'users.name', 'users.email', 'users.plain_pass', 'users_info.address1', 'users_info.address2', 'users_info.city', 'countries.country', 'users_info.state', 'users_info.postcode', 'users_info.phone', 'users_info.fax', 'users_info.status', 'users_info.showroom', 'users_info.customer_no', 'users_info.joined_date')->get();
            } else {
                $rules = [
                    'start_date' => 'required|date',
                    'end_date' => 'required|date'
                ];
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'Start and End Date mendetory');
                }

                $users = User::where('users.role', 'user')->join('users_info', 'users_info.user_id', 'users.id')->join('countries', 'countries.id', 'users_info.country')->whereBetween('users_info.joined_date', [$request->start_date, $request->end_date])->select('users_info.user_id', 'users.name', 'users.email', 'users.plain_pass', 'users_info.address1', 'users_info.address2', 'users_info.city', 'countries.country', 'users_info.state', 'users_info.postcode', 'users_info.phone', 'users_info.fax', 'users_info.status', 'users_info.showroom', 'users_info.customer_no', 'users_info.joined_date')->get();
            }
            // dd($users->toArray());
            return Excel::download(new UserExports($users), 'users.csv');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function download()
    {
        $users = User::where('users.role', 'user')->join('users_info', 'users_info.user_id', 'users.id')->get();
        return Excel::download(new UserExports($users), 'users.csv');
    }
}

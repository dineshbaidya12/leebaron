<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class employeeController extends Controller
{
    public function employee()
    {
        $employees = Employee::where('archive', 'no')->get();
        return view('admin.employees', compact('employees'));
    }

    public function addEmployee()
    {
        $isEdit = false;
        return view('admin.add-edit-employee', compact('isEdit'));
    }

    public function modifyEmpoyee($id)
    {
        $isEdit = true;
        $employee = Employee::where('id',  $id)->first();
        if (!$employee || $employee->archive == 'yes') {
            return redirect()->back()->with('error', 'Unable to find the employee.');
        }
        return view('admin.add-edit-employee', compact('isEdit', 'employee'));
    }

    public function changeEmployeeStatus(Request $request)
    {
        try {
            $employee = Employee::where('id', $request->id)->where('archive', 'no')->first();
            if ($employee) {
                if ($request->status == 'active') {
                    Employee::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    Employee::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Employee status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Employee Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteEmployee(Request $request)
    {
        try {
            Employee::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function employeeAction(Request $request)
    {
        try {
            $rules = [
                'editId' => 'required|numeric',
                'emp_username' => 'required',
                'emp_email' => 'required|email',
                'emp_password' => 'required',
                'status' => 'required|in:active,inactive',
                'showroom' => 'required|in:USNY,DKCO,SWST,HKCH,CATO'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $isExist = Employee::where('email', $request->emp_email)->count();
            $isExist2 = Employee::where('username', $request->emp_username)->count();
            if ($isExist > 0 && $request->editId == 0) {
                return redirect()->back()->with('error', 'Email already exist');
            }
            if ($isExist2 > 0 && $request->editId == 0) {
                return redirect()->back()->with('error', 'Username already exist');
            }

            $employee = Employee::find($request->editId) ?? new Employee();
            $employee->username = $request->emp_username;
            $employee->email = $request->emp_email;
            $employee->password = $request->emp_password;
            $employee->showroom = $request->showroom;
            $employee->status = $request->status;
            $employee->archive = 'no';
            $employee->save();

            $res = $request->editId  == 0 ? 'Added' : 'Modified';
            return redirect()->route('employee')->with('success', 'Employee ' . $res . ' Succcessfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }
}

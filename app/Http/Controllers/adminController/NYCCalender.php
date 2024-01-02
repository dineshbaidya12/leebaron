<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\NYCCalender as NYCCalenderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NYCCalender extends Controller
{
    public function nycCalender()
    {
        $nycCalenders = NYCCalenderModel::where('archive', 'no')->get();
        return view('admin.nyc-calenders', compact('nycCalenders'));
    }

    public function addCalender()
    {
        $isEdit = false;
        return view('admin.add-edit-nyc-calenders', compact('isEdit'));
    }

    public function modifyCalender($id)
    {
        $isEdit = true;
        $calender = NYCCalenderModel::where('id',  $id)->first();
        if (!$calender || $calender->archive == 'yes') {
            return redirect()->back()->with('error', 'Unable to find the calender.');
        }
        return view('admin.add-edit-nyc-calenders', compact('isEdit', 'calender'));
    }

    public function changeCalenderStatus(Request $request)
    {
        try {
            $calender = NYCCalenderModel::where('id', $request->id)->where('archive', 'no')->first();
            if ($calender) {
                if ($request->status == 'active') {
                    NYCCalenderModel::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    NYCCalenderModel::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Calender status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Calender Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteCalender(Request $request)
    {
        try {
            NYCCalenderModel::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function calenderAction(Request $request)
    {
        try {
            $rules = [
                'editId' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'calender_notes' => 'required',
                'calender_status' => 'required|in:active,inactive'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $nycCalender = NYCCalenderModel::find($request->editId) ?? new NYCCalenderModel;
            $nycCalender->start_time = $request->start_date;
            $nycCalender->end_time = $request->end_date;
            $nycCalender->notes = $request->calender_notes;
            $nycCalender->status = $request->calender_status;
            $nycCalender->archive = 'no';
            $nycCalender->save();
            $res = $request->editId  == 0 ? 'Added' : 'Modified';
            return redirect()->route('nyc-calender')->with('success', 'Calender ' . $res . ' Succcessfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }
}

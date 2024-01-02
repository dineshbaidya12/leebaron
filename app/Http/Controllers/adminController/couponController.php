<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class couponController extends Controller
{
    public function discount()
    {
        $coupons = voucher::get();
        return view('admin.coupon', compact('coupons'));
    }

    public function addVoucher()
    {
        $isEdit = false;
        return view('admin.add-edit-coupon', compact('isEdit'));
    }

    public function modifyVoucher($id)
    {
        $isEdit = true;
        $coupon = voucher::where('id', $id)->first();
        if (!$coupon) {
            return redirect()->back()->with('error', 'Voucher not exist');
        }
        return view('admin.add-edit-coupon', compact('isEdit', 'coupon'));
    }

    public function voucherAction(Request $request)
    {
        try {
            $rules = [
                'editId' => 'required|numeric',
                'coupon_name' => 'required',
                'coupon_code' => 'required',
                'min_applicable' => 'required|numeric',
                'voucher_amount' => 'required|numeric',
                'discount_type' => 'required|in:percentage,price',
                'status' => 'required|in:active,inactive',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd($request->toArray());

            $isExist = voucher::where('voucher_name', $request->coupon_name)->orWhere('voucher_code', $request->coupon_code)->count();
            if ($isExist > 0 && $request->editId == 0) {
                return redirect()->back()->with('error', 'Coupon Already Exist.');
            }

            $coupon = voucher::find($request->editId) ?? new voucher();
            $coupon->voucher_name = $request->coupon_name;
            $coupon->voucher_code = $request->coupon_code;
            $coupon->voucher_amount = $request->voucher_amount;
            $coupon->min_applicable = $request->min_applicable;
            $coupon->discount_type = $request->discount_type;
            $coupon->status = $request->status;
            $coupon->start_date = $request->start_date;
            $coupon->end_date = $request->end_date;
            $coupon->save();

            if ($request->editId == 0) {
                return redirect()->route('discount')->with('success', 'voucher Added Successfully.');
            } else {
                return redirect()->route('discount')->with('success', 'voucher Updated Successfully.');
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong' . $err);
        }
    }

    public function changeVoucherStatus(Request $request)
    {
        try {
            $coupon = voucher::where('id', $request->id)->first();
            if ($coupon) {
                if ($request->status == 'active') {
                    voucher::where('id', $request->id)->update(['status' => 'inactive']);
                } else {
                    voucher::where('id', $request->id)->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Coupon status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Coupon Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteVoucher(Request $request)
    {
        try {
            voucher::where('id', $request->id)->delete();
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }
}

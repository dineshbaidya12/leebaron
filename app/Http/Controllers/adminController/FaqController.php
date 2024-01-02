<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function adminFaq()
    {
        $faqs = Faq::where('archive', 'no')->orderBy('id', 'DESC')->get();
        return view('admin.faq', compact('faqs'));
    }

    public function deleteFaq(Request $request)
    {
        try {
            Faq::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function addFaq()
    {
        return view('admin.add-new-faq');
    }

    public function addNewFaq(Request $request)
    {
        try {
            $rules = [
                'question' => 'required',
                'answer' => 'required',
                'faq_status' => 'required|in:active,inactive',
                'order' => 'nullable|numeric',
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
            Faq::insert([
                'question' => $request->question,
                'answer' => $request->answer,
                'order' => $request->order ?? 0,
                'status' => $request->faq_status,
                'archive' => 'no'
            ]);
            return redirect()->route('faq-section')->with('success', 'Faq Added Successfully.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Somwthing Went Wrong');
        }
    }

    public function modifyFaq($id)
    {
        $faq = Faq::where('id', $id)->where('archive', 'no')->first();
        if ($faq) {
            return view('admin.modify-faq', compact('faq'));
        } else {
            return redirect()->back()->with('error', 'Faq Not Found!');
        }
    }

    public function modifyFaqAction($id, Request $request)
    {
        try {
            Faq::where('id', $id)->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'order' => $request->order ?? 0,
                'status' => $request->faq_status,
                'archive' => 'no'
            ]);
            return redirect()->route('faq-section')->with('success', 'Faq Updated Successfully.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function changeFaqStatus(Request $request)
    {
        try {
            $faq = Faq::where('id', $request->id)->where('archive', 'no')->first();
            if ($faq) {
                if ($request->status == 'active') {
                    Faq::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    Faq::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Faq status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Faq Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }
}

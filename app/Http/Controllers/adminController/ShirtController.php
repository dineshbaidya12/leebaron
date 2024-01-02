<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Shirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ShirtController extends Controller
{
    public function shirts()
    {
        $shirts = Shirt::where('archive', 'no')->get();
        return view('admin.shirts', compact('shirts'));
    }

    public function addShirt()
    {
        $isEdit = false;
        return view('admin.add-edit-shirt', compact('isEdit'));
    }

    public function modifyShirt($id)
    {
        $isEdit = true;
        $shirt = Shirt::where('id',  $id)->first();
        if (!$shirt || $shirt->archive == 'yes') {
            return redirect()->back()->with('error', 'Unable to find the Shirt.');
        }
        return view('admin.add-edit-shirt', compact('isEdit', 'shirt'));
    }

    public function changeShirtStatus(Request $request)
    {
        try {
            $shirt = Shirt::where('id', $request->id)->where('archive', 'no')->first();
            if ($shirt) {
                if ($request->status == 'active') {
                    Shirt::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    Shirt::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Shirt status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Shirt Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteShirt(Request $request)
    {
        try {
            Shirt::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function ShirtAction(Request $request)
    {
        try {
            $rules = [
                'editId' => 'required|numeric',
                'category' => 'required|in:Fabrics,Fit,Collars,Sleeves,Cuffs,Front,Pocket,Bottom Cut,Back Details',
                'product_name' => 'required',
                'shirt_status' => 'required|in:active,inactive',
                'order_by' => 'required|numeric'

            ];
            if ($request->editId == 0) {
                $rules['main_img'] = 'required|mimes:jpeg,jpg,png';
                $rules['thubnail'] = 'required|mimes:jpeg,jpg,png';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // dd($rules);

            $shirt = Shirt::find($request->editId) ?? new Shirt();
            $shirt->category = $request->category;
            $shirt->product_name = $request->product_name;
            $shirt->orderby = $request->order_by;
            $shirt->status = $request->shirt_status;
            $shirt->archive = 'no';
            $shirt->save();

            $theId = $shirt->id;
            if ($request->hasFile('main_img')) {
                $image = $request->file('main_img');
                $pName = str_replace(' ', '_', preg_replace('/\s+/', ' ', $request->product_name));
                $filename = $pName . now()->format('YmdHis') . '_' .  uniqid() . '_' . $theId . '.' . $image->getClientOriginalExtension();

                $storagePath = 'public/shirt/';
                $fullPath = $storagePath . $filename;
                $mainImg = Image::make($image);

                $existingRec = Shirt::find($theId);
                if ($shirt->image != '') {
                    if (Storage::disk('public')->exists('shirt/' . $existingRec->image)) {
                        Storage::disk('public')->delete('shirt/' . $existingRec->image);
                    }
                }

                Storage::put($fullPath, $mainImg->encode());
                $theShirt = Shirt::find($theId);
                $theShirt->image = $filename;
                $theShirt->save();
            }

            if ($request->hasFile('thubnail')) {
                $image = $request->file('thubnail');
                $pName = str_replace(' ', '_', preg_replace('/\s+/', ' ', $request->product_name));
                $filename = $pName . now()->format('YmdHis') . '_' .  uniqid() . '_' . $theId . '.' . $image->getClientOriginalExtension();

                $storagePath = 'public/shirt/thumb/';
                $fullPath = $storagePath . $filename;
                $thumbImg = Image::make($image)->fit(80, 80);

                $existingRec2 = Shirt::find($theId);
                if ($shirt->image != '') {
                    if (Storage::disk('public')->exists('shirt/thumb/' . $existingRec2->thumb)) {
                        Storage::disk('public')->delete('shirt/thumb/' . $existingRec2->thumb);
                    }
                }

                Storage::put($fullPath, $thumbImg->encode());
                $theShirt2 = Shirt::find($theId);
                $theShirt2->thumb = $filename;
                $theShirt2->save();
            }

            $res = $request->editId  == 0 ? 'Added' : 'Modified';
            return redirect()->route('shirt')->with('success', 'Shirt ' . $res . ' Succcessfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }
}

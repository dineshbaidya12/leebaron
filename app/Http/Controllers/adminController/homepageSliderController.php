<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\homepageSlider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class homepageSliderController extends Controller
{
    public function homepageSlider()
    {
        $sliders = homepageSlider::get()->where('archive', 'no') ?? [];
        return view('admin.homepage-slider', compact('sliders'));
    }

    public function addHomeSlider()
    {
        $isEdit = false;
        return view('admin.add-edit-homeslider', compact('isEdit'));
    }

    public function modifyHomeslider($id)
    {
        $isEdit = true;
        $slider = homepageSlider::where('id', $id)->where('archive', 'no')->first();
        if (!$slider) {
            return redirect()->back()->with('error', 'Homepage Slider Not Found');
        }
        return view('admin.add-edit-homeslider', compact('isEdit', 'slider'));
    }

    public function homesliderUpdate(Request $request)
    {
        try {
            $rules = [
                'isEdit' => 'required|numeric',
                'title' => 'required',
                'link_type' => 'required|in:none,internal,external',
                'status' => 'required|in:active,inactive',
                'new_window' => 'required|in:yes,no',
                'class_name' => 'required|in:white,black',
                'order' => 'required|numeric',
            ];

            if ($request->link_type == 'internal') {
                $rules += [
                    'link_option' => 'required',
                ];
            } elseif ($request->link_type == 'external') {
                $rules += [
                    'link' => 'required|url',
                ];
            }

            if ($request->isEdit == 0) {
                $rules += [
                    'image' => 'required|image|mimes:jpeg,png',
                ];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->isEdit != 0) {
                $theSlider = homepageSlider::find($request->isEdit);

                if (!$theSlider) {
                    abort(404, 'Home Slider Not Found');
                }
            }


            $data = [
                'title' => $request->title,
                'link_type' => $request->link_type,
                'link' => $request->link_type == 'external' ? $request->link : '',
                'internal_link' => $request->link_type == 'internal' ? $request->link_option : '',
                'new_window' => $request->new_window,
                'class_name' => $request->class_name,
                'status' => $request->status,
                'order' => $request->order,
                'archive' => 'no'
            ];



            if ($request->isEdit == 0) {
                $theId = homepageSlider::insertGetId($data);
            } else {
                homepageSlider::where('id', $request->isEdit)->update($data);
                $theId = $request->isEdit;
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = now()->format('YmdHis') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $storagePath = 'public/homepage-slider/';
                $path = $storagePath . $filename;
                $saveImage = Image::make($image);
                Storage::put($path, $saveImage->encode());
                if ($request->isEdit != 0) {
                    $theSlider = homepageSlider::where('id', $request->isEdit)->first();
                    if ($theSlider->image != '') {
                        if (Storage::disk('public')->exists('homepage-slider/' . $theSlider->image)) {
                            Storage::disk('public')->delete('homepage-slider/' . $theSlider->image);
                        }
                    }
                }

                homepageSlider::where('id', $theId)->update(['image' => $filename]);
            }

            $resMsg = $request->isEdit == 0 ? 'Inserted' : 'Updated';
            return redirect()->route('homepage-slider')->with('success', 'Home Slider ' . $resMsg . ' Successfully.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }

    public function changeSliderStatus(Request $request)
    {
        try {
            $slider = homepageSlider::where('id', $request->id)->where('archive', 'no')->first();
            if ($slider) {
                if ($request->status == 'active') {
                    homepageSlider::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    homepageSlider::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Home Slider status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Home Slider Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteHomeSlider(Request $request)
    {
        try {
            homepageSlider::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }
}

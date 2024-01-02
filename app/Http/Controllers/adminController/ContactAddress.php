<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\ContactAddress as ModelsContactAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ContactAddress extends Controller
{
    public function contactAddress()
    {
        $contacts = ModelsContactAddress::where('archive', 'no')->get();
        return view('admin.contact-address', compact('contacts'));
    }

    public function addContact()
    {
        $isEdit = false;
        return view('admin.add-edit-contact', compact('isEdit'));
    }

    public function modifyContact($id)
    {
        $isEdit = true;
        $contact = ModelsContactAddress::where('id',  $id)->first();
        if (!$contact || $contact->archive == 'yes') {
            return redirect()->back()->with('error', 'Unable to find the Contact Address.');
        }
        return view('admin.add-edit-contact', compact('isEdit', 'contact'));
    }

    public function changeContactStatus(Request $request)
    {
        try {
            $contact = ModelsContactAddress::where('id', $request->id)->where('archive', 'no')->first();
            if ($contact) {
                if ($request->status == 'active') {
                    ModelsContactAddress::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    ModelsContactAddress::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Contact status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Contact Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteContact(Request $request)
    {
        try {
            ModelsContactAddress::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function ContactAction(Request $request)
    {
        try {
            // dd($request->toArray());
            $rules = [
                'editId' => 'required|numeric',
                'title' => 'required',
                'gmap_address' => 'required',
                'contact_status' => 'required|in:active,inactive',
                'order_by' => 'required|numeric'

            ];
            if ($request->editId == 0) {
                $rules['main_img'] = 'required|mimes:jpeg,jpg,png';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // dd($rules);

            $contact = ModelsContactAddress::find($request->editId) ?? new ModelsContactAddress();
            $contact->title = $request->title ?? '';
            $contact->Address = $request->address ?? '';
            $contact->popup_content = $request->popup_content ?? '';
            $contact->popup_details = $request->popup_details ?? '';
            $contact->black_box_content = $request->blackbox_content ?? '';
            $contact->map_address = $request->gmap_address ?? '';
            $contact->orderby = $request->order_by ?? '';
            $contact->status = $request->contact_status ?? '';
            $contact->archive = 'no';
            $contact->save();

            $theId = $contact->id;
            if ($request->hasFile('main_img')) {
                $image = $request->file('main_img');
                $pName = str_replace(' ', '_', preg_replace('/\s+/', ' ', $request->title));
                $filename = $pName . now()->format('YmdHis') . '_' .  uniqid() . '_' . $theId . '.' . $image->getClientOriginalExtension();

                $storagePath = 'public/contact/';
                $fullPath = $storagePath . $filename;
                $mainImg = Image::make($image);

                $existingRec = ModelsContactAddress::find($theId);
                if ($contact->image != '') {
                    if (Storage::disk('public')->exists('contact/' . $existingRec->image)) {
                        Storage::disk('public')->delete('contact/' . $existingRec->image);
                    }
                }

                Storage::put($fullPath, $mainImg->encode());
                $hteContact = ModelsContactAddress::find($theId);
                $hteContact->image = $filename;
                $hteContact->save();
            }

            $res = $request->editId  == 0 ? 'Added' : 'Modified';
            return redirect()->route('contact-address')->with('success', 'Contact Address ' . $res . ' Succcessfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }
}

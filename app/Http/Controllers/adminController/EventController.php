<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function events()
    {
        $events = Event::where('archive', 'no')->get();
        return view('admin.events', compact('events'));
    }


    public function changeEventStatus(Request $request)
    {
        try {
            $event = Event::where('id', $request->id)->first();
            if ($event) {
                if ($request->status == 'active') {
                    Event::where('id', $request->id)->update(['status' => 'inactive']);
                } else {
                    Event::where('id', $request->id)->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Event status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Event Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function addEvent()
    {
        $isEdit = false;
        return view('admin.add-new-event', compact('isEdit'));
    }

    public function editEvent($id)
    {
        $isEdit = true;
        $event = Event::where('id', $id)->first();
        if (!$event || $event->archive == 'yes') {
            return redirect()->back()->with('error', 'Unable to find the event');
        }
        return view('admin.add-new-event', compact('isEdit', 'event'));
    }

    public function eventAction(Request $request)
    {
        try {
            $rules = [
                'editId' => 'required|numeric',
                'headline' => 'required',
                'event_content' => 'required',
                'event_status' => 'required|in:active,inactive',
                'location' => 'required',
                'start_date' => 'required',
                'end_date' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $event = Event::find($request->editId) ?? new Event();
            $event->headline = $request->headline;
            $event->content = $request->event_content;
            $event->location = $request->location;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->status = $request->event_status;
            $event->save();

            if ($request->editId == 0) {
                return redirect()->route('events')->with('success', 'Event Added Successfully.');
            } else {
                return redirect()->route('events')->with('success', 'Event Updated Successfully.');
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function deleteEvent(Request $request)
    {
        try {
            Event::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }
}

<?php

namespace App\Http\Controllers\adminController;

use App\Exports\AppointmentExports;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class AppointmentController extends Controller
{
    public function appointments()
    {
        $today = Carbon::now()->toDateString();
        Appointment::where('status', 'accepted')
            ->whereDate('appointment_date', '<', $today)
            ->update(['status' => 'expired']);
        $appointments = Appointment::where('status', 'accepted')->where('archive', 'no')->orderby('appointment_date', 'asc')->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function pendingAppointments()
    {
        $today = Carbon::now()->toDateString();
        Appointment::where('status', 'accepted')
            ->whereDate('appointment_date', '<', $today)
            ->update(['status' => 'expired']);
        $appointments = Appointment::where('status', 'waiting')->where('archive', 'no')->orderby('appointment_date', 'asc')->get();
        return view('admin.pending-appointment', compact('appointments'));
    }

    public function expireedAppointments()
    {
        $today = Carbon::now()->toDateString();
        Appointment::where('status', 'accepted')
            ->whereDate('appointment_date', '<', $today)
            ->update(['status' => 'expired']);
        $appointments = Appointment::where('status', 'expired')->orwhere('status', 'cancled')->where('archive', 'no')->orderby('appointment_date', 'asc')->get();
        return view('admin.expired-appointment', compact('appointments'));
    }

    public function cancleAppointment(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $appointment = Appointment::find($request->id);
            if (!$appointment) {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
            $appointment->status = 'cancled';
            $appointment->save();
            return redirect()->back()->with('success', 'Successfully cancled the appointment');
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }

    public function exportAppointments()
    {
        try {
            $appointment = Appointment::join('countries', 'countries.id', '=', 'appointments.country')
                ->select('appointments.name', 'appointments.address', 'appointments.city', 'countries.country as country_name', 'appointments.state', 'appointments.phone', 'appointments.email', 'appointments.postcode', 'appointments.appointment_date', 'appointments.request_date')
                ->where('status', 'accepted')
                ->get();
            return Excel::download(new AppointmentExports($appointment), 'appointment.csv');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went wrong');
        }
    }

    public function modifyAppointment($id)
    {
        $appointment = Appointment::where('appointments.id', $id)
            ->join('countries', 'countries.id', '=', 'appointments.country')
            ->select('countries.country as country_name', 'appointments.*')
            ->first();
        if (!$appointment) {
            return redirect()->back()->with('error', "Appointment Not Found.");
        }
        // dd($appointment->toArray());
        return view('admin.modify-appointments', compact('appointment'));
    }

    public function modifyAppointmentAction(Request $request)
    {
        try {
            $rules = [
                'app_date' => 'required|date',
                'app_id' => 'required|numeric'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $appointment = Appointment::find($request->app_id);
            if (!$appointment) {
                return redirect()->back()->with('error', 'Appointment Not found.');
            }
            $appointment->appointment_date = $request->app_date;
            $appointment->status = 'accepted';
            $appointment->save();

            //send mail to the person regarding appointment updation

            return redirect()->route('appointment')->with('success', 'Appointment Updated Successfully.');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Somethign went wrong ' . $err);
        }
    }

    public function deleteAppointment(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $appointment = Appointment::find($request->id);
            if (!$appointment) {
                return redirect()->back()->with('error', 'Something went wrong.');
            }
            $appointment->archive = 'yes';
            $appointment->save();
            return redirect()->back()->with('success', 'Successfully deleted the appointment');
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }
}

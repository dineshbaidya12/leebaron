<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmailTemplateController extends Controller
{
    public function emailTemplates($type)
    {
        $emailData = EmailTemplate::where('type', $type)->first();
        return view('admin.email-templates', compact('emailData'));
    }

    public function emailTemplatesAction(Request $request)
    {
        try {
            $rules = [
                'subject' => 'required',
                'email_template_content' => 'required',
                'type' => 'required|in:waiting_activation,acc_activated,acc_suspended,forgot_pass,enquiry,subscription,apointment,apointment_confirmation,apointment_reminder,new_order,dispatched,processing,cancelled'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = [
                'type' => $request->type,
                'subject' =>  $request->subject,
                'content' => $request->email_template_content,
            ];

            $emailTemplates = EmailTemplate::where('type', $request->type)->first();

            if (!$emailTemplates) {
                DB::table('email_templates')->insert($data);
            } else {
                $data = [
                    'subject' =>  $request->subject,
                    'content' => $request->email_template_content,
                ];
                DB::table('email_templates')->where('type', $request->type)->update($data);
            }
            return redirect()->back()->with('success', 'Email Tempalte Updated Successfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }
}

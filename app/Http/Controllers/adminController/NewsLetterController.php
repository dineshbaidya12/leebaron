<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\SendedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    public function newsletter()
    {
        $newsletters = Newsletter::get();
        return view('admin.newsletter-email', compact('newsletters'));
    }

    public function addNewsletter()
    {
        $isEdit = false;
        return view('admin.add-edit-newsletter', compact('isEdit'));
    }

    public function modifyNewsletter($id)
    {
        $isEdit = true;
        $newsletter = Newsletter::where('id',  $id)->first();
        if (!$newsletter) {
            return redirect()->back()->with('error', 'Unable to find the Newsletter Email.');
        }
        return view('admin.add-edit-newsletter', compact('isEdit', 'newsletter'));
    }

    public function changeNewsletterStatus(Request $request)
    {
        try {
            $newsletter = Newsletter::where('id', $request->id)->first();
            if ($newsletter) {
                if ($request->status == 'active') {
                    Newsletter::where('id', $request->id)->update(['status' => 'inactive']);
                } else {
                    Newsletter::where('id', $request->id)->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Newsletter Email status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Newsletter Email Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deleteNewsletter(Request $request)
    {
        try {
            Newsletter::where('id', $request->id)->delete();
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function newsletterAction(Request $request)
    {
        try {
            // dd($request->toArray());
            $rules = [
                'editId' => 'required|numeric',
                'newsletter_name' => 'required',
                'newsletter_email' => 'required|email',
                'status' => 'required|in:active,inactive,waiting'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->editId == 0) {
                $isExist = Newsletter::where('email', $request->newsletter_email)->count();
                if ($isExist > 0) {
                    return redirect()->back()->with('error', 'Email already Exist');
                }
            } else {
                $currentMail = Newsletter::find($request->editId);
                if (!$currentMail) {
                    return redirect()->back()->with('error', 'Email Not Found!');
                }
                if ($currentMail->email !== $request->newsletter_email) {
                    $isExist = Newsletter::where('email', $request->newsletter_email)->count();
                    if ($isExist > 0) {
                        return redirect()->back()->with('error', 'Email already Exist');
                    }
                }
            }

            $newsletter = Newsletter::find($request->editId) ?? new Newsletter();
            $newsletter->name = $request->newsletter_name;
            $newsletter->email = $request->newsletter_email;
            $newsletter->status = $request->status;
            $newsletter->save();

            $res = $request->editId  == 0 ? 'Added' : 'Modified';
            return redirect()->route('newsletter-email')->with('success', 'Newsletter Email ' . $res . ' Succcessfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }

    public function bulkUpload()
    {
        return view('admin.bulk-upload-csv');
    }

    public function bulkUploadAction(Request $request)
    {
        try {
            $rules = [
                'csv_file' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $csvFile = $request->file('csv_file');
            $filePath = $csvFile->getRealPath();
            $file = fopen($filePath, 'r');
            $recordInsert = 0;
            while (($record = fgetcsv($file)) !== false) {
                $name = $record[0] == '' ? 'subscriber' : $record[0];
                $email = $record[1];
                $isExist = Newsletter::where('email', $email)->count();
                if ($isExist < 1) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $newsLetter = new newsletter();
                        $newsLetter->name = $name;
                        $newsLetter->email = $email;
                        $newsLetter->status = 'active';
                        $newsLetter->save();
                        $recordInsert++;
                    }
                }
            }
            return redirect()->route('newsletter-email')->with('success', $recordInsert . ' record inserted successfully ');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function sendNewsLetterEmail()
    {
        $keep = SendedMail::orderby('id', 'desc')->take(8)->pluck('id');
        SendedMail::whereNotIn('id', $keep)->delete();
        $sendedMail = SendedMail::limit(8)->orderby('id', 'desc')->get();
        return view('admin.send-newsletter-mail', compact('sendedMail'));
    }

    public function sendNewsLetterEmailAction(Request $request)
    {
        try {
            $rules = [
                'reciever_type' => 'required|in:a,r,ra,d',
                'subject' => 'required',
                'mail_content' => 'required',
                'isCopied' => 'required|in:yes,no'
            ];

            if ($request->reciever_type == 'd') {
                $rules['email'] = 'required|email';
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //insert in table

            if ($request->isCopied == 'no') {
                if ($request->reciever_type == 'a') {
                    $type = 'all';
                } else if ($request->reciever_type == 'r') {
                    $type = 'r_user_s';
                } else if ($request->reciever_type == 'ra') {
                    $type = 'r_user_a';
                } else if ($request->reciever_type == 'd') {
                    $type = 'indivisual';
                } else {
                    $type = 'other';
                }

                $sended = new SendedMail();
                $sended->subject = $request->subject;
                $sended->content = $request->mail_content;
                $sended->type = $type ?? 'other';
                $sended->save();
            }

            //send the emails

            if ($request->reciever_type == 'a') {
                //send mail to all newsletter email
                $emails = Newsletter::where('status', 'active')->orderby('id', 'desc')->pluck('email')->toArray();
                foreach ($emails as $key => $email) {
                    //Send the mail now to this mail
                    echo $email . '<br>';
                }
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong. ' . $err);
        }
    }

    public function deleteSendedMail(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'History Not Found'], 404);
            }
            $history = SendedMail::find($request->id);
            if (!$history) {
                return response()->json(['status' => false, 'message' => 'History Not Found'], 404);
            }
            $history->delete();
            return response()->json(['status' => false, 'message' => 'History Not Found'], 200);
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong. ' . $err);
        }
    }

    public function prevMailData($id)
    {
        try {
            $sended = SendedMail::where('id', $id)->first();
            if (!$sended) {
                return response()->json(['status' => false, 'message' => 'History not found.']);
            }
            $data = ['status' => true, 'message' => 'Successfully Fetch data', 'data' => ['subject' => $sended->subject ?? '', 'content' => $sended->content ?? '']];
            return response()->json($data);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err]);
        }
    }
}

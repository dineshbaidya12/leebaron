<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\PagesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function pages()
    {
        $pages = PagesModel::where('archive', 'no')->get();
        // dd($pages->toArray());
        return view('admin.pages', compact('pages'));
    }

    public function addPage()
    {
        $isEdit = false;
        return view('admin.add-edit-page', compact('isEdit'));
    }

    public function modifyPage($id)
    {
        $isEdit = true;
        $page = PagesModel::where('id', $id)->first();
        if (!$page) {
            return redirect()->back()->with('error', 'Page not exist');
        }
        return view('admin.add-edit-page', compact('isEdit', 'page'));
    }

    public function pageAction(Request $request)
    {
        try {
            // dd($request->toArray());
            $rules = [
                'isEdit' => 'required|numeric',
                'page_heading' => 'required',
                'page_content' => 'required',
                'disaplay_on' => 'required|in:top_nav,footer,top_nav_and_footer,other,not_visible',
                'orderby' => 'required|numeric',
                'status' => 'required|in:active,inactive',
                'default_meta' => 'required|in:yes,no'
            ];
            if ($request->default_meta == "no") {
                $rules += [
                    'title' => 'required',
                    'meta_description' => 'required',
                    'keyword' => 'required'
                ];
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $seoFileMName = str_replace(' ', '_', $request->seo_file_name);
            if (strtolower(substr($seoFileMName, -4)) !== '.php') {
                $seoFileMName .= '.php';
            }
            $pageContent = PagesModel::find($request->isEdit) ?? new PagesModel();
            $pageContent->heading = $request->page_heading;
            $pageContent->pagecontent = $request->page_content;
            $pageContent->seo_file_name = $seoFileMName ?? '';
            $pageContent->orderby = $request->orderby;
            $pageContent->title = $request->default_meta == 'no' ? $request->title : '';
            $pageContent->meta_description = $request->default_meta == 'no' ? $request->meta_description : '';
            $pageContent->keyword = $request->default_meta == 'no' ? $request->keyword : '';
            $pageContent->disaplay_on = $request->disaplay_on;
            $pageContent->status = $request->status;
            $pageContent->default_meta = $request->default_meta;
            $pageContent->archive = 'no';
            $pageContent->save();

            if ($request->isEdit == 0) {
                return redirect()->route('pages')->with('success', 'Page Added Successfully.');
            } else {
                return redirect()->route('pages')->with('success', 'Page Updated Successfully.');
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong' . $err);
        }
    }

    public function changePageStatus(Request $request)
    {
        try {
            $page = PagesModel::where('id', $request->id)->first();
            if ($page) {
                if ($request->status == 'active') {
                    PagesModel::where('id', $request->id)->update(['status' => 'inactive']);
                } else {
                    PagesModel::where('id', $request->id)->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Page status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Page Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function deletePage(Request $request)
    {
        try {
            PagesModel::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }
}

<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::where('archive', 'no')->get();
        return view('admin.category', compact('categories'));
    }

    public function addCategory()
    {
        $isEdit = false;
        return view('admin.add-edit-category', compact('isEdit'));
    }

    public function modifyCategory($id)
    {
        $isEdit = true;
        $category = Category::where('id', $id)->where('archive', 'no')->first();
        if (!$category) {
            return redirect()->back()->with('error', 'Category Not Found');
        }
        return view('admin.add-edit-category', compact('isEdit', 'category'));
    }

    public function deleteCategory(Request $request)
    {
        try {
            Category::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function changeCategoryStatus(Request $request)
    {
        try {
            $category = Category::where('id', $request->id)->where('archive', 'no')->first();
            if ($category) {
                if ($request->status == 'active') {
                    Category::where('id', $request->id)->where('archive', 'no')->update(['status' => 'inactive']);
                } else {
                    Category::where('id', $request->id)->where('archive', 'no')->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Faq status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Faq Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function categoryAction(Request $request)
    {
        try {

            // dd($request->toArray());

            $rules = [
                'isEdit' => 'required|numeric',
                'category_name' => 'required',
                'shipping_price' => 'required|numeric',
                'category_desc' => 'required',
                'conneect_shirt_shop' => 'required|in:yes,no',
                'display_footer' => 'required|in:yes,no',
                'default_meta' => 'required|in:yes,no',
                'status' => 'required|in:active,inactive',
                'order_by' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $isCatExist = Category::where('category_name', $request->category_name)->count();
            if ($isCatExist > 0 && $request->isEdit == 0) {
                return redirect()->back()->with('error', 'Category Already Exists');
            }

            if ($request->default_meta == 'no') {
                if ($request->page_title == '' || $request->meta_desc == '' || $request->meta_key == '') {
                    return redirect()->back()->with('error', 'Please provide all meta details or select default meta data');
                }
            }

            $category = Category::find($request->isEdit) ?? new Category();
            $category->category_name = $request->category_name;
            $category->shipping_price = $request->shipping_price;
            $category->shirt_shop = $request->conneect_shirt_shop;
            $category->category_desc = $request->category_desc;
            $category->status = $request->status;
            $category->orderby = $request->order_by;
            $category->display_footer = $request->display_footer;
            $category->default_meta = $request->default_meta;
            $category->page_title = $request->default_meta == 'yes' ? '' : $request->page_title;
            $category->meta_desc = $request->default_meta == 'yes' ? '' : $request->meta_desc;
            $category->meta_keywords = $request->default_meta == 'yes' ? '' : $request->meta_key;
            $category->save();

            $res = $request->isEdit == 0 ? 'Added' : 'Updated';

            return redirect()->route('category')->with('success', 'Category ' . $res . ' Successfully');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong ' . $err);
        }
    }
}

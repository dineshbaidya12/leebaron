<?php

namespace App\Http\Controllers\adminController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::join('categories', 'categories.id', 'products.cateogry')->where('products.archive', 'no')->select('products.id', 'categories.category_name', 'products.name', 'products.product_code', 'products.price', 'products.main_img', 'products.status', 'products.orderby')->get();
        // dd($products->toArray());
        return view('admin.products', compact('products'));
    }


    public function changeProductStatus(Request $request)
    {
        try {
            $product = Product::where('id', $request->id)->first();
            if ($product) {
                if ($request->status == 'active') {
                    Product::where('id', $request->id)->update(['status' => 'inactive']);
                } else {
                    Product::where('id', $request->id)->update(['status' => 'active']);
                }
                return response()->json(['status' => 'true', 'messege' => 'Product status updated.', 'data' => ['status' => $request->status]]);
            } else {
                return response()->json(['status' => 'false', 'messege' => 'Product Not Found.']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => 'false', 'messege' => 'Something Went Wrong ' . $err]);
        }
    }

    public function addProduct()
    {
        $isEdit = false;
        $catgories = Category::where('archive', 'no')->select('id', 'category_name')->get();
        return view('admin.add-new-product', compact('isEdit', 'catgories'));
    }

    public function modifyProduct($id)
    {
        $isEdit = true;
        $product = product::where('id', $id)->first();
        if (!$product || $product->archive == 'yes') {
            return redirect()->back()->with('error', 'Unable to find the event');
        }
        $catgories = Category::where('archive', 'no')->select('id', 'category_name')->get();
        $pImages = ProductsImage::where('product_id', $id)->get();
        // dd($catgories->toArray());
        return view('admin.add-new-product', compact('isEdit', 'product', 'catgories', 'pImages'));
    }

    public function productAction(Request $request)
    {
        try {
            $rules = [
                'editId' => 'required|numeric',
                'category' => 'required|numeric',
                'orderby' => 'required|numeric',
                'product_name' => 'required',
                'product_code' => 'required',
                'product_price' => 'required|numeric',
                'product_description' => 'required',
                'status' => 'required|in:active,inactive',
                'default_meta' => 'required|in:yes,no',
                'product_multiple_images.*' => 'mimes:jpg,png,jpeg'
            ];

            if ($request->default_meta == 'no') {
                $rules += [
                    'page_title' => 'required',
                    'meta_desc' => 'required',
                    'meta_key' => 'required',
                ];
            }

            if ($request->editId == 0) {
                $rules += [
                    'product_img' => 'required|mimes:jpg,png,jpeg',
                ];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product = Product::find($request->editId) ?? new Product();
            $product->cateogry =  $request->category;
            $product->name =  $request->product_name;
            $product->product_code = strtoupper($request->product_code);
            $product->price =  $request->product_price;
            $product->description =  $request->product_description;
            $product->default_meta = $request->default_meta;
            $product->page_title = $request->default_meta == 'no' ? $request->page_title : '';
            $product->meta_key =  $request->default_meta == 'no' ?  $request->meta_key : '';
            $product->meta_desc =  $request->default_meta == 'no' ?  $request->meta_desc : '';
            $product->status =  $request->status;
            $product->orderby =  $request->orderby ?? 0;
            $product->save();

            $theId = $product->id;
            if ($request->hasFile('product_img')) {
                $image = $request->file('product_img');
                list($width, $height) = getimagesize($image->getPathname());
                $pName = str_replace(' ', '_', preg_replace('/\s+/', ' ', $request->product_name));
                $filename = $pName . now()->format('YmdHis') . '_' .  uniqid() . '_' . $theId . '.' . $image->getClientOriginalExtension();

                $storagePathThumb = 'public/product/thumb/';
                $storagePathMain = 'public/product/main/';

                $PathThumb = $storagePathThumb . $filename;
                $PathMain = $storagePathMain . $filename;

                $thumbImg = Image::make($image)->fit(150, 150);
                $mainImg = Image::make($image);

                $pDetails = Product::find($theId);
                if ($pDetails->main_img != '') {
                    if (Storage::disk('public')->exists('product/thumb/' . $pDetails->main_img)) {
                        Storage::disk('public')->delete('product/thumb/' . $pDetails->main_img);
                    }
                    if (Storage::disk('public')->exists('product/main/' . $pDetails->main_img)) {
                        Storage::disk('public')->delete('product/main/' . $pDetails->main_img);
                    }
                }

                Storage::put($PathThumb, $thumbImg->encode());
                Storage::put($PathMain, $mainImg->encode());

                $pDetails->main_img = $filename;
                $pDetails->save();
            }

            if ($request->hasFile('product_multiple_images')) {
                $images = $request->file('product_multiple_images');

                foreach ($images as $image) {
                    $pName = str_replace(' ', '_', preg_replace('/\s+/', ' ', $request->product_name));

                    // Create a new ProductsImage instance
                    $subImg = new ProductsImage();
                    $subImg->product_id = $theId;
                    $subImg->save();

                    // Generate a unique filename
                    $filename = $pName . '_' . uniqid() . '_' . $subImg->id . '.' . $image->getClientOriginalExtension();

                    // Storage paths
                    $storagePath = 'public/product/sub-img/';
                    $storagePathThumb = 'public/product/sub-img/thumb/';

                    // Make sure directories exist
                    Storage::makeDirectory($storagePath);
                    Storage::makeDirectory($storagePathThumb);

                    // Full paths
                    $Path = $storagePath . $filename;
                    $PathThumb = $storagePathThumb . $filename;

                    // Create Intervention Image instances
                    $thumbImg = Image::make($image)->fit(150, 150);
                    $mainImg = Image::make($image);

                    // Save images to storage
                    Storage::put($Path, $mainImg->encode());
                    Storage::put($PathThumb, $thumbImg->encode());

                    // Update ProductsImage record with the filename
                    $updateSubImg = ProductsImage::find($subImg->id);
                    $updateSubImg->image = $filename;
                    $updateSubImg->save();
                }
            }

            $res = $request->editId == 0 ? 'Added' : 'Updated';
            return redirect()->route('products')->with('success', 'Product ' . $res . ' Successfully.');

            // if ($width > $height) {
            //     //this is landscape
            //     if ($width >= 405) {
            //         $thumbWidth = 405;
            //         $widthDescPercent = (($width - $thumbWidth) / $width) * 100;
            //         $thumbHeight = $height - ($height * $widthDescPercent / 100);
            //     } else {

            //     }
            // } else if ($width < $height) {
            //     //this is portrait

            // } else {
            //     //this is squre
            // }
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            Product::where('id', $request->id)->update(['archive' => 'yes']);
            return;
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something Went Wrong! ' . $err);
        }
    }

    public function delProductImage(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'ID is mandatory.', 'data' => []]);
            }

            $image = ProductsImage::find($request->id);
            if (!$image) {
                return response()->json(['status' => false, 'message' => 'Image not found', 'data' => []]);
            }

            if ($image->image != '') {
                if (Storage::disk('public')->exists('product/sub-img/' . $image->image)) {
                    Storage::disk('public')->delete('product/sub-img/' . $image->image);
                }
                if (Storage::disk('public')->exists('product/sub-img/thumb/' . $image->image)) {
                    Storage::disk('public')->delete('product/sub-img/thumb/' . $image->image);
                }
            }
            $image->delete();
            return response()->json(['status' => true, 'message' => 'Image Deleted Successfully.', 'data' => []]);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err, 'data' => []]);
        }
    }
}

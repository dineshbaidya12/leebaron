@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Category')
@section('pagename', $res . ' Category')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('category-action') }}" method="POST" enctype="multipart/form-data" name="category_form">
            @csrf
            <input type="hidden" value="{{ $category->id ?? 0 }}" id="isEdit" name="isEdit">
            <div id="form-div">
                <div class="w-full p-4">
                    <label for="category_name" class="ti-form-label">Category Name:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="category_name" id="category_name"
                            value="{{ $category->category_name ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="shipping_price" class="ti-form-label">Shipping Price:</label>
                    <div class="relative">
                        <input type="number" class="ti-form-input" name="shipping_price" id="shipping_price"
                            value="{{ $category->shipping_price ?? '' }}" required>
                    </div>
                </div>


                <div class="w-full p-4">
                    <label for="category_desc" class="ti-form-label">Category Description:</label>
                    <div class="relative cat_desc">
                        <textarea name="category_desc" class="ti-form-input category_desc" id="category_desc" rows="3" required>{{ $category->category_desc ?? '' }}</textarea>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label"> Connect to SHIRT SHOP?:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="conneect_shirt_shop" class="ti-form-radio" id="hs-radio-in-form"
                                    checked="" value="yes" required
                                    @if ($isEdit) {{ $category->shirt_shop == 'yes' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Yes</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="conneect_shirt_shop" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="no" required
                                    @if ($isEdit) {{ $category->shirt_shop == 'no' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    checked="" value="active" required
                                    @if ($isEdit) {{ $category->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $category->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="display_fopter" class="ti-form-label">Display Footer:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="display_footer" class="ti-form-radio" id="hs-radio-in-form"
                                    checked="" value="yes" required
                                    @if ($isEdit) {{ $category->display_footer == 'yes' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Yes</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="display_footer" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="no" required
                                    @if ($isEdit) {{ $category->display_footer == 'no' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="order_by" class="ti-form-label">Order By:</label>
                        <input type="number" class="ti-form-input" name="order_by" id="order_by"
                            value="{{ $category->orderby ?? '' }}" required>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Use Default Meta Information :</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="default_meta" class="ti-form-radio" id="hs-radio-in-form"
                                    checked="" value="yes" required
                                    @if ($isEdit) {{ $category->default_meta == 'yes' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Yes</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="default_meta" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="no" required
                                    @if ($isEdit) {{ $category->default_meta == 'no' ? 'checked' : '' }}  @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">No</span>
                            </label>
                        </div>
                    </div>

                </div>

                <div id="default-desc-div">
                    <div class="w-full p-4">
                        <label for="page_title" class="ti-form-label">Page Title:</label>
                        <div class="relative">
                            <input type="text" class="ti-form-input" name="page_title" id="page_title"
                                value="{{ $category->page_title ?? '' }}">
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="meta_desc" class="ti-form-label">Meta Description:</label>
                        <div class="relative">
                            <textarea name="meta_desc" class="ti-form-input" id="meta_desc" rows="3">{{ $category->meta_desc ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="meta_key" class="ti-form-label">Meta Keywords:</label>
                        <div class="relative">
                            <textarea name="meta_key" class="ti-form-input" id="meta_key" rows="3">{{ $category->meta_keywords ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="w-full p-4">
                    <input type="button" id="submit-btn" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            //ckeditor
            CKEDITOR.replace('category_desc');


            let selectedValue = $('input[name="default_meta"]:checked').val();
            if (selectedValue == 'no') {
                $('#default-desc-div').css('display', 'block');
                $('input[name="page_title"]').attr('required', true);
                $('textarea[name="meta_desc"]').attr('required', true);
                $('textarea[name="meta_key"]').attr('required', true);
            } else {
                $('#default-desc-div').css('display', 'none');
                $('input[name="page_title"]').attr('required', false);
                $('textarea[name="meta_desc"]').attr('required', false);
                $('textarea[name="meta_key"]').attr('required', false);
            }


            $('input[name="default_meta"]').on('change', function() {
                let selectedValue = $(this).val();
                console.log(selectedValue);
                if (selectedValue == 'no') {
                    $('#default-desc-div').css('display', 'block');
                    $('input[name="page_title"]').attr('required', true);
                    $('textarea[name="meta_desc"]').attr('required', true);
                    $('textarea[name="meta_key"]').attr('required', true);
                } else {
                    $('#default-desc-div').css('display', 'none');
                    $('input[name="page_title"]').attr('required', false);
                    $('textarea[name="meta_desc"]').attr('required', false);
                    $('textarea[name="meta_key"]').attr('required', false);
                }
            });

            $('#submit-btn').on('click', function() {
                var invalidInputs = $('input[required], textarea[required]').filter(function() {
                    return !$(this).val();
                });

                $('input[required], textarea[required]').removeClass('err');

                var data = CKEDITOR.instances.category_desc.getData();
                if (data == '') {
                    $('.cat_desc').css('border', '1px solid red');
                } else {
                    $('.cat_desc').css('border', '');
                }

                if (invalidInputs.length > 0) {
                    event.preventDefault();
                    invalidInputs.addClass('err');
                } else {
                    $('input[required], textarea[required]').removeClass('err');
                    if (data == '') {
                        $('.cat_desc').css('border', '1px solid red');
                    } else {
                        $('.cat_desc').css('border', '');
                        $('form[name="category_form"]').submit();
                    }
                }
            });
        });
    </script>
@endsection

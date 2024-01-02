@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Page')
@section('pagename', $res . ' Page')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .err {
            border: 1px solid red !important;
        }

        #submit-btn {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('page-action') }}" method="POST" enctype="multipart/form-data" name="page_form">
            @csrf
            <input type="hidden" value="{{ $page->id ?? 0 }}" id="isEdit" name="isEdit">
            <div id="form-div">
                <div class="w-full p-4">
                    <label for="page_heading" class="ti-form-label">Page Heading:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="page_heading" id="page_heading"
                            value="{{ $page->heading ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="seo_file_name" class="ti-form-label">Seo File Name:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="seo_file_name" id="seo_file_name"
                            value="{{ $page->seo_file_name ?? '' }}">
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="display_on" class="ti-form-label"> Display On:</label>
                    <div class="grid sm:grid-cols-5 gap-5">
                        <label
                            class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                            <input type="radio" name="disaplay_on" class="ti-form-radio" id="hs-radio-in-form"
                                checked="" value="top_nav" required
                                @if ($isEdit) {{ $page->disaplay_on == 'top_nav' ? 'checked' : '' }} @endif>
                            <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Top Nav</span>
                        </label>
                        <label
                            class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                            <input type="radio" name="disaplay_on" class="ti-form-radio" id="hs-radio-checked-in-form"
                                value="footer" required
                                @if ($isEdit) {{ $page->disaplay_on == 'footer' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                            <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Footer</span>
                        </label>
                        <label
                            class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                            <input type="radio" name="disaplay_on" class="ti-form-radio" id="hs-radio-checked-in-form"
                                value="top_nav_and_footer" required
                                @if ($isEdit) {{ $page->disaplay_on == 'top_nav_and_footer' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                            <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Footer Nav &
                                Footer</span>
                        </label>
                        <label
                            class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                            <input type="radio" name="disaplay_on" class="ti-form-radio" id="hs-radio-checked-in-form"
                                value="other" required
                                @if ($isEdit) {{ $page->disaplay_on == 'other' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                            <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Other</span>
                        </label>
                        <label
                            class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                            <input type="radio" name="disaplay_on" class="ti-form-radio" id="hs-radio-checked-in-form"
                                value="not_visible" required
                                @if ($isEdit) {{ $page->disaplay_on == 'not_visible' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                            <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Not Visible</span>
                        </label>
                    </div>
                </div>


                <div class="grid grid-cols-2 gap-2">
                    <div class="w-full p-4">
                        <label for="status" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    checked="" value="active" required
                                    @if ($isEdit) {{ $page->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $page->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="status" class="ti-form-label">Order:</label>
                        <input type="number" class="ti-form-input" name="orderby" id="orderby"
                            value="{{ $page->orderby ?? '' }}" required>
                    </div>
                </div>



                <div class="w-full p-4">
                    <label for="page_content" class="ti-form-label">Page Content:</label>
                    <div class="relative page_content">
                        <textarea name="page_content" class="ti-form-input page_content" id="page_content" rows="3">{{ $page->pagecontent ?? '' }}</textarea>
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
                                    @if ($isEdit) {{ $page->default_meta == 'yes' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Yes</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="default_meta" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="no" required
                                    @if ($isEdit) {{ $page->default_meta == 'no' ? 'checked' : '' }}  @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">No</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div id="default-desc-div">
                    <div class="w-full p-4">
                        <label for="title" class="ti-form-label">Page Title:</label>
                        <div class="relative">
                            <input type="text" class="ti-form-input" name="title" id="title"
                                value="{{ $page->title ?? '' }}">
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="meta_description" class="ti-form-label">Meta Description:</label>
                        <div class="relative">
                            <textarea name="meta_description" class="ti-form-input" id="meta_description" rows="3">{{ $page->meta_description ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="keyword" class="ti-form-label">Meta Keywords:</label>
                        <div class="relative">
                            <textarea name="keyword" class="ti-form-input" id="keyword" rows="3">{{ $page->keyword ?? '' }}</textarea>
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
            CKEDITOR.replace('page_content');


            let selectedValue = $('input[name="default_meta"]:checked').val();
            if (selectedValue == 'no') {
                $('#default-desc-div').css('display', 'block');
                $('input[name="title"]').attr('required', true);
                $('textarea[name="meta_description"]').attr('required', true);
                $('textarea[name="keyword"]').attr('required', true);
            } else {
                $('#default-desc-div').css('display', 'none');
                $('input[name="title"]').attr('required', false);
                $('textarea[name="meta_description"]').attr('required', false);
                $('textarea[name="keyword"]').attr('required', false);
            }


            $('input[name="default_meta"]').on('change', function() {
                let selectedValue = $(this).val();
                console.log(selectedValue);
                if (selectedValue == 'no') {
                    $('#default-desc-div').css('display', 'block');
                    $('input[name="title"]').attr('required', true);
                    $('textarea[name="meta_description"]').attr('required', true);
                    $('textarea[name="keyword"]').attr('required', true);
                } else {
                    $('#default-desc-div').css('display', 'none');
                    $('input[name="title"]').attr('required', false);
                    $('textarea[name="meta_description"]').attr('required', false);
                    $('textarea[name="keyword"]').attr('required', false);
                }
            });

            $('#submit-btn').on('click', function() {
                var invalidInputs = $('input[required], textarea[required]').filter(function() {
                    return !$(this).val();
                });

                console.log(invalidInputs);

                $('input[required], textarea[required]').removeClass('err');

                var data = CKEDITOR.instances.page_content.getData();
                if (data == '') {
                    $('.page_content').css('border', '1px solid red');
                } else {
                    $('.page_content').css('border', '');
                }

                if (invalidInputs.length > 0) {
                    event.preventDefault();
                    invalidInputs.addClass('err');
                } else {
                    $('input[required], textarea[required]').removeClass('err');
                    if (data == '') {
                        $('.page_content').css('border', '1px solid red');
                    } else {
                        $('.page_content').css('border', '');
                        $('form[name="page_form"]').submit();
                    }
                }
            });
        });
    </script>
@endsection

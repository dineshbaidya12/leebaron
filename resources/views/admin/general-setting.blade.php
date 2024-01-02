@extends('admin.layouts.app')
@section('title', 'General Setting')
@section('pagename', 'General Setting')
@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        .admin-site-logo {
            background: #b7b7b7;
            padding: 10px;
        }

        .admin-site-logo img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            max-height: 135px;
        }

        .left-div {
            width: 70%;
        }

        .right-div {
            width: 20%;
            margin-left: 50px;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('general-setting') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="form-div">
                <div class="flex space-x-4">
                    <div class="w-1/2 p-4">
                        <label for="site-title" class="ti-form-label">Site Title:</label>
                        <div class="relative">
                            <input type="text" id="site-title" name="site_title"
                                class="ti-form-input ltr:pl-5 rtl:pr-11 focus:z-10"
                                value="{{ $generalSetting->site_title ?? '' }}" required>
                        </div>
                    </div>
                    <div class="w-1/2 p-4">
                        <label for="site-url" class="ti-form-label">Site URL:</label>
                        <div class="relative">
                            <input type="text" id="site-url" name="site_url"
                                class="ti-form-input ltr:pl-5 rtl:pr-11 focus:z-10"
                                value="{{ $generalSetting->site_url ?? '' }}" required>
                        </div>
                    </div>
                </div>
                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Meta Description:</label>
                    <div class="relative">
                        <textarea name="meta_description" class="ti-form-input" id="meta-description" rows="3">{{ $generalSetting->meta_descriptions ?? '' }}</textarea>
                    </div>
                </div>
                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Meta Keywords:</label>
                    <div class="relative">
                        <textarea name="meta_keywords" class="ti-form-input" id="meta-keywords" rows="3">{{ $generalSetting->meta_keywords ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Admin Logo:</label>
                    <div class="flex">

                        <div class="left-div">
                            <input type="file" name="admin_logo" id="file-input"
                                class="file-inputt block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/70 file:bg-transparent file:border-0 file:bg-gray-100 ltr:file:mr-4 rtl:file:ml-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/70"
                                onchange="changeImg(this);" accept=".png, .jpg, .jpeg" />
                        </div>

                        <div class="right-div">
                            <div class="admin-site-logo">
                                @if (count($generalSetting->toArray()) > 0)
                                    <img src="{{ asset('storage/general_setting/' . $generalSetting->admin_logo) }}"
                                        alt="logo" id="admin-logo" class="main-logo object-cover" />
                                @endif
                            </div>
                        </div>

                    </div>
                </div>



                <div class="w-full p-4">
                    <label for="site-title" class="ti-form-label">Fevicon icon:</label>
                    <div class="relative">
                        <input type="file" name="fevicon_icon" id="file-input"
                            class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 dark:text-white/70 file:bg-transparent file:border-0 file:bg-gray-100 ltr:file:mr-4 rtl:file:ml-4 file:py-3 file:px-4 dark:file:bg-black/20 dark:file:text-white/70"
                            accept=".png, .ico, .jpg">
                    </div>
                </div>

                <div class="w-full p-4">
                    <input type="submit" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>



@endsection
@section('custom-scripts')
    <script>
        function changeImg(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('admin-logo').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#admin-logo').on('click', function() {
            $('.file-inputt').click();
        });
    </script>
@endsection

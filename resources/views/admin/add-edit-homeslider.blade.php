@extends('admin.layouts.app')
@php
    $isEdit = $isEdit ?? false;
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Home Slider')
@section('pagename', $res . ' Home Slider')

@section('custom-styles')
    <style>
        #form-div {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        #location {
            width: 100%;
            border: 1px solid #e2e8f0;
            font-size: 12px;
            background: transparent;
        }

        .profile-picture {
            height: 150px;
            width: 150px;
            margin: auto;
            border-radius: 50%;
            background: transparent;
            position: relative;
            /* overflow: hidden; */
        }

        .profile-picture img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .edit-icon {
            position: absolute;
            top: -10px;
            font-size: 26px;
            right: -8px;
            cursor: pointer;
            padding: 5px;
        }

        .p-eye {
            position: absolute;
            cursor: pointer;
            top: 1px;
            right: 1px;
            font-size: 21px;
            padding: 12px;
        }
    </style>
@endsection

@section('content')

    <div class="box">
        <form action="{{ route('homeslider-update') }}" method="POST" enctype="multipart/form-data" name="homeslider_form">
            @csrf
            <input type="hidden" value="{{ $slider->id ?? 0 }}" id="isEdit" name="isEdit">
            <div class="mx-auto" style="width: 50%;">
                <div class="box-body">
                    <div class="profile-picture">
                        @if ($isEdit)
                            <img src="{{ asset('storage/homepage-slider/' . $slider->image) }}" alt="Home Page Slider"
                                id="show-profile-picture">
                        @else
                            <img src="{{ asset('admin/images/leebaron/default-image.jpg') }}" alt="Home Page Slider"
                                id="show-profile-picture">
                        @endif

                        <i class="ti ti-pencil edit-icon" id="edit-profile-picture"></i>
                    </div>
                    <input type="file" name="image" id="profile-picture" onchange="profileChange(this);"
                        accept=".png, .jpg, .jpeg" hidden {{ $isEdit ? '' : 'required' }}>
                </div>

                <div class="w-full p-4">
                    <label for="title" class="ti-form-label">Title:</label>
                    <div class="relative">
                        <input type="text" name="title" class="ti-form-input" id="title"
                            value="{{ $slider->title ?? '' }}" required>
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="link-type" class="ti-form-label">Link Type:</label>
                    <div class="relative">
                        <select name="link_type" id="link-type" class="w-full ti-form-select">
                            <option value="none"
                                @if ($isEdit) {{ $slider->link_type == 'none' ? 'selected' : '' }} @endif>
                                None
                            </option>
                            <option value="internal"
                                @if ($isEdit) {{ $slider->link_type == 'internal' ? 'selected' : '' }} @endif>
                                Internal Link
                            </option>
                            <option value="external"
                                @if ($isEdit) {{ $slider->link_type == 'external' ? 'selected' : '' }} @endif>
                                External Link
                            </option>
                        </select>
                    </div>
                </div>

                <div class="w-full p-4" style="display:none;" id="link-div">
                    <label for="link" class="ti-form-label">Link <span class="astric">*</span>:</label>
                    <div class="relative">
                        <select name="link_option" id="links-option" class="w-full">
                            @if ($isEdit)
                                <option value="home"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'home' ? 'selected' : '' }}>
                                    Home
                                </option>
                                <option value="collection"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'collection' ? 'selected' : '' }}>
                                    Collection</option>
                                <option value="contact us"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'contact us' ? 'selected' : '' }}>
                                    Contact Us</option>
                                <option value="faq"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'faq' ? 'selected' : '' }}>
                                    FAQ</option>
                                <option value="global events"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'global events' ? 'selected' : '' }}>
                                    Global Events</option>
                                <option value="order confirm"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'order confirm' ? 'selected' : '' }}>
                                    Order Confirm</option>
                                <option value="terms and conditions"
                                    {{ $slider->link_type == 'internal' && $slider->internal_link == 'terms and conditions' ? 'selected' : '' }}>
                                    Terms and Conditions</option>
                            @else
                                <option value="home">Home</option>
                                <option value="collection">Collection</option>
                                <option value="contact us">Contact Us</option>
                                <option value="faq">FAQ</option>
                                <option value="global events">Global Events</option>
                                <option value="order confirm">Order Confirm</option>
                                <option value="terms and conditions">Terms and Conditions</option>
                            @endif
                        </select>
                        @if ($isEdit)
                            <input type="text" name="link" class="ti-form-input" id="link"
                                value="{{ $slider->link_type == 'external' ? $slider->link : '' }}">
                        @else
                            <input type="text" name="link" class="ti-form-input" id="link" value="">
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required=""
                                    @if ($isEdit) {{ $slider->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required=""
                                    @if ($isEdit) {{ $slider->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Order:</label>
                        <div class="relative">
                            <input type="number" class="ti-form-input" name="order" id="order"
                                value="{{ $slider->order ?? '' }}" required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">New Window:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="new_window" class="ti-form-radio" id="hs-radio-in-form"
                                    value="yes"
                                    @if ($isEdit) {{ $slider->new_window == 'yes' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Yes</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="new_window" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="no"
                                    @if ($isEdit) {{ $slider->new_window == 'no' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Class Name:</label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="class_name" class="ti-form-radio" id="hs-radio-in-form"
                                    value="white"
                                    @if ($isEdit) {{ $slider->class_name == 'white' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">White</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="class_name" class="ti-form-radio"
                                    id="hs-radio-checked-in-form" value="black"
                                    @if ($isEdit) {{ $slider->class_name == 'black' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Black</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="w-full p-4">
                    <input type="button" id="submit-btn" class="ti-btn ti-btn-primary" value="Save">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $('#show-profile-picture').on('click', function() {
            $('#profile-picture').click();
        });

        function passShow() {
            let password = document.getElementById("password");
            let eye1 = document.querySelector('.password-eye-close');
            let eye2 = document.querySelector('.password-eye');
            if (password.type === "text") {
                password.type = "password";
                eye2.classList.add('hidden');
                eye1.classList.remove('hidden');
            } else {
                password.type = "text";
                eye1.classList.add('hidden');
                eye2.classList.remove('hidden');
            }
        }

        document.getElementById('edit-profile-picture').addEventListener('click', function() {
            document.getElementById('profile-picture').click();
        });

        function profileChange(input) {
            const profilePicImg = document.getElementById('show-profile-picture');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profilePicImg.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        // document.querySelector('#show-profile-picture').addEventListener('click', function() {
        //     notifier.success('This Is An Example Of Success')
        // })

        $('#link-type').on('change', function() {
            let val = $('#link-type').val();
            if (val == 'none') {
                $('#link-div').css('display', 'none');
                $('#links-option').attr('required', false);
                $('#link').attr('required', false);
                $('#links-option').css('display', 'none');
                $('#link').css('display', 'none');
            } else if (val == 'internal') {
                $('#link-div').css('display', 'block');
                $('#links-option').attr('required', true);
                $('#link').attr('required', false);
                $('#links-option').css('display', 'block');
                $('#link').css('display', 'none');
            } else {
                $('#link-div').css('display', 'block');
                $('#links-option').attr('required', false);
                $('#link').attr('required', true);
                $('#links-option').css('display', 'none');
                $('#link').css('display', 'block');
            }
        });

        $('#submit-btn').on('click', function() {
            var invalidInputs = $('input[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required]').removeClass('err');

            if ($('#profile-picture').val() == '') {
                $('#show-profile-picture').css('border', '1px solid red');
            } else {
                $('#show-profile-picture').css('border', '');
            }

            if (invalidInputs.length > 0) {
                event.preventDefault();
                invalidInputs.addClass('err');
            } else {
                $('input[required]').removeClass('err');
                $('form[name="homeslider_form"]').submit();
            }
        });

        $(document).ready(function() {
            let linkType = $('#link-type').val();
            if (linkType == 'none') {
                $('#link-div').css('display', 'none');
                $('#link').css('display', 'none');
                $('#link').attr('required', false);
                $('#links-option').css('display', 'none');
                $('#links-option').attr('required', false);
            } else if (linkType == 'internal') {
                $('#link-div').css('display', 'block');
                $('#link').css('display', 'none');
                $('#link').attr('required', false);
                $('#links-option').css('display', 'block');
                $('#links-option').attr('required', true);
            } else {
                $('#link-div').css('display', 'block');
                $('#link').css('display', 'block');
                $('#link').attr('required', true);
                $('#links-option').css('display', 'none');
                $('#links-option').attr('required', false);
            }
        });
    </script>

@endsection

@extends('admin.layouts.app')
@php
    $res = $isEdit ? 'Modify' : 'Add New';
@endphp
@section('title', $res . ' Newsletter Email')
@section('pagename', $res . ' Newsletter Email')
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

        .p-show {
            position: absolute;
            top: 13px;
            right: 11px;
            cursor: pointer;
            font-size: 20px;
        }

        #submit-btn {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="box">
        <form autocomplete="off" action="{{ route('newsletter-action') }}" method="POST" enctype="multipart/form-data"
            name="add-edit-newsletter" id="newsletter-form">
            @csrf
            <input type="hidden" name="editId" value="{{ $isEdit ? $newsletter->id : 0 }}">
            <div id="form-div">

                <div class="w-full p-4">
                    <label for="newsletter_name" class="ti-form-label">Name:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input username" name="newsletter_name" id="newsletter_name"
                            value="{{ $newsletter->name ?? '' }}" autocomplete="off" disabled />
                    </div>
                </div>

                <div class="w-full p-4">
                    <label for="newsletter_email" class="ti-form-label">Email:</label>
                    <div class="relative">
                        <input type="email" class="ti-form-input" name="newsletter_email" id="newsletter_email"
                            autocomplete="off" value="{{ $newsletter->email ?? '' }}">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="w-full p-4">
                        <label for="site-title" class="ti-form-label">Status:</label>
                        <div class="grid sm:grid-cols-3 gap-3">
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-in-form"
                                    value="active" required
                                    @if ($isEdit) {{ $newsletter->status == 'active' ? 'checked' : '' }} @else {{ 'checked' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Active</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="inactive" required
                                    @if ($isEdit) {{ $newsletter->status == 'inactive' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Inactive</span>
                            </label>
                            <label
                                class="flex p-3 w-full bg-white border border-gray-200 rounded-sm text-sm focus:border-primary focus:ring-primary dark:bg-bgdark dark:border-white/10 dark:text-white/70">
                                <input type="radio" name="status" class="ti-form-radio" id="hs-radio-checked-in-form"
                                    value="waiting" required
                                    @if ($isEdit) {{ $newsletter->status == 'waiting' ? 'checked' : '' }} @endif>
                                <span class="text-sm text-gray-500 ltr:ml-2 rtl:mr-2 dark:text-white/70">Waiting</span>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="w-full p-4">
                    <input type="submit" id="submit-btn" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#p-show').on('click', function() {
                $('#p-hide').css('display', 'block');
                $('#p-show').css('display', 'none');
                $('#pass').attr('type', 'password');
            });
            $('#p-hide').on('click', function() {
                $('#p-hide').css('display', 'none');
                $('#p-show').css('display', 'block');
                $('#pass').attr('type', 'text');
            });

            getRidOffAutocomplete();


        });

        function getRidOffAutocomplete() {

            var timer = window.setTimeout(function() {
                    $('.username').prop('disabled', false);
                    $('.username').focus();
                    clearTimeout(timer);
                },
                800);
        }

        $('#newsletter-form').on('submit', function(e) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Check and set border for the name field
            if ($('#newsletter_name').val() == '') {
                $('#newsletter_name').css('border', '1px solid red');
            } else {
                $('#newsletter_name').css('border', '');
            }

            // Check and set border for the email field
            if ($('#newsletter_email').val() == '' || !emailRegex.test($('#newsletter_email').val())) {
                $('#newsletter_email').css('border', '1px solid red');
            } else {
                $('#newsletter_email').css('border', '');
            }

            // Check if any validation failed
            if ($('#newsletter_name').val() == '' || $('#newsletter_email').val() == '' || !emailRegex.test($(
                    '#newsletter_email').val())) {
                e.preventDefault(); // Prevent form submission
            }
        });
    </script>
@endsection

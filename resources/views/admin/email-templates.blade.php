@extends('admin.layouts.app')
@php
    $type = request('type');
    if ($type == 'waiting_activation') {
        $res = 'Waiting for Activation';
    } elseif ($type == 'acc_activated') {
        $res = 'Account Activated';
    } elseif ($type == 'acc_suspended') {
        $res = 'Account Suspended';
    } elseif ($type == 'forgot_pass') {
        $res = 'Forgot Password';
    } elseif ($type == 'enquiry') {
        $res = 'Enquiry';
    } elseif ($type == 'subscription') {
        $res = 'Subscription';
    } elseif ($type == 'apointment') {
        $res = 'Appointment';
    } elseif ($type == 'apointment_confirmation') {
        $res = 'Appointment Confirmation';
    } elseif ($type == 'apointment_reminder') {
        $res = 'Appointment Reminder';
    } elseif ($type == 'new_order') {
        $res = 'New Order';
    } elseif ($type == 'dispatched') {
        $res = 'Order Dispatched';
    } elseif ($type == 'processing') {
        $res = 'Order Processing';
    } elseif ($type == 'cancelled') {
        $res = 'Order Cancled';
    } else {
        echo '
        <script>
            window.location.href = "'.url('admin/email-templates/waiting_activation').'";
        </script>
        ';
        exit();
    }
@endphp
@section('title', 'Email Templates')
@section('pagename', 'Email Templates / ' . $res)
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
    </style>
@endsection
@section('content')
    <div class="box">
        <form action="{{ route('email-templates-action') }}" method="POST" enctype="multipart/form-data" name="email-templates"
            id="email-templates">
            @csrf
            <input type="hidden" name="type" id="type" value="{{ $type ?? '' }}">
            <div id="form-div">
                <div class="w-full p-4">
                    <label for="subject" class="ti-form-label">Subject:</label>
                    <div class="relative">
                        <input type="text" class="ti-form-input" name="subject" id="subject" required
                            value="{{ $emailData->subject ?? '' }}">
                    </div>
                </div>
                <div class="w-full p-4">
                    <label for="email_template_content" class="ti-form-label">Email Content:</label>
                    <div class="relative template_content">
                        <textarea name="email_template_content" class="ti-form-input" id="email_template_content" rows="15" required>{{ $emailData->content ?? '' }}</textarea>
                    </div>
                </div>

                <div class="w-full p-4">
                    <input type="submit" id="submit" class="ti-btn ti-btn-primary" value="Submit">
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('email_template_content', {
                height: 300
            });
        });


        $('#submit').on('click', function(e) {
            var invalidInputs = $('input[required]').filter(function() {
                return !$(this).val();
            });

            $('input[required]').removeClass('err');

            var data = CKEDITOR.instances.email_template_content.getData();
            if (data == '') {
                $('.template_content').css('border', '1px solid red');
            } else {
                $('.template_content').css('border', '');
            }

            if (invalidInputs.length > 0) {
                e.preventDefault();
                invalidInputs.addClass('err');
            } else {
                $('input[required]').removeClass('err');
                if (data !== '') {
                    $('form[name="email-templates"]').submit();
                } else {
                    e.preventDefault();
                }
            }
        });
    </script>
@endsection
